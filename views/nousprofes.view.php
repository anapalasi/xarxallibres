<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Actualització nou professorat </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Actualització nou professorat  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
<h2 class="texto"> Introdueix el fitxer amb personal del centre </h2>
<br> El fitxer ha d'estar en format CSV, separat amb comes, separaćió de cadenes amb "" i amb codificació ISO-8859-13 <br> 
<form action="actualitzaProfessorat.php" method="post" enctype="multipart/form-data">
<input type="file" id="professorat" name="professorat" accept=".csv">
<br><br>
 <p align="center">  
 <button type="submit" value="submit"> Pujar fitxer </button> </p> 

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

