<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);

	// Si el archivo se ha cargado correctamente

	$fileTmpPath = $_FILES['professorat']['tmp_name'];

	//Abrimos nuestro archivo
	$archivo = fopen($fileTmpPath, "r");
	//Lo recorremos

	while (($datos = fgetcsv($archivo, ",")) == true)
	{
		$num = count($datos);
		$nif=$datos[1];

		if (strcmp(substr($nif,0,1),"0") == 0)
		{
			$sentencia="select * from Profesor where dni=\"$nif\"";
			$existe=executaSentencia($conexion,$sentencia);
			if (! $existe)
			{
				$sentencia="insert into Profesor (dni, nombre, apellido1, apellido2, contrasenya,rol) values (\"";
				$sentencia = $sentencia. $nif."\",\"". utf8_encode($datos[2])."\",\"". utf8_encode($datos[3])."\",\"";
				$sentencia= $sentencia.	utf8_encode($datos[4])."\",\"";
				$contrasenya= substr($datos[3],0,2).$nif;
				$contrasenya=strtolower($contrasenya);
				$sentencia = $sentencia. $contrasenya. "\",\"usuari\")";
				// Inserim el nou professor
				executaSentencia($conexion,$sentencia);
				// Xifrem la contrasenya
				$sentencia ="UPDATE Profesor SET contrasenya=sha2(contrasenya,512) where dni=\"$nif\"";
				executaSentencia($conexion, $sentencia);
			}
			$tutor=$datos[8];
			if (!empty($tutor)){
				// Obtenemos la fecha actual
				$hoy=getdate();
				$anyo=$hoy["year"];
				$anyo_dos=substr($anyo,-2); // Obtenemos los dos últimos numeros del anyo
				$mes=$hoy["mon"];
				if ($mes<9)
					$anyo_dos--;
				$tutoria=$anyo_dos."_".$tutor;
				
				// Asignamos el tutor a la clase (no comprobamos si está vacío porqué puede ser un sustituto
				$sentencia ="update Tutoria set dni_tutor=\"". $nif. "\" where id_tutoria=\"". $tutoria ."\"";
				executaSentencia($conexion, $sentencia);
			}

			
			
		}
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Llistat de professorat actualitzat";
?>
