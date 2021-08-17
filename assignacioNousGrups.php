<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);

	// Variable que se usa para saber cuántos alumnos se han actualizado
	$actualizado = 0;


	//Recorremos el conjunto de alumnos y si la nueva tutoria empieza por 21_ entonces la actualizamos
	for ($i=0; $i<count($_POST['nia']);$i++){
		
		$nuevaTutoria=$_POST['nuevaTutoria'][$i];
		$nuevaTutoria=trim($nuevaTutoria);
		
		$cursAlumne=substr($nuevaTutoria, 0,2);
		$properCurs="21";
		if (strcmp($cursAlumne,$properCurs) == 0)
		{
			$nia=$_POST['nia'][$i];
			$sentencia = "update Alumno set id_tutoria=\"". $nuevaTutoria. "\" where nia=\"". $nia . "\"";

			$resultado=executaSentencia($conexion, $sentencia);
			$actualizado=$actualizado+1;

		}
	
			

	}
	

	
	echo "Se han actualizado ". $actualizado . "  alumnos <br>";

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
