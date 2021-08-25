<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: login.php');
	}
	
	//echo $_POST['tutoria'];

	$conexion = conexion($bd_config);

	// Array per mostrar els resultats en forma de taula
	$mostrarAssignacions=array();
	$llibresSenseAssignar=array();
	$alumnesSenseAssignar=array();
	
	// Obtenemos los alumnos del nivel elegido

	if (strcmp($_POST['tutoria'],"4ESO") ==0){

		//Obtenemos las asignaciones de ciencias (tendremos que cambiar el año y el id_tutoria para actualizarlo el siguiente curso)

		// Obtenemos los que no son repetidores (mirar si estos cambian de itinerario y en ese caso poner el valor a 0)

		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AC\" and A.id_tutoria like '21_4ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"2020\" and A.repetidor=0 order by H.puntos desc";

		$alumnosCiencias=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="SELECT distinct H.id_lote, H.puntos,T.id_aula, L.retirat, L.repartit from Historico H, Tutoria T, Lote L, Alumno A where T.id_tutoria=H.id_tutoria and L.id_lote=H.id_lote and H.id_lote like '4ESOAC%' and H.curso=\"2020\" and A.id_lote=L.id_lote and A.repetidor=0  and L.repartit=0 order by H.puntos desc, T.id_aula asc ";
		$llibresCiencies=executaSentenciaTotsResultats($conexion,$sentencia);

		
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


		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AL\" and A.id_tutoria like '21_4ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"2020\" and A.repetidor=0 order by H.puntos desc";

		$alumnosLetras=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="SELECT distinct H.id_lote, H.puntos,T.id_aula, L.retirat, L.repartit from Historico H, Tutoria T, Lote L, Alumno A where T.id_tutoria=H.id_tutoria and L.id_lote=H.id_lote and H.id_lote like '4ESOAL%' and H.curso=\"2020\" and A.id_lote=L.id_lote and A.repetidor=0  and L.repartit=0 order by H.puntos desc";
		$llibresLletres=executaSentenciaTotsResultats($conexion,$sentencia);

		
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


		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AP\" and A.id_tutoria like '21_4ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"2020\" and A.repetidor=0 order by H.puntos desc";

		$alumnosAplicadas=executaSentenciaTotsResultats($conexion,$sentencia);

		$sentencia="SELECT distinct H.id_lote, H.puntos,T.id_aula, L.retirat, L.repartit from Historico H, Tutoria T, Lote L, Alumno A where T.id_tutoria=H.id_tutoria and L.id_lote=H.id_lote and H.id_lote like '4ESOAP%' and H.curso=\"2020\" and A.id_lote=L.id_lote and A.repetidor=0  and L.repartit=0 order by H.puntos desc, T.id_aula asc ";
		$llibresAplicades=executaSentenciaTotsResultats($conexion,$sentencia);

		
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
			$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion=\"AP\" and A.id_tutoria like '21_3ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"2020\" and A.repetidor=0 order by H.puntos desc";
			$alumnosAplicados=executaSentenciaTotsResultats($conexion,$sentencia);

			
			$sentencia="SELECT distinct L.id_lote, sum(E.puntos) as puntos from Ejemplar E, Lote L where L.id_lote=E.id_lote and L.id_lote like '3ESOAP%'  group by L.id_lote order by puntos desc";
			$llibresAplicats=executaSentenciaTotsResultats($conexion,$sentencia);

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
		// Alumnat acadèmic
		$sentencia = "SELECT A.nia, A.nombre, A.apellido1, A.apellido2, H.puntos, T.id_aula, A.repetidor, A.opcion FROM Historico H, Alumno A, Tutoria T where H.nia = A.nia and A.opcion is null and A.id_tutoria like '21_3ESO%' and banc_llibres=1 and T.id_tutoria=A.id_tutoria and H.curso=\"2020\" and A.repetidor=0 order by H.puntos desc";
		$alumnosAcademicos=executaSentenciaTotsResultats($conexion,$sentencia);


		
		$sentencia="select H.id_lote, L.repartit, L.retirat, T.id_aula, H.puntos from Historico H, Lote L, Tutoria T, Alumno A where L.id_lote=H.id_lote and H.id_lote like '3ESO_%' and H.id_lote not like '3ESOAP%' and L.repartit=0 and H.curso=\"2020\" and T.id_tutoria = H.id_tutoria and A.nia= H.nia and A.repetidor=0 order by H.puntos desc, T.id_aula asc ";


		$llibresAcademics=executaSentenciaTotsResultats($conexion,$sentencia);
		echo "Llibres academics: ". count($llibresAcademics);
		
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
	else{
		echo "2º o 1º de ESO";
	}

}

	
	require 'views/simulacio.view.php';



?>
 
 
  
  
 




 