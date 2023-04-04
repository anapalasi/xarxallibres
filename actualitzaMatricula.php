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

	$senseGrup=array();
	$insertados=0;

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
				//echo $sentencia. " ";
				$resultat=executaSentencia($conexion,$sentencia);
			//	echo $resultat["isbn"]."<br>";
				// Si hi ha un llibre associat hem de crear el grup
				if (strcmp($resultat["isbn"],"")!=0){
					// Falta buscar el grup al que pertany a l'alumne (ojo desdobles)
					$grupo=$anyo_dos.$asignatura.substr($tutoria,3,5);

					// Comprovar si existeix el grup
					$sentencia="select * from Grupo where id_grupo=\"".$grupo."\"";
					$resultado=executaSentencia($conexion,$sentencia);
					if (strcmp($resultado["descripcion"],"") ==0){
						if (!estaEnArray($senseGrup,$grupo)){
							// echo "-- ". $asignatura_libro. "<br>";
							array_push($senseGrup,$grupo);
						}
					}
					// Si el grup existeix inserim l'alumne al grup
					else{
						$insertados=$insertados+1;
						$sentencia ="insert into AlumnoGrupo values(\"". $nia. "\",\"". $grupo."\")";
//						echo $sentencia. "<br>";
						executaSentencia($conexion,$sentencia);			
					}
					 

				}
			}
			else {
				// Batxillerat
				$nivel=substr($tutoria,3,3);
				$asignatura= $datos[3];
				$codigo_asignatura=$nivel."_". $asignatura;

				// Buscamos las asignaturas que tienen libros. 
				$sentencia="select * from Libro where id_asignatura=\"". $codigo_asignatura."\"";
				$resultat=executaSentencia($conexion, $sentencia);
				
				if (strcmp($resultat["isbn"],"")!=0){
					$grupo=$anyo_dos.$asignatura.substr($tutoria,3,5);
					echo $grupo. "<br>";
					/*/ Comprovar si existeix el grup
                                        $sentencia="select * from Grupo where id_grupo=\"".$grupo."\"";
                                        $resultado=executaSentencia($conexion,$sentencia);
					if (strcmp($resultado["descripcion"],"") ==0){
						echo "Con grupo";
					}
					 */	
				}
			}	
		}
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Grups no trobats" . "<br>";
	foreach ($senseGrup as $grup){
		echo $grup . "<br>";
	}
	echo "S'han creat " . $insertados . " associacions alumnat-grup";
?>

