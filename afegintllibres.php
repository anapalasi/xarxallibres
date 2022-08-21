<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

	$conexion = conexion($bd_config);

	$isbn=$_POST['llibre'];
	$id_ejemplar = $_POST['id_ejemplar'];
	$puntos=$_POST['puntos'];
	$curso=$_POST['curso'];
	$fecha=date('Y-m-d');

	$numero=0;

	// Obtenim els exemplars d'eixe llibre
	$sentencia="select id_lote from Lote where id_lote like '". $curso. "%'";
	$lotes = executaSentenciaTotsResultats($conexion,$sentencia);

	$sentencia="select count(*) as numero from Libro where isbn=\"". $isbn . "\"";
	$resultado=executaSentencia($conexion,$sentencia);
	
	$num_ejemplares= $resultado['numero'];
	
	
	foreach ($lotes as $lote) {
		$num_lote=$lote['id_lote'];
		$num=substr($num_lote, 5);

		$volumen=1;
		
		
		while ($volumen<=$num_ejemplares)
		{
			$sentencia = "insert into Ejemplar (id_ejemplar, puntos, fecha_mod, isbn_libro,volumen_libro,id_lote) values (\"" . $id_ejemplar."_".$volumen."_".$num."\",". $puntos . ",\"". $fecha ."\",\"". $isbn. "\",". $volumen .",\"". $num_lote."\")";
			//echo $sentencia . "<br>";
			executaSentencia($conexion, $sentencia);
			$volumen=$volumen+1;
		}

		$numero=$numero+1;
	}

	require 'views/afegintllibres.view.php';

?>
