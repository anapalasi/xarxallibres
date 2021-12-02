<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);

	// Si el archivo se ha cargado correctamente

	$fileTmpPath = $_FILES['grups']['tmp_name'];

	//Abrimos nuestro archivo
	$archivo = fopen($fileTmpPath, "r");

	$curs_ini=$_POST['curs'];
	$curs_fin=$curs_ini + 1;

	$curs_academic=$curs_ini."-". $curs_fin;

	$fila = 0; // La primera fila no l'analitzem
	//Lo recorremos

	$creacion=0;

	while (($datos = fgetcsv($archivo, ",")) == true)
	{
		if ($fila !=0){
			$longitud=strlen($datos[2])-1;
			$nivel = substr($datos[2],0,$longitud);

			$codi_asignatura=$datos[3];
			if (strcmp($codi_asignatura,"GHLOMCE")==0){
				if (strcmp($nivel,"4ESO") !=0)
					$codi_asignatura=$codi_asignatura."_VAL";
			}
			$id_asignatura=$nivel."_".$codi_asignatura;

			$sentencia="select nombre from Asignatura where id_asignatura=\"". $id_asignatura."\"";
			$resultado=executaSentencia($conexion,$sentencia);
			$descripcion=$resultado["nombre"]." ". $datos[2] ;

			// Comprobamos que la asignatura existe
			if (strcmp($descripcion,"") !=0){

				// Creem el grup
				$id_grupo=$datos[5];
				$sentencia="insert into Grupo (id_grupo, descripcion, curso_academico, id_asignatura) values (\"";
				$sentencia = $sentencia. $id_grupo."\",\"". $descripcion. "\",\"". $curs_academic;
				$sentencia = $sentencia . "\",\"". $id_asignatura."\")";
				executaSentencia($conexion,$sentencia);

				// Creem l'associació grup profesor
				$sentencia="insert into GrupoProfesor (dni, id_grupo) values (\"". $datos[4]."\",\"". $id_grupo ."\")";
				executaSentencia($conexion,$sentencia);	
 				$creacion++;
			}
			
		}
		$fila++;
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Se han creado " . $creacion . " grupos";
?>
