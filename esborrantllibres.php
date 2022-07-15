<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);

	$isbn=$_POST['llibre'];

	$numero=0;

	// Obtenim els exemplars d'eixe llibre
	$sentencia="select id_ejemplar from Ejemplar where isbn_libro=\"". $isbn . "\"";
	$llibres = executaSentenciaTotsResultats($conexion,$sentencia);
	

	foreach ($llibres as $llibre) {
		// Esborrem totes les observacions de l'exemplar.
		$sentencia ="delete from ObservacionEjemplar where id_ejemplar=\"". $llibre['id_ejemplar'] . "\"";
		executaSentencia($conexion,$setencia);


		// Quan s'ha esborrat totes les observacions, s'esborra el llibre
    	$sentencia="delete from Ejemplar where id_ejemplar=\"". $llibre['id_ejemplar']."\"";
    	executaSentencia($conexion,$sentencia);
		
		$numero=$numero+1;
	}

	$sentencia="select titulo, id_asignatura from Libro where isbn=\"". $isbn ."\"";
	$resultat = executaSentencia($conexion,$sentencia);

	require 'views/esborrantllibres.view.php';

?>
