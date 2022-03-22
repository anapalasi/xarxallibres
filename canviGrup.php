<?php session_start();

require 'admin/config.php';
require 'functions.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);
$sentencia="SELECT id_tutoria, descripcion from Tutoria where id_tutoria like '21_%ESO%' or id_tutoria like '21_%CFB%'";

// Obtenemos las tutorias que tienen libros
$tutorias = executaSentenciaTotsResultats($conexion, $sentencia);

require 'views/canviGrup.view.php';

