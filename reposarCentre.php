<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

        $conexion = conexion($bd_config);

        $qui="pel centre";
        $reposar= reposarCentre($conexion);
	require 'views/reposarCentre.view.php';

?>
