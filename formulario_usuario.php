<?php include 'componentes/control_sesiones.php'; ?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>

        <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css"/>
        <script src="js/foundation-datepicker.js" type="text/javascript"></script>
        <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

        <script src="interfaces/datos_usuario.js?cant=tell&if=is_true&ver=1" type="text/javascript"></script>

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

        </script>
    </head>
    <body ng-app="datosUsuarioApp" ng-controller="datosUsuarioController" >        
        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="grid-x">                    
                    <div class="cell small-12">
                        <h4 class="text-center">Mis Datos</h4>
                    </div>
                    <div class="cell small-12 medium-3">
                        <div class="grid-x grid-padding-x">
                            <div class="cell small-12 medium-12">     
                                <br/>
                                <div ng-show="usuario_en_sesion.id_rol == 1">                    
                                    <a class="button small expanded" ng-href="estado_cuenta.php?id_usuario={{datos_usuario.id}}" >Estado Cuenta</a>
                                </div>
                                <div ng-show="usuario_en_sesion.id_rol == 2">
                                    <a class="button small expanded" ng-href="estado_cuenta.php?id_usuario={{datos_usuario.id}}" >Estado Cuenta</a>
                                    <a class="button small expanded" ng-href="catalogo.php?id_usuario={{datos_usuario.id}}" >Catalogo</a>
                                    <button class="button small expanded" data-open="modal_llamadas" ng-click="ObtenerCategoriasLlamada()" >Capturar Llamada</button>
                                    <button class="button small expanded" ng-click="RestaurarClaveUsuario()" >Restaurar Clave Usuario</button>
                                    <button class="button small expanded" data-open="modal_redenciones" ng-click="ObtenerRedenciones()">Redenciones</button>
                                </div>
                            </div> 
                        </div>

                    </div>
                    <div class="cell small-12 medium-9">
                        <div class="grid-x grid-padding-x">
                            <div class="medium-4 cell">
                                <label>
                                    Cédula
                                    <input type="text" placeholder="Cédula" ng-change="VerificarCambios()" ng-model="datos_usuario.cedula">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Nombre
                                    <input type="text" placeholder="Nombre" ng-change="VerificarCambios()" ng-model="datos_usuario.nombre">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Teléfono
                                    <input type="text" placeholder="Teléfono" ng-change="VerificarCambios()" ng-model="datos_usuario.telefono">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Celular
                                    <input type="text" placeholder="Celular" ng-change="VerificarCambios()" ng-model="datos_usuario.celular">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Fecha de Nacimiento
                                    <input id='txt_fecha_nacimiento' type="text" placeholder="YYYY-MM-DD" ng-change="VerificarCambios()" ng-model="datos_usuario.fecha_nacimiento">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Dirección
                                    <input type="text" placeholder="Dirección" ng-change="VerificarCambios()" ng-model="datos_usuario.direccion">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <div ng-show="!modificar_ciudad">
                                    <label ng-show="ciudades.length == 0">
                                        Ciudad <a href="#" ng-click="modificar_ciudad = true; nombre_ciudad = ''">
                                            <i class="fa fa-edit"></i> Cambiar Ciudad</a>
                                        <input type="text" ng-disabled="true" placeholder="Nombre de la ciudad" ng-model="nombre_ciudad" required>
                                    </label>
                                </div>
                                <div ng-show="modificar_ciudad">
                                    <label ng-show="ciudades.length == 0">
                                        Ciudad
                                        <input type="text" placeholder="Nombre de la ciudad" ng-blur="BuscarCiudad()" ng-model="nombre_ciudad" required>
                                        <button type="button" class="button">Seleccionar Ciudad <i class="fa fa-search"></i></button>
                                    </label>
                                    <label ng-show="ciudades.length > 0">
                                        Seleccionar Ciudad
                                        <select id="dd_ciudad_usuario" ng-model='datos_usuario.id_ciudad' ng-change="VerificarCambios()">
                                            <option ng-repeat="ciudad in ciudades track by $index" value='{{ciudad.id}}'>{{ciudad.nombre}}</option>
                                        </select>
                                        <button class="button alert" ng-click="ciudades = []; nombre_ciudad = '';"><i class="fa fa-arrow-left"></i> Cambiar</button>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Correo
                                    <input type="email" placeholder="Correo" ng-change="VerificarCambios()" ng-model="datos_usuario.correo_corporativo">
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Genero
                                    <select ng-model='datos_usuario.genero' ng-change="VerificarCambios()">
                                        <option value='m'>Masculino</option>
                                        <option value='f'>Femenino</option>
                                    </select>
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                <label>
                                    Operador de telefonía
                                    <select ng-model='datos_usuario.operador' ng-change="VerificarCambios()">
                                        <option value='1'>Movistar</option>
                                        <option value='2'>Tigo</option>
                                        <option value='3'>Exito</option>
                                        <option value='4'>Claro</option>
                                        <option value='5'>Virgin</option>
                                        <option value='6'>Uff</option>                                        
                                        <option value='7'>ETB</option>
                                        <option value='8'>Avantel</option>
                                    </select>
                                    <br/> 
                                </label>
                            </div>
                            <div class="medium-4 cell">
                                Tiene whatsapp
                                <div class="switch large">
                                    <input class="switch-input" id="yes-no" type="checkbox" ng-model="datos_usuario.whatsapp" ng-change="VerificarCambios()" >
                                    <label class="switch-paddle" for="yes-no">
                                        <span class="show-for-sr">¿Tiene whatsapp?</span>
                                        <span class="switch-active" aria-hidden="true">Si</span>
                                        <span class="switch-inactive" aria-hidden="true">No</span>
                                    </label>
                                </div>
                            </div>


                            <div class="medium-4 cell">
                                <labels>
                                    Estado
                                    <select ng-disabled="usuario_en_sesion.id_rol != 2" ng-model='datos_usuario.id_estado' ng-change="VerificarCambios()">
                                        <option value='1'>Activo</option>
                                        <option value='0'>Inactivo</option>
                                        <option value='2'>Descalificado</option>
                                    </select>
                                    </label>
                            </div>

                            <div class="medium-12 cell text-center" ng-show="usuario_en_sesion.id_rol != 3">
                                <br/>
                                <button class="button expanded" ng-click="ActualizarDatosUsuario()">Actualizar Información</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="large reveal" id="modal_llamadas" data-reveal>
            <h5>Captura de llamadas</h5>
            <label>
                <a ng-repeat="item in anteriores track by $index" >{{item}} - </a> 
                <span class="fa fa-remove" ng-show="anteriores.length > 0" aria-hidden="true" ng-click="ObtenerSubcategorias(-1)"></span>
            </label>
            <label ng-show='subCategorias.length > 0'>
                Categoria llamada
                <select id='categoriaLlamada' ng-model='subCategoria' ng-change='ObtenerSubcategorias(subCategoria)'>
                    <option value='0' ng-selected="true">Seleccionar</option>
                    <option ng-repeat="item in subCategorias track by item.ID" value='{{item.ID}}  '>{{item.NOMBRE}}</option>
                </select>
            </label>
            <label>
                Comentarios
                <textarea rows="4" ng-model='llamada.comentario' maxlength="250" ></textarea>
            </label>
            <button type="button" class="button" 
                    ng-click="RegistraLlamada()" 
                    ng-disabled=" !(subCategorias.length == 0 && llamada.comentario.length > 0)">
                Registrar llamada
            </button>
            <br/>
            <div style="height: 200px; overflow-y: auto">
                <table>
                    <thead>
                    <th>FECHA</th>
                    <th>CATEGORIA</th>
                    <th>REGISTRO</th>
                    <th>COMENTARIO</th>
                    </thead>
                    <tr ng-repeat="llamada in llamadas_usuarios track by $index">
                        <td>{{llamada.fecha}}</td>
                        <td>{{llamada.categoria}}</td>
                        <td>{{llamada.registro}}</td>
                        <td>{{llamada.comentario}}</td>
                    </tr>    
                </table>
            </div>

            <br/>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="small reveal" id="modal_clave" data-reveal>
            <h5>Actualizar Clave</h5>
            <div ng-show="datos_usuario.acepto_terminos == 0">
                Para aceptar los términos y condiciones  y continuar al programa debe asignar una nueva clave
                <br/>
                <!--<iframe
                    src="Terminos_y_Condiciones.pdf" frameborder="0" width="655" height="550" marginheight="0" marginwidth="0" id="pdf">
                    Ver los términos y condiciones
                </iframe>-->
                <br/>
                <input ng-init="acepta_terminos = false;" ng-model="acepta_terminos" id="checkbox1" type="checkbox"><label for="checkbox1">Aceptar terminos y condiciones</label>
            </div>
            <label ng-show="datos_usuario.acepto_terminos == 1">
                Clave Actual
                <input type="password" ng-model="datos_clave.clave_actual" placeholder="Clave Actual">
            </label>
            <label>
                Clave Nueva
                <input type="password" ng-model="datos_clave.clave_nueva" placeholder="Clave Nueva">
            </label>

            <label>
                Confirmación Clave Nueva
                <input type="password" ng-model="datos_clave.clave_confirma" placeholder="Confirma Clave Nueva">
            </label>
            <br/>
            <br/>
            <button type="button" class="button" 
                    ng-click="VerificaClave()" 
                    ng-disabled="(datos_usuario.acepto_terminos == 0 && !acepta_terminos) && datos_usuario.acepto_terminos != 1" >
                Actualizar Clave
            </button>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>     

        <div class="reveal large" id="modal_redenciones" data-reveal>
            <h5>Redenciones</h5>
            <table>
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Premio</th>
                        <th>Fecha Redencion</th>
                        <th>Puntos</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="redencion in redenciones track by $index">
                        <td>{{redencion.folio}}</td>
                        <td>{{redencion.premio}}</td>
                        <td>{{redencion.fecha_redencion}}</td>
                        <td>{{redencion.puntos}}</td>
                        <td>{{redencion.operacion}}</td>
                        <td><a ng-show="usuario_en_sesion.id_rol == 2" href="estados_redenciones.php?id_redencion={{redencion.folio}}" class="button small"><i class="fa fa-edit"></i></a></td>
                    </tr>
                </tbody>
            </table>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>  

        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>