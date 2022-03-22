<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	$nia = $_POST['nia'];
	$tutoria = $_POST['tutoria'];

	// Obtenemos el nombre del alumno
	$sentencia = "SELECT * FROM Alumno where nia=\"". $nia. "\"";	
	$resultat= executaSentencia($conexion,$sentencia);

	$nombre = $resultat['nombre']. " ". $resultat['apellido1']. " ". $resultat['apellido2'];
	$tutoria_actual=$resultat['id_tutoria'];

	 // Obtenemos el curso actual
         $hoy=getdate();
         $anyo=$hoy["year"];
         $anyo_dos=substr($anyo,-2); // Obtenemos los dos últimos numeros del anyo
         $mes=$hoy["mon"];
         if ($mes<9)
            $anyo_dos--;

	
	if ($_POST['canvi'] == "on"){	
	       
       	       // Obtenemos el curso actual
		$hoy=getdate();
                $anyo=$hoy["year"];
                $anyo_dos=substr($anyo,-2); // Obtenemos los dos últimos numeros del anyo
                $mes=$hoy["mon"];
                if ($mes<9)
                        $anyo_dos--;

		// Borramos los grupos anteriores	
		$sentencia = "DELETE FROM AlumnoGrupo where nia=\"" . $nia . "\" and id_grupo like '" . $anyo_dos . "%'";
		executaSentencia($conexion,$sentencia);
			
		// Obtenemos todos los grupos en los que estan matriculados los alumnos del grupo

		$sentencia ="SELECT distinct id_grupo FROM `AlumnoGrupo` AG, Alumno A where A.nia=AG.nia and A.id_tutoria=\"". $tutoria ."\" and AG.id_grupo like '". $anyo_dos ."%'";
        	$grupos=executaSentenciaTotsResultats($conexion, $sentencia);

		// Matriculamos al alumno en los grupos
        	foreach ($grupos as $grupo){
			$sentencia="insert into AlumnoGrupo (nia, id_grupo) VALUES (\"". $nia."\", \"". $grupo["id_grupo"]. "\")";
	                executaSentencia($conexion, $sentencia);
		}

		// En caso de no cursar frances lo borramos
		if ($_POST['frances'] == ""){
			$sentencia="DELETE FROM AlumnoGrupo where nia=\"". $nia . "\" and id_grupo like '21SLE%'";
			executaSentencia($conexion,$sentencia);	
		}

		// Cambio el grupo para indicar que se encuentra en la nueva tutoria
		$sentencia="UPDATE Alumno set id_tutoria=\"". $tutoria . "\" where nia=\"". $nia. "\"";
		executaSentencia($conexion,$sentencia);

	        echo "L'alumne " . $nombre. " ha sigut canviat a ". $tutoria. " <br>";

	}
	else{
		if ($_POST['frances'] == "on"){

			// Obtenim el grup de frances
			$sentencia = "SELECT distinct AG.id_grupo from AlumnoGrupo AG, Alumno A where AG.nia = A.nia and A.id_tutoria=\"". $tutoria_actual . "\" and AG.id_grupo like '". $anyo_dos. "SLE%'";
			$grupos=executaSentenciaTotsResultats($conexion,$sentencia);

			foreach ($grupos as $grupo){
  		        	$sentencia="insert into AlumnoGrupo (nia, id_grupo) VALUES (\"". $nia."\", \"". $grupo["id_grupo"]. "\")";
	                        executaSentencia($conexion, $sentencia);
			}
			echo "L'alumne " . $nombre. " ha sigut canviat a francés  <br>";

		}
	}
 
        echo "<center> <a href=\"";

  	if ($usuario['rol'] == 'administrador')
  	{
    	echo "admin.php";
  	}
  	else
  	{
    	echo "usuario.php";
  	}
  	echo "\">";
	echo "<img src=\"img/casa.png\" width=\"5%\"></a></center> <br>";
  	echo "<a href=\"close.php\">Cerrar Sesion</a>";
	echo "</body>";
	echo "</html>";
?>
