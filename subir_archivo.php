<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>

        <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css"/>
        <script src="js/foundation-datepicker.js" type="text/javascript"></script>
        <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

        <script src="js/angular-filter.js" type="text/javascript"></script>

        <script src="interfaces/subir_archivos.js?cant=tell&if=is_true&ver=2" type="text/javascript"></script>

        <script>
            var id_usuario = 0;
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            if (typeof getParameterByName("id_usuario") !== 'undefined' && getParameterByName("id_usuario") != "")
            {
                id_usuario = getParameterByName("id_usuario");
            } else
            {
                alert("No hay usuario seleccionado.");
                document.location.href = "listado_usuarios.php";
            }

            $(function () {
                $('#fecha_factura').fdatepicker({
                    format: 'yyyy-mm-dd',
                    disableDblClickSelection: true,
                    language: 'en',
                    pickTime: false
                });
            });
        </script>

        <style>
            .image_ajust{            
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: '200px';
                border: 1px solid #0000;            
            }
        </style>

    </head>
    <body ng-app="subirArchivosApp" ng-controller="subirArchivosController">  
        <div id="main_container" class="grid-container off-canvas-content" ng-init="SeleccionarAlmacen();">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>          

                <div class="grid-x grid-margin-x">

                    <div class="cell small-12">
                        <h4 class="text-center">Subir Archivos</h4>
                    </div>    

                    <form id="dataForm" name="dataForm" ng-submit="CargarArchivos()">
                        <div class="cell small-12 medium-6">   
                            <h6>1) Seleccione factura y/o remisión.</h6>
                            <input type="file" accept="image/*" id="uploadExhibicion" class="input_foto" data-img="#img_perfil" />


                            <div style="width: 300px; " class='img-container image_ajust'  id='img_perfil' data-upload='#img_perfil'>

                            </div>             

                            <div class="cell small-12 medium-4">
                                <h6>2) Seleccione Fecha de compra.</h6>
                                <div class="form-group">
                                    <input type="text" autocomplete="off"  id="fecha_factura" required>
                                </div>
                            </div>
                            <div class="cell small-12 medium-4">
                                <h6>3) Nombre establecimiento</h6>
                                <div class="form-group">
                                    <select name="id_almacenes" id="id_almacenes" required >
                                        <option value="0">Éxito</option>
                                        <option value="1">Carulla</option>
                                        <option value="2">Olímpica</option>
                                        <option value="3">Farmatodo</option>
                                        <option value="4">Jumbo</option>
                                        <option value="5">Metro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="cell small-12 medium-4">
                                <h6>3) Ingrese número de factura y/o remisión.</h6>
                                <div class="form-group">
                                    <input type="text" name="num_factura" autocomplete="off"  id="num_factura" required >
                                </div>
                            </div>

                            <div class="cell small-12 medium-12">                            
                                <h6>4) Precio</h6>
                                <div class="form-group">
                                    <input type="text" name="precio" autocomplete="off"  id="precio" required >
                                </div>                          
                            </div>     

                            <!-- REFERENECIA VIDRIO AZUL -->
                            <div class="cell small-12 medium-8" >
                                <h6>5) Ingrese los datos del producto que compraste.</h6>                                 
                                <div class="grid-x grid-margin-x" >
                                    <div class="cell small-12 medium-4">                                    
                                        <h6>Nombre de producto</h6>
                                    </div>
                                    <div class="cell small-12 medium-4">
                                        <h6>Nombre de Homologado</h6>

                                    </div>
                                    <div class="cell small-12 medium-4">
                                        <h6>Cantidad</h6>
                                    </div>
                                </div>

                                <div ng-repeat="data in Profiles">
                                    <div class="grid-x grid-margin-x" >
                                        <div class="cell small-12 medium-4">                       
                                            <div class="form-group">
                                                <input type="text" ng-model="data.nombre_producto_negocio" id="referencia_{{$index}}" name="referencia_{{$index}}" required>
                                            </div>                                                                                 
                                        </div>
                                        <div class="cell small-12 medium-4">
                                            <div class="form-group">
                                                <select ng-model="data.nombre_producto_homologado" id="espesor_{{$index}}" name="espesor_{{$index}}" required>
                                                    <option value='0'>Seleccionar</option>
                                                    <option value='1'>Chocolate Abuelita</option>
                                                    <option value='2'>MILO® Vending</option>
                                                    <option value='3'>Cappuccino Original</option>
                                                    <option value='4'>Cappuccino Vainilla</option>
                                                    <option value='5'>Chococcino Coco</option>
                                                    <option value='6'>Café latte Vainilla</option>
                                                    <option value='7'>Tinto</option>
                                                    <option value='8'>Cortado</option>
                                                    <option value='9'>Espresso</option>
                                                    <option value='10'>Espresso Doble</option>
                                                    <option value='11'>Ristreto</option>
                                                    <option value='12'>Americano</option>
                                                    <option value='13'>Latte</option>
                                                    <option value='14'>Mokanella Capuccino</option>
                                                </select>
                                            </div>  
                                        </div>
                                        <div class="cell small-12 medium-4">
                                            <div class="form-group">                                                
                                                <input type="text" ng-model="data.cantidad"  name="metros_{{$index}}" class="span2" id="metros_{{$index}}" title="Caracteres Invalidos Ejemplo: 10.5" pattern="[0-9]+([.][0-9]+)?" required>
                                            </div>
                                        </div>
                                        <div class="cell small-12 medium-4">
                                            <button ng-hide="$first"  type="button" class='button small alert' ng-click="delete($index)">Eliminar</button>
                                        </div>  
                                    </div>   
                                </div>               
                                <button  type="button" class='button secondary' ng-click="add()"><i class="fa fa-plus"></i> Agregar Articulo</button> 
                                <hr>
                                <div class="cell small-12">
                                    <h6>6) Verifica que la información es correcta.</h6>
                                    <h6>7) Registra tu compra!!!</h6>
                                    <button  type="submit" class='button expanded'>Haz click Aqui para finalizar el proceso</button>
                                </div>
                            </div>                            
                        </div>
                    </form>

                    <div class="cell small-12 medium-3">
                        <div ng-repeat="(key, value) in archivos | groupBy: 'img_factura' ">        
                            <div class="equipo" ng-repeat="imagenes in value" ng-hide="imagenes.validacion == 1">
                                <div class="imagen">
                                    <a ng-if="$first" href="clases/archivos/{{imagenes.id_usuario}}/{{imagenes.img_factura}}" download>
                                        <img border="0" ng-src="clases/archivos/{{imagenes.id_usuario}}/{{imagenes.img_factura}}"/>
                                    </a>
                                </div>
                                <button  class="button alert expanded" ng-click="EliminarArchivos(imagenes.id)">                                
                                    <i class="fa fa-trash"></i>   Borrar 
                                </button>
                                <button ng-if="$first" class="button success expanded" data-open="detalle_archivo" ng-click="ObtenerDetallesArchivos(imagenes.num_factura)">                                
                                    <i class="fa fa-desktop"></i>   Ver Detalles 
                                </button>
                            </div>
                        </div>
                    </div>
                </div>            

                <div class="reveal large" id="detalle_archivo" data-reveal>
                    <h1>Detalle Archivo</h1>
                    <table>
                        <thead>
                        <th>Fecha Factura</th>
                        <th>Nombre Negocio</th>
                        <th>Nombre Homologado</th>
                        <th>Cantidad</th>
                        <th>Fecha Carga</th>
                        <th>Num Factura</th>
                        <th>Almacen</th>                        
                        </thead>
                        <tbody>
                            <tr ng-repeat="detalle in detalle_archivos track by $index">
                                <td>{{detalle.fecha_factura}}</td>
                                <td>{{detalle.producto_negocio}}</td>
                                <td>{{detalle.producto_homologado}}</td>
                                <td>{{detalle.cantidad}}</td>
                                <td>{{detalle.fecha_carga}}</td>
                                <td>{{detalle.num_factura}}</td>
                                <td>{{detalle.almacen}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="close-button" data-close aria-label="Close modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>
