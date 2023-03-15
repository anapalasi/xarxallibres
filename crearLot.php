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

if ($numero == 0)
	$numero=1;


$tipus=$_POST['tipusLot'];

// Obtener de que curso es el lote
$curso=substr($tipus,0,4);

echo $curso . " : " .$tipus;

$titols=array();
$identificador=array();
$isbn=array();
$volum=array();
if (strcmp($tipus,'1eso') == 0){
	array_push($titols, 'Biologia i Geologia');
	array_push($identificador, '1ESO_BIO_1_E');
	array_push($isbn,'9788448627539');
	array_push($volum, 1);
	array_push($titols,'Història volum 1');
	array_push($identificador, '1ESO_HIS_VAL_1_E');
	array_push($isbn,'9788468284682');
	array_push($volum, 1);
	array_push($titols,'Història volum 2');
	array_push($identificador, '1ESO_HIS_VAL_2_E');
	array_push($isbn,'9788468284682');
	array_push($volum, 2);
	array_push($titols,'Llengua castellana');
	array_push($identificador, '1ESO_CAS_1_E');
	array_push($isbn,'9788430772872');
	array_push($volum, 1);
	array_push($titols,'Matemàtiques volum 1');
	array_push($identificador, '1ESO_MAT_1_E');
	array_push($isbn,'9788414305683');
	array_push($volum, 1);
	array_push($titols,'Matemàtiques volum 2');
	array_push($identificador, '1ESO_MAT_2_E');
	array_push($isbn,'9788414305683');
	array_push($volum, 2);
	array_push($titols,'Matemàtiques volum 3');
	array_push($identificador, '1ESO_MAT_3_E');
	array_push($isbn,'9788414305683');
	array_push($volum, 3);
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
	array_push($titols,'Tecnologia i Digitalització');
	array_push($identificador, '1ESO_TEC_1_E');
	array_push($isbn,'9780190547813');
	array_push($volum, 1);


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
			array_push($identificador, $prefijo.'3ESO_BIO_1_');
			array_push($isbn,'9788448627683');
			array_push($volum, 1);
			array_push($titols,'Història volum 1');
			array_push($identificador, $prefijo.'3ESO_HIS_VAL_1_');
			array_push($isbn,'9788468285092');
			array_push($volum, 1);
			array_push($titols,'Història volum 2');
			array_push($identificador, $prefijo. '3ESO_HIS_VAL_2_');
			array_push($isbn,'9788468285092');
			array_push($volum, 2);
			array_push($titols,'Llengua castellana');
			array_push($identificador, $prefijo.'3ESO_CAS_1_');
			array_push($isbn,'9788430772902');
			array_push($volum, 1);
			array_push($titols,'Matemàtiques');
			array_push($identificador, '3ESO_MAT_1_');
			array_push($isbn,'9788414305720');
			array_push($volum, 1);
			array_push($titols,'Matemàtiques volum 2');
			array_push($identificador, '3ESO_MAT_2_');
			array_push($isbn,'9788414305720');
			array_push($volum, 2);
			array_push($titols,'Matemàtiques volum 3');
			array_push($identificador, '3ESO_MAT_3_');
			array_push($isbn,'9788414305720');
			array_push($volum, 3);
			array_push($titols,'Anglés');
			array_push($identificador, $prefijo. '3ESO_ANG_1_');
			array_push($isbn,'9789963516414');
			array_push($volum, 1);
			array_push($titols,'Valencià volum 1');
			array_push($identificador, $prefijo. '3ESO_VAL_1_');
			array_push($isbn,'9788430789900');
			array_push($volum, 1);
			array_push($titols,'Valencià volum 2');
			array_push($identificador, $prefijo. '3ESO_VAL_2_');
			array_push($isbn,'9788430789900');
			array_push($volum, 2);
			array_push($titols,'Valencià volum 3');
			array_push($identificador, $prefijo.'3ESO_VAL_3_');
			array_push($isbn,'9788430789900');
			array_push($volum, 3);
			array_push($titols,'Tecnologia i Digitalització');
			array_push($identificador, $prefijo. '3ESO_TEC_1_');
			array_push($isbn,'9780190545482');
			array_push($volum, 1);
		}
	
		else
		{
			if (strcmp($curso,'4eso') == 0) {
				$prefijo=strtoupper($tipus);

				array_push($titols,'Anglés');
				array_push($identificador, $prefijo. '_ANG_1_');
				array_push($isbn,'9789963516476');
				array_push($volum, 1);
				array_push($titols,'Història volum 1');
				array_push($identificador, $prefijo.'_HIS_VAL_1_');
				array_push($isbn,'9788468236780');
				array_push($volum, 1);
				array_push($titols,'Història volum 2');
				array_push($identificador, $prefijo. '_HIS_VAL_2_');
				array_push($isbn,'9788468236780');
				array_push($volum, 2);
				array_push($titols,'Llengua castellana');
				array_push($identificador, $prefijo.'_CAS_1_');
				array_push($isbn,'9788468039992');
				array_push($volum, 1);
				array_push($titols,'Valencià volum 1');
				array_push($identificador, $prefijo. '_VAL_1_');
				array_push($isbn,'9788430791705');
				array_push($volum, 1);
			
				if (strcmp($tipus,'4esoac') == 0){
					array_push($titols,'Biologia i Geologia');
					array_push($identificador, $prefijo. '_BIO_1_');
					array_push($isbn,'9788491310273');
					array_push($volum, 1);
					array_push($titols, 'Física i Química');
					array_push($identificador, '4ESOAC_FIQ_1_');
					array_push($isbn,'9788468237763');
					array_push($volum, 1);
					array_push($titols,'Matemàtiques');
					array_push($identificador, '4ESOAC_MAT_1_');
					array_push($isbn,'9788467587371');
					array_push($volum, 1);
					
				}
				else{
					if (strcmp($tipus,'4esoal') == 0){
						array_push($titols,'Matemàtiques');
						array_push($identificador, '4ESOAL_MAT_1_');
						array_push($isbn,'9788467587371');
						array_push($volum, 1);
						array_push($titols,'Llatí');
						array_push($identificador, '4ESOAL_LLA_1_');
						array_push($isbn,'9788496977273');
						array_push($volum, 1);
						
					}
					else{
						array_push($titols,'Matemàtiques');
						array_push($identificador, '4ESOAP_MAT_1_');
						array_push($isbn,'9788490587409');
						array_push($volum, 1);
						array_push($titols,'CAAP');
						array_push($identificador, '4ESOAP_CAAP_1_');
						array_push($isbn,'9780190508043');
						array_push($volum, 1);
							
					}
				}
			}
			else {
				if (strcmp($curso,"1bat") == 0){

					array_push($titols,'Filosofia');
					array_push($identificador, strtoupper($tipus). '_FIL_1_');
					array_push($isbn,'9788468286228');
					array_push($volum, 1);
					array_push($titols,'Valencià: Llengua i literatura');
					array_push($identificador, strtoupper($tipus). '_VAL_1_');
					array_push($isbn,'9788490264454');
					array_push($volum, 1);
					array_push($titols,'Lengua castellana y literatura');
					array_push($identificador, strtoupper($tipus). '_CAS_1_');
					array_push($isbn,'9788430754403');
					array_push($volum, 1);
					array_push($titols,'Anglés');
					array_push($identificador, strtoupper($tipus). '_ANG_1_');
					array_push($isbn,'9789925305421');
					array_push($volum, 1);

					if (strcmp($tipus,'1batac')==0){

						array_push($titols,'Matemàtiques I');
						array_push($identificador, strtoupper($tipus). '_MAT_1_');
						array_push($isbn,'9788414311165');
						array_push($volum, 1);

					}
						
						
							
				}
			}
		}
	}
}
require 'views/crearLot.view.php';

