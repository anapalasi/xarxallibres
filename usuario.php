<?php session_start();

require 'admin/config.php';
require 'functions.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);
$user = iniciarSession('Profesor', $conexion);

if ($user['rol'] == 'usuari') {
  // traer el nombre del usuario
  $user = iniciarSession('Profesor', $conexion);
  $DatosTutoria = esTutor($conexion);

  if ($DatosTutoria != NULL){

	  $tutor="Recollida llibres tutoria " . $DatosTutoria['descripcion'];
	  // Guardamos el id de la tutoria
	  $_SESSION['id_tutoria']=$DatosTutoria['id_tutoria'];
  }

  require 'views/usuario.view.php';
} else {
  header('Location: index.php');
}

