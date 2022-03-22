<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Canvi alumne de grup </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Canvi alumne de grup i/o optativa  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto" align="center"> Dades de l'alumne/a
  </h2>
<br>
  Selecciona els checkbox corresponents depenent de si l'alumne canvia de tutoria, optativa o ambdues
  <br>
  <form action="actualitzaGrupAlumne.php" method="post">
	  <table border="1" align="center" bgcolor="white">
	<tr>
		<td> NIA </td>
		<td> <input type="text" name="nia" required> </td>
	</tr>	
	<tr>
		<td> Nova tutoria </td>
		<td>
		<input type="checkbox" name="canvi"><label> Canvi de grup </label><br>
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
	<tr>
		<td> Té com optativa francés </td>
		<td> <input type="checkbox" name="frances"> <label> Francés </label>
		</td>
	</tr>

	</table>
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
