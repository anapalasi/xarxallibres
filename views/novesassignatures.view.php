<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Actualització noves assignatures </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Actualització noves assignatures  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
<h2 class="texto"> Procediment per actualitzar noves   </h2>
<br>
<ol>
<li> Obtenir els continguts d'ITACA i passar-los a csv
<li> Eliminarles  columnes Enseñanza y nombre en castellano
<li> Substituir en curso:
	<ul>
		<li> 2712304870 por 1ESO
		<li> 2712304883 por 2ESO
		<li> 2712304855 por 3ESO
		<li> 2712304926 por 3PMAR
		<li> 2712304896 por 4ESO
		<li> 2712304946 por PR4
		<li>  Eliminar el resto de filas
	</ul>
<li> Crear una columna amb el codi del departament anomenada codi_dept. Eliminar les tutories i assignatures del Fons Social Europeu
<li>Crear la columna de codi amb la concatenació de la columna curs i codi *=CONCAT(A2;"_";B2)*
<li>Apegar el text en la columna de codi i eliminar la columna creada en el punt anterior
</ol>
<br> 
<form action="actualitzaAssignatures.php" method="post" enctype="multipart/form-data">
<input type="file" id=assignatures"" name="assignatures" accept=".csv">
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

