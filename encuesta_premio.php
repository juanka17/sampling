<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>

    <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css" />
    <script src="js/foundation-datepicker.js" type="text/javascript"></script>
    <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

    <script src="interfaces/estados_redencion.js?ver=3" type="text/javascript"></script>

    <script>
    var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
    var id_redencion = 0;
    if (typeof getParameterByName("id_redencion") !== 'undefined' && getParameterByName("id_redencion") != "") {
        id_redencion = getParameterByName("id_redencion");
    } else {
        alert("Redención no disponible.");
    }
    </script>
</head>

<body ng-app="estadosRedencionApp" ng-controller="estadosRedencionController">
    <div id="main_container" class="grid-container off-canvas-content">
        <div class="callout">
            <?php include 'componentes/controles_superiores.php'; ?>
            <?php include 'componentes/menu.php'; ?>
            <div class="grid-x">
                <div class="grid-x">
                    <div class="col small-12">
                        <h1>Encuesta redencion</h1>
                    </div>
                    <div class="col small-5">
                        <b>Premio</b>
                        <br />
                        {{redencion.premio}}
                    </div>
                    <div class="col small-3">
                        <b>Fecha Redencion</b>
                        <br />
                        {{redencion.fecha_redencion}}
                    </div>
                    <div class="col small-2">
                        <b>Puntos</b>
                        <br />
                        {{redencion.puntos}}
                    </div>
                    <div class="col small-2">
                        <button class="button alert" onclick="javascript:history.back();">Volver</button>
                    </div>

                    <div class="col small-12">
                        <table class="table" id="pnlEncuesta"
                            ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2916">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Opciones</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1. ¿Recibiste la bebida KLIM y la Receta?</td>
                                    <td>
                                        <select class="form-control">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>2. ¿Qué te gustó de la bebida KLIM® en cajita? ¿Qué no te gusto?</td>
                                    <td>
                                        <select ng-hide class="form-control" value="2">
                                            <option value="2">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>3. ¿Volverías a comprar este producto? ¿Por qué?</td>
                                    <td>
                                        <select class="form-control">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td><input class="form-control" type="text" /></td>
                                </tr>
                                <tr>
                                    <td>4. ¿Te gustó la receta de torta de avena y naranja con frutas como
                                        acompañamiento para KLIM® en cajita? </td>
                                    <td>
                                        <select class="form-control">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>5. ¿Qué otro tipo de recetas quisieras conocer? </td>
                                    <td>
                                        <select ng-hide class="form-control" value="2">
                                            <option value="2">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>6. ¿Realizó la receta que recibió con la cajita? </td>
                                    <td>
                                        <select ng-hide class="form-control" value="2">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>7. ¿Conoce la página de Nestlé? ¿Ha navegado en ella? </td>
                                    <td>
                                        <select ng-hide class="form-control" value="2">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <button class="button small expanded" type="button"
                                            ng-click="RegistrarEncuestaRedencion()">
                                            Registrar encuesta
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table" id="pnlEncuesta2"
                            ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2917">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Opciones</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1. Qué tipos de recetas te gustaría conocer?</td>
                                    <td>
                                        <label> <input type="checkbox" value="3">Saladas (Platos fuertes)</label>
                                        <label> <input type="checkbox" value="4">Dulces (Postres)</label>
                                        <label> <input type="checkbox" value="5">Saludables</label>
                                        <label> <input type="checkbox" value="6">Otras</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>2. ¿ Cual de las 3 Bases de Maggi de la Huerta te gusto más?</td>
                                    <td>
                                        <label> <input type="checkbox" value="7">Napolitana</label>
                                        <label> <input type="checkbox" value="8">Champiñones</label>
                                        <label> <input type="checkbox" value="9">Mexicana</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>3. ¿ Que receta preparaste para usar la base Maggi?</td>
                                    <td>
                                        <label> <input type="checkbox" value="10">Instructivo del empaque</label>
                                        <label> <input type="checkbox" value="11">Receta Propia</label>
                                        <label> <input type="checkbox" value="12">Recetas en Recetas Nestlé</label>
                                        <label> <input type="checkbox" value="13">Otras</label>
                                    </td>
                                    <td><input class="form-control" type="text" /></td>
                                </tr>
                                <tr>
                                    <td>4. ¿ Para quién cocinas? </td>
                                    <td>
                                        <label> <input type="checkbox" value="14">Familia</label>
                                        <label> <input type="checkbox" value="15">Pareja</label>
                                        <label> <input type="checkbox" value="16">Para Mi</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <button class="button small expanded" type="button"
                                            ng-click="RegistrarEncuestaRedencion()">
                                            Registrar encuesta
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="small-12 cell">
                        <table class="table" ng-show="encuesta_redencion.length > 0 && redencion.id_premio==2916">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Opciones</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="pregunta in encuesta_redencion track by $index">
                                    <td>
                                        <span ng-show="pregunta.numero_pregunta == 1">¿Recibiste la bebida KLIM y la
                                            Receta? </span>
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Qué te gustó de la bebida KLIM®
                                            en cajita? </span>
                                        <span ng-show="pregunta.numero_pregunta == 3">¿Volverías a comprar este
                                            producto?</span>
                                        <span ng-show="pregunta.numero_pregunta == 4">¿Te gustó la receta de torta de
                                            avena y naranja con frutas como acompañamiento para KLIM® en cajita? </span>
                                        <span ng-show="pregunta.numero_pregunta == 5">¿Qué otro tipo de recetas
                                            quisieras conocer? </span>
                                        <span ng-show="pregunta.numero_pregunta == 6">¿Realizó la receta que recibió con
                                            la cajita?</span>
                                        <span ng-show="pregunta.numero_pregunta == 7">¿Conoce la página de Nestlé? ¿Ha
                                            navegado en ella?</span>
                                    </td>
                                    <td>
                                        <span ng-show="pregunta.respuesta == 0">No</span>
                                        <span ng-show="pregunta.respuesta == 1">Si</span>
                                        <span ng-show="pregunta.respuesta == 2">NA</span>
                                    </td>
                                    <td>
                                        {{pregunta.comentario}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table" ng-show="encuesta_redencion.length > 0 && redencion.id_premio==2917">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Opciones</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="pregunta in encuesta_redencion track by $index">
                                    <td>
                                        <span ng-show="pregunta.numero_pregunta == 1">Qué tipos de recetas te gustaría
                                            conocer?</span>
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Cual de las 3 Bases de Maggi de
                                            la Huerta te gusto más?</span>
                                        <span ng-show="pregunta.numero_pregunta == 3">¿ Que receta preparaste para usar
                                            la base Maggi?</span>
                                        <span ng-show="pregunta.numero_pregunta == 4">¿ Para quién cocinas?</span>
                                    </td>
                                    <td>
                                        <span ng-show="pregunta.respuesta == 3">Saladas (Platos fuertes)</span>
                                        <span ng-show="pregunta.respuesta == 4">Dulces (Postres)</span>
                                        <span ng-show="pregunta.respuesta == 5">Saludables</span>
                                        <span ng-show="pregunta.respuesta == 6">Otras</span>
                                        <span ng-show="pregunta.respuesta == 7">Napolitana</span>
                                        <span ng-show="pregunta.respuesta == 8">Champiñones</span>
                                        <span ng-show="pregunta.respuesta == 9">Mexicana</span>
                                        <span ng-show="pregunta.respuesta == 10">Instructivo del empaque</span>
                                        <span ng-show="pregunta.respuesta == 11">Receta Propia</span>
                                        <span ng-show="pregunta.respuesta == 12">Recetas en Recetas Nestlé</span>
                                        <span ng-show="pregunta.respuesta == 13">Otras</span>
                                        <span ng-show="pregunta.respuesta == 14">Familia</span>
                                        <span ng-show="pregunta.respuesta == 15">Pareja</span>
                                        <span ng-show="pregunta.respuesta == 16">Para Mi</span>
                                    </td>
                                    <td>
                                        {{pregunta.comentario}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>