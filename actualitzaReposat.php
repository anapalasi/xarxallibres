<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Llibres a reposar per l'alumnat </title>
</head>
<body class="bg-image">
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
    <h1 align="center" class="texto">Actualitzar llibres reposats <?php echo $qui; ?> </h1>
    <br>

<?php session_start();

        require 'admin/config.php';
        require 'functions.php';

        // comprobar session
        if (!isset($_SESSION['usuario'])) {
                header('Location: login.php');
        }

        $conexion = conexion($bd_config);

        if(!empty($_POST['reposat'])){
                // Ponemos 3 a los libros que han sido repuestos.
                foreach($_POST['reposat'] as $selected){
                        // Fiquem el numero de punts a 3
                        $sentencia="update Ejemplar set puntos=3 where id_ejemplar=\"". $selected ."\"";
                        executaSentencia($conexion,$sentencia);
                        // Esborrem totes les observacions
                        $sentencia = "DELETE FROM ObservacionEjemplar WHERE id_ejemplar=\"". $selected . "\"";
                        executaSentenciaTotsResultats($conexion, $sentencia);
                        echo $selected . " ha sigut reposat <br>";
                }
                
        }
        else{
                echo "No es passen valors";
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
<center>
<img src="img/casa.png" width="5%"></a></center>
  <br>

  <a href="close.php">Cerrar Sesion</a>
</body>
</html>
