<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>
    <script src="interfaces/reportes.js?ver=2" type="text/javascript"></script>
    <script>
    var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
    </script>
    <style>
    #contenedorTabla {
        height: 400px;
        overflow: auto;
        width: 100%;
    }
    </style>
</head>

<body ng-app="reportesApp" ng-controller="reportesController">
    <div id="main_container" class="grid-container off-canvas-content">
        <div class="callout">
            <?php include 'componentes/controles_superiores.php'; ?>
            <?php include 'componentes/menu.php'; ?>
            <div class="grid-x grid-padding-x">
                <div class="cell small-12">
                    <br />
                    <br />
                    <h3>Selecciona el reporte que deseas descargar</h3>
                </div>
                <div class="cell small-6" ng-show="usuario_en_sesion.id_rol != 3">
                    <label>
                        Reporte
                        <select ng-model="reporte_seleccionado" ng-init="reporte_seleccionado = ''">
                            <option value="usuarios">Usuarios</option>
                            <option value="estado_cuenta">Estado Cuenta</option>
                            <option value="llamadas">Llamadas</option>
                            <option value="redenciones">Redenciones</option>
                            <option value="encuesta_klim">Reporte de encuesta Klim</option>
                            <option value="encuesta_maggi">Reporte de encuesta Maggi</option>
                            <option value="encuesta_vegie">Reporte de encuesta Maggi Veggie</option>
                        </select>
                    </label>
                    <div>
                        <label for="premio">Seleccione Premio</label>
                        <select name="premios" id="premio" ng-model="premio_filtro" ng-show="reporte_seleccionado == 'redenciones'">
                            <option value="1" selected>General</option>
                            <option value="2916">KLIM RTD Fresa TetraPak 180ml</option>
                            <option value="2917">SALSAS MAGGI</option>
                            <option value="2918">MAGGI VEGGIE</option>
                            <option value="2919">NATURE</option>
                            <option value="2921">LECHERA</option>
                            <option value="2929">MILO</option>
                            <option value="2930">FITNESS</option>
                            <option value="2931">COCOSETTE</option>
                            <option value="2932">RECETARIO</option>
                            <option value="2933">CREMA DE LECHE</option>
                        </select>
                    </div>
                </div>
                <div class="cell small-6">
                    <br />
                    <button class="button" ng-click="CargarReporte()" ng-disabled="reporte_seleccionado == ''">Obtener
                        Previo</button>
                    <button class="button" ng-click="DescargarReporte()" ng-disabled="data_reporte == null">Descargar
                        Reporte</button>
                </div>
                <div class="cell small-12">
                    <div id="contenedorTabla">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>