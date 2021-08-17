<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	// Obtenemos los alumnos del nivel elegido

	if (strcmp($_POST['tutoria'],"nous") !=0){
		$tutoria=$_POST['tutoria'];
		$sentencia = "select * from Alumno where id_tutoria like '20_" . $tutoria . "%' order by apellido1, apellido2, nombre";
	}
	else{
		$sentencia = "select * from Alumno where id_tutoria=\"NULL\" order by apellido1, apellido2, nombre";
	}

	$alumnos = executaSentenciaTotsResultats($conexion, $sentencia);

	$sentencia = "select id_tutoria from Tutoria where id_tutoria like '21_%ESO%' order by id_tutoria";
	$nuevasTutorias = executaSentenciaTotsResultats($conexion, $sentencia);


	echo "<!DOCTYPE html>";
	echo "<html lang=\"en\">";
	echo "<head>";
 	echo "<meta charset=\"utf-8\">";
  	echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
  	echo "<meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">";
 	echo "<link rel=\"stylesheet\" href=\"css/font-awesome.min.css\">";
    echo "<link rel=\"stylesheet\" href=\"css/style.css\">";
    echo "<title>Nous grups curs 21/22 </title> ";
    echo "<head>";
	echo "<body class=\"bg-image\">";
	echo "<p align=\"center\"> <img src=\"img/xarxa_llibres-300x150.png\" alt=\"Logo Xarxa Llibres\"></p><br>";
	echo "<center><h1 class=\"texto\"> Alumnes de ";
	echo $tutoria;
	echo " en el curs 20/21 </h1></center>";
	echo "<br><br>";
	echo " <form action=\"assignacioNousGrups.php\" method=\"post\" width=\"100%\">";
	echo " <table border=\"1\" align=\"center\" bgcolor=\"white\" width=\"100%\">";
	echo "<tr><th> Nom </th> <th> Cognoms </th><th> Tutoria actual </th><th> Nova tutoria </th></tr>";

 
	foreach ($alumnos as $alumno){
		
		$nia = $alumno["nia"];
		echo  "<tr align=\"center\"><td>";

		echo "<input type=\"hidden\" name=\"nia[]\" value=\"";
		echo $nia;
		echo "\">";
	      echo  utf8_encode($alumno["nombre"]) . "</td> <td>" . utf8_encode($alumno["apellido1"]);
                echo  " " . utf8_encode($alumno["apellido2"]) ."</td><td>";
                echo  $alumno["id_tutoria"] . "</td><td>";
                echo "<select name=\"nuevaTutoria[]\">";
				echo "<option value=\"no\"> No assignada </option> ";
				foreach ($nuevasTutorias as $nuevaTutoria){
					$tut_actual=$nuevaTutoria['id_tutoria'];
					echo "<option value=\"";
					echo $tut_actual;
					echo "\">";
					echo $tut_actual;
					echo "</option>";
				}
				
		echo "</select>";
		echo   "</td></tr>";
	
        }

        echo "</table>";
 		echo "<br><br>";
 		echo "<p align=\"center\"> <button type=\"reset\" value=\"reset\"> Valors inicials </button>"; 
 		echo "<button type=\"submit\" value=\"submit\"> Guardar canvis </button>  </p> ";
 		echo "</form>";
 		echo "<center> <a href=\"";

  if ($usuario['rol'] == 'administrador')
  {
    echo "admin.php";
  }
  else
  {
    echo "usuario.php";
  }

echo "\">";
echo "<img src=\"img/casa.png\" width=\"5%\"></a></center>";
echo "<br>";
echo "<a href=\"close.php\">Cerrar Sesion</a>";
echo "</body>";
echo "</html>";
?>
 
 
  
  
 




 