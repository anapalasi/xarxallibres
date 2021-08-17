<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

  <title> Valoracions lot </title>
</head>
<body class="bg-image">
  <p align="center"> <img src="img/xarxa_llibres-300x150.png" alt="Logo Xarxa Llibres"></p><br>
    <h1 align="center" class="texto">Observacions lots de llibres </h1>
    <br>
  <!--  <form action="actualitzaValoracions.php" method="post">-->

 
  <table border="1" bgcolor="white" align="center">
    <tr>
      <th> Alumne </th>
      <th> Identificador </th>
      <th> Observacions </th>
      <th> Tutoria </th>
     

    </tr>
    <?php
      $cabecera=array('Alumne','Identificador','Observacions', 'Tutoria');
      $anchura=array(80,20,150,25);
      $valores="";
      foreach ($dades as $lot){
        $fila = array();

        echo "<tr>";
        echo "<td>";
        $nombre=utf8_encode($lot["nombre"]). " ". utf8_encode($lot["apellido1"]). " ". utf8_encode($lot["apellido2"]);
        echo $nombre;
        array_push($fila, utf8_encode($nombre));
        echo "</td>";
        echo "<td>";
        echo $lot["lote"];
        array_push($fila,$lot["lote"]);
        echo "</td>";
        echo "<td>";
        echo utf8_encode($lot["valoracio"]);
        array_push($fila, utf8_encode($lot["valoracio"]));
        echo "</td>";
        echo "<td>";
        echo $lot["id_tutoria"];
        array_push($fila, $lot["id_tutoria"]);
        echo "</td>";
        echo "</tr>";
        $string_fila=implode(",", $fila);
        $valores= $valores . $string_fila. ";";
      }
    ?>
</table>
<!--</form> -->
  <form action="pdf.php" method="post">
  <?php
    $titulo="Observacions dels lots de llibres";
    $valores =substr($valores, 0,-1);
    ?>
     <input type="hidden" name="titulo" value=" <?php echo $titulo; ?>">
     <input type="hidden" name="cabecera" value="<?php echo implode(",", $cabecera); ?>">
     <input type="hidden" name="anchura" value="<?php echo implode(",", $anchura); ?>">
     <input type="hidden" name="valores" value="<?php echo $valores; ?>">

    
     <input type="submit" value="Generar PDF"></input> 
  </form>

</body>
</html>
