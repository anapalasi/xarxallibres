<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	

	// Obtenemos el curso actual
        $hoy=getdate();
        $anyo=$hoy["year"];
        $anyo_dos=substr($anyo,-2); // Obtenemos los dos últimos numeros del anyo
        $mes=$hoy["mon"];
        if ($mes<9)
             $anyo_dos--;

	$sentencia="select * from GrupoProfesor where dni=\"". $_POST['baixa']. "\" and id_grupo like '". $anyo_dos ."%'";
	$grupos=executaSentenciaTotsResultats($conexion,$sentencia);

	foreach ($grupos as $grupo){
		$sentencia="insert into GrupoProfesor (id_grupo,dni) values ('". $grupo['id_grupo']."','".$_POST['substitut']."')";
		executaSentencia($conexion,$sentencia);
		echo "S'ha matriculat el professor al grup ". $grupo['id_grupo']."<br>";
	}	


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
