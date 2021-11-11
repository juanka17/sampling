drop procedure if exists sp_obtener_redenciones_usuario;

DELIMITER //

create procedure sp_obtener_redenciones_usuario(id_usuario_p int)
begin

	select
		red.id folio,
		pre.id id_premio,
		pre.nombre premio,
		red.fecha fecha_redencion,
		red.comentarios,
		seg.id id_seguimiento,
		ope.nombre operacion,
		seg.fecha,
		red.puntos,
		red.comentarios,
		red.id_estado_cuenta,
		'' error
	from 
		redenciones red
		inner join premios pre on pre.id = red.id_premio
		inner join seguimiento_redencion seg on seg.id = red.id_ultima_operacion
		inner join operaciones_redencion ope on ope.id = seg.id_operacion
	where
		red.id_usuario = id_usuario_p;
		
end //

delimiter ;

call sp_obtener_redenciones_usuario(599);