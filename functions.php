<?php

function conexion($bd_config){
	try {
		// Estructura PDO0

		$conexion = new PDO('mysql:host=localhost;dbname='. $bd_config['db_name'], $bd_config['user'], $bd_config['pass']);
		return $conexion;
	}
	catch (PDOException $e){
		return false;
	}
}
// Evita inyecciones de codigo
	function limpiarDatos($datos){
		$datos=htmlspecialchars($datos); 
		$datos=trim($datos); // Evita espacios en blanco
		$datos=filter_var($datos, 'FILTER_SANITIZE_STRING'); //Se borran los caracteres especiales
		return $datos;
	}

	function iniciarSession ($table, $conexion)
	{
		$statement = $conexion->prepare("SELECT * from $table where dni = :usuario");
		$statement->execute([':usuario' => $_SESSION['usuario']]);
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/* Funcion que comprueba si el usuario es tutor de un grupo*/
	function esTutor($conexion){
		$statement = $conexion->prepare("SELECT * FROM Tutoria  where dni_tutor = :dni");
		$statement->execute([ ':dni' => $_SESSION['usuario']]);
	 	return	$statement->fetch(PDO::FETCH_ASSOC);
	}

	/* Funcion que extrae datos de los grupos donde el profesor tiene libros a valorar */
	function GrupoLibro($conexion, $dni){
		$sentencia= "SELECT distinct G.id_grupo, descripcion from Grupo G, GrupoProfesor GP, Libro L where G.id_grupo = GP.id_grupo and G.id_asignatura = L.id_asignatura and GP.dni= :dni";
		$statement = $conexion->prepare($sentencia);
		$statement->execute([ ':dni' => $dni ]);
	 	return	$statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/* Funcio que obte les dades d'un grup*/
	function dadesGrup($conexion, $grup){
		$sentencia = "SELECT * from Grupo where id_grupo = :grupo";
		$statement = $conexion->prepare($sentencia);
		$statement->execute([ ':grupo' => $grup]);
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/* Funcio que mostra els llibres d'un grup */
	function mostraLlibres($conexion, $grup){
		$sentencia="SELECT distinct A.nombre as nombre, A.apellido1 as apellido1, A.apellido2 as apellido2, E.id_ejemplar as ejemplar, E.volumen_libro as volumen, E.puntos as puntos FROM Grupo G, AlumnoGrupo AG, Alumno A, Ejemplar E, Libro L  WHERE G.id_grupo= :grupo and AG.nia=A.nia and AG.id_grupo = G.id_grupo and E.id_lote = A.id_lote and E.isbn_libro = L.isbn and L.id_asignatura= G.id_asignatura order by A.apellido1, A.apellido2, A.nombre, E.volumen_libro";
		$statement = $conexion->prepare($sentencia);
		$statement->execute([ ':grupo' => $grup]);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}


	  /* Funcio que mostra els llibres no valorats d'un grup al tutor */
        	function mostraLlibresNoValorats($conexion, $tutoria){
                $sentencia="SELECT distinct A.nombre as nombre, A.apellido1 as apellido1, A.apellido2 as apellido2, L.titulo as titulo, E.id_ejemplar as ejemplar, E.volumen_libro as volumen, E.puntos as puntos FROM Alumno A, Ejemplar E, Libro L  WHERE E.id_lote = A.id_lote and E.isbn_libro = L.isbn and E.volumen_libro=L.volumen and E.puntos=-1 and A.id_tutoria= :tutoria order by A.apellido1, A.apellido2, A.nombre, E.volumen_libro";
                $statement = $conexion->prepare($sentencia);
                $statement->execute([ ':tutoria' => $tutoria]);
                return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

	/* Funcio que executa una sentencia  en la base de dades sense parametres */
	function executaSentencia($conexion, $sentencia){
		$statement = $conexion->prepare($sentencia);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	function executaSentenciaTotsResultats($conexion, $sentencia){
		$statement = $conexion->prepare($sentencia);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/* Funcio que obte les observacions d'un exemplar */
	function observacionsExemplar($conexion, $exemplar){
		$sentencia ="select id_observacion from ObservacionEjemplar where id_ejemplar = :exemplar order by id_observacion";	
        $statement = $conexion->prepare($sentencia);
        $statement->execute([ ':exemplar' => $exemplar]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);

	}

	/* Funcio que indica si una observacio d'un exemplar es troba registrada o no */
	function observacioRegistrada($conexion, $exemplar, $observacio)
	{
		$sentencia= "select * from ObservacionEjemplar where id_observacion =\"" . $observacio. "\" and id_ejemplar = \"" . $exemplar. "\"";
		$resultat = executaSentencia($conexion, $sentencia); 
		return $resultat["id_observacion"];
	}

	/* Funcio que obté totes les observacions */
	function obteObservacions ($conexion)
	{
		$sentencia = "select * from ObservacionEjemplar";
		$resultat = executaSentenciaTotsResultats($conexion,$sentencia);
		$array_observacions = array();
		foreach ($resultat as $observacio)
		{
			$cadena = $observacio["id_ejemplar"]. "-". $observacio["id_observacion"];
			array_push($array_observacions, $cadena);
		}
		
		return $array_observacions;
	}

	function obteTipusObservacions($conexion)
	{
		$sentencia = "select * from Observacion";
		$resultat = executaSentenciaTotsResultats($conexion,$sentencia);
		return $resultat;
	}

	/*Funcio que indica si una cadena es troba en un array */
	function estaEnArray($lista, $cadena){
		$encontrado = False;

		foreach ($lista as $elemento){
			if (strcmp($elemento, $cadena) == 0){
				$encontrado = True;
				break;
			}
		}
		return $encontrado;
	}

	/* Funció que obte les dades que es mostren en recollida de lots */
	function dadesRecollidaLots($conexion, $tutoria)
	{
		$sentencia = "select A.nombre, A. apellido1, A.apellido2, A.nia as nia, L.repartit, L.folres, L.valoracioglobal, A.id_lote as lote, A.repetidor as repetidor from Alumno A, Lote L where A.id_lote = L.id_lote and A.banc_llibres!=0 and A.id_tutoria=\"" . $tutoria . "\" order by A.apellido1, A.apellido2, A.nombre";
		$resultats =executaSentenciaTotsResultats($conexion, $sentencia);
		return $resultats;
	}

	/* Funcio que mostra els llibres d'un lot */
	function mostraLlibresLot($conexion, $id_lote)
	{
		$sentencia = "select distinct E.id_ejemplar as id_ejemplar, A.nombre as nombre, E.puntos as puntos, E.volumen_libro as volumen from Ejemplar E, Libro L, Asignatura A  where E.isbn_libro = L.isbn and L.id_asignatura = A.id_asignatura and id_lote=\"" . $id_lote . "\" order by E.id_ejemplar, E.volumen_libro";
		$llibres = executaSentenciaTotsResultats($conexion, $sentencia);
		return $llibres;
	}
	/* Funcio que mostra els llibres d'un lot */
	function mostraLlibresAlumne($conexion, $nia)
	{
		$sentencia = "select distinct E.id_ejemplar as id_ejemplar, Asig.nombre as nombre, concat(A.nombre, ' ', A.apellido1, ' ', A.apellido2) as nombre_completo, E.puntos as puntos, E.volumen_libro as volumen from Ejemplar E, Libro L, Asignatura Asig, Alumno A  where E.isbn_libro = L.isbn and L.id_asignatura = Asig.id_asignatura and A.id_lote=E.id_lote and A.nia=\"". $nia. "\" order by E.id_ejemplar, E.volumen_libro";
		$llibres = executaSentenciaTotsResultats($conexion, $sentencia);
		return $llibres;
	}

	/* Funcio que mostra tots els llibres d'un alumne */
/*	function mostraLlibresAlumne ($conexion, $nia){
		$sentencia = "select E.id_ejemplar, E.puntos, E.fecha_mod, E.isbn_libro, E.volumen_libro, E.id_lote from Ejemplar E, Alumno A where E.id_lote = A.id_lote and A.nia =\"". $nia . "\"";
		$llibres = executaSentenciaTotsResultats($conexion, $sentencia);
                return $llibres;
}*/
	function alumnesNoXarxaTutoria($conexion, $grupo){
		$sentencia = "select nombre as nom, apellido1 as ape1, apellido2 as ape2 from Alumno A, AlumnoGrupo AG where A.nia=AG.nia and A.banc_llibres=\"0\" and AG.id_grupo=\"". $grupo."\"";

		$noxarxa=executaSentenciaTotsResultats($conexion, $sentencia);
		return $noxarxa;
	}

	/* Funcion que devuelve el nombre de los alumnos que aun tienen libros para valorar en una tutoria */
	function alumnosLibrosNoValorados($conexion, $tutoria){
		$sentencia="SELECT distinct nombre, apellido1, apellido2 from Alumno A, Ejemplar E where A.id_lote=E.id_lote and E.puntos=-1 and id_tutoria=\"". $tutoria . "\"";
		$alumnos=executaSentenciaTotsResultats($conexion, $sentencia);
		return $alumnos;
	}
	/* Funcio que torna els llibres a reposar per l'alumnat  */
	function reposarAlumnat($conexion){
		$sentencia="select distinct A.nombre, A.apellido1, A.apellido2, L.titulo, E.id_ejemplar, E.volumen_libro, A.id_tutoria, E.id_lote from Ejemplar E, ObservacionEjemplar O, Libro L, Alumno A where E.id_ejemplar = O.id_ejemplar and O.id_observacion=9 and E.isbn_libro=L.isbn and E.id_lote=A.id_lote and A.repetidor !=1 order by A.id_tutoria, A.apellido1";
		$reposar=executaSentenciaTotsResultats($conexion, $sentencia);
		return $reposar;
	}

	/* Funcio que torna els llibres a reposar pel centre  */
	function reposarCentre($conexion){
		$sentencia="select distinct A.nombre, A.apellido1, A.apellido2, L.titulo, E.id_ejemplar, E.volumen_libro, A.id_tutoria, E.id_lote from Ejemplar E, ObservacionEjemplar O, Libro L, Alumno A where E.id_ejemplar = O.id_ejemplar and O.id_observacion=8 and E.isbn_libro=L.isbn and E.id_lote=A.id_lote order by A.id_tutoria, A.apellido1";
		$reposar=executaSentenciaTotsResultats($conexion, $sentencia);
		return $reposar;
	}

	/* Ordena els llibres d'una tutoria per puntuacio */
	function ordenaLlibresTutoria($conexion, $tutoria){
		$sentencia="SELECT E.id_lote, A.nombre, A.apellido1, A.apellido2, sum(E.puntos) as puntos FROM `Ejemplar` E, Alumno A where A.id_lote = E.id_lote and A.id_tutoria =\"". $tutoria . "\" group by E.id_lote, A.apellido1, A.apellido2, A.nombre order by puntos desc, A.apellido1,A.apellido2, A.nombre";
		$resultat= executaSentenciaTotsResultats($conexion, $sentencia);
		return $resultat;
	}
	
	function LotsPerTornar($conexion){
		$sentencia="SELECT concat(A.nombre,' ', A.apellido1,' ', A.apellido2), A.id_lote as lote, A.id_tutoria FROM Lote L, Alumno A WHERE repartit=1 and L.id_lote = A.id_lote and id_tutoria like '%ESO%' and A.id_lote != \"NULL\" and A.repetidor != 1 order by A.id_tutoria, A.apellido1, A.apellido2";
		$resultat=executaSentenciaTotsResultats($conexion,$sentencia);
		return $resultat;
	}

	/* Obtenir les valoracions globals dels lots no buides */
	function valoracioLots($conexion){
		$sentencia="SELECT A.nombre, A.apellido1, A. apellido2, A.id_lote as lote, L.valoracioglobal as valoracio, A.id_tutoria FROM Lote L, Alumno A where L.valoracioglobal !=\"\"  and A.id_lote = L.id_lote ORDER BY A.id_tutoria, A.apellido1, A.apellido2, A. nombre";
		$resultat=executaSentenciaTotsResultats($conexion, $sentencia);
		return $resultat;
	}

	/* Obtenir els alumnes repetidors */
	function alumnesRepetidors($conexion){
		$sentencia = "SELECT concat(nombre, ' ', apellido1,' ', apellido2), id_tutoria,id_lote from Alumno where repetidor=\"1\" order by id_tutoria, apellido1, apellido2, nombre";
		$resultat=executaSentenciaTotsResultats($conexion, $sentencia);
		return $resultat;
	}
	/* Funcio que calcula les puntuacions dels lots */
	function puntuacioLotsTutoria($conexion,$tutoria){
		$sentencia = "select concat(A.nombre, ' ', A.apellido1,' ', A.apellido2) as nombre, E.id_lote, sum(E.puntos) as puntos, A.repetidor, L.repartit, L.folres, L.valoracioglobal from Ejemplar E, Alumno A, Lote L where E.id_lote = A.id_lote and L.id_lote=E.id_lote and A.id_tutoria=\"";
		$sentencia = $sentencia . $tutoria . "\" group by E.id_lote, A.apellido1, A.apellido2, A.nombre, L.repartit, L.folres, L.valoracioglobal,A.repetidor order by A.apellido1, A.apellido2, A.nombre";
		$resultat=executaSentenciaTotsResultats($conexion,$sentencia);
		return $resultat;
			}

	/* Funcio per obtenir totes les tutories que tenen llibres */
	function tutoriasConLibros($conexion){
		$sentencia = "select id_tutoria, descripcion from Tutoria where id_tutoria like '20%ESO%'"; //or id_tutoria like '20%CFB%'";
		$resultat = executaSentenciaTotsResultats($conexion, $sentencia);
		return $resultat;
	}

	/* Funció que torna els lots que ja han tornat i no tenen folres */
	function senseFolres($conexion){
		$sentencia="select concat(A.nombre,' ', A.apellido1,' ', A.apellido2), L.id_lote, A.id_tutoria from Alumno A, Lote L where A.id_lote= L.id_lote and L.repartit=\"0\" and L.folres=\"0\" order by A.id_tutoria, A.apellido1, A.apellido2, A.nombre";
		$resultat = executaSentenciaTotsResultats($conexion, $sentencia);
		return $resultat;
	}

	/* Funció que torna el nom complet d'un nia */
	function nomCompletNIA($conexion,$nia){
		$sentencia = "select concat(nombre,' ', apellido1,' ', apellido2) as nombre, id_lote as lote from Alumno where nia=\"" . $nia ."\"";
		$resultat=executaSentencia($conexion,$sentencia);
		return $resultat;
	}

	/* Funció que torna el nom complet de l'alumne al que pertany un lot */
	function nomCompletLot($conexion,$lot){
		$sentencia = "select concat(nombre,' ', apellido1,' ', apellido2) as nombre, id_lote as lote from Alumno where id_lote=\"" . $lot ."\"";
		$resultat=executaSentencia($conexion,$sentencia);
		return $resultat;
	}

	/* Funció que calcula la puntuació d'un lot */
	function calculaPuntuacio($conexion, $id_lote){
		$sentencia="select sum(puntos) as puntos from Ejemplar where id_lote=\"". $id_lote . "\" group by id_lote";
		$resultat=executaSentencia($conexion, $sentencia);
		return $resultat["puntos"];
	}

	/* Funció que obte les dades d'un lot */
	function dadesLot($conexion, $id_lote){
		$sentencia="select repartit, folres, valoracioglobal, retirat from Lote where id_lote=\"" . $id_lote . "\"";
		$resultat=executaSentencia($conexion, $sentencia);
		return $resultat;
	}

	/* Obte la descripcio d'una observacio a partir de l'identificador */
	function descripcioObservacio($conexion, $id_observacion){
		$sentencia="select descripcion from Observacion where id_observacion=\"". $id_observacion . "\"";
		$resultat = executaSentencia($conexion,$sentencia);
		return $resultat["descripcion"];
	}

	/* Funcion que permite buscar la posición de un lote en una aula con una puntuacion  */
	function posicionLotePuntosAula($array_lotes, $puntos,$id_aula){

		$noencontrado=1;
		$primeraPosicionPunts=-1;
		$pos=0;
		while ($noencontrado and $pos<count($array_lotes)){
			if ((strcmp($array_lotes[$pos]['puntos'],$puntos) ==0) and ($array_lotes[$pos]['usat'] == 0)){
				if ($primeraPosicionPunts == -1)
					$primeraPosicionPunts=$pos;
				if (strcmp($array_lotes['id_aula'],$id_aula))
				{
					//Hem trobat la posició adequada
					$noencontrado=0;
				}
			} 
			$pos++;
		}

		if ($noencontrado)
			return  $primeraPosicionPunts;
		else
			return $pos-1;
	}

	/* Funcion que permite buscar la posición de un lote con una puntuacion */
	function posicionLotePuntos($array_lotes, $puntos){

		$noencontrado=1;
		$pos=0;

		while ($noencontrado and $pos<count($array_lotes)){
			if ((strcmp($array_lotes[$pos]['puntos'],$puntos) ==0) and ($array_lotes[$pos]['usat'] == 0)){
					//Hem trobat la posició adequada
					$noencontrado=0;
			} 
			$pos++;
		}

		if ($noencontrado)
			return  $primeraPosicionPunts;
		else
			return $pos-1;
	}

	/* Funció que a partir d'un conjunt d'alumnes i lots torna l'assignació. Tant els alumnes com els lots estan ordenats de major a menor*/
	function assignaLotsAlumnes($alumnes, $lots){
		

		// Array con las aulas donde se encuentran los lotes
		$aulas=array();

		$lotsPerAssignar=array();
			foreach ($lots as $lot){
				$aux['id_lote']=$lot['id_lote'];
				$aux['puntos']=$lot['puntos'];
				$aux['repartit']=$lot['repartit'];
				if ($lot['retirat']){
					$aux['id_aula']="Magatzem";
				}
				else{
					$aula=$lot['id_aula'];
					$aux['id_aula']= $aula;
					if (!estaEnArray($aulas,$aula))
						array_push($aulas, $aula);
				}
				$aux['usat']=0;

				array_push($lotsPerAssignar, $aux);
			}
		

		// Ordenamos de menor a mayor las aulas que contienen lotes
		asort($aulas);

		// Obtenemos las aulas de los alumnos
		$aulasAlumnos=array();

		foreach ($alumnes as $alumne){
			$aula = $alumne['id_aula'];
			if (!estaEnArray($aulasAlumnos,$aula))
				array_push($aulasAlumnos, $aula);
		}

		asort($aulasAlumnos);

		// Comprobamos si alguna de las aulas de los alumnos coincide con la de los libros
		$noCoinciden=1;
		$num_aulas=count($aulasAlumnos);
		$i=0;

		while ($noCoinciden and $i<$num_aulas)
		{
			if (estaEnArray($aulas,$aulasAlumnos[$i]))
				$noCoinciden=0;
			$i++;
		}

		$lotsAssignats=array();

		// Comprobamos si tenemos mayor numero de lotes que de alumnos
		if (count($alumnes) >= count($lots))
			$maxim=count($lots);
		else
			$maxim=count($alumnes);

		if ($noCoinciden){
			// En este caso los lotes se asignan por orden
			echo "No hay aulas coincidentes";


			for ($i=0;$i<$maxim;$i++){
				$lot=array();

				$lot['nia']=$alumnes[$i]['nia'];
				$lot['nombre']=$alumnes[$i]['nombre'];
				$lot['apellido1']=$alumnes[$i]['apellido1'];
				$lot['apellido2']=$alumnes[$i]['apellido2'];
				$lot['id_lote']=$lots[$i]['id_lote'];
				$lot['puntos']=$lots[$i]['puntos'];
				if ($lot[$i]['retirat'])
					$lot['id_aula']="Magatzem";
				else
					$lot['id_aula']=$lots[$i]['id_aula'];

				array_push($lotsAssignats, $lot);
			}
		}
		else
		{
			echo "Hay aulas coincidentes";
			// Creamos un array asociativo con todos los lotes añadiendo uno que indique si se ha asignado o no
			

			// Primer assignarem els alumnes que estiguen en les aules que ja tenen llibres
			for ($i=0;$i<$maxim;$i++){
				// Comprovem si l'aula està entre les aules amb llibres
				$aulaAlumne=$alumnes[$i]['id_aula'];

			
				if (estaEnArray($aulas, $aulaAlumne))
				{
					// Busquem la posició a assignar
					$pos=posicionLotePuntosAula($lotsPerAssignar, $lots[$i]['puntos'],$aulaAlumne);
					$lotsPerAssignar[$pos]['usat']=1;
					$lot=array();
					$lot['nia']=$alumnes[$i]['nia'];
				
					$lot['nombre']=$alumnes[$i]['nombre'];
					$lot['apellido1']=$alumnes[$i]['apellido1'];
					$lot['apellido2']=$alumnes[$i]['apellido2'];
					$lot['id_lote']=$lotsPerAssignar[$pos]['id_lote'];
					$lot['puntos']=$lotsPerAssignar[$pos]['puntos'];
					if ($lot[$i]['retirat'])
						$lot['id_aula']="Magatzem";
					else
						$lot['id_aula']=$lotsPerAssignar[$pos]['id_aula'];
					array_push($lotsAssignats, $lot);
				}
			}
			
			// Ara assignarem la resta d'alumnes que no coincideixen en l'aula
			for ($i=0;$i<$maxim;$i++){
				// Aula
				$aulaAlumne = $alumnes[$i]['id_aula'];

				if (!estaEnArray($aulas,$aulaAlumne))
				{
					// Buscarem un lot a assignar amb la puntuacio
					$pos=posicionLotePuntos($lotsPerAssignar, $lots[$i]['puntos']);

					$lotsPerAssignar[$pos]['usat']=1;

					$lot=array();
					$lot['nia']=$alumnes[$i]['nia'];
					$lot['nombre']=$alumnes[$i]['nombre'];
					$lot['apellido1']=$alumnes[$i]['apellido1'];
					$lot['apellido2']=$alumnes[$i]['apellido2'];
					$lot['id_lote']=$lotsPerAssignar[$pos]['id_lote'];
					$lot['puntos']=$lotsPerAssignar[$pos]['puntos'];
					if ($lot[$i]['retirat'])
						$lot['id_aula']="Magatzem";
					else
						$lot['id_aula']=$lotsPerAssignar[$pos]['id_aula'];

					array_push($lotsAssignats, $lot);
				}
			}
		}

		
	
		return $lotsAssignats;

		

		

	}
