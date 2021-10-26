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
		//Recorremos las columnas de esa linea
		  for ($columna = 0; $columna<$num; $columna++)
		      {
		         echo $datos[$columna] . "\n";
		     }		 
	}
	//Cerramos el archivo
	fclose($archivo);
	echo "Fin";
?>
