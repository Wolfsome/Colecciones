<?php
  require_once 'includes/conexion.php';
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Colección de Monedas</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="common/public/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="common/public/js/bootstrap.bundle.min.js"></script>
    <script defer src="common/public/js/all.js"></script>
    <script src="common/public/js/jquery-3.6.0.js" crossorigin="anonymous"></script>

    <!-- Tablas -->
    <link rel="stylesheet" type="text/css" href="common/public/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="common/public/js/jquery.dataTables.js"></script>

    <!-- Hoja de estilos propia -->
    <link rel="stylesheet" href="common/public/css/style.css">

    <!-- Fontawesome -->
	  <link rel="stylesheet" href="common/public/css/fontawesome.min.css">

	  <!-- FavIcon -->
	  <link rel="shortcut icon" href="../common/public/images/icono_monedas.png"> 
  </head>

  <body class="fondo">

    <div class="container">
      <br>
      <div class="col text-center">
        <div class="col " style="background-color:white;">
          <div class="row">
            <div class="col-lg-12">
              <p class="login-form-font-header">Colecciones<br><span>Monedas</span><p>
            </div>
          </div>

          <div class="row" style="text-align:justify;">
            <div class="col-lg-12 lg-light rounded" style="text-align:justify;">

              <nav class="navbar navbar-expand-lg navbar-light" style="background-color:orange;">
                <div class="collapse navbar-collapse" id="navbarText">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toogle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Monedas</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="nacionales.php">Nacionales</a></li>
                          <li><a class="dropdown-item" href="extranjeras.php">Extranjeras</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#acercade">Acerca de ...</a>
                    </li>
                  </ul>
                </div>
              </nav>
