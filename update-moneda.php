<?php
// guardar_modificaciones.php

include_once 'includes/conexion.php'; 

// Maneja el envío de datos por AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtén los datos del formulario
    $id = $_POST['idmoneda'];
    $nombre = $_POST['nombre'];
    $anno = $_POST['anno'];
    $valor = $_POST['valor'];
    $unidad = $_POST['unidad'];
    $cantidad = $_POST['cantidad'];
    $motivo = $_POST['motivo'];
    $pais = $_POST['pais'];
    $estado = $_POST['estado'];
    $observaciones = $_POST['observaciones'];

    // Manejar la carga de la fotografía
    $fotoNombre = '';
    if (!empty($_FILES['cargarfoto']['name'])) {
        $fotoNombre = guardarFoto($id);
    }

    // Puedes realizar validaciones adicionales aquí si es necesario

    // Construye y ejecuta la consulta SQL de actualización
    $sql = "UPDATE monedas SET nombre='$nombre', anno='$anno', valor='$valor', unidad='$unidad', cantidad='$cantidad', motivo='$motivo', pais='$pais', estado='$estado', observaciones='$observaciones' WHERE id=$id";
    $resultado = mysqli_query($con,$sql) or die(mysqli_errno($con));

    // Actualiza la tabla de fotos si se cargó una nueva foto
    if (!empty($fotoNombre)) {

        //Borramos primero el archivo anterior

        $sqlarchivo = "SELECT foto FROM fotos WHERE id_moneda=$id;";
        $consultaarchivo = mysqli_query($con,$sqlarchivo) or die(mysqli_errno($con));
        $archivo = mysqli_fetch_array($consultaarchivo);
        $totalarchivo = mysqli_num_rows($consultaarchivo);
        if($totalarchivo > 0 && $archivo['foto'] != 'moneda.png') {
            $borrar = 'common/public/images/monedas/'.$archivo['foto'];
            unlink($borrar);
        }

        //Actualizamos el nombre del archivo en la bb.dd.

        $sqlFoto = "UPDATE fotos SET foto='$fotoNombre' WHERE id_moneda=$id";
        $resultadoFoto = mysqli_query($con, $sqlFoto) or die(mysqli_errno($con));
    }

    // Preparamos el array
    $response = array();

    if ($resultado) {
        // Éxito
        $response['estado'] = 'success';
        $response['mensaje'] = 'Moneda modificada correctamente';
    } else {
        // Error
        $response['estado'] = 'error';
        $response['mensaje'] = 'Error al modificar la moneda';
    }

    // Devolver la respuesta JSON al cliente
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

}

// Función para guardar la foto en el servidor
function guardarFoto($idMoneda) {
    $fotoNombre = '';
    $directorio = 'common/public/images/monedas/';

    $archivoTemp = $_FILES['cargarfoto']['tmp_name'];
    $archivoNombreOriginal = $_FILES['cargarfoto']['name'];

    // Genera un nombre único para la foto
    $fotoNombre = $idMoneda.'_'.uniqid().'.'.pathinfo($archivoNombreOriginal, PATHINFO_EXTENSION);

    // Mueve el archivo al directorio de destino
    if (move_uploaded_file($archivoTemp, $directorio . $fotoNombre)) {
        return $fotoNombre;
    } else {
        // Manejo de errores
        echo 'Error al mover el archivo.';
        return '';
    }

    return $fotoNombre;
}
