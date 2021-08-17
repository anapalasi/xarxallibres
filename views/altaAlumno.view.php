<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title>Alta alumne </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Alta d'un alume/a  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto" align="center"> Dades de l'alumne/a
  </h2>
  <br>
  <form action="alta.php" method="post">
	  <table border="1" align="center" bgcolor="white">
	<tr>
		<td> NIA </td>
		<td> <input type="text" name="nia" required> </td>
	</tr>	
	<tr>
		<td> Nom </td>
		<td> <input type="text" name="nombre" required></td>

	</tr>

	<tr>
		<td> Primer cognom  </td>
		<td> <input type="text" name="apellido1" required></td>
	</tr>

	<tr>
		<td> Segon cognom </td>
		<td> <input type="text" name="apellido2"></td>
	</tr>
	<tr>
		<td> Banc de llibres </td>
		<td align="center"> <input type="checkbox" value="1" name="banc"></td>
	</tr>
	<tr>
		<td> Identificador lot </td>
		<td><input type="text" name="id_lote"></td>
	</tr>
	<tr>
		<td> Tutoria </td>
		<td>
		<select name="tutoria">
		<?php
			foreach ($tutorias as $tutoria){
				echo "<option value=\"";
				echo $tutoria["id_tutoria"];
				echo "\">";
				echo $tutoria["descripcion"];
				echo "</option>";

			}

?>
		</select>
		</td>
	</tr>

	</table>
	<label><input type="checkbox" name="asignado" value="otro"> El lot de llibres estava assignat a un altre alumne?</label>
 <br><br>
 <p align="center"> <button type="reset" value="reset"> Valors inicials </button> <button type="submit" value="submit"> Guardar canvis </button></p> 
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
