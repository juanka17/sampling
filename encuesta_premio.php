<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>

    <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css" />
    <script src="js/foundation-datepicker.js" type="text/javascript"></script>
    <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

    <script src="interfaces/estados_redencion.js?ver=11" type="text/javascript"></script>

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
                    <table class="table" id="pnlEncuesta" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2916">
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
                                    <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                        Registrar encuesta
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" id="pnlEncuesta2" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2917">
                        <form ng-submit="RegistrarEncuestaRedencion()">
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
                                        <input type="checkbox" value="Saladas (Platos fuertes)" id="p1a">Saladas
                                        (Platos
                                        fuertes) <br>
                                        <input type="checkbox" value="Dulces (Postres)" id="p1b">Dulces (Postres)
                                        <br>
                                        <input type="checkbox" value="Saludables" id="p1c">Saludables <br>
                                        <input type="checkbox" value="Otras" id="p1d">Otras
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="p1comentario" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>2. ¿ Cual de las 3 Bases de Maggi de la Huerta te gusto más?</td>
                                    <td>
                                        <input type="checkbox" value="Napolitana" id="p2a">Napolitana <br>
                                        <input type="checkbox" value="Champiñones" id="p2b">Champiñones <br>
                                        <input type="checkbox" value="Mexicana" id="p2b">Mexicana
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="p2comentario" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>3. ¿ Que receta preparaste para usar la base Maggi?</td>
                                    <td>
                                        <input type="checkbox" value="Instructivo del empaque" id="p3a">Instructivo
                                        del
                                        empaque <br>
                                        <input type="checkbox" value="Receta Propia" id="p3b">Receta Propia <br>
                                        <input type="checkbox" value="Recetas en Recetas Nestlé" id="p3c">Recetas en
                                        Recetas
                                        Nestlé <br>
                                        <input type="checkbox" value="Otras" id="p3a">Otras
                                    </td>
                                    <td><input class="form-control" type="text" id="p3comentrio" /></td>
                                </tr>
                                <tr>
                                    <td>4. ¿ Para quién cocinas?</td>
                                    <td>
                                        <input type="checkbox" value="Familia" id="p4a">Familia <br>
                                        <input type="checkbox" value="Pareja" id="p4b">Pareja <br>
                                        <input type="checkbox" value="Para Mi" id="p4c">Para Mi
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="p4coemtario" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <button class="button small expanded" type="submit">
                                            Registrar encuesta
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                    </table>

                    <table class="table" id="pnlEncuesta3" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2918">
                        <form ng-submit="RegistrarEncuestaRedencion()">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Opciones</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1. ¿ Qué tipos de recetas te gustaría conocer?</td>
                                    <td>
                                        <input type="checkbox" value="Saladas (Platos fuertes)">Saladas (Platos
                                        Fuertes)<br>
                                        <input type="checkbox" value="Dulces (Postres)">Dulces (Postres)<br>
                                        <input type="checkbox" value="Saludables">Saludadables <br>
                                        <input type="checkbox" value="Otras">Otras
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>2. ¿Cuál de las MAGGI ® Hamburguesa de Quinoa Veggie Bases de Maggie Veggie
                                        te gusto más?</td>
                                    <td>
                                        <input type="checkbox" value="MAGGI® Salsa Bolognesa de Soya Veggie ">MAGGI®
                                        Salsa Bolognesa de Soya Veggie <br>
                                        <input type="checkbox" value="MAGGI ®  Hamburguesa de Quinoa Veggie ">MAGGI
                                        ®
                                        Hamburguesa de Quinoa Veggie
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>3. ¿Qué receta preparaste para usar la base Maggi?</td>
                                    <td>
                                        <input type="checkbox" value="Instructivo del empaque" id="p3a">Instructivo
                                        del
                                        empaque<br>
                                        <input type="checkbox" value="Receta Propia" id="p3b">Receta Propia<br>
                                        <input type="checkbox" value="Recetas en Recetas Nestlé" id="p3c">Recetas en
                                        Recetas Nestle<br>
                                        <input type="checkbox" value="Otras" id="p3a">Otra
                                    </td>
                                    <td><input class="form-control" type="text" /></td>
                                </tr>
                                <tr>
                                    <td>4. ¿Para quién Cocinas?</td>
                                    <td>
                                        <input type="checkbox" value="Familia" id="p4a">Familia <br>
                                        <input type="checkbox" value="Pareja" id="p4b">Pareja <br>
                                        <input type="checkbox" value="Para Mi" id="p4c">Para Mi
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                            Registrar encuesta
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                    </table>

                    <table class="table" id="pnlEncuesta4" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2919">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Opciones</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1. ¿Conocías la marca Nature's Heart</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>2. ¿Incluirías en tu próxima compra alguna de estas variedades? ¿Cual? </td>
                                <td>
                                    <select ng-hide class="form-control" value="2">
                                        <option value="Te Detox">Te Detox</option>
                                        <option value="Mezcla Antioxidante">Mezcla Antioxidante</option>
                                        <option value="Té  y Snack">Té y Snack</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>3. De la Mezcla Antioxidante ¿Qué fue lo que más te gusto?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="NA">NA</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" /></td>
                            </tr>
                            <tr>
                                <td>4. ¿Te gustó la receta de torta de avena y naranja con frutas como
                                    acompañamiento para KLIM® en cajita? </td>
                                <td>
                                    <select class="form-control">
                                        <option value="NA">NA</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">
                                    <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                        Registrar encuesta
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" id="pnlEncuesta5" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2929">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Opciones</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1. ¿Conocías previamente esta variedad de MILO® Sin Azúcar Añadida</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>2. ¿Qué te pareció el sabor? </td>
                                <td>
                                    <select ng-hide class="form-control" value="2">
                                        <option value="NA">NA</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>3. ¿Incluirías MILO® Nutrifit® en tu próxima compra para la lonchera de tu hijo/a? </td>
                                <td>
                                    <select class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" /></td>
                            </tr>
                            <tr>
                                <td>4. ¿Qué fue lo que más te gustó?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Sabor">Sabor</option>
                                        <option value="Que no tiene azúcar añadida">Que no tiene azúcar añadida</option>
                                        <option value="Las dos anteriores">Las dos anteriores</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">
                                    <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                        Registrar encuesta
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" id="pnlEncuesta6" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2921">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Opciones</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.¿Para qué utiliza la leche condensada o utilizaría la leche condensada?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Como ingrediente en preparaciones">Como ingrediente en preparaciones</option>
                                        <option value="Como golosina para consumir directamente">Como golosina para consumir directamente</option>
                                        <option value="Como topping">Como topping</option>
                                        <option value="Como endulzante para bebidas">Como endulzante para bebidas</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>2. ¿Cuál es su formato preferido de La Lechera? </td>
                                <td>
                                    <select ng-hide class="form-control" value="2">
                                        <option value="Doypack (bolsa)">Doypack (bolsa)</option>
                                        <option value="Lata">Lata</option>
                                        <option value="Formato individual Lechera Stick 25g">Formato individual Lechera Stick 25g</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>3. ¿Conoce usted la referencia de La Lechera Light? ¿La preferiría sobre la referencia original? </td>
                                <td>
                                    <select class="form-control">
                                        <option value="Si la conozco pero prefiero la original">Si la conozco pero prefiero la original</option>
                                        <option value="No la conozco y prefiero la original">No la conozco y prefiero la original</option>
                                        <option value="Si la conozco y sí me cambiaría a la referencia Light">Si la conozco y sí me cambiaría a la referencia Light</option>
                                        <option value="No la conozco pero sí me cambiaría a la referencia Light">No la conozco pero sí me cambiaría a la referencia Light</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" /></td>
                            </tr>
                            <tr>
                                <td>4. ¿Conoce usted la variedad de recetas con La Lechera que se encuentran en Recetas Nestlé?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Sí las conozco pero no las uso a menudo">Sí las conozco pero no las uso a menudo</option>
                                        <option value="No las conozco pero me gustaría conocerlas">No las conozco pero me gustaría conocerlas</option>
                                        <option value="Sí las conozco y sí las utilizo en mis preparaciones">Sí las conozco y sí las utilizo en mis preparaciones</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>5. ¿Cuáles son los postres que contienen La Lechera que más recuerdas de tu infancia o que eran preparados en tu hogar?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="N/A">N/A</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">
                                    <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                        Registrar encuesta
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" id="pnlEncuesta7" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2931">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Opciones</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1. ¿Qué fue lo que más te gusto de Cocosette® Chocosandwich?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Sabor en general">Sabor en general</option>
                                        <option value="Combinación de Chocolate y Coco">Combinación de Chocolate y Coco</option>
                                        <option value="Presentacion">Presentación</option>
                                        <option value="Otra">Otra </option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>2. ¿Qué fue lo que menos te gusto de Cocosette® Chocosandwich?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Sabor en general">Sabor en general</option>
                                        <option value="Combinación de Chocolate y Coco">Combinación de Chocolate y Coco</option>
                                        <option value="Presentación">Presentación</option>
                                        <option value="Muy dulce">Muy dulce</option>
                                        <option value="Otra">Otra </option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>3. ¿Incluirías en tu próxima compra Cocosette® Chocosandwich?</td>
                                <td>
                                    <select class="form-control" value="2">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                      </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>4. ¿En qué medios has visto comunicación de Cocosette® Chocosandwich?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Television">Televisión</option>
                                        <option value="Redes Sociales (Instagram-Facebook)">Redes Sociales (Instagram-Facebook)</option>
                                        <option value="Internet (Páginas Webs)">Internet (Páginas Webs)</option>
                                        <option value="No he visto">No he visto</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>5. ¿Conocías la marca Cocosette®?</td>
                                <td>
                                    <select class="form-control" value="2">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                      </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">
                                    <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                        Registrar encuesta
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" id="pnlEncuesta8" ng-show="encuesta_redencion.length == 0 && redencion.id_premio==2933">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Opciones</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.¿Cuál es el uso al cual asocia la Crema de Leche Nestlé?</td>
                                <td>
                                    <select class="form-control">
                                        <option value="Ingrediente en preparaciones dulces.">Ingrediente en preparaciones dulces.</option>
                                        <option value="Ingrediente en preparaciones saladas. ">Ingrediente en preparaciones saladas. </option>
                                        <option value="Topping/Adiciones.">Topping/Adiciones.</option>
                                        <option value="Otro, ¿cuál? ">Otro, ¿cuál? </option>
                                        <option value="Otro ">Otro </option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>2.	¿Cuál es el principal diferencial que encuentra entre Crema de Leche Nestlé y otras marcas de Crema de Leche del mercado?</td>
                                <td>
                                    <select class="form-control" value="2">
                                        <option value="Sabor">Sabor</option>
                                        <option value="Cremosidad">Cremosidad</option>
                                        <option value="Color">Color</option>
                                        <option value="Calidad">Calidad</option>
                                        <option value="Variedad de sabores">Variedad de sabores.</option>
                                      </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>3.	¿Conoce y utiliza las recetas hechas con Crema de Leche Nestlé encontradas en Recetas Nestlé?</td>
                                <td>
                                    <select class="form-control" value="2">
                                        <option value="Si las conozco pero no las utilizo.">Si las conozco pero no las utilizo.</option>
                                        <option value="No las conozco pero me gustaría conocerlas. ">No las conozco pero me gustaría conocerlas. </option>
                                        <option value="Sí las conozco y sí las utilizo en mis preparaciones ">Sí las conozco y sí las utilizo en mis preparaciones </option>
                                        <option value="Prefiero realizar las preparaciones que ya conozco ">Prefiero realizar las preparaciones que ya conozco </option>
                                      </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td>4.	¿En cuáles momentos o situaciones pasaría de considerar Crema de Leche Nestlé como una opción a comprarla como su opción preferida?</td>
                                <td>
                                    <select class="form-control" value="2">
                                        <option value="Platos cotidianos.">Platos cotidianos.</option>
                                        <option value="Ocasiones especiales.">Ocasiones especiales.</option>
                                        <option value="Ambos">Ambos</option>
                                      </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">
                                    <button class="button small expanded" type="button" ng-click="RegistrarEncuestaRedencion()">
                                        Registrar encuesta
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>


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
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Qué te gustó de la bebida
                                            KLIM®
                                            en cajita? </span>
                                        <span ng-show="pregunta.numero_pregunta == 3">¿Volverías a comprar este
                                            producto?</span>
                                        <span ng-show="pregunta.numero_pregunta == 4">¿Te gustó la receta de torta
                                            de
                                            avena y naranja con frutas como acompañamiento para KLIM® en cajita?
                                        </span>
                                        <span ng-show="pregunta.numero_pregunta == 5">¿Qué otro tipo de recetas
                                            quisieras conocer? </span>
                                        <span ng-show="pregunta.numero_pregunta == 6">¿Realizó la receta que recibió
                                            con
                                            la cajita?</span>
                                        <span ng-show="pregunta.numero_pregunta == 7">¿Conoce la página de Nestlé?
                                            ¿Ha
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
                                        <span ng-show="pregunta.numero_pregunta == 1">Qué tipos de recetas te
                                            gustaría
                                            conocer?</span>
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Cual de las 3 Bases de Maggi
                                            de
                                            la Huerta te gusto más?</span>
                                        <span ng-show="pregunta.numero_pregunta == 3">¿ Que receta preparaste para
                                            usar
                                            la base Maggi?</span>
                                        <span ng-show="pregunta.numero_pregunta == 4">¿ Para quién cocinas?</span>
                                    </td>
                                    <td>
                                        <span>{{pregunta.respuesta}}</span>
                                    </td>
                                    <td>
                                        {{pregunta.comentario}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table" ng-show="encuesta_redencion.length > 0 && redencion.id_premio==2918">
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
                                        <span ng-show="pregunta.numero_pregunta == 1">¿ Qué tipos de recetas te
                                            gustaría conocer?</span>
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Cuál de las MAGGI ®
                                            Hamburguesa de Quinoa Veggie Bases de Maggie Veggie te gusto más?</span>
                                        <span ng-show="pregunta.numero_pregunta == 3">¿Qué receta preparaste para
                                            usar la base Maggi?</span>
                                        <span ng-show="pregunta.numero_pregunta == 4">¿Para quién Cocinas?</span>
                                    </td>
                                    <td>
                                        <span>{{pregunta.respuesta}}</span>
                                    </td>
                                    <td>
                                        {{pregunta.comentario}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table" ng-show="encuesta_redencion.length > 0 && redencion.id_premio==2919">
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
                                        <span ng-show="pregunta.numero_pregunta == 1">¿Conocías la marca Nature's Heart®?</span>
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Incluirías en tu próxima compra alguna de estas variedades? ¿Cual? </span>
                                        <span ng-show="pregunta.numero_pregunta == 3">De la Mezcla Antioxidante ¿Qué fue lo que más te gusto?</span>
                                        <span ng-show="pregunta.numero_pregunta == 4">Del Te Detox ¿Qué fue lo que más te gusto?</span>
                                    </td>
                                    <td>
                                        <span>{{pregunta.respuesta}}</span>
                                    </td>
                                    <td>
                                        {{pregunta.comentario}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table" ng-show="encuesta_redencion.length > 0 && redencion.id_premio==2929">
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
                                        <span ng-show="pregunta.numero_pregunta == 1">¿Conocías previamente esta variedad de MILO® Sin Azúcar Añadida?</span>
                                        <span ng-show="pregunta.numero_pregunta == 2">¿Qué te pareció el sabor?</span>
                                        <span ng-show="pregunta.numero_pregunta == 3">¿Incluirías MILO® Nutrifit® en tu próxima compra para la lonchera de tu hijo/a? </span>
                                        <span ng-show="pregunta.numero_pregunta == 4">¿Qué fue lo que más te gustó?</span>
                                    </td>
                                    <td>
                                        <span>{{pregunta.respuesta}}</span>
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

        <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>