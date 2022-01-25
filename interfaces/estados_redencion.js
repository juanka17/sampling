angular.module('estadosRedencionApp', []).controller('estadosRedencionController', function($scope, $http) {

    $scope.datos_usuario = { nombre: "", cedula: "" };

    // <editor-fold defaultstate="collapsed" desc="Información Redención">

    $scope.CargarRedencion = function() {
        var parametros = { catalogo: "redencion", id: id_redencion };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarRedencion);
    };

    $scope.MostrarRedencion = function(data) {
        $scope.redencion = data[0];
        console.log($scope.redencion);
        $scope.CargarSeguimientoRedencion();
    };

    $scope.CargarSeguimientoRedencion = function() {
        var parametros = { catalogo: "seguimiento_redencion", id_redencion: id_redencion };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarSeguimientoRedencion);
    };

    $scope.MostrarSeguimientoRedencion = function(data) {
        $scope.seguimiento_redencion = data;
        $scope.CargarOperacionesRedencion();
    };

    $scope.CargarOperacionesRedencion = function() {
        var parametros = { catalogo: "operaciones_redencion" };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarOperacionesRedencion);
    };

    $scope.MostrarOperacionesRedencion = function(data) {
        $scope.operaciones_redencion = data;
        $scope.CargarEncuestaRedencion();
    };

    $scope.nuevo_estado = { id_operacion: 0, comentario: "", referencia: "", id_registra: 0 };
    $scope.RegistrarSeguimiento = function() {
        $scope.nuevo_estado.id_redencion = id_redencion;
        $scope.nuevo_estado.id_registra = $scope.usuario_en_sesion.id;
        var parametros = {
            catalogo: "seguimiento_redencion",
            datos: $scope.nuevo_estado
        };
        console.log($scope.nuevo_estado.id_redencion);
        console.log($scope.nuevo_estado.id_registra);
        console.log(parametros);
        $scope.EjecutarLlamado("especiales", "registrar_seguimiento_redencion", parametros, $scope.ResultadoRegistroSeguimiento);
    };

    $scope.ResultadoRegistroSeguimiento = function(data) {
        $scope.nuevo_estado = { id_operacion: 0, comentario: "", referencia: "", id_registra: 0 };
        if (index_folio_masivo == -1) {
            if (data.ok) {
                $scope.seguimiento_redencion = data.data;
            } else {
                CallToast(data.error);
            }
        } else {
            $scope.ProcesarFoliosMasivos();
        }
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Estados masivos">

    $scope.informacion_folios = { cantidad: 0, listado: "", folios_correctos: 0, folios_procesados: 0 };
    $scope.SumarioFoliosMasivos = function() {
        $scope.informacion_folios.cantidad = $scope.informacion_folios.listado == "" ? 0 : $scope.informacion_folios.listado.split(/\n/g).length;

        var listado = $scope.informacion_folios.listado.split(/\n/g);
        $scope.informacion_folios.folios_correctos = 0;
        angular.forEach(listado, function(folio) {

            var folio_correcto = true;

            var informacion_folio = folio.split('|');
            if (informacion_folio.length != 4) {
                folio_correcto = false;
            } else if (!$.isNumeric(informacion_folio[0])) {
                folio_correcto = false;
            } else if (!$.isNumeric(informacion_folio[1])) {
                folio_correcto = false;
            } else if (informacion_folio[2].length > 100) {
                folio_correcto = false;
            }

            if (folio_correcto) {
                $scope.informacion_folios.folios_correctos++;
            }
        });

        $scope.informacion_folios.listado = $scope.informacion_folios.listado.replace(/\t+/g, '');
    };

    var index_folio_masivo = -1;
    $scope.ProcesarFoliosMasivos = function() {
        var listado = $scope.informacion_folios.listado.split(/\n/g);
        index_folio_masivo++;
        $scope.informacion_folios.folios_procesados = index_folio_masivo;
        if (index_folio_masivo < 200 && index_folio_masivo < listado.length) {
            $scope.ProcesarFolio(listado[index_folio_masivo].split('|'));
        } else {
            $scope.informacion_folios = { cantidad: 0, listado: "", folios_correctos: 0, folios_procesados: 0 };
            alert("Proceso finalizado correctamente");
        }
    };

    $scope.ProcesarFolio = function(folio) {
        id_redencion = folio[0];
        $scope.nuevo_estado.id_operacion = folio[1];
        $scope.nuevo_estado.comentario = folio[2];
        $scope.nuevo_estado.referencia = folio[3];

        $scope.RegistrarSeguimiento();
    };

    // </editor-fold>
    $scope.RegistrarEncuestaRedencion = function() {
        var preguntas_encuesta = Array();
        if ($scope.redencion.id_premio == 2916) {
            $("#pnlEncuesta tbody tr").each(function(index, row) {
                if (index < 7) {
                    var pregunta = {
                        id_redencion: id_redencion,
                        numero_pregunta: (index + 1),
                        respuesta: $(row).find("select").first().val(),
                        comentario: $(row).find("input").first().val()
                    };
                    preguntas_encuesta.push(pregunta);
                }
            });
        }

        if ($scope.redencion.id_premio == 2917) {
            $("#pnlEncuesta2 tbody tr").each(function(index, row) {
                if (index < 4) {
                    var pregunta = { id_redencion: 0, numero_pregunta: 0, respuesta: [], comentario: "" };
                    pregunta = {
                        id_redencion: id_redencion,
                        numero_pregunta: (index + 1),
                        respuesta: [] $(row).find("input[type=checkbox]:checked").val(),
                        comentario: $(row).find("input[type=text]").first().val()
                    };
                    preguntas_encuesta.push(pregunta);
                }
            });
        }

        console.log(preguntas_encuesta);

        var parametros = {
            catalogo: "encuesta_redencion",
            catalogo_real: "encuesta_redencion",
            lista_datos: preguntas_encuesta,
            id_redencion: id_redencion
        };
        console.log(parametros);
        //$scope.EjecutarLlamado("catalogos", "RegistraCatalogoMixtoMasivo", parametros, $scope.CargarEncuestaRedencion);
    };

    $scope.CargarEncuestaRedencion = function() {
        var parametros = { catalogo: "encuesta_redencion", id_redencion: id_redencion };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarEncuestaRedencion);
    };

    $scope.encuesta_redencion = Array();
    $scope.MostrarEncuestaRedencion = function(data) {
        if (data.length > 0) {
            $scope.encuesta_redencion = data;
        }
    };

    $scope.EjecutarLlamado = function(modelo, operacion, parametros, CallBack) {
        $http({
            method: "POST",
            url: "clases/jarvis.php",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: { modelo: modelo, operacion: operacion, parametros: parametros }
        }).success(function(data) {
            if (data.error == "") {
                CallBack(data.data);
            } else {
                console.log(data);
                $scope.errorGeneral = data.error;
            }
        });
    };

    $scope.usuario_en_sesion = usuario_en_sesion;

    if (id_redencion != 0) {
        $scope.CargarRedencion();
    }
});