<?php session_start();

	
	require 'admin/config.php';
	require 'functions.php';
	require 'fpdf/pdf.php';

    // comprobar session
   if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
    }

	$conexion = conexion($bd_config);


	$grupos = tutoriasConLibrosCurso($conexion,"21");

	$cabecera=array('Alumne','Lot','Ja té el lot','Tornar lot','Comprar folres','Valoracio lot antic','Valoracio lot nou');
	$anchura=array(70,20,25,25,25,60,60);
	
	$filas=LotsPerTornar($conexion);


	$pdf = new PDF("L");
	$pdf->AliasNbPages();
	foreach ($grupos as $grupo){
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,utf8_decode("Distribució lots de llibres de "). utf8_encode($grupo["descripcion"]),0,0,"C");
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		// Imprimimos la cabecera
		 $i=0;
	 	foreach($cabecera as $col){

	  	    $pdf->Cell($anchura[$i],7,utf8_decode($col),1,0,"C");
	    	$i++;
		  }
	 	 $pdf->Ln();
		
		$filas = alumnesXarxaTutoria($conexion,$grupo["id_tutoria"]);

		foreach ($filas as $valor){
	  	// Obtenemos los valores separándolos por comas
			$nombre= $valor['nom']. " ". $valor["ape1"]. " ". $valor["ape2"];
  			$pdf->Cell($anchura[0],10,utf8_decode($nombre),1,0,"C");

  			$pdf->Cell($anchura[1],10,utf8_decode($valor['id_lote']),1,0,"C");

  			$sentencia="select L.repartit as repartit, L.folres as folres, L.valoracioglobal as valoracio from Lote L, Historico H where L.id_lote=H.id_lote and H.curso=\"2020\" and H.nia=\"" . $valor['nia']. "\"";

  			$lotAnterior=executaSentencia($conexion, $sentencia);
  			//$pdf->Cell(0,10,$sentencia,1,0,"C");

  			// Si es repetidor comprovem si té el lot
  			if (strcmp($valor['repetidor'],"1") == 0){
  				if (strcmp($lotAnterior['repartit'],"1") == 0)
  					$pdf->Cell($anchura[2],10,"S",1,0,"C");
  				else
  					$pdf->Cell($anchura[2],10,"",1,0,"C");

  			}
  			else
  				$pdf->Cell($anchura[2],10,"",1,0,"C");

	  		/*foreach ($valor as $dato){
	  			if (strcmp($dato,"0") == 0){
	  				$dato="N";
	  			}
	  			else{
	  				if (strcmp($dato,"1") == 0)
	  					$dato="S";
	  			}
	  			$pdf->Cell($anchura[$i],10,$dato,1,0,"C");
	    		$i++;
	   		 }*/
	    	$pdf->Ln();
	  	}
	  	$pdf->Ln();
  		$pdf->Ln();
  		$fecha=date('d/m/y');
  		$frase = "Informe generat el " . $fecha;
  		$pdf->Cell(0,10,utf8_encode($frase),0,0,"R");
	}
	

	$pdf->Output();
?>
