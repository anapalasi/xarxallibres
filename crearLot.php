<?php session_start();

require 'admin/config.php';
require 'functions.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);

// Primer crearem el lot (id_lote, puntos, repartit, folres, valoracioglobal, retirat)
$sentencia = "select substring(id_lote,locate('_',id_lote)+1) as numero from Lote where id_lote like '". $_POST['tipusLot']."%'";
$resultado =executaSentenciaTotsResultats($conexion,$sentencia);

$max=-1;
foreach ($resultado as $numero){
	if ($numero['numero'] >$max){
		$max=$numero['numero'];

	}
}
$numero=$max+1;

$tipus=$_POST['tipusLot'];
echo $tipus;
$titols=array();
$identificador=array();
$isbn=array();
$volum=array();
if (strcmp($tipus,'1eso') == 0){
	array_push($titols, 'Biologia volum 1');
	array_push($identificador, '1ESO_BIO_1_E');
	array_push($isbn,'9788426397348');
	array_push($volum, 1);
	array_push($titols, 'Biologia volum 2');
	array_push($identificador, '1ESO_BIO_2_E');
	array_push($isbn,'9788426397348');
	array_push($volum, 2);
	array_push($titols, 'Biologia volum 3');
	array_push($identificador, '1ESO_BIO_3_E');
	array_push($isbn,'9788426397348');
	array_push($volum, 3);
	array_push($titols,'Història volum 1');
	array_push($identificador, '1ESO_HIS_VAL_1_E');
	array_push($isbn,'9788467851557');
	array_push($volum, 1);
	array_push($titols,'Història volum 2');
	array_push($identificador, '1ESO_HIS_VAL_2_E');
	array_push($isbn,'9788467851557');
	array_push($volum, 2);
	array_push($titols,'Història volum 3');
	array_push($identificador, '1ESO_HIS_VAL_3_E');
	array_push($isbn,'9788467851557');
	array_push($volum, 3);
	array_push($titols,'Llengua castellana');
	array_push($identificador, '1ESO_CAS_1_E');
	array_push($isbn,'9788468015774');
	array_push($volum, 1);
	array_push($titols,'Matemàtiques');
	array_push($identificador, '1ESO_MAT_1_E');
	array_push($isbn,'9788467578324');
	array_push($volum, 1);
	array_push($titols,'Música');
	array_push($identificador, '1ESO_MUS_1_E');
	array_push($isbn,'9788430785513');
	array_push($volum, 1);
	array_push($titols,'Anglés');
	array_push($identificador, '1ESO_ANG_1_E');
	array_push($isbn,'9780194666107');
	array_push($volum, 1);
	array_push($titols,'Valencià volum 1');
	array_push($identificador, '1ESO_VAL_1_E');
	array_push($isbn,'9788430789795');
	array_push($volum, 1);
	array_push($titols,'Valencià volum 2');
	array_push($identificador, '1ESO_VAL_2_E');
	array_push($isbn,'9788430789795');
	array_push($volum, 2);
	array_push($titols,'Valencià volum 3');
	array_push($identificador, '1ESO_VAL_3_E');
	array_push($isbn,'9788430789795');
	array_push($volum, 3);


}
else{
	if (strcmp($tipus,'2eso') == 0){
	array_push($titols, 'Física i Química volum 1');
	array_push($identificador, '2ESO_FIQ_1_');
	array_push($isbn,'9788414003220');
	array_push($volum, 1);
	array_push($titols, 'Física i Química volum 2');
	array_push($identificador, '2ESO_FIQ_2_');
	array_push($isbn,'9788414003220');
	array_push($volum, 2);
	array_push($titols,'Història volum 1');
	array_push($identificador, '2ESO_HIS_VAL_1_');
	array_push($isbn,'9788469815335');
	array_push($volum, 1);
	array_push($titols,'Història volum 2');
	array_push($identificador, '2ESO_HIS_VAL_2_');
	array_push($isbn,'9788469815335');
	array_push($volum, 2);
	array_push($titols,'Història volum 3');
	array_push($identificador, '2ESO_HIS_VAL_3_');
	array_push($isbn,'9788469815335');
	array_push($volum, 3);
	array_push($titols,'Llengua castellana');
	array_push($identificador, '2ESO_CAS_1_');
	array_push($isbn,'9788468040073');
	array_push($volum, 1);
	array_push($titols,'Matemàtiques');
	array_push($identificador, '2ESO_MAT_1_');
	array_push($isbn,'9788467587364');
	array_push($volum, 1);
	array_push($titols,'Anglés');
	array_push($identificador, '2ESO_ANG_1_');
	array_push($isbn,'9780194666244');
	array_push($volum, 1);
	array_push($titols,'Valencià volum 1');
	array_push($identificador, '2ESO_VAL_1_');
	array_push($isbn,'9788430790876');
	array_push($volum, 1);
	array_push($titols,'Valencià volum 2');
	array_push($identificador, '2ESO_VAL_2_');
	array_push($isbn,'9788430790876');
	array_push($volum, 2);
	array_push($titols,'Valencià volum 3');
	array_push($identificador, '2ESO_VAL_3_');
	array_push($isbn,'9788430790876');
	array_push($volum, 3);


	}
	else{
		
		if (strcmp(substr($tipus,0,4),'3eso') == 0)
		{ 
			$prefijo=strtoupper($tipus);
			array_push($titols, 'Biologia i Geologia');
			array_push($identificador, $prefijo.'_BIO_1_');
			array_push($isbn,'9788490583326');
			array_push($volum, 1);
			array_push($titols,'Història volum 1');
			array_push($identificador, $prefijo.'_HIS_VAL_1_');
			array_push($isbn,'9788468234519');
			array_push($volum, 1);
			array_push($titols,'Història volum 2');
			array_push($identificador, $prefijo. '_HIS_VAL_2_');
			array_push($isbn,'9788468234519');
			array_push($volum, 2);
			array_push($titols,'Història volum 3');
			array_push($identificador, $prefijo. '_HIS_VAL_3_');
			array_push($isbn,'9788468234519');
			array_push($volum, 3);
			array_push($titols,'Llengua castellana');
			array_push($identificador, $prefijo.'_CAS_1_');
			array_push($isbn,'9788468036571');
			array_push($volum, 1);

			// Distinguimos las matemáticas
			if (strcmp($tipus,'3eso')== 0)
			{
				array_push($titols,'Matemàtiques');
				array_push($identificador, '3ESO_MAT_1_');
				array_push($isbn,'9788467578690');
				array_push($volum, 1);
			}
			else
			{

				array_push($titols,'Matemàtiques volum 1');
				array_push($identificador, '3ESOAP_MAT_1_');
				array_push($isbn,'9788467852981');
				array_push($volum, 1);
				array_push($titols,'Matemàtiques volum 2');
				array_push($identificador, '3ESOAP_MAT_2_');
				array_push($isbn,'9788467852981');
				array_push($volum, 2);
				array_push($titols,'Matemàtiques volum 3');
				array_push($identificador, '3ESOAP_MAT_3_');
				array_push($isbn,'9788467852981');
				array_push($volum, 3);
			}
			
			array_push($titols,'Anglés');
			array_push($identificador, $prefijo. '_ANG_1_');
			array_push($isbn,'9789963516414');
			array_push($volum, 1);
			array_push($titols,'Valencià volum 1');
			array_push($identificador, $prefijo. '_VAL_1_');
			array_push($isbn,'9788430789900');
			array_push($volum, 1);
			array_push($titols,'Valencià volum 2');
			array_push($identificador, $prefijo. '_VAL_2_');
			array_push($isbn,'9788430789900');
			array_push($volum, 2);
			array_push($titols,'Valencià volum 3');
			array_push($identificador, $prefijo.'_VAL_3_');
			array_push($isbn,'9788430789900');
			array_push($volum, 3);
		}
	}
}

require 'views/crearLot.view.php';

