<?php

class Consultas
{
    public static $consulta_usuarios = '
        select 
            usu.id,
            usu.cedula,
            usu.nombre,
            usu.fecha_nacimiento,
            usu.telefono,
            usu.celular,
            usu.direccion,
            usu.genero,
            usu.correo_corporativo,
            usu.operador,
            usu.whatsapp,
            ciu.id id_ciudad,
            concat(dep.nombre," - ",ciu.nombre) ciudad,
            usu.acepto_terminos,
            est.id id_estado,
            est.nombre estado,
            rol.id id_rol,
            rol.nombre rol
        from 
            usuarios usu
            inner join categorias cat on cat.id = usu.id_categoria
            inner join estados est on est.id = usu.id_estado
            inner join roles rol on rol.id = usu.id_rol
            left join almacenes alm on alm.id = usu.id_almacen
            left join ciudad ciu on ciu.id = usu.id_ciudad
            left join departamento dep on dep.id = ciu.id_departamento 
    ';
    
    public static $consulta_llamadas_usuarios = "
        SELECT 
            la.id, 
            la.fecha, 
            concat(tp.NOMBRE,'-',sc.NOMBRE,'-',cl.NOMBRE) categoria,
            usr.NOMBRE registro, 
            comentario
        FROM    
            llamadas_usuarios la 
            inner join categorias_llamada cl on la.ID_SUBCATEGORIA = cl.ID 
            inner join categorias_llamada sc on sc.ID = cl.ID_PADRE
            inner join categorias_llamada tp on tp.ID = sc.ID_PADRE
            left join usuarios usr on usr.id = la.id_usuario_registra
        ";
    
    public static $consulta_llamadas_usuarios_completa = "
        SELECT 
            usu.id id_usuario,
            usu.cedula,
            usu.nombre usuario,
            alm.nombre almacen,
            lla.id, 
            lla.fecha, 
            concat(tpl.NOMBRE,'-',scl.NOMBRE,'-',cal.NOMBRE) categoria,
            usr.NOMBRE registro, 
            comentario
        FROM    
            llamadas_usuarios lla 
            inner join categorias_llamada cal on lla.ID_SUBCATEGORIA = cal.ID 
            inner join categorias_llamada scl on scl.ID = cal.ID_PADRE
            inner join categorias_llamada tpl on tpl.ID = scl.ID_PADRE
            inner join usuarios usu on usu.id = lla.id_usuario
            inner join almacenes alm on alm.id = usu.id_almacen
            left join usuarios usr on usr.id = lla.id_usuario_registra
    ";
    
    public static $consulta_habilidades_usuario = "
    select 
	hau.id,
	hab.nombre habilidad
    from
	habilidades_usuario hau
	inner join habilidades hab on hab.id = hau.id_habilidad
    ";
    
    public static $consulta_estado_cuenta = "
        SELECT                                 
            ecu.id ,
            per.id id_periodo,
            per.nombre periodo,
            usu.id id_usuario,
            usu.nombre usuario,
            usu.cedula,
            con.id id_concepto,
            con.nombre concepto,
            ecu.descripcion,
            ecu.metros cantidad,
            (SELECT arc.precio FROM archivos arc WHERE arc.id_usuario = ecu.id_usuario AND arc.num_factura = ecu.num_factura LIMIT 1) precio,
            ecu.num_factura,
            (SELECT alm.nombre FROM archivos arc INNER JOIN almacenes alm ON alm.id = arc.id_almacen  WHERE arc.id_usuario = ecu.id_usuario AND arc.num_factura = ecu.num_factura LIMIT 1) id_almacen,
            (SELECT arc.img_factura FROM archivos arc WHERE arc.id_usuario = ecu.id_usuario AND arc.num_factura = ecu.num_factura LIMIT 1) img_factura,
            (SELECT arc.fecha_factura FROM archivos arc WHERE arc.id_usuario = ecu.id_usuario AND arc.num_factura = ecu.num_factura LIMIT 1) fecha_factura,
            case when con.suma = 1 then ecu.puntos else ecu.puntos * -1 end puntos
        from 
            estado_cuenta ecu
            inner join conceptos con on con.id = ecu.id_concepto
            inner join periodo per on per.id = ecu.id_periodo
            inner join temporadas tem on tem.id = per.id_temporada
            inner join usuarios usu on ecu.id_usuario = usu.id
    ";
    
    public static $consulta_premios = "
        select
            pre.id id_premio,
            pre.nombre premio,
            cat.id id_categoria,
            cat.nombre categoria,
            pre.marca,
            pre.descripcion,
            pre.puntos,
            pre.solo_call,
            pre.fecha_actualizacion,
            pre.puntos_promocion,            
            pre.fecha_vigencia,
        case 
            when pre.puntos_promocion > 0 and now() < fecha_vigencia then pre.puntos_promocion 
            else pre.puntos 
            end puntos_actuales
        from 
            premios pre
            inner join categoria_premios cat on cat.id = pre.id_categoria	
    ";
    
    public static $consulta_general_redenciones = "
        select
            usu.id id_usuario,
            usu.cedula,
            usu.nombre usuario,
            usu.telefono,
            usu.celular,
            usu.direccion,
            ciu.nombre ciudad,
            dep.nombre departamento,
            pre.id id_premio,
            pre.nombre premio,
            pre.marca,
            red.direccion_envio,
            red.ciudad_envio,
            red.fecha fecha_redencion,
            (SELECT fecha FROM llamadas_usuarios WHERE id_usuario = usu.id ORDER BY 1 LIMIT 1) fecha_llamada,
            red.comentarios,
            red.id id_redencion,
            seg.id id_seguimiento,
            seg.referencia,
            ope.nombre operacion,
            case
                when pre.marca='KLIM' then concat('SPK-',red.id)
            	when pre.marca='MAGGI' then concat('SPM-',red.id)
            end folio,
            reg.nombre registra
        from 
            redenciones red
            inner join usuarios usu on usu.id = red.id_usuario
            inner join categorias cat on cat.id = usu.id_categoria
            left join ciudad ciu on ciu.id = usu.id_ciudad
            left join departamento dep on dep.id = ciu.id_departamento
            left join almacenes alm on alm.id = usu.id_almacen
            inner join premios pre on pre.id = red.id_premio
            inner join seguimiento_redencion seg on seg.id = red.id_ultima_operacion
            inner join operaciones_redencion ope on ope.id = seg.id_operacion
            left join usuarios reg on reg.id = red.id_registra

    ";
    
    public static $consulta_seguimiento_redencion = "
        select
            ope.nombre operacion,
            seg.comentario,
            seg.referencia,
            seg.fecha
        from
            seguimiento_redencion seg
            inner join operaciones_redencion ope on ope.id = seg.id_operacion
    ";
    
    public static $reporte_cumpleanos = "
        select
            alm.nombre almacen,
            rep.nombre representante,
            usu.nombre usuario,
            usu.cedula,
            usu.fecha_nacimiento,
            day(usu.fecha_nacimiento) 'Día',
            month(usu.fecha_nacimiento) 'Mes',
            year(usu.fecha_nacimiento) 'Año'
        from 
            usuarios usu
            inner join almacenes alm on alm.id = usu.id_almacen
            left join usuarios rep on rep.id = alm.id_representante
        where
            usu.fecha_nacimiento is not null
    ";
    
    public static $periodos_temporada = "
        select per.id, concat(tem.nombre,'-',per.nombre) nombre 
        from 
	periodo per 
	inner join temporadas tem on tem.id = per.id_temporada
    ";
    
    public static $consulta_pollas_activas = "
        select 
            pol.id,
            pol.nombre,
            eqa.nombre nombre_A,
            eqa.imagen imagen_A,
            eqb.nombre nombre_B,
            eqb.imagen imagen_B,
            pol.fecha_evento,
            DATE_SUB(pol.fecha_evento, INTERVAL pol.minutos_cierre MINUTE) fecha_vigencia,
            case when ppa.id is null then 0 else ppa.id end participacion,
            case when ppa.marcadora is null then -1 else ppa.marcadora end marcadora,
            case when ppa.marcadorb is null then -1 else ppa.marcadorb end marcadorb
        from 
            polla pol
            inner join polla_equipos eqa on eqa.id = pol.id_equipo_a
            inner join polla_equipos eqb on eqb.id = pol.id_equipo_b
            left join polla_participacion ppa on ppa.id_polla = pol.id and ppa.id_usuario = _id_usuario_
        where
            now() <= DATE_SUB(pol.fecha_evento, INTERVAL pol.minutos_cierre MINUTE)
        order by
            pol.fecha_evento
    ";
    
    public static $consulta_ganadores_polla = "
        SELECT
            pol.id,
            pol.nombre partido,	
            eqa.nombre nombre_a,
            eqb.nombre nombre_b,
            pol.resultado_a,
            pol.resultado_b,
            usu.nombre usuario,
            par.marcadora,
            par.marcadorb
        FROM polla pol
            inner join polla_participacion par on pol.id = par.id_polla
            inner join polla_equipos eqa on pol.id_equipo_a = eqa.id
            inner join polla_equipos eqb on pol.id_equipo_b = eqb.id
            inner join usuarios usu on usu.id = par.id_usuario
            where pol.resultado_a = par.marcadora and pol.resultado_b = par.marcadorb
    ";
    
    public static $consulta_equipos_mundial = "
        SELECT
            *
        FROM
            polla_predicciones pre

    ";
    
    public static $consulta_pollas_participacion_usuario = "
        select 
            par.id_usuario,
            pol.nombre,
            par.marcadora,
            par.marcadorb,
            equ1.nombre nombre_a,
            equ2.nombre nombre_b,
            par.fecha_participacion
        from 
            polla_participacion par
            left join polla pol on pol.id = par.id_polla
            inner join polla_equipos equ1 on equ1.id = pol.id_equipo_a
            inner join polla_equipos equ2 on equ2.id = pol.id_equipo_b
    ";
    
    public static $evaluacion_tienda = "
        select 
            eva.id,
            eva.id_periodo,
            per.nombre periodo,
            eva.avisos,
            eva.exhibidores,
            eva.triciclo,
            graphic_floor,
            branding_vehiculo,
            branding_local
        from evaluacion_tienda eva
        inner join periodo per on per.id = eva.id_periodo
    ";
    
    public static $puntos_pendientes = "
        SELECT 
            cat.nombre categoria,
            arc.fecha_carga,
            arc.milimetros,
            arc.metros,
            arc.num_factura,
            ROUND(metros)puntos
        FROM archivos arc
            inner join categoria_productos cat on cat.id = arc.id_categoria
    ";
    
    public static $reporte_inventario= "
        SELECT
            cat.nombre producto,
            inv.fecha,
            inv.cantidad,
            inv.espesor,
            inv.id_almacenes,
            alm.nombre Distribuidora,
            inv.id_usuarios,
            usu.nombre 
        FROM inventario_lista inv
            inner join categoria_productos cat on cat.id = inv.id_categoria_productos
            inner join usuarios usu on usu.id = inv.id_usuarios
            inner join almacenes alm on alm.id = inv.id_almacenes
    ";
    
        public static $listado_inventario_distribuidores= "
        SELECT 
            inv.id_inventario_lista,
            CASE
                WHEN MONTH(inv.fecha)=1 THEN 'Enero'
                WHEN MONTH(inv.fecha)=2 THEN 'Febrero'
                WHEN MONTH(inv.fecha)=3 THEN 'Marzo'
                WHEN MONTH(inv.fecha)=4 THEN 'Abril'
                WHEN MONTH(inv.fecha)=5 THEN 'Mayo'
                WHEN MONTH(inv.fecha)=6 THEN 'Junio'
                WHEN MONTH(inv.fecha)=7 THEN 'Julio'
                WHEN MONTH(inv.fecha)=8 THEN 'Agosto'
                WHEN MONTH(inv.fecha)=9 THEN 'Septiembre'
                WHEN MONTH(inv.fecha)=10 THEN 'Octubre'
                WHEN MONTH(inv.fecha)=11 THEN 'Noviembre'
                WHEN MONTH(inv.fecha)=12 THEN 'Diciembre'
                ELSE '0'
            END periodo,
            MONTH(inv.fecha)id_fecha,
            cat.nombre,
            inv.espesor,
            sum(inv.cantidad) cantidad
            FROM inventario_lista inv
            INNER JOIN categoria_productos cat ON inv.id_categoria_productos = cat.id
            WHERE inv.id_almacenes = _id_distribuidora_
            GROUP BY inv.fecha
    ";
        
        public static $detalle_archivos= "
        SELECT
            arc.fecha_factura,
            arc.nombre_producto_negocio producto_negocio,
            arc.nombre_producto_homologado producto_homologado,
            arc.cantidad,
            arc.fecha_carga,
            arc.num_factura,   
            arc.id_almacen,  
       CASE
                WHEN arc.id_almacen = 0 THEN 'Exito'
                WHEN arc.id_almacen = 1 THEN 'Carulla'
                WHEN arc.id_almacen = 2 THEN 'Olímpica'
                WHEN arc.id_almacen = 3 THEN 'Farmatodo'
                WHEN arc.id_almacen = 4 THEN 'Jumbo'
                WHEN arc.id_almacen = 5 THEN 'Metro'
                ELSE 'The quantity is under 30'
            END almacen            
            FROM archivos arc
    ";
        
        public static $almacen_usuario= "
        SELECT
            usu.id,
            alm.id,
            alm.nombre
            FROM usuarios usu
            inner JOIN almacenes alm ON alm.id = usu.id_almacen
    ";

    public static $reporte_encuesta= '
        SELECT usu.id id,
            usu.cedula,
            usu.nombre,
            red.id redencion,
            case when numero_pregunta=1 AND respuesta= 0 then "No"
                    when numero_pregunta=1 AND  respuesta=1 then "Si"
                    when numero_pregunta=1 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 1",
            case when numero_pregunta=1 then enc.comentario end  "comentario pregunta 1",
            case when numero_pregunta=2 AND respuesta= 0 then "No"
                    when numero_pregunta=2 AND  respuesta=1 then "Si"
                    when numero_pregunta=2 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 2",
            case when numero_pregunta=2 then enc.comentario end  "comentario pregunta 2",
            case when numero_pregunta=3 AND respuesta= 0 then "No"
                    when numero_pregunta=3 AND  respuesta=1 then "Si"
                    when numero_pregunta=3 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 3",
            case when numero_pregunta=3 then enc.comentario end  "comentario pregunta 3",
            case when numero_pregunta=4 AND respuesta= 0 then "No"
                    when numero_pregunta=4 AND  respuesta=1 then "Si"
                    when numero_pregunta=4 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 4",
            case when numero_pregunta=4 then enc.comentario end  "comentario pregunta 4",
            case when numero_pregunta=5 AND respuesta= 0 then "No"
                    when numero_pregunta=5 AND  respuesta=1 then "Si"
                    when numero_pregunta=5 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 5",
            case when numero_pregunta=5 then enc.comentario end  "comentario pregunta 5",
            case when numero_pregunta=6 AND respuesta= 0 then "No"
                    when numero_pregunta=6 AND  respuesta=1 then "Si"
                    when numero_pregunta=6 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 6",
            case when numero_pregunta=6 then enc.comentario end  "comentario pregunta 6",
            case when numero_pregunta=7 AND respuesta= 0 then "No"
                    when numero_pregunta=7 AND  respuesta=1 then "Si"
                    when numero_pregunta=7 AND  respuesta=2 then "NA" 
                    END "respuesta pregunta 7",
            case when numero_pregunta=7 then enc.comentario end  "comentario pregunta 7"
        FROM encuesta_redencion enc
            INNER JOIN redenciones red ON enc.id_redencion=red.id
            INNER JOIN usuarios usu ON usu.id=red.id_usuario
        GROUP BY usu.cedula,
                usu.nombre,
                red.id,
                enc.numero_pregunta
        ORDER BY usu.cedula, enc.numero_pregunta
';
}

?>