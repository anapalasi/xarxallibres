<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title>Valoracio de llibres d'un grup </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Valoracio de llibres </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto">Llistat d'alumnes de la tutoria amb llibres per valorar </h2>
  <br>
  <form action="actualizaPuntuacion.php" method="post" width="100%">
  <table border="1" bgcolor="white" width="100%">

  <tr><th> Nom </th> <th> Cognoms </th><th> T&iacute;tol</th><th> Exemplar </th><th> Volum </th> <th> Estat </th> <th> Observacions </th></tr>
<?php
	foreach ($llibres as $llibre){
		
		$exemplar = $llibre["ejemplar"];
		echo  "<tr align=\"center\"><td>";

		echo "<input type=\"hidden\" name=\"ejemplar[]\" value=\"";
		echo $llibre["ejemplar"];
		echo "\">";
	       	echo  utf8_encode($llibre["nombre"]) . "</td> <td>" . utf8_encode($llibre["apellido1"]);
		echo  " " . utf8_encode($llibre["apellido2"]) ."</td><td>";
		echo utf8_encode($llibre["titulo"]);
		echo "</td><td>";
                echo  $llibre["ejemplar"] . "</td><td>";
		echo  $llibre["volumen"] . "</td><td>";
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
		echo "<td>";
		foreach ($observacions as $observacio){

			// Emmagatzemem les observacions en una llista
			$observacions_exemplar = $observacionsExemplars[$exemplar];
			// Comprovem si esta buida
			$buida = empty($observacions_exemplar);
			echo "<input type=\"checkbox\" name=\"observacions";
		//	echo  $observacio["id_observacion"];
			echo "[]\" value=\"";
			echo $llibre["ejemplar"]. "-" .$observacio["id_observacion"];
			echo "\"";
			if (!$buida){
				foreach ($observacions_exemplar as $obs){
					//echo "Observacio actual " . $obs . " Observacio buscada " . $observacio["id_observacion"];
					if (strcmp($obs,$observacio["id_observacion"])== 0)
						echo " checked";
				}
			}
			// Comprovaremos si esta seleccionat a la base de dades
			echo ">";
			echo utf8_encode($observacio["descripcion"]);
			echo "<br>";	
		}
		echo   "</td></tr>";
	
        }

?>
 </table>
 <br><br>
 <p align="center"> <button type="reset" value="reset"> Valors inicials </button> 
 <button type="submit" value="submit"> Guardar canvis </button>  </p> 
 </form>
 <center> <a href="<?php
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

