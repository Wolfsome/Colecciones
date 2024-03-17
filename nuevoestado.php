<?php

//Mostramos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['pagina'] = 'Monedas - Nuevo Estado de Conservación';

include_once 'includes/header.php';

?>


<div class="container text-center">
    <div class="container mt-3 mb-3">

        <form id="nuevoestado" class="form-control">
            <div class="card-body row">
                <div class="col-3">
                    <label for="id">Nomenclatura:</label>
                    <input type="text" name="id" id="id" class="form-control">
                </div>
                <div class="col-9">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control">
                </div>
            </div>
            <div class="card-body row m-3">
                <div class="col" style="text-align: right;">
                    <a href="estados.php" class="btn btn-danger">Cancelar</a>
                    <a href="#" class="btn btn-success bt-nuevo">Guardar</a>
                </div>
            </div>
        </form>

    </div>
</div>


<?php include_once 'includes/footer.php' ?>

<script>

    // Función para mostrar el mensaje en el div
    function mostrarMensaje(mensaje, clase = 'alert-success') {
        $('#mensajeResultado').removeClass().addClass('alert ' + clase).text(mensaje).show();
    }

    // Función para ocultar el mensaje en el div
    function ocultarMensaje() {
        $('#mensajeResultado').hide();
    }

    $(document).ready(function () {
        $('.bt-nuevo').click(function (event) {
            // Detenemos el comportamiento predeterminado del enlace
            event.preventDefault();

            // Realizar la operación AJAX
            $.ajax({
                url: 'save-estado.php',
                method: 'POST',
                data: $('#nuevoestado').serialize(), // Obtener datos del formulario
                dataType: 'json',
                success: function (response) {
                    if (response.estado === 'success') {
                        // Mostrar el mensaje de éxito
                        mostrarMensaje(response.mensaje);

                        // Redireccionar a estados.php después de 1 segundo
                        setTimeout(function () {
                            window.location.href = 'estados.php';
                        }, 1000);
                    } else {
                        // Manejar el error
                        mostrarMensaje(response.mensaje, 'alert-danger');
                    }
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                    console.error(error);
                }
            });
        });
    });
</script>
