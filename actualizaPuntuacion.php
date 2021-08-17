<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);


	// Comprobaremos el numero de tipos de observaciones que hay
	$sentencia = "select descripcion from Observacion where id_observacion !=0";
	$numeroObservaciones = executaSentenciaTotsResultats($conexion,$sentencia);

	$variable=array();
	$num_observacions = count($numeroObservaciones);

	// Obtenim totes les observacions
	$llistat_observacions = obteObservacions($conexion);
				
	// Observacions formulari
	$observacions_formulari = array();

	// Array amb els exemplars del curs. L'usarem despres per veure si les observacions son d'eixe curs
	$exemplars=array();

	//echo count($_POST['observacions']);
	for($i=0;$i<count($_POST['ejemplar']);$i++){
		$sql = "update Ejemplar set puntos  = '".$_POST['estat'][$i]." ' where id_ejemplar = '".$_POST['ejemplar'][$i]."'";
		array_push($exemplars,$_POST['ejemplar'][$i]);
		$resultat = executaSentencia($conexion,$sql);
		//	$indice=1;
	}
	for ($i=0;$i<count($_POST['observacions']);$i++){
		// Si la observacio es diferent de NULL aleshores s'afig a l'array corresponent
		if ($_POST['observacions'][$i]){
			array_push($observacions_formulari, $_POST['observacions'][$i]);
		}
	}
    	/* Comprovem si les observacions guardades es mantenen i si no les esborrem */
	foreach ($llistat_observacions as $guardada){
		// Dividim amb el caracter separador. parts[0] seria l'exemplar i part[1] l'observacio
		$parts = explode("-",$guardada); 

		// Comprovem que l'observacio pertany a aquest curs
		if (estaEnArray($exemplars,$parts[0]))
		{
			// Si ja no estan al formulari s'han d'esborrar
			if (! in_array($guardada, $observacions_formulari)){
				$sentencia = "DELETE FROM ObservacionEjemplar WHERE id_ejemplar=\"" . $parts[0]. "\" and id_observacion=\"". $parts[1]."\"";
				executaSentencia($conexion, $sentencia);	
			}
		}
			
		
	}

	/* Comprovem si les observacions del formulari estaven ja guardades i si no les inserirem */
	foreach ($observacions_formulari as $nova_obs){
		//Dividim amb el caracter separador
		$parts = explode("-",$nova_obs);
//	 	echo $nova_obs;	
		// Si no es troba en els llistats guardats hem d'inserir-la
		if (! in_array($nova_obs, $llistat_observacions)){
//			echo $parts[0] . " " . $parts[1];
			$sentencia = "INSERT INTO ObservacionEjemplar (id_ejemplar, id_observacion) VALUES (\"". $parts[0]. "\",". $parts[1]. ")"; 
			executaSentencia($conexion, $sentencia);	
		}
	}

    $usuario= iniciarSession('Profesor', $conexion); // Obtenemos el rol del usuario
	
	
	
	
	require 'views/actualizaPuntuacion.view.php';
?>
