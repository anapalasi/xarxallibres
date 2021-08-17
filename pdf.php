<?php
require('fpdf/pdf.php');

$pdf=new PDF("L");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
// Imprimimos el título
$pdf->Cell(0,10,utf8_decode($_POST["titulo"]),0,0,"C");
$pdf->Ln();
$pdf->Ln();

// Obtenemos la cabecera de la tabla
 $array = $_POST['cabecera'];
 $cabecera=explode(",", $array);

 // Imprimimos la cabecera
 $pdf->SetFont('Arial','B',10);
 $array = $_POST['anchura'];
 $anchura=explode(",", $array);
 $i=0;
 foreach($cabecera as $col){

    $pdf->Cell($anchura[$i],7,utf8_decode($col),1,0,"C");
    $i++;
  }
  $pdf->Ln();
  $matriz=$_POST["valores"];
  $filas=explode(";", $matriz);
  foreach ($filas as $valor){
  	// Obtenemos los valores separándolos por comas
  	$valores=explode(",", $valor);
  	$i=0;
  	foreach ($valores as $dato){
  		$pdf->Cell($anchura[$i],10,utf8_decode($dato),1,0,"C");
    	$i++;
    }
    $pdf->Ln();
  }

$pdf->Output("I");
?>
