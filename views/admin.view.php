<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title>Bienvenido Administrador</title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto">Hola <?php echo utf8_encode($user['nombre']) ." ". utf8_encode($user['apellido1']) ; ?></h1>
<h2 class="texto"> Operacions que es poden realitzar </h2>
<br><br>
<h3 class="texto"> Gestió de recollida de llibres </h3>
<br><br>
    <a href="valorar.php"> Valorar llibres</a> <br>
   	  <?php
			if ($tutor != ""){ 
				echo "<br><a href=\"valoraGrupTutor.php\"> Valorar llibres no valorats de la tutoria </a><br>";
				echo "<br><a href=\"tutor.php\">" .  $tutor. "</a><br><br>";
		}
        ?>     
<br><h3 class="texto"> Gestió llibres a reposar </h3>
  <br> <a href="reposarAlumnat.php"> Llistat de llibres a reposar per l'alumnat </a>
  <br> <a href="reposarCentre.php"> Llistat de llibres a reposar pel centre </a> 
  <br> <a href="lotsSenseTornar.php"> Llistat de lots sense tornar </a>
  <br> <a href="observacionsLot.php"> Llistat d'observacions del lot</a></br>
  <br> <a href="senseFolres.php"> Llistat de lots tornats sense folres </a></br>
<br> <h3 class="texto"> Gestió alta/baixa alumnat </h3>
<br> <a href="repetidors.php"> Alumnes repetidors </a>
<br> <a href="altaAlumno.php"> Donar d'alta a un alumne </a><br>
<br> <h3 class="texto"> Gestió assignació de llibres </h3>
<br> <a href="nousGrups.php"> Assignació de grups del següent curs</a>
<br><a href="simulacioAssignacio.php"> Simulació assignació llibres per cursos </a>
<br><a href="distribucioLots.php"> Distribucions lots per tutories </a>
<br><a href="nousLots.php"> Crear un nou lot </a>
<br><br><h3 class="texto"> Altres operacions </h3>
        <br> <a href="demanaLot.php"> Actualitzar informacio d'un lot </a>
        <br> <a href="puntuacionsLots.php"> Consultar puntuacions lots </a>
        <br><a href="dadesLotAlumne.php"> Consultar alumnes i dades de lots assignats </a>

	

  <br><br><a href="close.php">Cerrar Sesion</a>
</body>
</html>

