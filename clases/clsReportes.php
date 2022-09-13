<?php
include_once('clsDDBBOperations.php');
include_once('consultas.php');

class clsReportes
{
    public static function EjecutarOperacion($operacion, $parametros)
    {
        switch ($operacion)
        {
            case "usuarios": $datos = clsReportes::ReporteUsuarios($parametros);break;
            case "llamadas": $datos = clsReportes::ReporteLlamadas($parametros);break;
            case "redenciones": $datos = clsReportes::ReporteRedenciones($parametros);break;
            case "estado_cuenta": $datos = clsReportes::ReporteEstadoCuenta($parametros);break;
            case "cumpleanos": $datos = clsReportes::ReporteCumpleanos($parametros);break;
            case "encuesta_klim": $datos = clsReportes::ReporteEncuestaKlim($parametros);break;
            case "encuesta_maggi": $datos = clsReportes::ReporteEncuestaMaggi($parametros);break;
            case "encuesta_vegie": $datos = clsReportes::ReporteEncuestaVeggie($parametros);break;
            case "inventario_lista": $datos = clsReportes::ReporteInventario($parametros);break;
            case "encuesta_crocante": $datos = clsReportes::ReporteEncuestaCrocante($parametros);break;
        }
        return clsReportes::ProcesarDatos($datos);
    }
    
    private static function ProcesarDatos($datos)
    {
        if(count($datos))
        {
            $headers = array();
            $colCount = 0;
            if(count($datos) > 0)
            {
                foreach ($datos[0] as $columName => $rowDefiner)
                {
                    $headers[$colCount] = $columName;
                    $colCount++;
                }
            }

            $data = array("header" => $headers, "data" => $datos);
        }
        
        return $data;
    }
    
    private static function ReporteUsuarios($parametros)
    {
        $query = Consultas::$consulta_usuarios." where rol.id = 1 order by 1";
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteLlamadas($parametros)
    {
        
        $query = Consultas::$consulta_llamadas_usuarios_completa;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteRedenciones($parametros)
    {
        if($parametros->id_premio == 1){
            $consulta = 'where 1=1';
        }else{
            $consulta = "where  pre.id = ". $parametros->id_premio;
        }
        $query = Consultas::$consulta_general_redenciones.$consulta;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteEstadoCuenta($parametros)
    {
        
        $query = Consultas::$consulta_estado_cuenta;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteVentas($parametros)
    {
        
        $query = "call sp_ventas(0);";
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteVentasLijaSeca($parametros)
    {
        
        $query = "call sp_ventas(1);";
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteCumpleanos($parametros)
    {
        $query = Consultas::$reporte_cumpleanos;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteEncuestaKlim($parametros)
    {
        $query = "call sp_consulta_encuesta_redencion(2916);";
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }

    private static function ReporteEncuestaMaggi($parametros)
    {
        $query = "call sp_consulta_encuesta_redencion(2917);";
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteEncuestaVeggie($parametros)
    {
        $query = "call sp_consulta_encuesta_redencion(2918);";
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }

    private static function ReporteInventario($parametros)
    {
        $query = Consultas::$reporte_inventario;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }   

    private static function ReporteEncuestaCrocante($parametros)
    {
        $query = Consultas::$reporte_encuesta_crocante;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
}
    
?>