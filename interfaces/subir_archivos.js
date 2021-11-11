angular.module('subirArchivosApp', ['angular.filter']).controller('subirArchivosController', function ($scope, $http) {

    $scope.Profiles = [
        {
            nombre_producto_negocio: "",
            nombre_producto_homologado: "",
            cantidad: ""
        }
    ];

    $scope.entity = {};

    /*
     $scope.edit = function(index){
     $scope.entity = $scope.Profiles[index];
     $scope.entity.index = index;
     $scope.entity.editable = true;
     };
     
     $scope.save = function(index){
     $scope.Profiles[index].editable = false;     
     };
     */

    $scope.delete = function (index) {
        $scope.Profiles.splice(index, 1);
    };

    $scope.add = function () {
        $scope.Profiles.push({
            nombre_producto_negocio: "",
            nombre_producto_homologado: "",
            cantidad: ""
        });


    };

    $scope.SeleccionarAlmacen = function ()
    {
        var parametros = {catalogo: "almacen_usuario", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarAlmacenesUsuario);
    };

    $scope.MostrarAlmacenesUsuario = function (data)
    {
        $scope.almacenes = data;
    };

    $scope.CargarArchivos = function ()
    {
        var url = "clases/cargar_archivos.php";
        var img_perfil = $("#img_perfil").find("img").first().attr("src");

        if (typeof img_perfil == "undefined") {
            alert('debe agregar una factura');
            return false;
        }

        var base64ImageContentExhibicion = img_perfil.replace(/^data:image\/(png|jpeg|pdf);base64,/, "");

        var blobExhibicion = base64ToBlob(base64ImageContentExhibicion, 'image/jpeg');

        var jsonSent = JSON.stringify($scope.Profiles, function (key, value) {
            if (key === "$$hashKey") {
                return undefined;
            }

            return value;
        });

        var formData = new FormData();
        formData.append('img_perfil', blobExhibicion, id_usuario + ".jpg");
        formData.append('img_factura', id_usuario + ".jpg");
        formData.append('num_factura', $("#num_factura").val());
        formData.append('precio', $("#precio").val());
        formData.append('fecha_factura', $("#fecha_factura").val());
        formData.append('id_almacen', $("#id_almacenes").val());
        formData.append('id_usuario', id_usuario);
        //formData.append('dynamyc',  JSON.stringify(jsonSent));
        formData.append('dinamyc', jsonSent);

        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData
        }).done(function (e) {
            console.log(e);
        });

        if (confirm('Haz subido con éxito tu remisión y/o factura, \n\
                        iniciamos un proceso de validación \n\
                        que finalizará en máximo 5 días hábiles.'))
        {
            // location.reload();
            $scope.ObtenerArchivos();
            document.getElementById("dataForm").reset();
            $scope.Profiles = [
                {
                    nombre_producto_negocio: "",
                    nombre_producto_homologado: "",
                    cantidad: ""
                }
            ];
            $("img").remove('#imagen_creada');
        }
    };

    $scope.ObtenerArchivos = function ()
    {
        var parametros = {
            catalogo: "archivos",
            id_usuario: $scope.id_usuario
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarArchivos);
    };

    $scope.MostrarArchivos = function (data)
    {
        $scope.archivos = data;
    };

    $scope.EliminarArchivos = function (id)
    {
        var parametros = {
            catalogo: "archivos",
            id_usuario: $scope.id_usuario,
            id: id
        };
        console.log(parametros);
        $scope.EjecutarLlamado("catalogos", "EliminaCatalogoSimple", parametros, $scope.ResultadoEliminacionArchivos);
    };

    $scope.ResultadoEliminacionArchivos = function (data)
    {
        $scope.ObtenerArchivos(data);
    };

    $scope.ObtenerDetallesArchivos = function (data)
    {
        $scope.num_factura = data;
        var parametros = {
            catalogo: "detalle_archivos",
            num_factura: $scope.num_factura
        };
        console.log(parametros);
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDetallesArchivos);
    };

    $scope.MostrarDetallesArchivos = function (data)
    {
        $scope.detalle_archivos = data;
    };

    // </editor-fold   

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

    $scope.usuario_en_sesion = usuario_en_sesion;
    $scope.id_usuario = id_usuario;
    $scope.ObtenerArchivos();

    $scope.delete_image = function () {
        $("#imagen_creada").remove();
    };

});

$(function () {
    $(".input_foto").on("change", function () {
        // $(this).hide();
        //console.log(this);        
        $("img").remove('#imagen_creada');
        handleFiles(this, this.files);
    });

    $("#img_perfil").on("click", function () {
        /*$(this).hide();
         $(this).html("");*/
        $($(this).data("upload")).show();
        //$($(this).data("upload")).val("");
        console.log('click imagen');
    });
});



function handleFiles(input, files) {
    var file = files[0];
    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext('2d');
    var img = new Image;
    // console.log(file);
    var img_obj = document.createElement("img");
    img.onload = function () {
        var proporcion = 1024;
        var width = proporcion;
        var height = (img.height * proporcion) / img.width;
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0, width, height);

        img_obj.src = canvas.toDataURL("image/jpeg");
        img_obj.style.width = width;
        img_obj.style.height = height;
        img_obj.id = 'imagen_creada';

        $($(input).data("img")).append(img_obj);
        $($(input).data("img")).show();
        //console.log($($(input).data("img")).find("img").first());
    }

    img.src = URL.createObjectURL(file);

}

function base64ToBlob(base64, mime)
{
    mime = mime || '';
    var sliceSize = 1024;
    var byteChars = window.atob(base64);
    var byteArrays = [];

    for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
        var slice = byteChars.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    return new Blob(byteArrays, {type: mime});
}
