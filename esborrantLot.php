<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);
	if (strcmp(trim($_POST['id_lote']),"") != 0){
		$lote=$_POST['id_lote'];
		// Encuentro los libros que tienen observaciones
		$sentencia="select distinct E.id_ejemplar from Ejemplar E, ObservacionEjemplar O where O.id_ejemplar=E.id_ejemplar and E.id_lote=\"". $lote . "\"";
		$llibresAmbObservacions=executaSentenciaTotsResultats($conexion, $sentencia);

		foreach ($llibresAmbObservacions as $llibre){
			$sentencia="delete from ObservacionEjemplar where id_ejemplar=\"". $llibre['id_ejemplar']. "\"";
			executaSentencia($conexion,$sentencia);
		}

		// Borramos los datos históricos
		$sentencia="select id_histórico from Historico where id_lote=\"". $lote ."\"";
		$historico=executaSentenciaTotsResultats($conexion,$sentencia);
		
		foreach ($historico as $historia){
			$sentencia="delete from Historico where id_histórico=\"". $historia['id_histórico']."\"";
			executaSentencia($conexion,$sentencia);
		}

		// Borramos los libros del lote
		$sentencia="select id_ejemplar from Ejemplar where id_lote=\"". $lote. "\"";
		$libros=executaSentenciaTotsResultats($conexion,$sentencia);

		foreach ($libros as $libro){
			$sentencia="delete from Ejemplar where id_ejemplar=\"". $libro['id_ejemplar'] . "\"";
			executaSentencia($conexion,$sentencia);
		}		
		
		// Miramos si está asignado a un alumno
		$sentencia="select * from Alumno where id_lote=\"". $lote ."\"";
		$alumnos=executaSentenciaTotsResultats($conexion,$sentencia);

		foreach ($alumnos as $alumno){
			$cursoAlumno=substr($alumno['id_tutoria'],0,2);
			$cursoActual=calculaCurso();
			if ($cursoAlumno != $cursoActual){
				$sentencia="update Alumno set id_lote=NULL where nia=\"". $alumno['nia']."\"";
				executaSentencia($conexion,$sentencia);	
			}	
		}
		// Borramos el lote
		$sentencia="delete from Lote where id_lote=\"".$lote ."\"";
		executaSentencia($conexion,$sentencia);

		echo "El lot $lote s'ha esborrat satisfactòriament <br>";
	}
	if (strcmp(trim($_POST['id_lote']),"") == 0)
		echo "No ha introducido datos para identificar el lote";
	

?>
