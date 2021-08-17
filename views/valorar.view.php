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
  <h1 align="center" class="texto"> Valoracio de llibres </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto"> Grups en els que s'imparteix classe </h2>
  <?php
	if (empty($grupos)){

		echo "<br><p> No tens grups amb llibres </p><br><br>";
	}
	else {

		echo "<br><br><ul>";
		foreach ($grupos as $grupo){
			echo "<li> <a href=\"valoraGrup.php?grup=" . $grupo['id_grupo']. "\"> Valoraci&oacute; llibres: " . utf8_encode($grupo['descripcion']). "</a></li>";
		}
		echo "</ul>";

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

