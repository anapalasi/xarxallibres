<?php session_start();

require 'admin/config.php';
require 'functions.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);
$sentencia="SELECT * from Profesor order by apellido1, apellido2, nombre";

// Obtenemos las tutorias que tienen libros
$professors = executaSentenciaTotsResultats($conexion, $sentencia);

require 'views/professoratSubstitut.view.php';

