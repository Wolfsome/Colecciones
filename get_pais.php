<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // Devuelve los resultados en formato JSON
  header('Content-Type: application/json');

  require_once 'includes/conexion.php';

  // Obtener el país seleccionado desde la solicitud POST
    $id = mysqli_real_escape_string($con, $_POST['id']);

    // Consulta para obtener las divisas del país seleccionado
    $sql = "SELECT * FROM paises WHERE id = '".$id."'";
    $query = mysqli_query($con, $sql);

    // Construir un array con las divisas
    $data = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }

    // Devolver el resultado como JSON
    echo json_encode(array('data' => $data));

    // Cerrar la conexión a la base de datos
    mysqli_close($con);