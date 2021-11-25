<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);

	// Si el archivo se ha cargado correctamente

	$fileTmpPath = $_FILES['assignatures']['tmp_name'];

	//Abrimos nuestro archivo
	$archivo = fopen($fileTmpPath, "r");
	//Lo recorremos
	
	$fila=1; // Variable que creo para no contar la primera fila que es donde se encuentran los encabezados
	$nuevos=0; // Variable para contar cuantas asignaturas nuevas hemos creado.

	while (($datos = fgetcsv($archivo, ",")) == true)
	{
		$num = count($datos);
		$codigo=$datos[1];

		if ($fila != 1) // No procesamos la primera fila 
		{
			
			$sentencia="select * from Asignatura where id_asignatura=\"$codigo\"";
			$existe=executaSentencia($conexion,$sentencia);
			if (! $existe)
			{
				$sentencia="insert into Assignatura (id_asignatura, nombre, codi_dept, id_curso) values (\"";
				$sentencia = $sentencia. $codigo."\",\"". utf8_encode($datos[2])."\",\"". utf8_encode($datos[3])."\",\"";
				$sentencia= $sentencia.	utf8_encode($datos[0])."\")";
				// Inserim el nou professor
				executaSentencia($conexion,$sentencia);
				$nuevos++;
			}

			
			
		}
		$fila++;
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Se han creat ". $nuevos . " assignatures";
?>
