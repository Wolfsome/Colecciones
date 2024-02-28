<?php
$servername = "localhost"; // Nombre/IP del servidor
$database = "coleccion"; // Nombre de la BBDD
$username = "root"; // Nombre del usuario
$password = "Husky@1970"; // Contraseña del usuario
// Creamos la conexión
$con = mysqli_connect($servername, $username, $password, $database);
mysqli_query($con,"SET NAMES 'utf8'");
// Comprobamos la conexión
if (!$con) {
    die("La conexión ha fallado: " . mysqli_connect_error());
}
    
?>