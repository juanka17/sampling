<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>

        <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css"/>
        <script src="js/foundation-datepicker.js" type="text/javascript"></script>
        <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

        <script src="interfaces/estados_redencion.js?ver=2" type="text/javascript"></script>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            var id_redencion = 0;
        </script>

    </head>
    <body ng-app="estadosRedencionApp" ng-controller="estadosRedencionController">
        <div id="main_container" class="grid-container off-canvas-content">            
            <div class="callout1">  
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div id="main_container" class="grid-container off-canvas-content">
                    <div class="callout">

                        <div class="row" ng-show="redencion.operacion != 'Encuestado'">
                            <div class="col-sm-12">
                                <br/>
                                <h3>Actualización masiva</h3>
                            </div>
                            <div class="col-sm-9">
                                Ingrese los folios a ser modificados con la siguiente organización: 
                                <ul>
                                    <li>
                                        <p>Cada fila debe contener los siguientes datos separados por este carácter |:</p>
                                        <p>
                                            <b>
                                                Por ejemplo a continuación se muestra el modelo para indicar que el folio 
                                                con número 1234 cambiará a estado Enviado y en su comentario se indicará la 
                                                información relevante del cambio de estado en este caso Enviado por trasportadora 
                                                envia, y finalmente el número de referencia será el número de guía que se usará 
                                                200009339992.
                                            </b>
                                        </p>
                                        <p>
                                            <b>
                                                1234|3|Enviado por trasportadora envia|838389202
                                            </b>
                                        </p>
                                    </li>
                                    <li>
                                        Los datos estan listados a continuación
                                        <ul>
                                            <li>Número de folio a modificar</li>
                                            <li>Estado a modificar</li>
                                            <li>Comentario *</li>
                                            <li>Codigo de referencia (N° de Guia, N° de Folio)</li>
                                        </ul>
                                    </li>
                                </ul>
                                <i>* El comentario debe ser maximo de 100 carácteres y se recomienda que se ingrese información concreta y relevante como el número de guía.</i>
                            </div>
                            <div class="col-sm-9">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Estados posibles</th>
                                        </tr>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>1</td><td>Redimido</td></tr>
                                        <tr><td>2</td><td>Solicitado</td></tr>
                                        <tr><td>3</td><td>Enviado</td></tr>
                                        <tr><td>4</td><td>Entregado</td></tr>
                                        <tr><td>5</td><td>Cancelado</td></tr>
                                        <tr><td>6</td><td>Novedad</td></tr>
                                        <tr><td>7</td><td>Encuestado</td></tr>
                                        <tr><td>8</td><td>Despachado</td></tr>
                                        <tr><td>9</td><td>Garantia En Proceso</td></tr>
                                        <tr><td>10</td><td>Devolución - Ausente</td></tr>
                                        <tr><td>11</td><td>Devolución - No reside</td></tr>
                                    </tbody>
                                </table>         
                                <b>Cantidad de folios:</b> {{informacion_folios.cantidad}}
                                <br/>
                                <b>Estructura correcta:</b> {{informacion_folios.folios_correctos}}
                                <br/>
                                <b>Estructura incorrecta:</b> {{informacion_folios.cantidad - informacion_folios.folios_correctos}}
                                <br/>
                                <b>Procesados correctamente:</b> {{informacion_folios.folios_procesados}}
                                <br/>
                                <button class="button button-primary" 
                                        ng-click="ProcesarFoliosMasivos()"
                                        ng-disabled=" !(informacion_folios.cantidad > 0 && informacion_folios.cantidad == informacion_folios.folios_correctos)">
                                    Procesar folios
                                </button>
                            </div>
                            <div class="col-sm-12">
                                <br/>
                                <textarea ng-model="informacion_folios.listado" ng-change="SumarioFoliosMasivos()" rows="10" style="width: 100%;"></textarea>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>