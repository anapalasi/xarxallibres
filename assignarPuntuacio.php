<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	$identificador=strtoupper($_POST['lot']);
	// Crear ellote
	$sentencia="insert into Lote (id_lote, puntos, repartit, folres, valoracioglobal, retirat) VALUES (\"";
	$sentencia = $sentencia . $identificador;
	$sentencia = $sentencia . "\", 0,0,1,\"\",0)";

	$fecha=date('Y-m-d');
	// Insertamos lote en la base de datos
	executaSentencia($conexion, $sentencia);

	
	$i=0;
	foreach ($_POST['identificador'] as $identificador)
	{
		echo $estat[$i]. "<br>";
		$sentencia ="insert into Ejemplar  (id_ejemplar, puntos, fecha_mod, isbn_libro,volumen_libro,id_lote) values (\"";
		$sentencia= $sentencia. $identificador. "\", ";
		$estat = $_POST['estat'][$i];
		$sentencia = $sentencia.$estat.",\"". $fecha . "\",\"" . $_POST['isbn'][$i]."\",\"". $_POST['volumen'][$i]. "\",\"". strtoupper($_POST['lot']). "\")";
		executaSentencia($conexion, $sentencia);
		$i++;
		//echo $sentencia;
	}


	echo "Lot " . strtoupper($_POST["lot"]).  " ha sigut donat d'alta <br>";

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
