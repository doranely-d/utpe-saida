<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Oficio de respuesta - Acuse de recibido</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        {{ stylesheet_link('css/pdf.css') }}
    </head>
    <body>
        <div style="width: 1019px; height: 1319px;">
            <div style="padding-left: 5px; padding-right: 5px">
                {{ image('img/pdf/logos.png', 'alt': 'Imagen de unidad de transparencia', 'class': 'user-image') }}
                <table style="border: 1px solid black; border-collapse: collapse;">
                    <tbody>
                    <tr>
                        <th colspan="3">
                            <h3 class="text-center" style="color: #a33d9c;">
                                <strong><span style="font-size: 16.0px; font-family: 'Calibri','sans-serif'; color: #6f2f9f;">Acuse de recibo de solicitud de informaci&oacute;n</span></strong>
                                <strong><span style="font-size: 10.5px; font-family: 'Calibri','sans-serif'; color: #6f2f9f; position: relative; top: -5.0pt;">1</span></strong>
                            </h3>
                        </th>
                    </tr>
                    <tr>
                        <td width="40%" style="text-align: right"><p style="margin: 4.6pt 0cm .0001pt 69.35pt;"><span class="texto">Fecha de recepción</span></p></td>
                        <td colspan="2"><strong><span class="texto">{{ date("d-m-Y") }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="text-align: right"><p style="margin: 4.6pt 0cm .0001pt 69.35pt;"><span class="texto">Nombre del solicitante</span></p></td>
                        <td colspan="2"><strong><span class="texto" > {% if(solicitud.ANONIMO) %}ANONIMO{% else %}{{ solicitud.NOMBRE ~ ' ' ~ solicitud.APELLIDO_PATERNO  ~ ' ' ~ solicitud.APELLIDO_MATERNO  }}{% endif %}</span></strong></td>
                    <tr>
                        <td style="text-align: right"><p style="margin: 4.6pt 0cm .0001pt 69.35pt;"><span class="texto">No. de folio</span></p></td>
                        <td colspan="2"><strong><span class="texto" >{{solicitud.FOLIO}}</span></strong></td>
                    </tr>
                    <tr>
                        <td  colspan="3">
                            <p style="margin: 0.35pt 7.35pt 0.0001pt 5.2pt; text-align: justify;">
                            <span style="font-family: 'Calibri','sans-serif'; font-size: 10.4018px;">
                            Para&nbsp; efecto&nbsp; de&nbsp; computar&nbsp; los&nbsp; plazos&nbsp; establecidos&nbsp; en&nbsp;
                                los&nbsp; art&iacute;culos&nbsp; 125,&nbsp; 130&nbsp; y&nbsp; 134&nbsp; de&nbsp; la&nbsp;
                                Ley&nbsp; de&nbsp; Transparencia&nbsp; y&nbsp; Acceso&nbsp; a&nbsp; la Informaci&oacute;n P&uacute;blica del Estado de Quer&eacute;taro,
                                estos correr&aacute;n a partir del d&iacute;a h&aacute;bil siguiente a la recepci&oacute;n de su solicitud, de conformidad con el Acuerdo
                                por el que se da a conocer el calendario de suspensi&oacute;n de labores y el horario de atenci&oacute;n de la Unidad de Transparencia
                                del Poder Ejecutivo del Estado de Quer&eacute;taro para el ejercicio 2018.
                            </span>
                            </p>
                            <p style="line-height: 12pt; margin: 0cm 7.35pt 0.0001pt 5.2pt; text-align: justify;">
                            <span style="font-family: 'Calibri','sans-serif'; font-size: 10.4018px;">Asimismo se hace de su conocimiento que al haber presentado su solicitud por correo electr&oacute;nico,
                                acepta que las notificaciones y resoluciones que se formulen derivado de &eacute;sta, sean por el mismo medio.
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;" colspan="3" bgcolor="#d9d9d9">
                            <p style="margin: 0">
                                <strong>
                                <span style="font-size: 11.3984px; font-family: 'Calibri','sans-serif'; color: #6f2f9f;">
                                    Plazos de respuesta a la solicitud de acceso a la informaci&oacute;n p&uacute;blica</span>
                                    <span style="font-size: 7.0pt; font-family: 'Calibri','sans-serif'; color: #6f2f9f; position: relative; top: -4.0pt;">2</span>
                                </strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p><strong><span class="texto" >Requerimiento a efecto de solicitar elementos adicionales o corregir informaci&oacute;n.</span></strong><br>
                                <span style="font-size: 8.0pt; font-family: 'Calibri','sans-serif';">
                                Este</span><span style="font-size: 8.0pt; font-family: 'Calibri','sans-serif';"> requerimiento interrumpir&aacute; el plazo de respuesta establecido
                            en el art&iacute;culo 130 de la le Ley en la materia, por lo que comenzar&aacute; a computarse nuevamente, al d&iacute;a siguiente del desahogo
                            por parte del particular. En este caso, el sujeto obligado atender&aacute; la solicitud en los t&eacute;rminos en que fue desahogado el requerimiento de informaci&oacute;n adicional.</span></p>
                        </td>
                        <td><strong><span class="texto">5 días hábiles</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p><strong><span class="texto" >Respuesta a la solicitud</span></strong></p></td>
                        <td><strong><span class="texto" >20 días hábiles</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p><strong><span class="texto" >Notificación de ampliación de plazo</span></strong></p></td>
                        <td><strong><span class="texto" >20 días hábiles</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p><strong><span class="texto" >Respuesta a la solicitud, en caso de que haya recibido notificación de ampliación de plazo</span></strong></p></td>
                        <td><strong><span class="texto" >30 días hábiles</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" bgcolor="#d9d9d9">
                            <p style="font-family: 'Calibri','sans-serif'; font-size: 10.4018px;">
                            La Unidad de Transparencia del Poder Ejecutivo
                            del Estado de Quer&eacute;taro es el organismo responsable del tratamiento de los&nbsp; datos&nbsp;
                            que&nbsp; nos&nbsp; proporcione,&nbsp; mismos&nbsp; que&nbsp; ser&aacute;n&nbsp; utilizados&nbsp;
                            para&nbsp; efectuar&nbsp; el&nbsp; tr&aacute;mite&nbsp; de&nbsp; su&nbsp; solicitud&nbsp; de&nbsp;
                            acceso&nbsp; a&nbsp; la informaci&oacute;n p&uacute;blica. Consulte nuestro aviso de privacidad en http://bit.ly/2zqyiGf o en la oficina de atenci&oacute;n de la Unidad
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p style="margin-top: .3pt; line-height: 13.0pt;"><span style="font-size: 13.0pt;">&nbsp;</span></p>
                <p style="margin: 1.55pt 0cm .0001pt 40.1pt;"><span style="font-size: 4.5pt; font-family: 'Calibri','sans-serif'; position: relative; top: -2.0pt;">1&nbsp; </span><span style="font-size: 7.0pt; font-family: 'Calibri','sans-serif';">Se recomienda conservar el presente acuse para fines informativos y aclaraciones.</span></p>
                <p style="margin-left: 40.1pt;"><span style="font-size: 4.5pt; font-family: 'Calibri','sans-serif'; position: relative; top: -2.0pt;">2&nbsp; </span><span style="font-size: 7.0pt; font-family: 'Calibri','sans-serif';">Las solicitudes recibidas en un d&iacute;a inh&aacute;bil o despu&eacute;s de las 15:30 horas de un d&iacute;a h&aacute;bil, se dan por recibidas al siguiente d&iacute;a h&aacute;bil.</span></p>
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>