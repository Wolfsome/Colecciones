<?php
  require_once 'includes/conexion.php';

  //Vamos a generar el modal de 'Acerca de ...'

  echo '
    <div class="modal fade" id="acercade" tabindex="-1" aria-labelledby="acercade">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header" style="background-color:orange;">
            <h5 class="modal-title">Acerca de ...</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Colección de Monedas y Libros versión 1.0</p>
            <p>© Copyright 
						<a class="text-reset fw-bold" href="https://www.facebook.com/profile.php?id=100091331941079" target="_blank">Wolfsome</a> - '.date('Y').'</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" style="background-color:orange;" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  ';

?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Colección de Monedas y Libros</title>

    <!-- jQuery -->
    <script defer src="common/public/js/all.js"></script>
    <script src="common/public/js/jquery-3.6.0.js" crossorigin="anonymous"></script>

    <!-- Bottstrap jQuery -->
    <script src="common/public/js/bootstrap.bundle.min.js"></script>

    <!-- Datatable jQuery -->
    <script type="text/javascript" charset="utf8" src="common/public/js/jquery.dataTables.js"></script>

    <!-- Select 2 jQuery -->
    <script src="common/public/js/select2.min.js"></script>

    <!-- Select 2 CSS -->
    <link href="common/public/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="common/public/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="common/public/css/buttons.bootstrap.min.css">

    <!-- Tablas CSS -->
    <link rel="stylesheet" type="text/css" href="common/public/css/jquery.dataTables.css">

    <!-- Hoja de estilos propia -->
    <link rel="stylesheet" href="common/public/css/style.css">

    <!-- Fontawesome -->
	  <link rel="stylesheet" href="common/public/css/fontawesome.min.css">

	  <!-- FavIcon -->
	  <link rel="shortcut icon" href="common/public/images/icono_monedas.png"> 
  </head>

  <body class="fondo">

    <div class="container">
      <br>
      <div class="col text-center">
        <div class="col " style="background-color:white;">
          <div class="row">
            <div class="col-lg-12">
              <p class="login-form-font-header">Colecciones<br><span><?php echo $_SESSION['pagina']; ?></span><p>
            </div>
          </div>

          <div class="row" style="text-align:justify;">
            <div class="col-lg-12 lg-light rounded" style="text-align:justify;">

              <nav class="navbar navbar-expand-lg navbar-light" style="background-color:orange;">
                <div class="collapse navbar-collapse" id="navbarText">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toogle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Monedas</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="nacionales.php">Nacionales</a></li>
                          <li><a class="dropdown-item" href="extranjeras.php">Extranjeras</a></li>
                        </ul>
                    </li>
                    <li class="nav-item active">
                      <a class="nav-link" href="#">Libros</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toogle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administración</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="estados.php">Estados de conservación</a></li>
                          <li><a class="dropdown-item" href="paises.php">Países / Divisas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#acercade">Acerca de ...</a>
                    </li>
                  </ul>
                </div>
              </nav>
