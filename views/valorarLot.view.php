<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title>Valoracio de llibres </title>
</head>
<body class="bg-image">

<?php  
    echo   "<h1 align=\"center\" class=\"texto\"> Valoracio dels llibres de l'alumne/a ";
    echo $nombreCompleto["nombre"];
    echo "</h1>";
 
  echo "<p align=\"center\"> <img src=\"img/xarxa_llibres-300x150.png\" alt=\"Logo Xarxa Llibres\"></p><br>";
?>

  
  <h2 class="texto"> Llibres del lot 
  <?php
  if (!empty($_POST['nia'])){
    $lote=$nombreCompleto["lote"];
    echo $lote;
  }
  else {
    $lote=$_POST['id_lote'];
    echo $lote;
  }
  echo "</h2><br>";
	if (empty($llibres)){

		echo "<br><p> No hi ha llibres assignats a eixe lot </p><br><br>";
	}
	else {
    echo "<br> <strong> Puntuació del lot de llibres " . $puntuacio. " </strong><br>";
    // Mostrem els llibres del lot
    echo "<form action=\"actualizaLot.php\" method=\"post\" width=\"100%\">";
    echo "<input type=\"hidden\" name=\"lote\" value=\"". $lote ."\">";
    echo "<h3 class=\"texto\"> Dades del lot </h3><br>";
    echo "<table border=\"0\"><tr><td>";
    echo "Repartit <input type=\"checkbox\" name=\"repartit\" ";
    $repartit=$dadesLot["repartit"];
    if ($repartit == "1"){
        echo "checked ";
    }
    echo ">";
    echo "</td>";
    echo "<td>";
     echo "Folres <input type=\"checkbox\" name=\"folres\" ";
    $folres=$dadesLot["folres"];
    if ($folres == "1"){
        echo "checked ";
    }
    echo ">";
  
    echo "</td>";
     echo "<td>";
     echo "Retirat <input type=\"checkbox\" name=\"retirat\" ";
    $retirat=$dadesLot["retirat"];
    if ($retirat == "1"){
        echo "checked ";
    }
    echo ">";
  
    echo "</td>";
    echo "</tr>";
    echo "<tr><td colspan=\"2\">";
    echo "<input type=\"text\" name=\"valoracioglobal\" value=\"". $dadesLot["valoracioglobal"]. "\" size=\"60\">";
    echo "</td>";
    echo "</table>";
    echo "<br><br>";

	  echo "<h3 class=\"texto\"> Dades dels llibres </h3><br>";
		echo "<table border=\"1\" align=\"center\" bgcolor=\"white\" width=\"100%\">";
		echo " <tr><th> Identificador de l'exemplar </th> <th>Assignatura  </th><th> Volum </th><th>Estat  </th> <th> Observacions </th></tr>";
		foreach ($llibres as $llibre){
			echo "<tr>";
			echo "<td>";
      $exemplar=$llibre['id_ejemplar'];
      echo "<input type=\"hidden\" name=\"ejemplar[]\" value=\"";
        echo $exemplar;
        echo "\">";
			echo $exemplar;
			echo "</td>";
			echo "<td>";
                        echo utf8_encode($llibre['nombre']);
                        echo "</td>";
			echo "<td align=\"center\">";
                        echo $llibre['volumen'];
                        echo "</td>";
			echo "<td align=\"center\">";
      echo "<select name=\"estat[]\">";
        echo "<option value=\"3\" ";
          if ($llibre["puntos"] == "3")
            echo "selected";
        echo "> MB </option>";
        echo "<option value=\"2\" ";
                    if ($llibre["puntos"] == "2")
                            echo "selected";
                    echo "> B </option>";
        echo "<option value=\"1\" ";
                    if ($llibre["puntos"] == "1")
                            echo "selected";
                    echo "> R </option>";
        echo "<option value=\"0\"";
                    if ($llibre["puntos"] == "0")
                            echo "selected";
        echo "> M </option>";
        echo "<option value=\"-1\"";
        if ($llibre["puntos"] == "-1")
          echo "selected";
        echo "> No lliurat </option>";

     echo "</select>";
                       echo "</td>";
			echo "<td>";
			// Identificadors de les observacions
      $llista = observacionsExemplar($conexion, $exemplar);
      $llista_observacions=array();
      foreach ($llista as $elemento){
        array_push($llista_observacions, $elemento["id_observacion"]);
      }

      $totesObservacions=obteTipusObservacions($conexion);
      foreach ($totesObservacions as $observacio){
        echo "<input type=\"checkbox\" name=\"observacions";
        //  echo  $observacio["id_observacion"];
        echo "[]\" value=\"";
        echo $exemplar. "-" .$observacio["id_observacion"];
        echo "\"";
        if (estaEnArray($llista_observacions,$observacio["id_observacion"]))
            echo " checked";
        echo ">";
        echo utf8_encode($observacio["descripcion"]);
        echo "<br>";  
      }
      echo "</td>";

			echo "</tr>";
		}
		echo " </table>";
    echo "<br><br>";
   echo "<p align=\"center\"> <button type=\"reset\" value=\"reset\"> Valors inicials </button> ";
   echo "<button type=\"submit\" value=\"submit\"> Guardar canvis </button>  </p> ";
		echo "</form>";


	}	
?>
<br><br>
<a href="<?php
  if ($usuario['rol'] == 'administrador')
  {
    echo "admin.php";
  }
  else
  {
    echo "usuario.php";
  }
?>
">

<img src="img/casa.png" width="5%"></a></center>
  <br>

  <a href="close.php">Cerrar Sesion</a>
</body>
</html>

