angular.module('datosUsuarioApp', []).controller('datosUsuarioController', function($scope, $http) {

    $scope.datos_usuario = { nombre: "", cedula: "" };

    // <editor-fold defaultstate="collapsed" desc="Datos básicos">

    $scope.CrearUsuario = function() {
        if ($scope.datos_usuario.cedula != "" && $scope.datos_usuario.nombre != "") {

            var parametros = {
                catalogo_real: "usuarios",
                datos: $scope.datos_usuario
            };

            $scope.EjecutarLlamado("especiales", "crear_usuario", parametros, $scope.ResultadoCreacionUsuario);
        }
    };

    $scope.ResultadoCreacionUsuario = function(data) {
        if (data.ok) {
            document.location.href = "formulario_usuario.php?id_usuario=" + data.datos_usuario.id;
        } else {
            CallToast(data.error);
        }
    };

    // </editor-fold>

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
});