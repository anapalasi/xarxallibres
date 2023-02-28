<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title>Creació d'un nou lot </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Creació d'un nou lot  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  
  <br>
  <form action="assignarPuntuacio.php" method="post">

	<p> Crear nous lots per a l'alumnat de tot el nivell <input type="checkbox" name="nivell">
<br><br><br>
		<center> <h2 class="texto"> Llibres del lot de <?php echo $tipus; echo " : " .$numero; ?> </h2>
      <br><br>
		<table border="1" bgcolor="white">
      <tr>
        <td> <input type="hidden" name="lot" value="<?php echo $tipus."_".$numero; ?>">
        Identificador </td><td>Llibre</td><td>Estat</td>
      </tr>
      <?php
	$i=0;
 	echo "<input type=\"hidden\" name=\"tipus\" value=\"" . $tipus . "\">";
      while ($i<count($titols)){
        echo "<tr>";
        echo "<td>";
        $id=$identificador[$i].$numero;
        echo "<input type=\"hidden\" name=identificador[] value=\"". $id. "\">";
        echo $id;
        echo "<input type=\"hidden\" name=isbn[] value=\"". $isbn[$i]. "\">";
        echo "<input type=\"hidden\" name=volumen[] value=\"". $volum[$i]. "\">";

        echo "</td>";
        echo "<td>";
        echo $titols[$i];
        echo "</td>";
        echo "<td>";
        echo "<select name=estat[]>";
        echo "<option value=\"3\" selected";
        echo "> MB </option>";
        echo "<option value=\"2\">";
        echo " B </option>";
        echo "<option value=\"1\"";
        echo "> R </option>";
        echo "</select>";
        echo "</td>";
        echo "</tr>";
        $i++;
      }
      ?>
    </table>
    <br><br>
	
  <button type="submit" value="submit"> Crear lot </button></form>
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
