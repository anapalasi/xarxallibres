<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}

	$conexion = conexion($bd_config);
	
	$identificador=strtoupper($_POST['lot']);

	if (isset($_POST['nivell'])== 1)
	{
		// Assignació per a tot el nivell
		// Obtenir el nombre d'alumnat d'una determinada opció
		$tipus=	$_POST["tipus"];
		if (strcmp(substr($tipus,0,4),"1bat")==0){
			$subtipus=substr($tipus,-2,2);
			$curso=calculaCurso();
			if (strcmp($subtipus,"ac") == 0)
			{
				$sentencia="select * from Alumno where id_tutoria like '". $curso. "_1BA%' and opcion=\"AC\"";
				$alumnes=executaSentenciaTotsResultats($conexion,$sentencia);
				$contador=count($alumnes);
			}
			else {
			
				$sentencia="select * from Alumno where id_tutoria like '". $curso. "_1BA%' and opcion is NULL";
				$alumnes=executaSentenciaTotsResultats($conexion,$sentencia);
				$contador=count($alumnes);
			} 

		}
/*		else
	echo "No es Batxillerat";*/
	}
	else {
		// Creació d'un sol lot
		$contador=1;
	}	
	// Crear el lote

	$i=1;
	$raiz=substr($identificador,0,7);

	$fecha=date('Y-m-d');

	if ($contador != 1){
		echo "Creacion en masa ". $identificador. "<br>";
		$num=1;
		foreach ($alumnes as $alumne){
			// Calculamos el identificador
			$identificador = $raiz.$num;
			$lote=$identificador;

			// Creamos el lote

			$sentencia="insert into Lote (id_lote, puntos, repartit, folres, valoracioglobal, retirat) VALUES (\"";
			$sentencia = $sentencia . $identificador;
			$sentencia = $sentencia . "\", 0,0,1,\"\",0)";
			executaSentencia($conexion,$sentencia);
//				echo $sentencia. "<br>";
			// Creamos los libros asociados a un lote
			
			$i=0;
			foreach ($_POST['identificador'] as $identificador){
				$pos=strripos($identificador,"_");
				$raiz_libro=substr($identificador,0,$pos+1);
			      	$ejemplar_libro = $raiz_libro. $num; 
				//echo $ejemplar_libro.	 "<br>";
						
				$sentencia ="insert into Ejemplar  (id_ejemplar, puntos, fecha_mod, isbn_libro,volumen_libro,id_lote) values (\"";
				$sentencia= $sentencia. $ejemplar_libro. "\", ";
				$sentencia = $sentencia."\"3\"".",\"". $fecha . "\",\"" . $_POST['isbn'][$i]."\",\"". $_POST['volumen'][$i]. "\",\"". strtoupper($lote). "\")";
//				echo $sentencia. "<br>";	
				executaSentencia($conexion, $sentencia);
				$i++;
			}
			$num++; 	//Actualizamos el número
			// Asignamos el lote al alumno
			$nia=$alumne['nia'];
			$sentencia = "update Alumno set id_lote=\"". $lote . "\" where nia=\"". $nia."\"";
			//echo $sentencia. "<br>";
			executaSentencia($conexion,$sentencia);
			$i++;
			echo "Lote ". $lote. "creado satisfactoriamente <br>";
		}
	}
	else {

		$sentencia="insert into Lote (id_lote, puntos, repartit, folres, valoracioglobal, retirat) VALUES (\"";
		$sentencia = $sentencia . $identificador;
		$sentencia = $sentencia . "\", 0,0,1,\"\",0)";
		executaSentencia($conexion, $sentencia);

	
		$i=0;
		foreach ($_POST['identificador'] as $identificador)
		{
			echo $estat[$i]. "<br>";
			$sentencia ="insert into Ejemplar  (id_ejemplar, puntos, fecha_mod, isbn_libro,volumen_libro,id_lote) values (\"";
			$sentencia= $sentencia. $identificador. "\", ";
			$estat = $_POST['estat'][$i];
			$sentencia = $sentencia.$estat.",\"". $fecha . "\",\"" . $_POST['isbn'][$i]."\",\"". $_POST['volumen'][$i]. "\",\"". strtoupper($_POST['lot']). "\")";
			executaSentencia($conexion, $sentencia);
			$i++;
			//echo $sentencia;
		}
	


		echo "Lot " . strtoupper($_POST["lot"]).  " ha sigut donat d'alta <br>";
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
