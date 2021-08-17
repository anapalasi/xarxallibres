<?php session_start();

	require 'admin/config.php';
	require 'functions.php';
	require 'fpdf/pdf.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	$tutorias= tutoriasConLibros($conexion);


	

	
    $pdf = new PDF();
    $pdf->AliasNbPages();

    foreach ($tutorias as $tutoria) {

    	$id_tutoria=$tutoria["id_tutoria"];
    	$alumnes = puntuacioLotsTutoria($conexion,$id_tutoria);

    	foreach ($alumnes as $alumne){
    		$pdf->AddPage();
        	$pdf->SetFont('Arial','B',16);
        	$pdf->Cell(0,10,$alumne["nombre"],0,0,"C");
        	$pdf->Ln();
       		$pdf->Ln();
        	$pdf->SetFont('Arial','B',12);
        	$pdf->Cell(0,10,"Tutoria: " .$tutoria["descripcion"]. "   Lot: ". $alumne["id_lote"] . "   Punts: ". $alumne["puntos"]);
        	$pdf->Ln();
        	if ($alumne["repetidor"] == 1)
        		$repetidor="S";
        	else
        		$repetidor="N";
        	$pdf->Cell(0,10,"Repetidor/a curs 21/22: " . $repetidor);
        	$pdf->SetFont('Arial','B',10);
        	if ($alumne["repartit"] == 1)
        		$repartit="S";
        	else
        		$repartit="N";

        	if ($alumne["folres"] == 1)
        		$folres="S";
        	else
        		$folres="N";
        	$pdf->Ln();
        	$pdf->Cell(0,10,"Repartit:" . $repartit. " Folres:" . $folres);
        	$pdf->Ln();
        	$pdf->Cell(0,10,"Comentari: " . $alumne["valoracioglobal"]);
        	$pdf->Ln();
           	$pdf->SetFont('Arial','B',12);
        	$pdf->Cell(0,10,"Dades dels llibres");
        	$pdf->Ln();
        	$pdf->SetFont('Arial','',10);
        	$cabecera=array('Id_Ejemplar','Titol','Estat','Volum','Observacions');
   		$anchura=array(40,65,15,15,55);
   		 // Imprimimos la cabecera
   		$i=0;
	        foreach($cabecera as $col){
	                $pdf->Cell($anchura[$i],7,utf8_decode($col),1,0,"C"); 
	                $i++;
	        }
		$pdf->Ln();
		// Obtenim els llibres de cadascun dels lots
		$llibres=mostraLlibresLot($conexion,$alumne["id_lote"]);

		// Arrays per saber els llibres a reposar per l'alumnat i pel centre
		$reposarAlumnat=array();
		$reposarCentre=array();

		foreach ($llibres as $llibre)
		{
			$i=0;


			
			$observacions=observacionsExemplar($conexion, $llibre["id_ejemplar"]);
			$altura=7;
			if (count($observacions)>=2){
				$altura=count($observacions)*$altura;
			}

			foreach ($llibre as $dato){
				$pdf->Cell($anchura[$i],$altura,$dato,1,0,"C");
				$i++;
			}

			// Si l'exemplar te observacions busquem la seua descripcio
			if (count($observacions) !=0){
				$text="";
				foreach ($observacions as $observacio){
					$descripcio=descripcioObservacio($conexion,$observacio["id_observacion"]);
					$text = $text . $descripcio. "\n";
					if (strcmp($observacio["id_observacion"],"8")==0){
						array_push($reposarCentre,$llibre["id_ejemplar"]);
					}
					else{

						if (strcmp($observacio["id_observacion"],"9")==0){
							array_push($reposarAlumnat,$llibre["id_ejemplar"]);
						}
					}
				}
				$text=substr($text,0,-1);
				$pdf->MultiCell($anchura[$i],7,$text,1,"C",false);
			}	
			else {
				$pdf->Cell($anchura[$i],7,"",1,0,"C");
				$pdf->Ln();
			}
		}

		if (count($reposarCentre) !=0){
			$pdf->Ln();
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,"Llibres a reposar pel Centre");
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);

			foreach ($reposarCentre as $reposar){
				$pdf->Cell(0,10,$reposar);
				$pdf->Ln();
			}
		}	
         	if (count($reposarAlumnat) !=0){
                        $pdf->Ln();
                        $pdf->SetFont('Arial','B',12);
                        $pdf->Cell(0,10,"Llibres a reposar per l'alumnat");
                        $pdf->Ln();
                        $pdf->SetFont('Arial','',10);

                        foreach ($reposarAlumnat as $reposar){
                                $pdf->Cell(0,10,$reposar);
                                $pdf->Ln();
                        }
                }


    	}
        
    }
        $pdf->Ln();
        $fecha=date('d/m/y');
        $frase = "Informe generat el " . $fecha;
        $pdf->Cell(0,10,utf8_encode($frase),0,0,"R");

        

        $pdf->Output();

  
?>
