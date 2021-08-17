<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);
	$id_grup= $_GET["grup"];
	$grup = dadesGrup($conexion,$id_grup);
	$llibres=mostraLlibresNoValorats($conexion, $_SESSION["id_tutoria"]);
	// Possibles valors d'observacions dels llibres
	$sentencia = "select * from Observacion where id_observacion != 0";
	$observacions = executaSentenciaTotsResultats($conexion, $sentencia);
	// Creem una llista d'exemplars
	$llista_exemplars=array();
	foreach ($llibres as $llibre){
		array_push($llista_exemplars,$llibre["ejemplar"]);
	}

	// Obtindrem les observacions de cada exemplar
	$observacionsExemplars = array();
	foreach ($llista_exemplars as $exemplar){

		// Crearem un array on el primer element siga l'identificador d'exemplar i el segon element una llista d'observacions
		// [1ESO_ANG_1, [2,3,6]]
	//	$obs=array();
	//	array_push($obs, $exemplar);
		

		$llista_incidencies = array();

		$llista = observacionsExemplar($conexion, $exemplar);
		foreach ($llista as $incidencia){
			array_push($llista_incidencies,$incidencia["id_observacion"]);
		}

		// Afegirem les incidencies a la llista		
	//	array_push($obs, $llista_incidencies);
		//Afegirem les incidencies a les observacions
		//array_push($observacionsExemplars, $obs);
		$observacionsExemplars[$exemplar] = $llista_incidencies;

	}
	$alumnesNoXarxa=alumnesNoXarxaTutoria($conexion, $id_grup);
	require 'views/valoraGrupTutor.view.php';

?>
