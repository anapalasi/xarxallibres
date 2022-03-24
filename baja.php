<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	$nia = $_POST['nia'];	


	// Obtenemos el numero de lote asignado
	$sentencia = "select * from Alumno where nia=\"" . $nia. "\"";
	$resultado = executaSentencia($conexion, $sentencia);
	$id_lote = $resultado['id_lote'];

	// Actualizamos que el numero de lote sea NULL
	$sentencia = "update Alumno set id_lote=NULL where nia=\"". $nia. "\"";
	executaSentencia($conexion,$sentencia);

	// Obtenemos el curso actual
        $hoy=getdate();
        $anyo=$hoy["year"];
        $anyo_dos=substr($anyo,-2); // Obtenemos los dos últimos numeros del anyo
        $mes=$hoy["mon"];
        if ($mes<9)
             $anyo_dos--;

	$sentencia = "delete from AlumnoGrupo where nia=\"". $nia . "\" and id_grupo like '".$anyo_dos. "%'";
	executaSentencia($conexion,$sentencia);	
	// Borramos todos los grupos de alumnos a los que pertenecia.
	
	// Poner que el lote está repartido
	$sentencia = "update Lote set repartit=\"0\" where id_lote=\"". $id_lote . "\"";
	executaSentencia($conexion,$sentencia);

	echo utf8_encode($resultado["nombre"]). " ". utf8_encode($resultado["apellido1"]). " " . utf8_encode($resultado["apellido2"]). " ha sigut donat/da de baixa <br>";

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
	echo "<img src=\"img/casa.png\" width=\"5%\"></a></center> <br>";
  	echo "<a href=\"close.php\">Cerrar Sesion</a>";
	echo "</body>";
	echo "</html>";
?>
