<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('meekrodb.2.3.class.php');

extract($_REQUEST);

/*
$dataForms = json_decode(stripslashes($dynamyc), true);

$json[] = $dinamyc;

$json[] = stripslashes($dynamyc);

// Un string json válido
$json[] = '[{"Organización": "Equipo de documentación PHP"}]';

// Un string json no válido que causa un error de sintaxis, en este caso, se ha
// usado ' en vez de " para entrecomillar
$json[] = "[{'Organización': 'Equipo de documentación PHP'}]";


foreach($json as $string) {
    echo 'Decodificando: ' . $string . '<br>';
    json_decode($string);

    switch(json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Sin errores';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Excedido tamaño máximo de la pila';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Desbordamiento de buffer o los modos no coinciden';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Encontrado carácter de control no esperado';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Error de sintaxis, JSON mal formado';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Caracteres UTF-8 malformados, posiblemente codificados de forma incorrecta';
        break;
        default:
            echo ' - Error desconocido';
        break;
    }

    echo '<br>';

    echo PHP_EOL;
}

if (is_array($dataForm)) { print 'es array'; }

*/


DB::$nested_transactions = true;
 
$depth = DB::startTransaction();
try {
$dataForm = json_decode($dinamyc);
$archivo = array();

foreach($dataForm as $data) {

    foreach($data as $clave => $valor) {
        #print "$clave => $valor\n";
        
        $archivo["id_usuario"] = $id_usuario;
        $archivo["fecha_factura"] = $fecha_factura;
        $archivo["precio"] = $precio;
        $archivo["img_factura"] = $num_factura.'_'.$img_factura;
        $archivo["num_factura"] = $num_factura;
        $archivo["id_almacen"] = $id_almacen;
        $archivo[$clave] = $valor;       
    }

    $result =  DB::insert("archivos", $archivo);

    

}


$id_usuario = explode(".", $_FILES["img_perfil"]["name"])[0];

$nombre_carpeta = "archivos/" . $id_usuario;

if (!is_dir($nombre_carpeta)) {
    mkdir($nombre_carpeta, 0777, true);
}

$target_dir = dirname(__FILE__) . "/archivos/" . $id_usuario;

$img_exhibicion = $_FILES['img_perfil'];

$datatime = new DateTime();
//$archivo["img_factura"] = $datatime->getTimestamp().'_'.$img_factura;
#print $datatime->getTimestamp();

$target_file_exhibicion = $target_dir . "/" . $num_factura.'_'.$img_factura;


if (move_uploaded_file($_FILES["img_perfil"]["tmp_name"], $target_file_exhibicion)) {
   # echo "ok";
} else {
throw new Exception("error: " . $_FILES["img_perfil"]["error"], 1);


}

$mensaje = [];
$mensaje['request'] = $_REQUEST;
$mensaje['success'] = true;
$mensaje['msj'] = "se almaceno registro";

print json_encode($mensaje);    

$depth = DB::commit(); // commit the outer transaction


}  catch (PDOException $e) {
    #$mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: PDOException ' . $e->getMessage();
    print json_encode($mensaje);
    DB::rollBack();
} catch (Exception $e) {
    #$mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: Exception ' . $e->getMessage();
    print json_encode($mensaje);
    DB::rollBack();
} catch (Throwable $e) {
    #$mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: Throwable ' . $e->getMessage();
    print json_encode($mensaje);
    DB::rollBack();
}