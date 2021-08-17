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
  <form action="crearLot.php" method="post">
		<center> <h2 class="texto"> Tipus de lot </h2>
		<select name="tipusLot">
	  <option value="1eso"> 1r ESO </option>
    <option value="2eso"> 2n ESO </option>
    <option value="3eso"> 3r ESO Acadèmic</option>
    <option value="3esoap"> 3r ESO Aplicat</option>
    <option value="4esoac"> 4t ESO Ciències</option>
    <option value="4esoal"> 4t ESO Lletres</option>
    <option value="4esoap"> 4t ESO Aplicat</option>



		</select> <br><br>
	
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
