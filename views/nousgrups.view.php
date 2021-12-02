<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Actualització nous grups </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Actualització nous grups  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
<h2 class="texto"> Procediment per actualitzar els nous grups </h2>
<br>
<ol style="background-color:#fbf1d5"> 
<li> Importar de ITACA contenido_matricula y horarios_grupo
<li> Pasar de xml a csv
<li> De contenido_matricula eliminar:
	<ul>
        <li> Enseñanza
        <li> Idioma
        <li> ACIs
        <li> tipo_basico
        <li> tipo_predom
        <li> curso_pendiente
	</ul>
<li>    De horarios_grupos eliminar:
	<ul>
	<li> Plantilla
        <li> Hora_desde y Hora_hasta
        <li> Enseñanza
        <li> Curso
        <li> Aula
        <li> Idioma
	</ul>
<li>    Ordenar por docente, dia_semana, sesion_orden

<li>  Crear una columna llamada Texto con concatenación de grupo y contenido

<li>      Crear una columna llamada Repetido que compare la celda de Texto de la fila actual con la anterior. Si coinciden pondrá verdadero y si no, falso

<li>      Datos- Filtro automático y seleccionar que Repetido sea verdadero

<li>      Se eliminan las columnas repetidos. Se seleccionan las filas con Repetido = Verdadero y con el menú Hoja- Eliminar filas

<li>      Eliminar columnas Repetido y Texto

<li>      Eliminar filas de las enseñanzas de Bachillerato y Ciclos

<li>      Hacer un filtro automático donde se seleccionen las asignaturas que no tienen libros y eliminar esas filas como en el paso anterior.

<li>      Crear una tabla dinámica con Campos fila: docente, dia_semana, sesion_orden y Campos datos Recuento grupos

<li>      Crear un formato condicional para que resalte cuando el recuento sea mayor que  1 que significará que el docente más de un grupo en una sesión.

<li>    Buscar las asignaturas que tienen más de un grupo y apuntarlas.

<li>    Ordenar los datos por docente, grupo, dia_semana de modo ascendente.

<li>    Crear una columna llamada id_grupo que concatene el número de año (21), grupo y el contenido. =CONCAT("21";D2;C2) Ejemplo:21LCLLOMCE3ESOE

<li>    Eliminamos los repetidos creando una columna que compare los campos del anterior punto =F2=F1. Filtramos los que son verdaderos y elimimanos las filas

<li>    Eliminar la columna anterior.
 
</ol><br> 
<form action="actualitzaGrups.php" method="post" enctype="multipart/form-data">
Curs acadèmic (has de ficar els dos últims números del primer any YY)
<br> 
<input type="number" name="curs" min="21" max="99">
<br><br>
<input type="file" id="grups" name="grups" accept=".csv">
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

