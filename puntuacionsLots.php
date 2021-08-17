<?php session_start();

	
	require 'admin/config.php';
	require 'functions.php';
	require 'fpdf/pdf.php';

    // comprobar session
   if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
    }

	$conexion = conexion($bd_config);


	$grupos = tutoriasConLibros($conexion);

	$cabecera=array('Alumne','Lot','Punts','Repeteix','Repartit','Folre','ValoracioGlobal');
	$anchura=array(80,20,15,20,15,15,100);
	
	$filas=LotsPerTornar($conexion);


	$pdf = new PDF("L");
	$pdf->AliasNbPages();
	foreach ($grupos as $grupo){
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Puntuacions lots de llibres de '. utf8_encode($grupo["descripcion"]),0,0,"C");
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
		
		$filas = puntuacioLotsTutoria($conexion,$grupo["id_tutoria"]);
		foreach ($filas as $valor){
	  	// Obtenemos los valores separándolos por comas
			$i=0;
	  		foreach ($valor as $dato){
	  			if (strcmp($dato,"0") == 0){
	  				$dato="N";
	  			}
	  			else{
	  				if (strcmp($dato,"1") == 0)
	  					$dato="S";
	  			}
	  			$pdf->Cell($anchura[$i],10,$dato,1,0,"C");
	    		$i++;
	   		 }
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
