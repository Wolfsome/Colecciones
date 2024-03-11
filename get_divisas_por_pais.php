<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // Devuelve los resultados en formato JSON
  header('Content-Type: application/json');

  require_once 'includes/conexion.php';

  // Obtener el país seleccionado desde la solicitud POST
    $paisSeleccionado = $_POST['pais'];

    // Consulta para obtener las divisas del país seleccionado
    $sql = "SELECT id,divisa FROM paises WHERE id = '" . mysqli_real_escape_string($con, $paisSeleccionado) . "'";
    $query = mysqli_query($con, $sql);

    // Construir un array con las divisas
    $divisas = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $divisas[] = $row;
    }

    // Devolver el resultado como JSON
    echo json_encode(array('divisas' => $divisas));

    // Cerrar la conexión a la base de datos
    mysqli_close($con);