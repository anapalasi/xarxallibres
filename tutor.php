<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);
	$dades = dadesRecollidaLots($conexion, $_SESSION["id_tutoria"]);
	$alumnosNoValorados = alumnosLibrosNoValorados($conexion, $_SESSION["id_tutoria"]);	
	require 'views/tutor.view.php';

?>
