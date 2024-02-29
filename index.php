<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include_once 'includes/header.php';
  
?>

<div class="row" style="text-align:justify;">
  <div class="col-lg-12 lg-light rounded" style="text-align:justify;">

  <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Buscar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Imprimir</a>
          </li>
        </ul>
      </div>
    </nav>




<?php include_once 'includes/footer.php' ?>