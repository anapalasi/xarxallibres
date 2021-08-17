<?php 
	require('fpdf.php');

	class PDF extends FPDF{
		function Footer()
		{
			// A 1,5 cm del final
			$this->SetY(-15);
			$this->SetFont('Arial','I',10);
			$this->Cell(0,10,utf8_decode('Pàgina '). $this->PageNo().' de {nb}',0,0,'C');
		}
	}