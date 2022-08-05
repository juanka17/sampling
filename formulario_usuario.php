<?php include 'componentes/control_sesiones.php'; ?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>

    <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css" />
    <script src="js/foundation-datepicker.js" type="text/javascript"></script>
    <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

    <script src="interfaces/datos_usuario.js?cant=tell&if=is_true&ver=2" type="text/javascript"></script>

    <script>
    var id_usuario = 0;
    var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
    if (typeof getParameterByName("id_usuario") !== 'undefined' && getParameterByName("id_usuario") != "") {
        id_usuario = getParameterByName("id_usuario");
    } else {
        alert("No hay usuario seleccionado.");
        document.location.href = "listado_usuarios.php";
    }
    </script>
</head>

<body ng-app="datosUsuarioApp" ng-controller="datosUsuarioController">
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
                            <br />
                            <div ng-show="usuario_en_sesion.id_rol == 1">
                                <a class="button small expanded"
                                    ng-href="estado_cuenta.php?id_usuario={{datos_usuario.id}}">Estado Cuenta</a>
                            </div>
                            <div ng-show="usuario_en_sesion.id_rol == 2">
                                <a class="button small expanded"
                                    ng-href="estado_cuenta.php?id_usuario={{datos_usuario.id}}">Estado Cuenta</a>
                                <a class="button small expanded"
                                    ng-href="catalogo.php?id_usuario={{datos_usuario.id}}">Catalogo</a>
                                <button class="button small expanded" data-open="modal_llamadas"
                                    ng-click="ObtenerCategoriasLlamada()">Capturar Llamada</button>
                                <button class="button small expanded" ng-click="RestaurarClaveUsuario()">Restaurar Clave
                                    Usuario</button>
                                <button class="button small expanded" data-open="modal_redenciones"
                                    ng-click="ObtenerRedenciones()">Redenciones</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="cell small-12 medium-9">
                    <div class="grid-x grid-padding-x">
                        <div class="medium-4 cell">
                            <label>
                                Cédula
                                <input type="text" placeholder="Cédula" ng-change="VerificarCambios()"
                                    ng-model="datos_usuario.cedula">
                            </label>
                        </div>
                        <div class="medium-4 cell">
                            <label>
                                Nombre
                                <input type="text" placeholder="Nombre" ng-change="VerificarCambios()"
                                    ng-model="datos_usuario.nombre">
                            </label>
                        </div>
                        <div class="medium-4 cell">
                            <label>
                                Teléfono
                                <input type="text" placeholder="Teléfono" ng-change="VerificarCambios()"
                                    ng-model="datos_usuario.telefono">
                            </label>
                        </div>
                        <div class="medium-4 cell">
                            <label>
                                Celular
                                <input type="text" placeholder="Celular" ng-change="VerificarCambios()"
                                    ng-model="datos_usuario.celular">
                            </label>
                        </div>
                        <div class="medium-4 cell">
                            <label>
                                Fecha de Nacimiento
                                <input id='txt_fecha_nacimiento' type="text" placeholder="YYYY-MM-DD"
                                    ng-change="VerificarCambios()" ng-model="datos_usuario.fecha_nacimiento">
                            </label>
                        </div>


                        <div class="medium-4 cell">
                            Dirección <a href="#" ng-click="AbrirModalDireccion()">
                                <i class="fa fa-edit"></i> Agregar dirección</a>
                            <label>

                                <input type="text" ng-disabled="true" placeholder="Direccion" 
                                    ng-model="datos_usuario.direccion" required>
                            </label>

                            <div ng-show="modificar_direccion">
                                <label ng-show="ciudades.length == 0">
                                    Direccion

                                </label>

                                <label ng-show="ciudades.length > 0">
                                    Seleccionar Ciudad
                                    <select id="dd_ciudad_usuario" ng-model='datos_usuario.id_ciudad'
                                        ng-change="VerificarCambios()">
                                        <option ng-repeat="ciudad in ciudades track by $index" value='{{ciudad.id}}'>
                                            {{ciudad.nombre}}</option>
                                    </select>
                                    <button class="button alert" ng-click="ciudades = []; nombre_ciudad = '';"><i
                                            class="fa fa-arrow-left"></i> Cambiar</button>
                                </label>
                            </div>
                        </div>

                        <div class="medium-4 cell">
                            <div ng-show="!modificar_ciudad">
                                <label ng-show="ciudades.length == 0">
                                    Ciudad <a href="#" ng-click="modificar_ciudad = true; nombre_ciudad = ''">
                                        <i class="fa fa-edit"></i> Cambiar Ciudad</a>
                                    <input type="text" ng-disabled="true" placeholder="Nombre de la ciudad"
                                        ng-model="nombre_ciudad" required>
                                </label>
                            </div>
                            <div ng-show="modificar_ciudad">
                                <label ng-show="ciudades.length == 0">
                                    Ciudad
                                    <input type="text" placeholder="Nombre de la ciudad" ng-blur="BuscarCiudad()"
                                        ng-model="nombre_ciudad" required>
                                    <button type="button" class="button">Seleccionar Ciudad <i
                                            class="fa fa-search"></i></button>
                                </label>
                                <label ng-show="ciudades.length > 0">
                                    Seleccionar Ciudad
                                    <select id="dd_ciudad_usuario" ng-model='datos_usuario.id_ciudad'
                                        ng-change="VerificarCambios()">
                                        <option ng-repeat="ciudad in ciudades track by $index" value='{{ciudad.id}}'>
                                            {{ciudad.nombre}}</option>
                                    </select>
                                    <button class="button alert" ng-click="ciudades = []; nombre_ciudad = '';"><i
                                            class="fa fa-arrow-left"></i> Cambiar</button>
                                </label>
                            </div>
                        </div>
                        <div class="medium-4 cell">
                            <label>
                                Correo
                                <input type="email" placeholder="Correo" ng-change="VerificarCambios()"
                                    ng-model="datos_usuario.correo_corporativo">
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
                                <br />
                            </label>
                        </div>
                        <div class="medium-4 cell">
                            Tiene whatsapp
                            <div class="switch large">
                                <input class="switch-input" id="yes-no" type="checkbox"
                                    ng-model="datos_usuario.whatsapp" ng-change="VerificarCambios()">
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
                                <select ng-disabled="usuario_en_sesion.id_rol != 2" ng-model='datos_usuario.id_estado'
                                    ng-change="VerificarCambios()">
                                    <option value='1'>Activo</option>
                                    <option value='0'>Inactivo</option>
                                    <option value='2'>Descalificado</option>
                                </select>
                                </label>
                        </div>

                        <div class="medium-12 cell text-center" ng-show="usuario_en_sesion.id_rol != 3">
                            <br />
                            <button class="button expanded" ng-click="ActualizarDatosUsuario()">Actualizar
                                Información</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="large reveal" id="modaldireccion" data-reveal>
        <h5>Dirección de residencia</h5>
<form ng-submit="GuardarDireccion()">
<div class="grid-x grid-margin-x">
        <div class="medium-4 cell">
            <label>
                Seleccione departamento *
                <select id="dd_departamento_usuario" ng-model='datos_direccion.dpt_direccion'
                    ng-change="ObtenerCiudad(datos_direccion.dpt_direccion)">
                    <option ng-repeat="d in departamentos_direccion track by $index" value='{{d.ID}}'>
                        {{d.NOMBRE}}</option>
                </select>
            </label>
        </div>

        <div class="medium-4 cell">
            <label>
                Seleccione ciudad *
                <select id="dd_ciudad_usuario" ng-model='datos_direccion.ciudad_direccion'
                    ng-change="ValidarLocalidad(datos_direccion.ciudad_direccion)">
                    <option ng-repeat="c in ciudades_direccion track by $index" value='{{c.ID}}'>
                        {{c.NOMBRE}}</option>
                </select>

            </label>
        </div>

        <div class="medium-4 cell">
            <label ng-if="MostrarLocalidad">
                Seleccionar localidad *
                <select ng-model="datos_direccion.localidad_direccion" required>
                    <option value=''>Seleccione...</option>
                    <option value='Usaquén'>Usaquén</option>
                    <option value='Chapinero'>Chapinero</option>
                    <option value='Santa Fe'>Santa Fe</option>
                    <option value='San Cristóbal'>San Cristóbal</option>
                    <option value='Usme'>Usme</option>
                    <option value='Tunjuelito'>Tunjuelito</option>
                    <option value='Bosa'>Bosa</option>
                    <option value='Kennedy'>Kennedy</option>
                    <option value='Fontibón'>Fontibón</option>
                    <option value='Engativa'>Engativa</option>
                    <option value='Suba'>Suba</option>
                    <option value='Barrios Unidos'>Barrios Unidos</option>
                    <option value='Teusaquillo'>Teusaquillo</option>
                    <option value='Los Mártires'>Los Mártires</option>
                    <option value='Antonio Nariño'>Antonio Nariño</option>
                    <option value='Puente Aranda'>Puente Aranda</option>
                    <option value='Candelaria'>Candelaria</option>
                    <option value='Rafael Uribe Uribe'>Rafael Uribe Uribe</option>
                    <option value='Ciudad Bolívar'>Ciudad Bolívar</option>
                    <option value='Sumapaz'>Sumapaz</option>
                </select>
            </label>
        </div>
</div>
        <div class="grid-x grid-margin-x">
            <div class="cell small-4">
                <label>
                    Vía *
                    <select ng-model="datos_direccion.via" required>
                        <option value=''>Seleccione...</option>
                        <option value='Avenida calle'>Avenida calle</option>
                        <option value='Calle'>Calle</option>
                        <option value='Carrera'>Carrera</option>
                        <option value='Circular'>Circular</option>
                        <option value='Circunvalar'>Circunvalar</option>
                        <option value='Diagonal'>Diagonal</option>
                        <option value='Transversal'>Transversal</option>
                    </select>
                    <br />
                </label>
            </div>
            <div class="cell small-4"><label>
                    Número *
                    <input type="number" placeholder="" ng-model="datos_direccion.numero" required>
                </label></div>
            <div class="cell small-4"> <label>
                    Letra
                    <select ng-model="datos_direccion.letra">
                        <option value=''>Seleccione...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                        <option value="J">J</option>
                        <option value="K">K</option>
                        <option value="L">L</option>
                        <option value="M">M</option>
                        <option value="N">N</option>
                        <option value="O">O</option>
                        <option value="P">P</option>
                        <option value="Q">Q</option>
                        <option value="R">R</option>
                        <option value="S">S</option>
                        <option value="T">T</option>
                        <option value="U">U</option>
                        <option value="V">V</option>
                        <option value="W">W</option>
                        <option value="X">X</option>
                        <option value="Y">Y</option>
                        <option value="Z">Z</option>
                    </select>
                    <br />
                </label></div>

            <div class="cell small-4">
                <label>
                    BIS
                    <select ng-model="datos_direccion.bis">
                        <option value='bis'>BIS</option>
                    </select>
                    <br />
                </label>
            </div>

            <div class="cell small-4"> <label>
                    Complemento
                    <select ng-model="datos_direccion.complemento">
                        <option value=''>Seleccione...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                        <option value="J">J</option>
                        <option value="K">K</option>
                        <option value="L">L</option>
                        <option value="M">M</option>
                        <option value="N">N</option>
                        <option value="O">O</option>
                        <option value="P">P</option>
                        <option value="Q">Q</option>
                        <option value="R">R</option>
                        <option value="S">S</option>
                        <option value="T">T</option>
                        <option value="U">U</option>
                        <option value="V">V</option>
                        <option value="W">W</option>
                        <option value="X">X</option>
                        <option value="Y">Y</option>
                        <option value="Z">Z</option>
                    </select>
                    <br />
                </label></div>

            <div class="cell small-4">
                <label>
                    Cardinalidad
                    <select ng-model="datos_direccion.cardinalidad">
                        <option value=''>Seleccione...</option>
                        <option value='Norte'>Norte</option>
                        <option value='Sur'>Sur</option>
                        <option value='Este'>Este</option>
                        <option value='Oeste'>Oeste</option>
                        <option value='Centro'>Centro</option>
                    </select>
                    <br />
                </label>
            </div>

            <div class="cell small-4 text-center">#</div>

            <div class="cell small-4"><label>
                    Número *
                    <input type="number" placeholder="" ng-model="datos_direccion.numero1" required>
                </label></div>

            <div class="cell small-4"> <label>
                    Letra
                    <select ng-model="datos_direccion.letra1">
                        <option value=''>Seleccione...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                        <option value="J">J</option>
                        <option value="K">K</option>
                        <option value="L">L</option>
                        <option value="M">M</option>
                        <option value="N">N</option>
                        <option value="O">O</option>
                        <option value="P">P</option>
                        <option value="Q">Q</option>
                        <option value="R">R</option>
                        <option value="S">S</option>
                        <option value="T">T</option>
                        <option value="U">U</option>
                        <option value="V">V</option>
                        <option value="W">W</option>
                        <option value="X">X</option>
                        <option value="Y">Y</option>
                        <option value="Z">Z</option>
                    </select>
                    <br />
                </label></div>


            <div class="cell small-4 text-center">-</div>

            <div class="cell small-4"><label>
                    Complemento *
                    <input type="number" placeholder="Escriba el complemento del número"
                        ng-model="datos_direccion.complemento1" required>
                </label></div>

            <div class="cell small-4"> <label>
                    Cardinalidad
                    <select ng-model="datos_direccion.cardinalidad1">
                        <option value=''>Seleccione...</option>
                        <option value='Norte'>Norte</option>
                        <option value='Sur'>Sur</option>
                        <option value='Este'>Este</option>
                        <option value='Oeste'>Oeste</option>
                        <option value='Centro'>Centro</option>
                    </select>
                    <br />
                </label></div>

            <div class="cell small-4 text-center"><i class="fa fa-home"></i></a></div>

            <div class="cell small-4"><label>
                    Barrio *
                    <input type="text" placeholder="Escriba el barrio" ng-model="datos_direccion.barrio" required>
                </label></div>

            <div class="cell small-4"> <label>
                    Vivienda *
                    <select ng-model="datos_direccion.vivienda" required>
                        <option value=''>Seleccione...</option>
                        <option value="Casa">Casa</option>
                        <option value="Apartamento">Apartamento</option>
                    </select>
                    <br />
                </label></div>

            <div class="cell small-4 text-center"><i class=""></i></a></div>

            <div class="cell small-8">

                <label>
                    Otros *
                    <textarea rows="4" ng-model="datos_direccion.otros" maxlength="250" placeholder="Especificar detalles adicionales (torre, apto)" required></textarea>
                    
                </label>
            </div>

        </div>


        <button type="submit" class="button">
            Guardar
        </button>
        <br />
</form>
    </div>

    <div class="large reveal" id="modal_llamadas" data-reveal>
        <h5>Captura de llamadas</h5>
        <label>
            <a ng-repeat="item in anteriores track by $index">{{item}} - </a>
            <span class="fa fa-remove" ng-show="anteriores.length > 0" aria-hidden="true"
                ng-click="ObtenerSubcategorias(-1)"></span>
        </label>
        <label ng-show='subCategorias.length > 0'>
            Categoria llamada
            <select id='categoriaLlamada' ng-model='subCategoria' ng-change='ObtenerSubcategorias(subCategoria)'>
                <option value='0' ng-selected="true">Seleccionar</option>
                <option ng-repeat="item in subCategorias track by item.ID" value='{{item.ID}}  '>{{item.NOMBRE}}
                </option>
            </select>
        </label>
        <label>
            Comentarios
            <textarea rows="4" ng-model='llamada.comentario' maxlength="250"></textarea>
        </label>
        <button type="button" class="button" ng-click="RegistraLlamada()"
            ng-disabled=" !(subCategorias.length == 0 && llamada.comentario.length > 0)">
            Registrar llamada
        </button>
        <br />
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

        <br />
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="small reveal" id="modal_clave" data-reveal>
        <h5>Actualizar Clave</h5>
        <div ng-show="datos_usuario.acepto_terminos == 0">
            Para aceptar los términos y condiciones y continuar al programa debe asignar una nueva clave
            <br />
            <!--<iframe
                    src="Terminos_y_Condiciones.pdf" frameborder="0" width="655" height="550" marginheight="0" marginwidth="0" id="pdf">
                    Ver los términos y condiciones
                </iframe>-->
            <br />
            <input ng-init="acepta_terminos = false;" ng-model="acepta_terminos" id="checkbox1" type="checkbox"><label
                for="checkbox1">Aceptar terminos y condiciones</label>
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
        <br />
        <br />
        <button type="button" class="button" ng-click="VerificaClave()"
            ng-disabled="(datos_usuario.acepto_terminos == 0 && !acepta_terminos) && datos_usuario.acepto_terminos != 1">
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
                    <td><a ng-show="usuario_en_sesion.id_rol == 2"
                            href="estados_redenciones.php?id_redencion={{redencion.folio}}" class="button small"><i
                                class="fa fa-edit"></i></a></td>
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