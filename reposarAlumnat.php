<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

        $conexion = conexion($bd_config);

        $qui="per l'alumnat";
        $reposar= reposarAlumnat($conexion);
	require 'views/reposarAlumnat.view.php';

?>
