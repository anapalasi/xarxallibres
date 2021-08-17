<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
  		header('Location: '.RUTA.'login.php');
	}

	$conexion = conexion($bd_config);
	$admin = iniciarSession('Profesor', $conexion);

	if ($admin['rol'] == 'administrador') {
	  // traer el nombre del usuario
	  $user = iniciarSession('Profesor', $conexion);

	  $DatosTutoria = esTutor($conexion);

	  if ($DatosTutoria != NULL){
	
        	  $tutor="Recollida llibres tutoria " . $DatosTutoria['descripcion'];
          	// Guardamos el id de la tutoria
         	 $_SESSION['id_tutoria']=$DatosTutoria['id_tutoria'];
  	}

	  require 'views/admin.view.php';
	} else {
	  header('Location: index.php');
	}

 ?>

