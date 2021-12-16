<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>
    <script src="interfaces/reportes.js" type="text/javascript"></script>
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
                            <option value="reporte_encuesta">Reporte de encuesta</option>
                        </select>
                    </label>
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