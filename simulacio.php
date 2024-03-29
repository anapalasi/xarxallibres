<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}
	
	//echo $_POST['tutoria'];

	$conexion = conexion($bd_config);

	$curs=$_POST['curs'];
	$cursAnterior= $curs-1;

	// Array per mostrar els resultats en forma de taula
	$mostrarAssignacions=array();
	$llibresSenseAssignar=array();
	$alumnesSenseAssignar=array();
	
	// Obtenemos los alumnos del nivel elegido
	$num_assignacions=0;

	if (strcmp($_POST['tutoria'],"4ESO") ==0){

		//Obtenemos las asignaciones de ciencias (tendremos que cambiar el año y el id_tutoria para actualizarlo el siguiente curso)

		// Obtenemos los que no son repetidores (mirar si estos cambian de itinerario y en ese caso poner el valor a 0)

		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AC\" and A.id_tutoria like '". $curs. "_4ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"20". $cursAnterior. "\" and A.repetidor=0 order by H.puntos desc";

		$alumnosCiencias=executaSentenciaTotsResultats($conexion,$sentencia);


		$sentencia="select A.nia, A.nombre, A.apellido1, A.apellido2,0,T.id_aula,A.repetidor,A.opcion from Alumno A, Tutoria T where not exists (select * from Historico H where A.nia = H.nia) and A.id_tutoria like '". $curs. "_4ESO%' and A.opcion=\"AC\" and banc_llibres=1 and T.id_tutoria = A.id_tutoria";
		$alumnesnous= executaSentenciaTotsResultats($conexion, $sentencia);


		foreach ($alumnesnous as $alumne)
		{
			array_push($alumnosCiencias, $alumne);
		}


		$sentencia="SELECT distinct H.id_lote, H.puntos,T.id_aula, L.retirat, L.repartit from Historico H, Tutoria T, Lote L, Alumno A where T.id_tutoria=H.id_tutoria and L.id_lote=H.id_lote and H.id_lote like '4ESOAC%' and H.curso=\"20". $cursAnterior. "\" and A.id_lote=L.id_lote and A.repetidor=0  and L.repartit=0 order by H.puntos desc, T.id_aula asc ";
		$llibresCiencies=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="select L.id_lote, sum(E.puntos) as puntos, \"Nou\", L.retirat, L.repartit from Lote L, Ejemplar E where not exists (select * from Historico H where H.id_lote=L.id_lote) and L.id_lote like '4ESOAC%' and E.id_lote=L.id_lote group by L.id_lote order by puntos desc";
		$lots_nous=executaSentenciaTotsResultats($conexion,$sentencia);

		if (count($lots_nous) !=0){
			$indiceLlibres=0;
			$indiceNous=0;

			$llibresOrdenats=array();

			while ($indiceLlibres < count($llibresCiencies) or $indiceNous < count($indiceNous))
			{
				if ($llibresCiencies[$indiceLlibres]['puntos'] >= $lots_nous[$indiceNous]['puntos']){
					array_push($llibresOrdenats, $llibresCiencies[$indiceLlibres]);
					$indiceLlibres++;
				}
				else {

					array_push($llibresOrdenats, $lots_nous[$indiceNous]);
					$indiceNous++;
				
				}
			}
			$llibresCiencies=$llibresOrdenats;
		}


		$sentencia="select L.id_lote from Lote L where not exists (select * from Historico H where H.id_lote=L.id_lote) and L.id_lote like '4ESOAC%'";
		if (count($alumnosCiencias)> count($llibresCiencies))
		{
			for ($i=count($llibresCiencies);$i<count($alumnosCiencias);$i++){
				array_push($alumnesSenseAssignar, $alumnosCiencias[$i]);
			
				
			}
		}
		elseif (count($alumnosCiencias)<count($llibresCiencies)) {
			for ($i=count($alumnosCiencias);$i<count($llibresCiencies);$i++)
				array_push($llibresSenseAssignar, $llibresCiencies[$i]);
		}
		else{
			echo "Hay el mismo número de lotes que de alumnos";
		}

		$assignacio=assignaLotsAlumnes($alumnosCiencias, $llibresCiencies);
		array_push($mostrarAssignacions, $assignacio);
		// Si hem dit que l'assigne ho fa
		if (strcmp($_POST['assignacio'],"on")==0){
			foreach ($assignacio as $lot){
				$sentencia="update Alumno set id_lote=\"". $lot['id_lote']. "\" where nia=\"". $lot['nia']."\"";
				executaSentencia($conexion,$sentencia);
			}
		}


		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AL\" and A.id_tutoria like '". $curs. "_4ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"20" . $cursAnterior. "\" and A.repetidor=0 order by H.puntos desc";

		$alumnosLetras=executaSentenciaTotsResultats($conexion,$sentencia);


		$sentencia="select A.nia, A.nombre, A.apellido1, A.apellido2,0,T.id_aula,A.repetidor,A.opcion from Alumno A, Tutoria T where not exists (select * from Historico H where A.nia = H.nia) and A.id_tutoria like '". $curs. "_4ESO%' and A.opcion=\"AL\" and banc_llibres=1 and T.id_tutoria = A.id_tutoria";
		$alumnesnous= executaSentenciaTotsResultats($conexion, $sentencia);


		foreach ($alumnesnous as $alumne)
		{
			array_push($alumnosLetras, $alumne);
		}

		$sentencia="SELECT distinct H.id_lote, H.puntos,T.id_aula, L.retirat, L.repartit from Historico H, Tutoria T, Lote L, Alumno A where T.id_tutoria=H.id_tutoria and L.id_lote=H.id_lote and H.id_lote like '4ESOAL%' and H.curso=\"20". $cursAnterior. "\" and A.id_lote=L.id_lote and A.repetidor=0  and L.repartit=0 order by H.puntos desc";
		$llibresLletres=executaSentenciaTotsResultats($conexion,$sentencia);


		$sentencia="select L.id_lote, sum(E.puntos) as puntos, \"Nou\", L.retirat, L.repartit from Lote L, Ejemplar E where not exists (select * from Historico H where H.id_lote=L.id_lote) and L.id_lote like '4ESOAL%' and E.id_lote=L.id_lote group by L.id_lote order by puntos desc";
		$lots_nous=executaSentenciaTotsResultats($conexion,$sentencia);

		
		if (count($lots_nous) !=0){
			$indiceLlibres=0;
			$indiceNous=0;

			$llibresOrdenats=array();

			while ($indiceLlibres < count($llibresLletres) or $indiceNous < count($indiceNous))
			{
				if ($llibresLletres[$indiceLlibres]['puntos'] >= $lots_nous[$indiceNous]['puntos']){
					array_push($llibresOrdenats, $llibresLletres[$indiceLlibres]);
					$indiceLlibres++;
				}
				else {

					array_push($llibresOrdenats, $lots_nous[$indiceNous]);
					$indiceNous++;
				
				}
			}
			$llibresLletres=$llibresOrdenats;
		}

		if (count($alumnosLetras)> count($llibresLletres))
		{
			for ($i=count($llibresLletres);$i<count($alumnosLetras);$i++){
				array_push($alumnesSenseAssignar, $alumnosLetras[$i]);
				
			}
		}
		elseif (count($alumnosLetras)<count($llibresLletres)) {
			for ($i=count($alumnosLetras);$i<count($llibresLletres);$i++)
				array_push($llibresSenseAssignar, $llibresLletres[$i]);
		}
		else{
			echo "Hay el mismo número de lotes que de alumnos";
		}

		$assignacio=assignaLotsAlumnes($alumnosLetras, $llibresLletres);
		array_push($mostrarAssignacions, $assignacio);

		// Si hem dit que l'assigne ho fa
		if (strcmp($_POST['assignacio'],"on")==0){
			foreach ($assignacio as $lot){
				$sentencia="update Alumno set id_lote=\"". $lot['id_lote']. "\" where nia=\"". $lot['nia']."\"";
				executaSentencia($conexion,$sentencia);
			}
		}


		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AP\" and A.id_tutoria like '". $curs. "_4ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"20". $cursAnterior. "\" and A.repetidor=0 order by H.puntos desc";

		$alumnosAplicadas=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="select A.nia, A.nombre, A.apellido1, A.apellido2,0,T.id_aula,A.repetidor,A.opcion from Alumno A, Tutoria T where not exists (select * from Historico H where A.nia = H.nia) and A.id_tutoria like '" . $curs. "_4ESO%' and A.opcion=\"AC\" and banc_llibres=1 and T.id_tutoria = A.id_tutoria";
		$alumnesnous= executaSentenciaTotsResultats($conexion, $sentencia);


		foreach ($alumnesnous as $alumne)
		{
			array_push($alumnosAplicados, $alumne);
		}

		$sentencia="SELECT distinct H.id_lote, H.puntos,T.id_aula, L.retirat, L.repartit from Historico H, Tutoria T, Lote L, Alumno A where T.id_tutoria=H.id_tutoria and L.id_lote=H.id_lote and H.id_lote like '4ESOAP%' and H.curso=\"20". $cursAnterior. "\" and A.id_lote=L.id_lote and A.repetidor=0  and L.repartit=0 order by H.puntos desc, T.id_aula asc ";
		$llibresAplicades=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="select L.id_lote, sum(E.puntos) as puntos, \"Nou\", L.retirat, L.repartit from Lote L, Ejemplar E where not exists (select * from Historico H where H.id_lote=L.id_lote) and L.id_lote like '4ESOAP%' and E.id_lote=L.id_lote group by L.id_lote order by puntos desc";
		$lots_nous=executaSentenciaTotsResultats($conexion,$sentencia);

	//	echo count($llibresAplicades). " ";
		if (count($lots_nous) !=0){
			$indiceLlibres=0;
			$indiceNous=0;

			$llibresOrdenats=array();

			while ($indiceLlibres < count($llibresAplicades) or $indiceNous < count($indiceNous))
			{
				if ($llibresAplicades[$indiceLlibres]['puntos'] >= $lots_nous[$indiceNous]['puntos']){
					array_push($llibresOrdenats, $llibresAplicades[$indiceLlibres]);
					$indiceLlibres++;
				}
				else {

					array_push($llibresOrdenats, $lots_nous[$indiceNous]);
					$indiceNous++;
				
				}
			}
			$llibresAplicades=$llibresOrdenats;
		}

		
		if (count($alumnosAplicadas)> count($llibresAplicades))
		{
			for ($i=count($llibresAplicades);$i<count($alumnosAplicadas);$i++){
				array_push($alumnesSenseAssignar, $alumnosAplicadas[$i]);
				
			}
		}
		elseif (count($alumnosAplicadas)<count($llibresAplicades)) {
			for ($i=count($alumnosAplicadas);$i<count($llibresAplicades);$i++)
				array_push($llibresSenseAssignar, $llibresAplicades[$i]);
		}
		else{
			echo "Hay el mismo número de lotes que de alumnos";
		}

		$assignacio=assignaLotsAlumnes($alumnosAplicadas, $llibresAplicades);
		array_push($mostrarAssignacions, $assignacio);

		// Si hem dit que l'assigne ho fa
		if (strcmp($_POST['assignacio'],"on")==0){
			foreach ($assignacio as $lot){
				$sentencia="update Alumno set id_lote=\"". $lot['id_lote']. "\" where nia=\"". $lot['nia']."\"";
				executaSentencia($conexion,$sentencia);
			}
			foreach ($alumnesSenseAssignar as $alumne){
				$sentencia = "update Alumno set id_lote=NULL where nia=\"". $alumne['nia']."\"";
				executaSentencia($conexion, $sentencia);
			}
				
		}
	}
	else {
		if (strcmp($_POST['tutoria'],"3ESO") ==0){

			// Alumnat de reforç
		/*	$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AP\" and A.id_tutoria like '". $curs."_3ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"20". $cursAnterior. "\" and A.repetidor=0 order by H.puntos desc";
			$alumnosAplicados=executaSentenciaTotsResultats($conexion,$sentencia);


			$sentencia="select A.nia, A.nombre, A.apellido1, A.apellido2,0,T.id_aula,A.repetidor,A.opcion from Alumno A, Tutoria T where not exists (select * from Historico H where A.nia = H.nia) and A.id_tutoria like '". $curs . "_3ESO%' and A.opcion=\"AP\" and banc_llibres=1 and T.id_tutoria = A.id_tutoria";
			$alumnesnous= executaSentenciaTotsResultats($conexion, $sentencia);

			foreach ($alumnesnous as $alumne)
			{
				array_push($alumnosAplicados, $alumne);
			}
				
			$sentencia="SELECT distinct L.id_lote, sum(E.puntos) as puntos from Ejemplar E, Lote L where L.id_lote=E.id_lote and L.id_lote like '3ESOAP%'  group by L.id_lote order by puntos desc";
			$llibresAplicats=executaSentenciaTotsResultats($conexion,$sentencia);
			$sentencia="select L.id_lote, sum(E.puntos) as puntos, \"Nou\", L.retirat, L.repartit from Lote L, Ejemplar E where not exists (select * from Historico H where H.id_lote=L.id_lote) and L.id_lote like '3ESOAP%' and E.id_lote=L.id_lote group by L.id_lote order by puntos desc";
			$lots_nous=executaSentenciaTotsResultats($conexion,$sentencia);
			if (count($lots_nous) !=0){
				$indiceLlibres=0;
				$indiceNous=0;

				$llibresOrdenats=array();

				while ($indiceLlibres < count($llibresAplicats) or $indiceNous < count($indiceNous))
				{
					if ($llibresAplicats[$indiceLlibres]['puntos'] >= $lots_nous[$indiceNous]['puntos']){
						array_push($llibresOrdenats, $llibresAplicats[$indiceLlibres]);
						$indiceLlibres++;
					}
					else {

						array_push($llibresOrdenats, $lots_nous[$indiceNous]);
						$indiceNous++;
					
					}
				}
				$llibresAplicats=$llibresOrdenats;
			}


			if (count($alumnosAplicados)> count($llibresAplicats))
			{
			for ($i=count($llibresAplicats);$i<count($alumnosAplicados);$i++){
				array_push($alumnesSenseAssignar, $alumnosAplicados[$i]);
			
				
			}
			}
			elseif (count($alumnosAplicados)<count($llibresAplicats)) {
				for ($i=count($alumnosAplicados);$i<count($llibresAplicats);$i++)
					array_push($llibresSenseAssignar, $llibresAplicats[$i]);
			}
			else{
				echo "Hay el mismo número de lotes que de alumnos";
			}
			$assignacio=assignaLotsAlumnes($alumnosAplicados, $llibresAplicats);
			array_push($mostrarAssignacions, $assignacio);

			// Si hem dit que l'assigne ho fa
			if (strcmp($_POST['assignacio'],"on")==0){
				foreach ($assignacio as $lot){
					$sentencia="update Alumno set id_lote=\"". $lot['id_lote']. "\" where nia=\"". $lot['nia']."\"";
					executaSentencia($conexion,$sentencia);
				}
				foreach ($alumnesSenseAssignar as $alumne){
					$sentencia = "update Alumno set id_lote=NULL where nia=\"". $alumne['nia']."\"";
					executaSentencia($conexion, $sentencia);
				}
				
			}
		*/
				// Alumnat acadèmic 
			$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, A.repetidor, A.opcion FROM Historico H, Alumno A where H.nia = A.nia and A.opcion is null and A.id_tutoria like '". $curs. "_3ESO%' and banc_llibres=1 and H.curso=\"20". $cursAnterior. "\" and A.repetidor=0 order by H.puntos desc";
			$alumnosAcademicos=executaSentenciaTotsResultats($conexion,$sentencia);


			$sentencia="select A.nia, A.nombre, A.apellido1, A.apellido2,0,A.repetidor,A.opcion from Alumno A where not exists (select * from Historico H where A.nia = H.nia) and A.id_tutoria like '". $curs. "_3ESO%' and A.opcion is null  and banc_llibres=1";
			$alumnesnous= executaSentenciaTotsResultats($conexion, $sentencia);




			foreach ($alumnesnous as $alumne)
			{
				array_push($alumnosAcademicos, $alumne);
			}

			$sentencia="select H.id_lote, L.repartit, L.retirat, H.puntos from Historico H, Lote L, Alumno A where L.id_lote=H.id_lote and H.id_lote like '3ESO%' and L.repartit=0 and H.curso=\"20" . $cursAnterior. "\" and A.nia= H.nia and A.repetidor=0 order by H.puntos desc";


			$llibresAcademics=executaSentenciaTotsResultats($conexion,$sentencia);
			
			$sentencia="select L.id_lote, sum(E.puntos) as puntos, \"Nou\", L.retirat, L.repartit from Lote L, Ejemplar E where L.id_lote not in (select id_lote from Historico H where curso=\"20".$cursAnterior. "\") and L.id_lote like '3ESO%' and E.id_lote=L.id_lote group by L.id_lote order by puntos desc";
			$lots_nous=executaSentenciaTotsResultats($conexion,$sentencia);

			if (count($lots_nous) !=0){
				$indiceLlibres=0;
				$indiceNous=0;

				$llibresOrdenats=array();

				while ($indiceLlibres < count($llibresAcademics) or $indiceNous < count($indiceNous))
				{
					if ($llibresAcademics[$indiceLlibres]['puntos'] >= $lots_nous[$indiceNous]['puntos']){
						array_push($llibresOrdenats, $llibresAcademics[$indiceLlibres]);
						$indiceLlibres++;
					}
					else {

						array_push($llibresOrdenats, $lots_nous[$indiceNous]);
						$indiceNous++;
					
					}
				}
				$llibresAcademics=$llibresOrdenats;
			}
			echo (count($llibresAcademics));

			
			if (count($alumnosAcademicos)> count($llibresAcademics))
			{
				for ($i=count($llibresAcademics);$i<count($alumnosAcademicos);$i++){
					array_push($alumnesSenseAssignar, $alumnosAcademicos[$i]);
						
				}
			}
			elseif (count($alumnosAcademicos)<count($llibresAcademics)) {
				for ($i=count($alumnosAcademicos);$i<count($llibresAcademics);$i++)
						array_push($llibresSenseAssignar, $llibresAcademics[$i]);
				}
			else{
					echo "Hay el mismo número de lotes que de alumnos";
			}
			$assignacio=assignaLotsAlumnes($alumnosAcademicos, $llibresAcademics);
			array_push($mostrarAssignacions, $assignacio);

			// Si hem dit que l'assigne ho fa
			if (strcmp($_POST['assignacio'],"on")==0){
				foreach ($assignacio as $lot){
					$sentencia="update Alumno set id_lote=\"". $lot['id_lote']. "\" where nia=\"". $lot['nia']."\"";
					executaSentencia($conexion,$sentencia);
				}
				foreach ($alumnesSenseAssignar as $alumne){
					$sentencia = "update Alumno set id_lote=NULL where nia=\"". $alumne['nia']."\"";
					executaSentencia($conexion, $sentencia);
				}
					
			}

	}
	else{

		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, A.repetidor, A.opcion FROM Historico H, Alumno A where H.nia = A.nia and A.opcion is null and A.id_tutoria like '". $curs. "_". $_POST['tutoria']. "%' and banc_llibres=1 and H.curso=\"20" . $cursAnterior. "\" and A.repetidor=0 order by H.puntos desc";
		$alumnos=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="select A.nia, A.nombre, A.apellido1, A.apellido2,0,A.repetidor,A.opcion from Alumno A where not exists (select * from Historico H where A.nia = H.nia) and A.id_tutoria like '". $curs. "_" . $_POST['tutoria'] ."%'  and banc_llibres=1";

		$alumnesnous= executaSentenciaTotsResultats($conexion, $sentencia);


		foreach ($alumnesnous as $alumne)
		{
			array_push($alumnos, $alumne);
		}

		$sentencia="select H.id_lote, L.repartit, L.retirat, H.puntos from Historico H, Lote L, Alumno A where L.id_lote=H.id_lote and H.id_lote like '". $_POST['tutoria']. "_%' and L.repartit=0 and H.curso=\"20".$cursAnterior. "\" and A.nia= H.nia and A.repetidor=0 order by H.puntos desc";
		$llibres=executaSentenciaTotsResultats($conexion,$sentencia);

		// Lots que no es troben a l'històric
		$sentencia="select L.id_lote, sum(E.puntos) as puntos, \"Nou\", L.retirat, L.repartit from Lote L, Ejemplar E where L.id_lote not in  (select H.id_lote from Historico H where H.curso=\"20". $cursAnterior. "\") and L.id_lote like '". $_POST['tutoria']. "_%' and E.id_lote=L.id_lote and L.repartit=0 group by L.id_lote order by puntos desc";
		
		
		$lots_nous=executaSentenciaTotsResultats($conexion,$sentencia);

		if (count($lots_nous) !=0){
				$indiceLlibres=0;
				$indiceNous=0;

				$llibresOrdenats=array();

				while ($indiceLlibres < count($llibres) or $indiceNous < count($indiceNous))
				{
					if ($llibres[$indiceLlibres]['puntos'] >= $lots_nous[$indiceNous]['puntos']){
						array_push($llibresOrdenats, $llibres[$indiceLlibres]);
						$indiceLlibres++;
					}
					else {

						array_push($llibresOrdenats, $lots_nous[$indiceNous]);
						$indiceNous++;
					
					}
				}
				$llibres=$llibresOrdenats;
			}
			//echo count($llibres);

	
			/*$sentencia="select L.id_lote, L.repartit, L.retirat, T.id_aula, sum(E.puntos) as puntos from Lote L, Tutoria T, Alumno A, Ejemplar E where A.id_lote=L.id_lote and A.id_tutoria= T.id_tutoria and E.id_lote=L.id_lote and L.repartit=0 and A.repetidor=0 and ";
			$sentencia =$sentencia . "L.id_lote like '".  $_POST['tutoria']. "%' group by L.id_lote,L.repartit, L.retirat, T.id_aula order by puntos desc";
			$llibres=executaSentenciaTotsResultats($conexion, $sentencia);
			echo $sentencia. "<br>";*/
			$assignacio=assignaLotsAlumnes($alumnos, $llibres);
		array_push($mostrarAssignacions, $assignacio);
		
		
		// Si hem dit que l'assigne ho fa
		if (strcmp($_POST['assignacio'],"on")==0){
			foreach ($assignacio as $lot){
				$sentencia="update Alumno set id_lote=\"". $lot['id_lote']. "\" where nia=\"". $lot['nia']."\"";
				executaSentencia($conexion,$sentencia);
			}
			foreach ($alumnesSenseAssignar as $alumne){
				$sentencia = "update Alumno set id_lote=NULL where nia=\"". $alumne['nia']."\"";
				executaSentencia($conexion, $sentencia);
			}
					
		}
		if (count($alumnos)> count($llibres))
		{
			for ($i=count($llibres);$i<count($alumnos);$i++){
				array_push($alumnesSenseAssignar, $alumnos[$i]);
					
			}
		}
		elseif (count($alumnos)<count($llibres)) {
			for ($i=count($alumnos);$i<count($llibres);$i++)
					array_push($llibresSenseAssignar, $llibres[$i]);
			}
		else{
				echo "Hay el mismo número de lotes que de alumnos";
		}

	}

}

	
	require 'views/simulacio.view.php';



?>
 
 
  
  
 




 

