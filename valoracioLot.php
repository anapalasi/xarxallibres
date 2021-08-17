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
    <h1 align="center" class="texto">Valoracions lots de llibres </h1>
    <br>
 
<form action="actualitzaValoracions.php" method="post">

  <table border="1" bgcolor="white" align="center">
    <tr>
      <th> Alumne </th>
      <th> Identificador </th>
      <th> Observacions </th>
      <th> Tutoria </th>
     

    </tr>
  <?php
      $cabecera=array('Alumne','Identificador','Observacions', 'Tutoria');
      $anchura=array(80,30,80,25);
      $valores="";
      foreach ($dades as $llibre){
        $fila = array();
        echo "<tr>";
        echo "<td>";
        $nombre = $llibre["nombre"]. " " . $llibre["apellido1"]. " " .$llibre["apellido2"];
        echo utf8_encode($nombre);
        array_push($fila,utf8_encode($nombre));
        echo "</td>";
        echo "<td>";
        echo utf8_encode($llibre["lote"]);
        array_push($fila,utf8_encode($llibre["lote"]));
        echo "</td>";
        echo "<td>";
        echo "<input type=\"text\" value=\"";
        echo utf8_encode($llibre["valoracioglobal"]);
        echo "\">"
        array_push($fila,$llibre["valoracioglobal"]);
        echo "</td>";
        echo "<td>";
        echo utf8_encode($llibre["id_tutoria"]);
        array_push($fila,$llibre["id_tutoria"]);
        echo "</td>";
        
        $string_fila=implode(",", $fila);
        $valores= $valores . $string_fila. ";";
      }
    ?> 
  </table>
  <br><br>

 /*   <button type="reset"> Valors inicials </button> <button type="submit"> Actualitza valoracions</button> 
</form>
  <form action="pdf.php" method="post">
  <?php
    $titulo="Observacions lots";
    $valores =substr($valores, 0,-1);
    ?>
     <input type="hidden" name="titulo" value=" <?php echo $titulo; ?>">
     <input type="hidden" name="cabecera" value="<?php echo implode(",", $cabecera); ?>">
     <input type="hidden" name="anchura" value="<?php echo implode(",", $anchura); ?>">
     <input type="hidden" name="valores" value="<?php echo $valores; ?>">

    
  <input type="submit" value="Generar PDF"></input> 
  </form>

<br><br>
<a href="<?php
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
<center>
<img src="img/casa.png" width="5%"></a></center>
  <br>

  <a href="close.php">Cerrar Sesion</a>*/
</body>
</html>

