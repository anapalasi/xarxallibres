<?php session_start();

	require 'admin/config.php';
	require 'functions.php';
	require 'fpdf/pdf.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	$sentencia= "select id_tutoria, descripcion, id_aula from Tutoria where id_tutoria=\"". $_POST['tutoria']. "\"";
	$tutoria=executaSentencia($conexion,$sentencia);

    $sentencia="select A.nombre, A.apellido1, A.apellido2, A.id_lote, A.id_lote from Alumno A where A.id_tutoria=\"". $_POST['tutoria']."\" and A.banc_llibres=\"1\" ";
	/*$sentencia="select A.nombre, A.apellido1, A.apellido2, A.id_lote, T.id_aula, L.retirat from Alumno A, Historico H, Tutoria T, Lote L where A.id_tutoria=\"". $_POST['tutoria']."\" and A.id_lote = H.id_lote and H.curso=\"2020\" and H.id_tutoria=T.id_tutoria and L.id_lote=A.id_lote order by A.apellido1, A.apellido2, A.nombre";*/
	$alumnos = executaSentenciaTotsResultats($conexion, $sentencia);

   /* if(count($alumnos) == 0){
        $sentencia="select A.nombre, A.apellido1, A.apellido2, A.id_lote, \"Nou\" as id_aula, L.retirat from Alumno A, Lote L where A.id_tutoria=\"". $_POST['tutoria']."\" and A.id_lote = L.id_lote order by A.apellido1, A.apellido2, A.nombre";
        $alumnos = executaSentenciaTotsResultats($conexion, $sentencia);
    }*/
	
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,$tutoria['descripcion'],0,0,"C"); //descripcion
    $pdf->Ln();
    $pdf-> SetFont('Arial','B',12);
    $pdf->Cell(0,10,"Aula: " . $tutoria['id_aula'],0,0,"C");
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $cabecera=array('Alumne/a','Lot','Ubicació del lot');
   	$anchura=array(100,45,45);
	$i=0;
	foreach($cabecera as $col){
	    $pdf->Cell($anchura[$i],7,utf8_decode($col),1,0,"C"); 
	    $i++;
	}
	$pdf->Ln();
    $pdf->SetFont('Arial','',10);
    $negreta=0;

    foreach ($alumnos as $alumno){
    
    	$altura=10;
    	// Mostramos el nombre
    	$nombre = utf8_decode($alumno['nombre']). " ". utf8_decode($alumno["apellido1"]). " ". utf8_decode($alumno["apellido2"]);
    	$pdf->Cell($anchura[0],$altura,$nombre,1,0);

        $sentencia = "select count(*) as numero from Ejemplar where id_lote=\"". $alumno['id_lote']. "\" and id_ejemplar like '%_HIS_CAS_%' ";
        $num=executaSentencia($conexion, $sentencia);

        if ($num['numero'] !=0){
            $pdf->SetFont('Arial','B',10);
            $negreta=1;

        }
    	$pdf->Cell($anchura[1],$altura, $alumno['id_lote'],1,0,'C');

        $pdf->SetFont('Arial','',10);

        $sentencia="select L.retirat, T.id_aula from Lote L, Historico H, Tutoria T where L.id_lote=\"". $alumno['id_lote']. "\" and L.id_lote = H.id_lote and H.id_tutoria = T.id_tutoria";
        $lote=executaSentencia($conexion,$sentencia);

        if (count($lote) == 1 and strcmp($alumno['id_lote'],"")){
            $ubicacio="Nou";
        }
        else{
            if ($lote['retirat'])
                 $ubicacio="Magatzem";
            else
              $ubicacio=$lote['id_aula'];
        }
    	
    	$pdf->Cell($anchura[2],$altura,$ubicacio,1,0,'C');
    	$pdf->Ln();

    }
    $pdf->SetFont('Arial','B',8);
    // Trobar el curs en el que estan matriculats
    $curs=substr($_POST['tutoria'], 3,1);

    $alumnesSenseLot=array();
    $sentencia="select distinct nombre, apellido1, apellido2 from Alumno where banc_llibres=1 and  id_tutoria=\"". $_POST['tutoria']. "\" and nia not in (select nia from Alumno where id_tutoria=\"". $_POST['tutoria']. "\" and id_lote like '". $curs. "ESO%')";
    $alumnesSenseLot=executaSentenciaTotsResultats($conexion,$sentencia);

  

 
    //$pdf->Cell(0,10,$sentencia);

   

    
    if (count($alumnesSenseLot) != 0){

    	$pdf->SetFont('Arial','B',10);
    	$pdf->Cell(0,10,"Alumnes sense lot",0,0,"C");
    	$pdf->Ln();
    	$pdf->SetFont('Arial','',10);

    	foreach ($alumnesSenseLot as $alumne){
    		$nombre = utf8_decode($alumne['nombre']). " ". utf8_decode($alumne["apellido1"]). " ". utf8_decode($alumne["apellido2"]);
    		$pdf->Cell(0,$altura,$nombre);
    		$pdf->Ln();
    	}


    }
    if ($negreta ==1){
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,10,utf8_decode("Els lots en negreta contenen els llibres d'Història en Castellà")); 
    }
   

    $pdf->Output();

  
?>
