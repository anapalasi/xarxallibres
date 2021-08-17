<?php session_start();

        require 'admin/config.php';
        require 'functions.php';
        require 'fpdf/pdf.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

        $conexion = conexion($bd_config);

        $cabecera=array('Alumne','Lot','Tutoria');
        $anchura=array(80,30,30);

	
        $pdf = new PDF();
        $pdf->AliasNbPages();

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Lots de llibres sense folres ',0,0,"C");
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
      
        $files= senseFolres($conexion);
        foreach ($files as $valor){
                $i=0;

                foreach ($valor as $dato){
                       // Obtenemos los valores separándolos por comas
                        $pdf->Cell($anchura[$i],10,utf8_decode($dato),1,0,"C");
                        $i++;
                }
                $pdf->Ln();
        }
        
        $pdf->Ln();
        $fecha=date('d/m/y');
        $frase = "Informe generat el " . $fecha;
        $pdf->Cell(0,10,utf8_encode($frase),0,0,"R");

        

        $pdf->Output();

?>
