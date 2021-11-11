angular.module('indexApp', []).controller('indexController', function ($scope, $http) {

    $scope.datos_usuario = {cedula: "", clave: ""};
    $scope.crear_usuario = {cedula: "", nombre: "", celular: "", clave: ""};


    $scope.CrearUsuario = function ()
    {
        if ($scope.crear_usuario.cedula != "" && $scope.crear_usuario.nombre != "" && $scope.crear_usuario.celular)
        {
            var datos =
                    {
                        cedula: $scope.crear_usuario.cedula,
                        nombre: $scope.crear_usuario.nombre,
                        celular: $scope.crear_usuario.celular,
                        clave: $scope.crear_usuario.cedula,
                    };
            var parametros = {
                catalogo_real: "usuarios",
                datos: datos
            };

            $scope.EjecutarLlamado("especiales", "crear_usuario", parametros, $scope.ResultadoCreacionUsuario);
        } else
        {
            alert("Debe Llenar Todos Los Campos");
        }
    };

    $scope.ResultadoCreacionUsuario = function (data)
    {
        if (data.ok)
        {
            CallToast("Datos registrados satisfactoriamente");
            $scope.registro = 1;
        } else
        {
            CallToast(data.error);
        }
    };

    $scope.Login = function ()
    {
        var parametros = {
            cedula: $scope.datos_usuario.cedula,
            clave: $scope.datos_usuario.clave
        };

        $scope.EjecutarLlamado("especiales", "iniciar_sesion_usuario", parametros, $scope.ResultadoLogin);
    };
    
    $scope.RestaurarClave = function()
    {
        $("#pnlLoad").show();
        var parametros = {
            email: $scope.datos_usuario.email,
        };
        $scope.EjecutarLlamado("especiales", "SolicitarClave", parametros, $scope.BuscarEmail);
    };
    
    $scope.BuscarEmail = function(data)
    {        
        if(data.ok)
        {
            $("#pnlLoad").hide();
            alert("Clave restaurada satisfactoriamente. Por favor revise su correo")
        }
        else
        {
            $scope.boton = 0;
            $("#pnlLoad").hide();
            alert("El Correo Ingresado no Existe");
        }
    };

    $scope.ResultadoLogin = function (data)
    {
        if (data.ok)
        {
            document.location.href = "bienvenida.php";
        } else
        {
            CallToast(data.error);
        }
    };

    $scope.EjecutarLlamado = function (modelo, operacion, parametros, CallBack)
    {
        $http({
            method: "POST", url: "clases/jarvis.php", headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {modelo: modelo, operacion: operacion, parametros: parametros}
        }).success(function (data) {
            if (data.error == "")
            {
                CallBack(data.data);
            } else
            {
                console.log(data);
                $scope.errorGeneral = data.error;
            }
        });
    };
});