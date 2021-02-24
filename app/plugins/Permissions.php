<?php

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;

/*
 * COPYRIGHT © 2019. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

/*
* plugin roles para llevar a cabo permisos de usuarios en Phalcon
*/

class Permissions extends Plugin
{
    /**
     * lógica para crear una aplicación con roles de usuarios
     *  @author Raúl Alejandro Verde Martínez
     */
    public function getAcl()
    {
        if (!isset($this->persistent->acl)) {

            //Se crea la instancia de acl para crear los roles
            $acl = new Phalcon\Acl\Adapter\Memory();

            //Por defecto la acción será denegar el acceso a cualquier zona
            $acl->setDefaultAction(Phalcon\Acl::DENY);

            //Se registran  los roles
            $roles = array();

            $resultRoles = $this->modelsManager->executeQuery('SELECT nombre AS ROL FROM SdRol WHERE estatus = \'AC\' ORDER BY id');

            //Rol default de la aplicación
            $roles['INVITADO'] = new Phalcon\Acl\Role('INVITADO');

            foreach ($resultRoles as $rol) {
                $roles[strtoupper(trim($rol->ROL))] = new Phalcon\Acl\Role(strtoupper(trim($rol->ROL)));
            }

            //Se añade los roles al acl
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            //Se realiza la búsqueda de los recursos públicos de la aplicación
            $publicResources = array();
            $recurso = '';

            $resultPublic = $this->modelsManager->executeQuery(
                "SELECT R.nombre AS RECURSO, A.nombre AS ACCION
				  FROM SdRecurso R
						 INNER JOIN SdRecursoAccion RA ON (R.id = RA.id_recurso)
						 INNER JOIN SdAccion A ON (A.id = RA.id_accion)
				  WHERE R.estatus = 'AC' AND RA.estatus = 'AC' AND A.estatus = 'AC' AND RA.privacidad = 'PUBLICA'
				  GROUP BY R.nombre, A.nombre
				  ORDER BY R.nombre, A.nombre ASC");

            if (count($resultPublic) == 0) {
                //Agregamos el recurso para mostrar el sitio
                $resultPublic = [['RECURSO' => 'login', 'ACCION' => 'login'],
                    ['RECURSO' => 'estatus', 'ACCION' => 'login']];
                foreach ($resultPublic as $public) {
                    if (trim($recurso) != trim($public['RECURSO'])) {
                        $publicResources[strtolower(trim($public['RECURSO']))][] = trim($public['ACCION']);
                        $recurso = strtolower(trim($public['RECURSO']));
                    } else {
                        $publicResources[strtolower(trim($recurso))][] = trim($public['ACCION']);
                    }
                }
            } else {
                foreach ($resultPublic as $public) {
                    if (trim($recurso) != trim($public->RECURSO)) {
                        $publicResources[strtolower(trim($public->RECURSO))][] = trim($public->ACCION);
                        $recurso = strtolower(trim($public->RECURSO));
                    } else {
                        $publicResources[strtolower(trim($recurso))][] = trim($public->ACCION);
                    }
                }
            }

            //Se añade los recursos públicos a la aplicación
            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Se realiza la búsqueda de los recursos restringidos de la aplicación
            $restrictedResources = array();
            $restrictedAreas = array();
            $recurso = '';

            $resultRestricted = $this->modelsManager->executeQuery(
                'SELECT R.nombre AS RECURSO, A.nombre AS ACCION
				  FROM SdRecurso R
						 INNER JOIN SdRecursoAccion RA ON (R.id = RA.id_recurso)
						 INNER JOIN SdAccion A ON (A.id = RA.id_accion)
				  WHERE R.estatus = \'AC\' AND RA.estatus = \'AC\' AND A.estatus = \'AC\' AND RA.privacidad = \'PRIVADA\'
				  ORDER BY R.nombre, A.id ASC'
            );

            foreach ($resultRestricted as $restricted) {
                if (trim($recurso) != trim($restricted->RECURSO)) {
                    $restrictedResources[strtolower(trim($restricted->RECURSO))][] = trim($restricted->ACCION);
                    $recurso = strtolower(trim($restricted->RECURSO));
                } else {
                    $restrictedResources[strtolower(trim($recurso))][] = trim($restricted->ACCION);
                }
            }

            //Se añade los recursos restringidos a la aplicación
            foreach ($restrictedResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Se realiza la búsqueda de las zonas restringidas de la aplicación
            $resultRestricted = $this->modelsManager->executeQuery(
                'SELECT R.nombre AS RECURSO, A.nombre AS ACCION, R2.nombre AS ROL
				  FROM SdRecurso R
						 INNER JOIN SdRecursoAccion RA ON (R.id = RA.id_recurso)
						 INNER JOIN SdRecursoRol RR ON (R.id = RR.id_recurso)
						 INNER JOIN SdRol R2 ON (R2.id = RR.id_rol)
						 INNER JOIN SdAccion A ON (A.id = RA.id_accion)
				  WHERE R.estatus = \'AC\' AND RA.estatus = \'AC\' AND A.estatus = \'AC\' AND R2.estatus = \'AC\' AND RA.privacidad = \'PRIVADA\'
				  ORDER BY R.nombre, R2.id ASC'
            );

            foreach ($resultRestricted as $restricted) {
                if (trim($recurso) != trim($restricted->RECURSO)) {
                    $restrictedAreas[strtolower(trim($restricted->RECURSO))][] = ucfirst(trim($restricted->ROL)) . '|' . trim($restricted->ACCION);
                    $recurso = strtolower(trim($restricted->RECURSO));
                } else {
                    $restrictedAreas[strtolower(trim($recurso))][] = ucfirst(trim($restricted->ROL)) . '|' . trim($restricted->ACCION);
                }
            }

            //Se reagistran las zonas públicas de la aplicación
            foreach ($roles as $role) {
                foreach ($publicResources as $resource => $actions) {
                    foreach ($actions as $action) {
                        $acl->allow($role->getName(), $resource, $action);
                    }
                }
            }

            //Se reagistran las zonas restringidas de la aplicación por rol
            foreach ($restrictedAreas as $resource => $restricteds) {
                foreach ($restricteds as $restricted) {
                    $action = explode('|', $restricted);
                    $acl->allow($action[0], $resource, $action[1]);

                }
            }
            //El acl queda almacenado en sesión
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    /**
     * Esta acción se ejecuta antes de ejecutar cualquier acción en la aplicación
     *  @author Raúl Alejandro Verde Martínez
     */
   public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        //Usuario por default de la aplicación
        $role = 'INVITADO';

        //Validamos si el usuarios ha sido logueado
        if ($this->session->usuario['roles']) {

            //Obtenemos el rol
            foreach ($this->session->usuario['roles'] as $rol){
                $roles[] = $rol->NOMBRE;
            }
            $role = $roles;
        }

        //nombre del controlador al que intentamos acceder
        $controller = trim($dispatcher->getControllerName());

        //nombre de la acción a la que intentamos acceder
        $action = trim($dispatcher->getActionName());

        //obtenemos la Lista de Control de Acceso(acl) que hemos creado
        $acl = $this->getAcl();

        if ($this->session->has('usuario')) {
            if (is_array($role)) {

                foreach ($role AS $rol) {
                    //boolean(true | false) si tenemos permisos devuelve true en otro caso false
                    $allowed = $acl->isAllowed($rol, $controller, $action);

                    //Si el usuario no tiene acceso a la zona que intenta acceder
                    if ($allowed == Acl::ALLOW) {
                        return true;
                    } else {
                        $dispatcher->forward(array(
                            'controller' => 'index',
                            'action' => 'index'
                        ));

                        return false;
                    }
                }
            } else {
                //boolean(true | false) si tenemos permisos devuelve true en otro caso false
                $allowed = $acl->isAllowed($role, $controller, $action);

                if (!$allowed) {
                    $dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));

                    return false;
                }
            }
        } else {
            //boolean(true | false) si tenemos permisos devuelve true en otro caso false
            $allowed = $acl->isAllowed($role, $controller, $action);

            if ($allowed) {
                return true;
            } else {
                //Se veirfica que la ruta se diferente a la principal
                if (($controller != 'login') || ($controller == 'login' && $action != 'login')) {
                    $dispatcher->forward(
                        array(
                            'controller' => 'index',
                            'action' => 'index'
                        )
                    );
                }
            }
        }

        return true;
    }
}