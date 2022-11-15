<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);
	if (strcmp(trim($_POST['id_lote']),"") != 0){
		$llibres = mostraLlibresLot($conexion, $_POST['id_lote']);
		$nombreCompleto=nomCompletLot($conexion, $_POST['id_lote']);
		$puntuacio=calculaPuntuacio($conexion, $_POST['id_lote']);
		$dadesLot=dadesLot($conexion, $_POST['id_lote']);
		$sentencia ="SELECT H.id_histórico, H.puntos, A.nombre, A.apellido1, A.apellido2 from Historico H, Alumno A where H.nia=A.nia and H.id_lote=\"". $_POST['id_lote']. "\" order by H.id_histórico";
		$resultat=executaSentenciaTotsResultats($conexion,$sentencia);

	}
	else {
		if (strcmp(trim($_POST['nia']),"") !=0){
//			$llibres= mostraLlibresAlumne($conexion, $_POST['nia']);
			$llibres = mostraLlibresAlumne($conexion,$_POST['nia']);
			$nombreCompleto = nomCompletNIA($conexion, $_POST["nia"]);
			$puntuacio = calculaPuntuacio($conexion,$nombreCompleto["lote"]);
			$dadesLot=dadesLot($conexion,$nombreCompleto["lote"]);
		}
	}
	if ((strcmp(trim($_POST['id_lote']),"") == 0) && (strcmp(trim($_POST['nia']),"") == 0))
		echo "No ha introducido datos para identificar el lote";
	
	require 'views/valorarLot.view.php';

?>
