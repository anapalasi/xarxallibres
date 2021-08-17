<?php 

	// Inicializamos la sesion
	session_start();

	require 'admin/config.php';
	require 'functions.php';

	$errores='';

	// Se realiza la conexion y se accede a los datos necesarios.
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$usuario=$_POST['usuario'];
		$password=strtolower($_POST['password']);
		$password=hash('sha512', $password);

		$conexion=conexion($bd_config);
		
		$statement = $conexion->prepare('SELECT * FROM Profesor WHERE dni = :usuario and contrasenya = :password');

		$statement->execute(
			array(
				':usuario'=> $usuario,
				':password' => $password
			)
		);


		$resultado = $statement->fetch();

		if ($resultado !== false)
		{
		
			$_SESSION['usuario']=$usuario;
			//$errores = $_SESSION['usuario'];
			header('Location: index.php');
			
		}
		else
		{
			$errores='<li class="error"> Tu usuario y/o contraseña son incorrectos</li>';
		}	
	}
	require 'views/login.view.php';
?>

