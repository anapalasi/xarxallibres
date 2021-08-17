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
  <h1 align="center" class="texto"> Assignació nous grups per al curs 2021/2022  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto" align="center"> Cursos
  </h2>
  <br>
  <form action="grupsSeguentCurs.php" method="post">
	  <table border="1" align="center" bgcolor="white">
	<tr align="center">
		<td> Nivell </td>
		<td> 
			<select name="tutoria">
				<option value="1ESO"> 1r d'ESO </option>
				<option value="2ESO"> 2n d'ESO </option>
				<option value="3ESO"> 3r d'ESO </option>
				<option value="4ESO"> 4t d'ESO </option>
				<option value="nous"> Nous alumnes </option>




	
		</select>
		</td>
	</tr>

	</table>
<br><br>	
 <p align="center"> <button type="submit" value="submit"> Consultar alumnat </button></p> 
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
