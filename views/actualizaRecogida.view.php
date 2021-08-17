<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Actualitza puntuacio </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Actualitza puntacio  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  Dades guardades correctament. 
  <br>
   S'han actualitzat <?php echo $i; ?> registres
  <br>
  <br>
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
