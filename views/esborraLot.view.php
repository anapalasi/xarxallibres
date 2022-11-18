<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Esborrar lot </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Esborrar un lot  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
<h2 class="texto"> Introdueix les dades del lot </h2>
<form action="esborrantLot.php" method="post">

<p> Identificador del lot </p>
<p><input type="text" name="id_lote"> </p>
<br>
 <p align="center"> <button type="reset" value="reset"> Valors inicials </button> 
 <button type="submit" value="submit"> Esborra lot </button> </p> 

</form>
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

