<?php

//Mostramos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['pagina'] = 'Monedas - Estados de Conservación';

include_once 'includes/header.php';

//Vamos a obtener todas las monedas de España
$sql= "SELECT * FROM estado;";
$query = mysqli_query($con,$sql) or die(mysqli_errno($con));
  
while ($row = mysqli_fetch_array($query)){

    // Modal
    echo'
    <div class="modal fade modal-lg" id="estadoModal-'.$row['id'].'" tabindex="-1" aria-labelledby="estadoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mb-2">
                    <h1 class="modal-title fs-5" id="estadoModalLabel">ESTADOS DE CONSERVACIÓN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card modal-body mx-2 mb-2">
                    <div class="row">
                        <div class="col-lg-12 lg-light rounded" style="text-align:justify;">
                            <b>Estado:</b> '.$row['descripcion'].'
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <a href="editarestado.php?id='.$row['id'].'" type="button" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>';

    //Fin del Modal
    
}

?>

    <div class="container text-center">
        <div class="container mt-3 mb-3">

            <!-- Div para mostrar resultado de operaciones -->
            <div id="mensajeResultado" class="alert alert-success" style="display: none;"></div>

            <!-- Agrega el botón para insertar un nuevo estado -->
            <div class="d-flex justify-content-end mb-3">
                <a href="nuevoestado.php" class="btn btn-dark" title="Añadir nuevo estado"><i class="fas fa-plus"></i> Estado</a>
            </div>

            <table id="tablaestados" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>



<?php include_once 'includes/footer.php' ?>

<script>
    $(document).ready(function () {
        $('#tablaestados').DataTable({
            "ajax": {
                "url": "datos_estados.php",
                "dataSrc": ""
            },
            "language":	{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ estados",
                "sZeroRecords":    "No se encontraron estados",
                "sEmptyTable":     "Ningún estado disponible en esta tabla",
                "sInfo":           "Mostrando estados del _START_ al _END_ de un total de _TOTAL_ estados",
                "sInfoEmpty":      "Mostrando estados del 0 al 0 de un total de 0 monedas",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ estados)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
                    },
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="ver-estado" data-bs-toggle="modal" data-bs-target="#estadoModal-' + row.id + '" title="Ver moneda">' + row.id + '</a>';                    
                    },
                 },
                { "data": "descripcion" },
                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-primary btn-outline ver-estado" data-bs-toggle="modal" data-bs-target="#estadoModal-' + row.id + '" title="Ver estado"><i class="fas fa-eye"></i></a> <a href="#" class="btn btn-danger btn-outline eliminar-estado" data-id="' + row.id + '" title="Eliminar estado"><i class="fas fa-trash"></i></a>';
                    }, 
                    "orderable": false, // Última columna no ordenable
                    "width": "100px" 
                }
            ],
        });

        // Manejar el clic en el botón "Ver estado"
        $('#tablaestados').on('click', '.ver-estado', function () {
            // Obtener el ID de la moneda desde el atributo data-id del botón
            var estadoId = $(this).data('id');
            // Abrir el modal correspondiente
            $('#estadoModal-' + estadoId).modal('show');
        });

        // Manejar el clic en el botón "Eliminar moneda"
        $('#tablaestados').on('click', '.eliminar-estado', function (e) {
            e.preventDefault();

            // Obtener el ID de la moneda desde el atributo data-id del botón
            var estadoId = $(this).data('id');

            // Preguntar al usuario si realmente desea eliminar la moneda
            var confirmacion = window.confirm('¿Estás seguro de que deseas eliminar este estado?');

            if (confirmacion) {
                // Realizar la operación AJAX
                $.ajax({
                    url: 'eliminarestado.php',
                    method: 'POST',
                    data: { id: estadoId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Mostrar el mensaje de éxito
                            mostrarMensaje('Estado eliminado correctamente');

                            // Ocultar el mensaje después de 1 segundo
                            setTimeout(function () {
                                ocultarMensaje();
                            }, 1000);

                            // Recargar la tabla
                            $('#tablaestados').DataTable().ajax.reload();
                        } else {
                            // Manejar el error, mostrar un mensaje, etc.
                            console.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Manejar errores de la solicitud AJAX
                        console.error(error);
                    }
                });
            }
        });

        // Función para mostrar el mensaje en el div
        function mostrarMensaje(mensaje, clase = 'alert-success') {
            $('#mensajeResultado').removeClass().addClass('alert ' + clase).text(mensaje).show();
        }

        // Función para ocultar el mensaje en el div
        function ocultarMensaje() {
            $('#mensajeResultado').hide();
        }

    });
</script>
