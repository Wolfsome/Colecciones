<?php
// guardar_modificaciones.php

include_once 'includes/conexion.php'; 

// Maneja el envío de datos por AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtén los datos del formulario
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    // Puedes realizar validaciones adicionales aquí si es necesario

    // Construye y ejecuta la consulta SQL de actualización
    $sql = "UPDATE estado SET descripcion='$estado' WHERE id=$id;";
    $resultado = mysqli_query($con,$sql) or die(mysqli_errno($con));

    // Preparamos el array
    $response = array();

    if ($resultado) {
        // Éxito
        $response['estado'] = 'success';
        $response['mensaje'] = 'Estado modificado correctamente';
    } else {
        // Error
        $response['estado'] = 'error';
        $response['mensaje'] = 'Error al modificar el estado';
    }

    // Devolver la respuesta JSON al cliente
    echo json_encode($response);
    exit();

}