<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	// Comprobamos si el lote estaba asignado a otro alumno y lo desasignamos
	if (strcmp($_POST['asignado'],"otro") == 0){
		if (strcmp($_POST['id_lote'],"") != 0){


		$sentencia = "select * from Alumno where id_lote=\"" . $_POST['id_lote']. "\"";
		$resultado = executaSentencia($conexion, $sentencia);

		
		$sentencia = "update Alumno set id_lote=\"NULL\" where nia=\"". $resultado["nia"]. "\"";
		executaSentencia($conexion, $sentencia);

		}
	}
	$sentencia="insert into Alumno (nia, nombre, apellido1, apellido2, banc_llibres, id_lote, id_tutoria) VALUES (\"";
	$sentencia = $sentencia . $_POST['nia'];
	$sentencia = $sentencia . "\", \"";
	$sentencia = $sentencia . $_POST['nombre'];
	$sentencia = $sentencia . "\", \"";
	$sentencia = $sentencia . $_POST['apellido1'];
	$sentencia = $sentencia . "\", \"";
	$sentencia = $sentencia . $_POST['apellido2'];
	$sentencia = $sentencia . "\", ";
	if (strcmp($_POST['banc'],"") == 0)
		$sentencia = $sentencia . "0";
	else
		$sentencia = $sentencia . "1";
	$sentencia = $sentencia . ", \"";
	if (strcmp($_POST['id_lote'],"") == 0)
		$sentencia = $sentencia . "NULL";
	else
		$sentencia = $sentencia . $_POST['id_lote'];
	$sentencia = $sentencia . "\", \"";
	$sentencia = $sentencia . $_POST['tutoria'];
	$sentencia = $sentencia . "\")";

	// Insertamos alumno en la base de datos
	executaSentencia($conexion, $sentencia);

	// Buscamos los grupos a los que pertenece la clase
	$sentencia ="SELECT distinct id_grupo FROM `AlumnoGrupo` AG, Alumno A where A.nia=AG.nia and A.id_tutoria=\"". $_POST['tutoria']."\"";
	$grupos=executaSentenciaTotsResultats($conexion, $sentencia);

	// Insertamos el alumno nuevo en dichos grupos
	foreach ($grupos as $grupo){
		$sentencia="insert into AlumnoGrupo (nia, id_grupo) VALUES (\"". $_POST['nia']."\", \"". $grupo["id_grupo"]. "\")";
		executaSentencia($conexion, $sentencia);	
	}

	echo $_POST["nombre"]. " ". $_POST["apellido1"]. " ha sigut donat d'alta <br>";

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
