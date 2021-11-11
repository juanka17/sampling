<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>

        <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css"/>
        <script src="js/foundation-datepicker.js" type="text/javascript"></script>
        <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>        
        <script src="interfaces/crear_usuario.js?reload=1&charge=kss" type="text/javascript"></script>

        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script>
    </head>
    <body ng-app="datosUsuarioApp" ng-controller="datosUsuarioController">         
        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="grid-x">
                    <div class="col small-12">
                        <h4 class="text-center">Crear Nuevo Usuario</h4>
                    </div>
                    <div class="small-12 medium-offset-3 medium-6 cell">
                        <div class="grid-x grid-padding-x">
                            <div class="medium-12 cell">
                                <label>
                                    Cédula
                                    <input type="text" placeholder="Cédula" ng-model="datos_usuario.cedula">
                                </label>
                            </div>
                            <div class="medium-12 cell">
                                <label>
                                    Nombre
                                    <input type="text" placeholder="Nombre" ng-model="datos_usuario.nombre">
                                </label>
                            </div>
                        </div>
                        <div class="small-12 cell text-center" ng-show="usuario_en_sesion.id_rol != 3">
                            <button class="button" ng-click="CrearUsuario()">Crear Usuario</button>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>      

        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>