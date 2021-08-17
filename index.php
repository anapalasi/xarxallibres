<?php 
	// Iniciamos una sesion
	session_start();

	require 'admin/config.php';
	require 'functions.php';

	// Comprobar sesion
	if (isset($_SESSION['usuario'])){
		// Validar los datos por privilegio
		$conexion= conexion($bd_config);
		$usuario= iniciarSession('Profesor', $conexion);


		if ($usuario['rol'] == 'administrador'){
			header('Location: admin.php');
		}
		elseif ($usuario['rol'] == 'usuari'){
			header('Location: usuario.php');
		}
		else{
			header('Location: login.php');
		}
	}
	else {
				
		header('Location: login.php');
	}
?>
