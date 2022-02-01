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
		
		$sentencia="select id_tutoria from Alumno where nia=\"". $nia. "\"";
		$resultado=executaSentencia($conexion,$sentencia);	

		// Obtenemos el curso actual
                $hoy=getdate();
                $anyo=$hoy["year"];
                $anyo_dos=substr($anyo,-2); // Obtenemos los dos últimos numeros del anyo
                $mes=$hoy["mon"];
                if ($mes<9)
			$anyo_dos--;

		$tutoria=$resultado["id_tutoria"];
		$anyo_matricula=substr($tutoria,0,2);

		// Está matriculado este anyo
		if (strcmp($anyo_dos,$anyo_matricula)==0){
			// Comprobamos que cursa la ESO
			$etapa=substr($tutoria,4,3);
			if (strcmp($etapa,'ESO')==0){
				$nivel=substr($tutoria,3,4);
				
				// Extraemos la asignatura
				$asignatura=$datos[2];

				// Comprovem si el contingut son Mates aplicades i afegim al nivel AP
				if ((strcmp($asignatura,"MAPLOMCE")==0) && (strcmp($nivel,"4ESO")==0)){
					$nivel=$nivel."AP";
				}

				$asignatura_libro=$nivel."_".$asignatura;

				//Buscar las asignaturas con libros.
				$sentencia="select * from Libro where id_asignatura=\"". $asignatura_libro."\"";
				$resultat=executaSentencia($conexion,$sentencia);
				// Si hi ha un llibre associat hem de crear el grup
				if (strcmp($resultat["isbn"],"")!=0){
					// Falta buscar el grup al que pertany a l'alumne (ojo desdobles)
					$grupo=$anyo_dos.$asignatura.substr($tutoria,3,5);

					// Comprovar si existeix el grup
					$sentencia="select * from Grupo where id_grupo=\"".$grupo."\"";
					$resultado=executaSentencia($conexion,$sentencia);
					if (strcmp($resultado["descripcion"],"") !=0){
						echo $resultado["descripcion"]."<br>";
					}
					else
						echo $grupo. "<br>";

				}
			}
		}

		// Solo para alumnos matriculados en el curso actual y de la ESO
//		if (str_contains($tutoria,"ESO")){
			/*			if (str_starts_with($tutoria,$anyo_dos)){*/
//				echo $tutoria;
			//}
	//	}
 
		// Comprovar que la tutoria contiene ESO
/*
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

			
			
		}*/
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Llistat de professorat actualitzat";
?>
