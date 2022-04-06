<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Gestió substitucions professorat </title>
</head>
<body class="bg-image">
  <h1 align="center" class="texto"> Gestió de substitucions de professorat  </h1>
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
  </h2>
  <br>
  <form action="substituir.php" method="post">
	  <table border="1" align="center" bgcolor="white" cellspacing="10">
	<tr>
		<td> Professor de baixa  </td>
		<td> 
		    <select name="baixa">
		    <?php
			foreach ($professors as $professor){
				echo "<option value=\"";
				echo $professor["dni"];
				echo "\">";
				echo utf8_encode($professor["nombre"]) ." ".  utf8_encode($professor["apellido1"]) . " ".utf8_encode($professor["apellido2"]);
				echo "</option>";
			}
 
		    ?>
    	            </select>
		</td>
	</tr>	
	<tr>
		<td> Professor substitut  </td>
		<td> 
			<select name="substitut">
		<?php
			foreach ($professors as $professor){
				echo "<option value=\"";
                                echo $professor["dni"];
                                echo "\">";
                                echo utf8_encode($professor["nombre"]) ." ".  utf8_encode($professor["apellido1"]) . " ".utf8_encode($professor["apellido2"]);
                                echo "</option>";


			}
		?>
		</select>
		</td>
	</tr>

	</table>
 <br><br>
 <p align="center"> <button type="reset" value="reset"> Valors inicials </button> <button type="submit" value="submit"> Guardar canvis </button></p> 
 </form>
 <center> <a href="<?php
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
