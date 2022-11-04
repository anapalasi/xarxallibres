<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Afig llibres en bloc </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Afig llibres en bloc </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  <h2 class="texto"> Procediment que permet afegir llibres en bloc </h2>
  <br> Llistat de llibres que estan vigents 
<br> <br> 
<form action="afegintllibres.php" method="post" width="100%"> 
 
 Llibre: <select name="llibre" id="llibre">
   <?php
      foreach ($resultat as $llibre) {
        $titulo=$llibre['titulo'];
          echo "<option value=\"". $llibre['isbn']. "\">". utf8_encode($titulo) . "( " .$llibre['id_asignatura']. ") </option>";
      }
  ?>
 
</select>
<br> <br> Comprova que és el llibre perquè no es pot canviar<br> <br>
<br>id_ejemplar (sin _) <input type="text" name="id_ejemplar">
<br> puntos <input type="text" name="puntos" value="3">
<br> curso <input type="text" name="curso">

<p align="center"><input type="submit" name="esborra"  value="Afig llibres" ><br> <br>
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

