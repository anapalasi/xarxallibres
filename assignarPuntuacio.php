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
	//	executaSentencia($conexion, $sentencia);

	
	$i=0;
	foreach ($_POST['identificador'] as $identificador)
	{
		$sentencia ="insert into Ejemplar  (id_ejemplar, puntos, fecha-mod, isbn_libro,volumen_libro,id_lote) values (\"";
		$sentencia= $sentencia. $identificador. "\", ";
		if (strcmp($estat[$i],"MB") == 0)
			$sentencia=$sentencia. "3,";
		else{
			if (strcmp($estat[$i],"B") == 0)
			$sentencia=$sentencia. "2,";
			else{
				$sentencia=$sentencia. "1,";

			}
		}
		echo $sentencia . "<br>";
		$i++;
	}
	echo $i;

	// Donem d'alta els exemplars
/*	for($i=0;$i<count($_POST['identificador']);$i++){
	{
		$sentencia ="insert into Ejemplar "; //(id_ejemplar, puntos, fecha-mod, isbn_libro,volumen_libro,id_lote) values (\"";
		echo $sentencia;
		$i++;
	}*/
	

/*	$grupos=executaSentenciaTotsResultats($conexion, $sentencia);

	// Insertamos el alumno nuevo en dichos grupos
	foreach ($grupos as $grupo){
		$sentencia="insert into AlumnoGrupo (nia, id_grupo) VALUES (\"". $_POST['nia']."\", \"". $grupo["id_grupo"]. "\")";
		executaSentencia($conexion, $sentencia);	
	}

	echo $_POST["nombre"]. " ". $_POST["apellido1"]. " ha sigut donat d'alta <br>";*/

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
