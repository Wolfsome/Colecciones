<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(!isset($_SESSION['pagina']))
    session_start();

  $_SESSION['pagina'] = 'Monedas y Libros';

  include_once 'includes/header.php';

?>



    <div class="container text-center">
      <img src="common/public/images/monedas.png">
    </div>



<?php include_once 'includes/footer.php' ?>