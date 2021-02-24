<?php

/*
 * COPYRIGHT © 2019. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

class Menus extends \Phalcon\Mvc\User\Component
{
    /**
     *  Generamos código html con el contenido del menú del sistema SAIDA
     *  @return string con el menú generado en código html
     *  @author Dora Nely Vega Gonzalez
     */
    public function getMenu()
    {
        $html = '';
        $menu = $this->getMenuPadre();
        //para cada uno de los items del menú
        foreach ($menu as $item) {
            $html .= $this->crearMenu($item);
        }
        return $html;
    }

    /**
     *  Generamos el menu en código html
     *  @return string con las etiquetas <li> del menú generado en código html
     *  @author Dora Nely Vega Gonzalez
     */
    protected function crearMenu($item)
    {
        if (empty($item)) {
            return '';
        }

        $html = '';
        $html .= sprintf('<li class="%s">', (isset($item->SUBMENUS) &&$item->SUBMENUS <> 0) ? 'treeview' : '');

        //Generamos los <li> del menú
        if (isset($item->URL) && is_string($item->URL)) {
            //obtenemos el link dentro de la etiqueta <a>
            $html .= $this->crearLink($item);
            //Validamos que el item seleccionado tenga submenus
            if (isset($item->SUBMENUS) && isset($item->ID_MENU) && $item->SUBMENUS <> 0) {
                $submenus = $this->getSubmenu($item->ID_MENU);
                if($submenus){
                    $html .= ' <ul class="treeview-menu">';
                    //para cada unos de los items del submenu creamos las etiquetas <li>
                    foreach ($submenus as $submenu) {
                        $html .= sprintf('<li class="%s">', $submenu->SUBMENUS <> 0 ? 'treeview' : '');
                        $html .= $this->crearSubmenu($submenu);
                        $html .= '</li>';
                    }
                    $html .= ' </ul>';
                }
            }
        }
        $html .= '</li>';
        return $html;
    }

    /**
     *  Generamos el submenu de los items en código html
     *  @return string con las etiquetas <li> del submenu generado en código html
     *  @author Dora Nely Vega Gonzalez
     */
    protected function crearSubmenu($item)
    {
        if (empty($item)) {
            return '';
        }

        $html = '';
        //Generamos los <li> del submenu
        if (isset($item->URL) && is_string($item->URL)) {
            //obtenemos el link dentro de la etiqueta <a>
            $html .= $this->crearLink($item);
            //Validamos que el item seleccionado del submenu tenga submenus
            if (isset($item->SUBMENUS) && isset($item->ID_MENU) && $item->SUBMENUS <> 0) {
                $submenus = $this->getSubmenu($item->ID_MENU);
                if($submenus){
                    $html .= ' <ul class="treeview-menu">';
                    //para cada unos de los items del submenu creamos las etiquetas <li>
                    foreach ($submenus as $submenu) {
                        $html .= sprintf('<li class="%s">', $submenu->SUBMENUS <> 0 ? 'treeview' : '');
                        $html .= $this->crearMenu($submenu);
                        $html .= '</li>';
                    }
                    $html .= ' </ul>';
                }
            }
        }
        return $html;
    }

    /**
     *  Generamos los links del menu en código html
     *  @var \Phalcon\Tag $tag
     *  @return string con el lik del menu generado en código html
     *  @author Dora Nely Vega Gonzalez
     */
    protected function crearLink($item)
    {
        //Componente para generar código HTML.
        $tag  = $this->getDI()->getShared('tag');

        if (empty($item)) {
            return '';
        }

        $text  = isset($item->NOMBRE) ? $item->NOMBRE : '';

        //agregamos el nombre a la etiqueta <a> del menú
        if (isset($item->NOMBRE) && is_string($item->NOMBRE)) {
            $text = strtr('<:open>:text</:close>', [
                ':open'  => 'span',
                ':close' => 'span',
                ':text'  => $text
            ]);
        }

        //agregamos el icono a la etiqueta <a> del menú
        if (isset($item->ICONO) && is_string($item->ICONO)) {
            $text = strtr(':icon:text' ,[
                ':icon' => '<i class="'.$item->ICONO.'"></i> ',
                ':text' => $text
            ]);
        }

        //agregamos el icono de flecha a la etiqueta <a> cuando se tienen submenus
        if (isset($item->SUBMENUS) && $item->SUBMENUS <> 0) {
            $text = strtr(':text:icon' ,[
                ':icon' => '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>',
                ':text' => $text
            ]);
        }

        $href = isset($item->URL) ? $item->URL : '';

        return $tag->linkTo([$href, $text] + (array) $item, true);
    }

    /**
     *  Obtenemos el menu del sistema saida
     *  @author Dora Nely Vega Gonzalez
     */
    public function getMenuPadre()
    {

        $menu = [];
        $roles = [];

        //Validamos si el usuarios ha sido logueado
        if (isset($this->session->usuario['roles'])) {
            //Hacemos la búsqueda de los roles activos del usuario
            foreach ($this->session->usuario['roles'] as $rol){
                $roles[] = $rol->ID;
            }
        }

        if($roles){
            $roles_r = implode(', ', (array)$roles);
            if($roles_r){
                //Se realiza la búsqueda  de los itmes del menu cuando id_padre = 0
                $phql = "SELECT M.id_menu AS ID_MENU, M.id_padre AS ID_PADRE, M.nombre
                  AS NOMBRE, M.url AS URL, M.icono AS ICONO, M.orden AS ORDEN,
                  (SELECT COUNT(*) AS COUN FROM SdMenu MM WHERE MM.id_padre= M.id_menu) AS SUBMENUS
                FROM SdMenu       M,
                     SdMenuRol   MR,
                     SdRol        ROL
               WHERE  M.id_menu = MR.id_menu
                     AND M.estatus = :estatus:
                     AND M.id_padre = :id_padre:
                     AND ROL.id = MR.id_rol
                     AND ROL.id IN  (".$roles_r.")
            GROUP BY M.id_menu,  M.id_padre, M.nombre, M.url, M.icono, M.orden
            ORDER BY M.orden ASC";

                $menu  = $query = $this->modelsManager->executeQuery($phql, ['id_padre' => 0, 'estatus' => 'AC']);
            }
        }



        return $menu;

    }

    /**
     *  Obtenemos el submenu del menu
     *  @author Dora Nely Vega Gonzalez
     */
    protected function getSubmenu($idPadre)
    {
        //Se realiza la búsqueda de los submenus del menu seleccionado
        $phql = "SELECT M.id_menu AS ID_MENU, M.id_padre AS ID_PADRE, M.nombre
                  AS NOMBRE, M.url AS URL, M.icono AS ICONO, M.orden AS ORDEN,
                  (SELECT COUNT(*) AS COUN FROM SdMenu MM WHERE MM.id_padre= M.id_menu) AS SUBMENUS
                FROM SdMenu       M
               WHERE M.estatus = :estatus:
                    AND M.id_padre = :id_padre:
            GROUP BY M.id_menu,  M.id_padre, M.nombre, M.url, M.icono, M.orden
            ORDER BY M.orden ASC";

        $submenu  = $query = $this->modelsManager->executeQuery($phql, ['id_padre' => $idPadre, 'estatus' => 'AC']);

        return $submenu;
    }
}