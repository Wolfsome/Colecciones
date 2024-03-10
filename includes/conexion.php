<?php
$servername = getenv("MYSQL_HOST"); // Nombre/IP del servidor
$username = getenv("MYSQL_USER"); // Nombre del usuario
$password = getenv("MYSQL_PASSWD"); // Contraseña del usuario
$database = "coleccion"; // Nombre de la BBDD
// Creamos la conexión
$con = mysqli_connect($servername, $username, $password, $database);
mysqli_query($con,"SET NAMES 'utf8'");
// Comprobamos la conexión
if (!$con) {
    die("La conexión ha fallado: " . mysqli_connect_error());
}
