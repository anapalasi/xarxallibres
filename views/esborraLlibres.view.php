<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Esborrar llibres a retirar </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Esborrar llibres a retirar </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto"> Procediment que permet esborrar llibres </h2>
  <br> Llistat de llibres que estan vigents 
<br> <br> 
<form action="esborrantllibres.php" method="post" width="100%"> 
 
  <select name="llibre" id="llibre">
   <?php
      foreach ($resultat as $llibre) {
        $titulo=$llibre['titulo'];
          echo "<option value=\"". $titulo. "\">". $titulo . "( " .$llibre['id_asignatura']. ") </option>";
      }
  ?>
 
</select>
<br> <br> Comprova que és el llibre perquè no es pot canviar<br> <br> 
</form> 
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

