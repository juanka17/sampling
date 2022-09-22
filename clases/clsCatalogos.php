<?php

include_once('clsDDBBOperations.php');
include_once('consultas.php');

class clsCatalogos
{
    public static function EjecutarOperacion($operacion, $parametros)
    {
        switch($operacion)
        {
            case "CargaCatalogo": return clsCatalogos::EjecutarConsulta($parametros); break;
            case "RegistraCatalogoSimple": return clsCatalogos::EjecutarInsercion($parametros); break;
            case "RegistraCatalogoMixto": return clsCatalogos::EjecutarInsercionMixta($parametros); break;
            case "RegistraCatalogoMixtoMasivo": return clsCatalogos::EjecutarInsercionMixtaMasiva($parametros); break;
            case "ModificaCatalogoSimple": return clsCatalogos::EjecutarModificacion($parametros); break;
            case "ModificaCatalogoMixto": return clsCatalogos::EjecutarModificacionMixta($parametros); break;
            case "EliminaCatalogoSimple": return clsCatalogos::EjecutarEliminacion($parametros); break;
            case "EliminaCatalogoMixta": return clsCatalogos::EjecutarEliminacionMixta($parametros); break;
        }
    }
    
    private static function EjecutarConsulta($parametros)
    {
        $query = "SELECT * FROM ".$parametros->catalogo;
        $order = " ORDER BY 2";
        
        switch ($parametros->catalogo)
        {
                    
            case "usuario": { 
                $query = Consultas::$consulta_usuarios." where usu.id = ".$parametros->id; 
                $order = " order by nombre ";
            }; break;
        
            case "llamadas_usuarios": { 
                $query = Consultas::$consulta_llamadas_usuarios." where la.id_usuario = ".$parametros->id_usuario; 
                $order = " order by la.fecha desc ";
            }; break;
            
            case "informacion_usuario": { 
                $query = "select * from usuarios where id = ".$parametros->id; 
                $order = " order by nombre ";
            }; break;
        
            case "ciudades": { 
                $order = " order by id ";
            }; break;
        
            case "familiares": { 
                $query = $query." where id_usuario = ".$parametros->id_usuario;
                $order = " order by id ";
            }; break;
        
            case "estado_cuenta": { 
                $query = Consultas::$consulta_estado_cuenta;
                $query = $query." where ecu.id_usuario = ".$parametros->id_usuario;
                $order = " order by 2,fecha_factura;";
            }; break;
        
            case "premios": { 
                $query = Consultas::$consulta_premios;
                $query = $query." where pre.activo = 1";
                $order = "";
            }; break;
        
            case "premios_menor_mayor": { 
                $query = Consultas::$consulta_premios;
                $query = $query." where pre.activo = 1";
                $order = " order by pre.puntos";
            }; break;
        
            case "premios_mas_redimidos": { 
                $query = Consultas::$consulta_premios;
                $query = $query." where pre.id in(2104,2105,2467,2017,2006,2073)";
                $order = " order by pre.puntos";
            }; break;
        
            case "redimir_hoy": { 
                $query = Consultas::$consulta_premios;
                $query = $query." where pre.puntos <= ".$parametros->saldo_actual;
                $order = " order by pre.puntos";
            }; break;
        
            case "si_te_esfuerzas": { 
                $query = Consultas::$consulta_premios;
                $query = $query." where pre.puntos <= ".$parametros->saldo_actual;
                $order = " order by pre.puntos";
            }; break;
        
            case "ciudad": {
                $query = "select ciu.id, concat(dep.nombre,' - ',ciu.nombre) nombre from ciudad ciu inner join departamento dep on dep.id = ciu.id_departamento";
                $query = $query." where ciu.nombre like '%".$parametros->nombre_ciudad."%'";
                $order = " order by dep.nombre,ciu.nombre";
            }; break;
        
            case "redenciones_usuario": {
                $query = " call sp_obtener_redenciones_usuario(".$parametros->id_usuario."); ";
                $order = "";
            }; break;
        
            case "redencion": {
                $query = " call sp_obtener_redencion(".$parametros->id."); ";
                $order = "";
            }; break;
        
            case "seguimiento_redencion": {
                $query = Consultas::$consulta_seguimiento_redencion." where seg.id_redencion = ".$parametros->id_redencion;
                $order = " order by seg.id";
            }; break;

            case "cantidad_respuestas": {
                $query = "SELECT COUNT(*) AS respuestas FROM encuesta_premio_klim where id_usuario = ".$parametros->id_usuario;
                $order = " ";
            }; break;
        
            case "periodos_temporada": {
                $query = Consultas::$periodos_temporada." where per.id >= 2 ";
                $order = " order by tem.id,per.id ";
            }; break;
        
            case "encuesta_redencion": {
                $query = $query." where id_redencion = ".$parametros->id_redencion;
                $order = " order by id ";
            }; break;

            case "encuesta_premio_klim": { 
                $query = $query." where id_usuario = ".$parametros->id_usuario;
                $order = " order by id ";
            }; break;
        
            case "encuesta_programa_usuario": {
                $query = "select * from encuesta_programa where id_usuario = ".$parametros->id_usuario;
                $order = " order by id ";
            }; break;
        
            case "archivos": {
                $query = "select max(id) id,id_usuario, fecha_factura, img_factura,num_factura, validacion from archivos where id_usuario = ".$parametros->id_usuario;
                $order = " group by fecha_factura,fecha_carga order by 1  ";
            };break;
        
            case "detalle_archivos": {
                $query = Consultas::$detalle_archivos." where arc.num_factura = ".$parametros->num_factura;
                $order = " ";
            };break;
        
            case "negocio": {
                $query = "select id,negocio,direccion,celular from usuarios where negocio is not null";
                $order = " order by id ";
            }; break;
        
            case "periodo_actual": {
                $query = "select * from periodo where now() between fecha_inicio and fecha_final";
                $order = " order by id ";
            }; break;
        
            case "evaluacion_tienda": {
                $query = Consultas::$evaluacion_tienda." where id_usuario = ".$parametros->id_usuario." and id_periodo = ".$parametros->id_periodo;
                $order = " ";
            }; break;
        
            case "puntos_pendientes": {
                $query = Consultas::$puntos_pendientes." where id_usuario = ".$parametros->id_usuario." and validacion = 0";
                $order = " ";
            }; break;
        
            case "total_puntos_pendientes": {
                $query = "SELECT sum(ROUND(metros))puntos FROM archivos where id_usuario = ".$parametros->id_usuario." and validacion = 0";
                $order = " ";
            }; break;
        
            case "puntos_usuario": {
                $query = " call sp_puntos_usuario(".$parametros->id_usuario."); ";
                $order = " ";
            }; break;
        
            case "cargar_lista_distribuidores": {
                $query = "SELECT * FROM almacenes WHERE id != 999 and id != 0";
                $order = " ";
            }; break;
        
            case "inventario_distribuidores": {
                $query = str_replace("_id_distribuidora_", $parametros->id_distribuidora, Consultas::$listado_inventario_distribuidores);
                $order = " ";
            }; break;
        
            case "inventario_archivos": {
                $query = " call sp_modulo_distribuidores(".$parametros->id_almacen."); ";
                $order = " ";
            }; break;
            case "almacen_usuario": {
                $query = Consultas::$almacen_usuario." where usu.id = ".$parametros->id_usuario;
                $order = " ";
            };break;

            case "departamentosdireccion": {
                $query = "SELECT * FROM departamento";
                $order = " ";
            };break;
            case "ciudadesdireccion": {
                $query = "SELECT * FROM ciudad WHERE id_departamento = ".$parametros->id_departamento;
                $order = " ";
            };break;
            
                
        }
        $query = $query.$order;
        return clsDDBBOperations::ExecuteSelectNoParams($query);
    }
    
    private static function EjecutarInsercion($parametros)
    {
        $result = clsDDBBOperations::ExecuteInsert((array)$parametros->datos, $parametros->catalogo);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
    
    private static function EjecutarInsercionMixta($parametros)
    {
        $result = clsDDBBOperations::ExecuteInsert((array)$parametros->datos, $parametros->catalogo_real);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
    
    private static function EjecutarInsercionMixtaMasiva($parametros)
    {
        foreach ($parametros->lista_datos as $datos)
        {
            $result = clsDDBBOperations::ExecuteInsert((array)$datos, $parametros->catalogo_real);
        }
        
        return clsCatalogos::EjecutarConsulta($parametros);
    }
    
    private static function EjecutarModificacion($parametros)
    {
        clsDDBBOperations::ExecuteUpdate((array)$parametros->datos, $parametros->catalogo, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
    
    private static function EjecutarModificacionMixta($parametros)
    {
        clsDDBBOperations::ExecuteUpdate((array)$parametros->datos, $parametros->catalogo_real, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
    
    private static function EjecutarEliminacion($parametros)
    {
        clsDDBBOperations::ExecuteDelete($parametros->catalogo, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
    
    private static function EjecutarEliminacionMixta($parametros)
    {
        clsDDBBOperations::ExecuteDelete($parametros->catalogo_real, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
}
    
?>