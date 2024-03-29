<?php

  // Devuelve los resultados en formato JSON
  header('Content-Type: application/json');

  require_once 'includes/conexion.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID de la moneda desde la solicitud POST
    $monedaId = $_POST['id'];

    // Realizar la operación de eliminación de la moneda
    $sqlEliminar = "DELETE FROM monedas WHERE id = $monedaId";
    $resultado = mysqli_query($con, $sqlEliminar);

    // Realizar la operación de eliminación de la foto
    //Primero borramos físicamente el archivo
    $sql="SELECT foto FROM fotos WHERE id_moneda=$monedaId";
    $res = mysqli_query($con,$sql) or die(mysqli_errno($con));
    $archivo = mysqli_fetch_array($res);
    if($archivo['foto'] != 'moneda.png'){
        unlink ('common/public/images/monedas/'.$archivo['foto']);
    }
    //Eliminamos el registro de la BB.DD.
    $sqlEliminar = "DELETE FROM fotos WHERE id_moneda = $monedaId";
    $resultado = mysqli_query($con, $sqlEliminar);

    // Preparar la respuesta JSON
    $response = array();
    if ($resultado) {
        $response['success'] = true;
        $response['message'] = 'Moneda eliminada exitosamente';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error al eliminar la moneda';
    }

    // Devolver la respuesta JSON al cliente
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}