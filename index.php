<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include_once 'includes/header.php';
  
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
            <p>Colección de Monedas versión 1.0</p>
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



    <div class="container text-center">
      <img src="common/public/images/monedas.png">
    </div>



<?php include_once 'includes/footer.php' ?>