<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title> Login Xarxa Llibres </title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body class="bg-image">
	<h1 align="center" class="texto"> Login Xarxa Llibres </h1>
	<center><img src="img/xarxa_llibres-300x150.png" alt="logo xarxa llibres"> </center>
	<div class="container">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<p class="texto" align="center">Introdueix l'usuari i la contrasenya (recorda que l'usuari es NIF amb un 0 davant i la lletra en majuscula) </p>
			<br>
			<div class="input-group">
				<i class="fa fa-user-o icons aria-hidden="false"></i>
				<input type="text" name="usuario" placeholder="Usuario" class="form-control">
			</div>
			<div class="input-group">
				<i class="fa fa-lock icons" aria-hidden="false"> </i>
				<input type="password" name="password" placeholder="Contraseña" class="form-control">
			</div>
			<ul>
				<?php if(!empty($errores)): ?>
				<?php echo $errores ?>
				<?php endif; ?>
			</ul>
			<button type="submit" name="submit" class="btn btn-flat-green">Entrar</button>
		</form>
	</div>
	
</body>
</html>
