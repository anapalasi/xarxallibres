<?php session_start();

	
	require 'admin/config.php';
	require 'functions.php';
	require 'fpdf/pdf.php';

    // comprobar session
   if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
    }

	$conexion = conexion($bd_config);


	$curso=calculaCurso();
	$sentencia="select id_tutoria, descripcion from Tutoria where id_tutoria like '".$curso."_1ESO%'";
	$grupos =executaSentenciaTotsResultats ($conexion,$sentencia);

	$cabecera=array('Alumne','Lot','Repartit');
	$anchura=array(120,30,20);
	


	$pdf = new PDF();
	$pdf->AliasNbPages();
	foreach ($grupos as $grupo){
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Lots de llibres de '. utf8_encode($grupo["descripcion"]),0,0,"C");
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
		
	$sentenciaDatos="SELECT DISTINCT concat( A.nombre, \" \", A.apellido1, \" \", A.apellido2 ) AS Nombre_alumno, A.id_lote, L.repartit FROM Alumno A, Lote L WHERE A.id_tutoria='".$grupo['id_tutoria']. "' AND A.id_lote = L.id_lote ORDER BY A.id_tutoria, A.apellido1, A.apellido2, A.nombre";
		$filas=executaSentenciaTotsResultats($conexion,$sentenciaDatos);
		foreach ($filas as $valor){
	  	// Obtenemos los valores separándolos por comas
			$i=0;
	  		foreach ($valor as $dato){
	  			if (strcmp($dato,"0") == 0){
	  				$dato="NO";
	  			}
	  			else{
	  				if (strcmp($dato,"1") == 0)
	  					$dato="SÍ";
	  			}
	  			$pdf->Cell($anchura[$i],10,utf8_decode($dato),1,0,"C");
	    		$i++;
	   		 }
	    	$pdf->Ln();
	  	}
	  	$pdf->Ln();
  		$pdf->Ln();
  		//$fecha=date('d/m/y');
  		//$frase = "Informe generat el " . $fecha;
		//$pdf->Cell(0,10,utf8_encode($frase),0,0,"R");
	}
	

	$pdf->Output();
?>
