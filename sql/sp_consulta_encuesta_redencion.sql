drop procedure if exists sp_consulta_encuesta_redencion;

DELIMITER //

create procedure sp_consulta_encuesta_redencion(id_premio_ int)
begin
	
	SET @id_premio=id_premio_;
	
	drop table if exists t_redenciones;
	create table t_redenciones (
	
		select distinct
			usu.nombre usuario,
			usu.cedula,
			red.id id_redencion,
			per.nombre periodo,
			pre.nombre premio,
			ope.nombre operacion,
			red.fecha fecha_redencion
		from 
			encuesta_redencion enc
			left join redenciones red on red.id = enc.id_redencion
			left join premios pre on pre.id = red.id_premio
			left join seguimiento_redencion seg on seg.id = red.id_ultima_operacion
			left join operaciones_redencion ope on ope.id = seg.id_operacion
			left join usuarios usu on usu.id = red.id_usuario
			left join periodo per on per.id = red.id_periodo
			left join almacenes alm on alm.id = usu.id_almacen
			WHERE id_premio= @id_premio
	);
	
	drop table if exists t_encuestas;
	create table t_encuestas (
	
		select
			red.id_redencion,
			red.usuario,
			red.cedula,
			red.periodo,
			red.premio,
			red.operacion,
			red.fecha_redencion,
			enc.fecha fecha_encuesta,
			max(case when enc.numero_pregunta = 1 then enc.respuesta else '' end) p1,
			max(case when enc.numero_pregunta = 2 then enc.respuesta else '' end) p2,
			max(case when enc.numero_pregunta = 3 then enc.respuesta else '' end) p3,
			max(case when enc.numero_pregunta = 4 then enc.respuesta else '' end) p4,
			max(case when enc.numero_pregunta = 5 then enc.respuesta else '' end) p5,
			max(case when enc.numero_pregunta = 6 then enc.respuesta else '' end) p6,
			max(case when enc.numero_pregunta = 7 then enc.respuesta else '' end) p7,
			trim(replace(group_concat(enc.comentario order by enc.id),',',' ')) comentarios
		from 
			t_redenciones red
			left join encuesta_redencion enc on enc.id_redencion = red.id_redencion
		group by
			red.id_redencion,
			red.usuario
		order by
			red.id_redencion,
			enc.numero_pregunta
	);
	
	select
		enc.id_redencion,
		enc.usuario,
		enc.cedula,
		enc.periodo,
		enc.premio,
		enc.operacion,
		enc.fecha_redencion,
		enc.fecha_encuesta,
		case 
			when enc.p1 = 0 AND @id_premio = 2916 then 'No'
			when enc.p1 = 1 AND @id_premio = 2916 then 'Si'
			ELSE enc.p1
		END  pregunta1,
		case 
			when enc.p2 = 2 AND @id_premio = 2916 then 'NA'
			else enc.p2
		end pregunta2,
		case 
			when enc.p3 = 0 AND @id_premio = 2916 then 'No'
			when enc.p3 = 1 AND @id_premio = 2916 then 'Si'
			else enc.p3
		end pregunta3,
		case 
			when enc.p4 = 0 AND @id_premio = 2916 then 'No'
			when enc.p4 = 1 AND @id_premio = 2916 then 'Si'
			else enc.p4
		end pregunta4,
		case 
			when enc.p5 = 2 AND @id_premio = 2916 then 'NA'
			else enc.p5
		end pregunta5,
		case 
			when enc.p6 = 0 AND @id_premio = 2916 then 'No'
			when enc.p6 = 1 AND @id_premio = 2916 then 'Si'
			else enc.p6
		end pregunta6,
		case 
			when enc.p7 = 0 AND @id_premio = 2916 then 'No'
			when enc.p7 = 1 AND @id_premio = 2916 then 'Si'
			else enc.p7
		end pregunta7,
		enc.comentarios
	from 
		t_encuestas enc
	order by
		enc.usuario,
		enc.id_redencion;
	
	
	SELECT * FROM t_redenciones;
	SELECT * FROM t_encuestas;
	
	/*drop table if exists t_redenciones;
	//drop table if exists t_encuestas;*/
	
END //

delimiter ;

call sp_consulta_encuesta_redencion(2918);