<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);
	$resultat=actualizaHistorico($conexion);

	 $nous_registres=0; // Nombre de nous registres que s'actualitzaran

        foreach ($resultat as $historic){
           $nous_registres++;
           $s="insert into Historico(id_histórico, curso, puntos, id_lote, nia, id_tutoria) values  (\"". $historic['id_historico']."\",\"".$historic['curso']."\",\"". $historic['puntos']."\",\"". $historic['id_lote']. "\",\"".$historic['nia']. "\",\"". $historic['id_tutoria']. "\");";
	   //  echo $s . "<br>";
	   try{
		   executaSentencia($conexion,$s);
	   }
	   catch (PDOException $e)
	   {
		   echo $e->getMessage();
	   }
	}

	require 'views/actualitzaHistoric.view.php';

?>
