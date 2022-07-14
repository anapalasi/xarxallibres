<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Actualització històric curs anterior </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Actualització històric  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
<h2 class="texto"> Procediment per actualitzar l'històric  </h2>
<br> Amb les dades del curs anterior es crea una taula on es guarda quin lot estava assignat a cada alumne, a quina tutoria pertanyia
<br><br>
S'han actualitzat <?php echo $nous_registres; ?> dades històriques <br> <br>
<br><br> COMPROVAR QUE LES DADES S'HAN COPIAT CORRECTAMENT <br><br>
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

