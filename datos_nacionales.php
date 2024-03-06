<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once 'includes/conexion.php';

  $sql = "SELECT monedas.*, paises.nombre AS nombrepais, paises.bandera FROM monedas JOIN paises ON monedas.pais = paises.id";
  $consulta = mysqli_query($con,$sql) or die(mysqli_errno($con));
  $total = mysqli_num_rows($consulta);

  if($total>0){
    // Convierte los resultados a un array asociativo
    $data = array();
    while ($row = $consulta->fetch_assoc()) {
        $data[] = $row;
    }

    // Devuelve los resultados en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
  } else {
    echo "No se encontraron monedas";
  }

  mysqli_close($con);
