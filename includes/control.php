<?php

//Con este código se muestran los errores PHP y MySQL, si los hubiera
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Declaramos los valores de acceso
$usuario = 'admin';
$contra = 'Chanata04740';


  if(( $_POST['usuario'] == $usuario) && ($_POST['contrasena']==$contra)) {  

    // Inicia las sesiones con sus credenciales
    // Esto es como una especie de Cookies de sesión seguras
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['contrasena'] = $_POST['contrasena'];
    $_SESSION['tipo'] = 'Administrador de la CronoEscalada 2024';

    // O bien agrega este otro valor
    // El valor puede ser un String encriptado
    $_SESSION['autenticado'] = 'connect_true';

    // y por último redirecciona a la página principal
    header('Location: ../administracion.php');
    exit;
  } else {  
    header('Location: logout.php');
    exit;
  }
?>