<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);
	$sentencia="select distinct isbn, titulo, id_asignatura from Libro order by id_asignatura";
	$resultat=executaSentenciaTotsResultats($conexion, $sentencia);

	require 'views/afigLlibres.view.php';

?>
