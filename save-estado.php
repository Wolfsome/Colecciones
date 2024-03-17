<?php
// guardar_modificaciones.php

include_once 'includes/conexion.php'; 

// Maneja el envío de datos por AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtén los datos del formulario
    $id = strtoupper($_POST['id']);
    $descripcion = strtoupper($_POST['descripcion']);

    //Vamos a comprobar que no hay ya una id en la tabla
    $sql = "SELECT id FROM estado WHERE id='$id';";
    $resultado = mysqli_query($con,$sql) or die(mysqli_errno($con));

    if($total=mysqli_num_rows($resultado) == 0) {

        //Insertamos en nuevo estado en la tabla
        $sql = "INSERT INTO estado (id,descripcion) VALUES ('$id','$descripcion');";
        $resultado = mysqli_query($con,$sql) or die(mysqli_errno($con));

        //Preparamos en array
        $response = array();

        if ($resultado) {
            // Éxito
            $response['estado'] = 'success';
            $response['mensaje'] = 'Estado creado correctamente';
        } else {
            // Error
            $response['estado'] = 'error';
            $response['mensaje'] = 'Error al crear el estado';
        }

    }else{
        //Ya exite una id en la BB.DD. igual
        $response['estado'] = 'error';
        $response['mensaje'] = 'Ya existe una nomenclatura '.$id;
    }

    //Devolvemos el resultado
    echo json_encode($response);
    exit();

}