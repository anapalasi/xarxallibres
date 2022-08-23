<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);

	// Si el archivo se ha cargado correctamente

	$fileTmpPath = $_FILES['matricula']['tmp_name'];

	//Abrimos nuestro archivo
	$archivo = fopen($fileTmpPath, "r");
	//Lo recorremos

	while (($datos = fgetcsv($archivo, ",")) == true)
	{
		$num = count($datos);
		$nia=$datos[0];
		

		// La primera fila tiene las cabeceras
		if (strcmp(substr($nia,0,1),"1") == 0)
		{
			$sentencia="select * from Alumno where nia=\"$nia\"";
			$existe=executaSentencia($conexion,$sentencia);
			if ($existe)
			{
				$grupo=$datos[8];
				// Calculamos el curso
				$curso=calculaCurso()+1;
				$grupoActual = $curso. "_". $grupo;
				echo $grupoActual. "<br>";
				$sentencia="update Alumno set id_tutoria=\"$grupoActual\" where nia=\"$nia\"";
				// Actualitzem el grup de l'alumne
				executaSentencia($conexion,$sentencia);
				
				
			}

		}
		//else Falta l'alumnat nou
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Llistat de alumnat actualitzat";
?>
