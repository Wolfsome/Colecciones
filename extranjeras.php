<?php

//Mostramos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['pagina'] = 'Monedas - Extranjeras';

include_once 'includes/header.php';

//Vamos a obtener todas las monedas extranjeras
$sql= "SELECT * FROM monedas WHERE pais <> 'es';";
$query = mysqli_query($con,$sql) or die(mysqli_errno($con));
  
while ($row = mysqli_fetch_array($query)){

    $sqlestado = "SELECT * FROM estado WHERE id='".$row['estado']."';";
    $queryestado = mysqli_query($con,$sqlestado) or die(mysqli_errno($con));
    $estado = mysqli_fetch_array($queryestado);
    // Obtenemos los datos de la divisa para mostrar en el modal
    $sqlmoneda = "SELECT divisa FROM paises WHERE id='".$row['pais']."';";
    $querymoneda = mysqli_query($con,$sqlmoneda) or die(mysqli_errno($con));
    $moneda = mysqli_fetch_array($querymoneda);
    // Modal

    echo'
    <div class="modal fade modal-lg" id="monedaModal-'.$row['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mb-2">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">'.strtoupper($row['nombre']).'</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card modal-body mx-2 mb-2">
                    <div class="row">
                        <div class="col-lg-6 lg-light rounded" style="text-align:justify;">
                            <b>Nombre:</b> '.$row['nombre'].'
                            <br>
                            <b>Valor:</b> '.number_format($row['valor'], 1, ',', '.').' '.$moneda['divisa'].'
                            <br>
                            <b>Año:</b> '.$row['anno'].' 
                            <br>
                            <b>Estado:</b> '.$estado['descripcion'].'
                            <br>
                            <b>Motivo:</b> '.$row['motivo'].'
                            <br>
                            <b>Cantidad:</b> '.$row['cantidad'].'
                        </div>
                        <div class="col-lg-6 lg-light rounded" style="text-align:justify;">
                            <b>Observaciones:</b> '.$row['observaciones'].'
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 lg-light rounded text-center" style="text-align:justify;">';                            
                        $sqlcoin = "SELECT * FROM fotos WHERE id_moneda = ".$row['id'].";";
                        $querycoin = mysqli_query($con,$sqlcoin) or die(mysqli_errno($con));
                        $coin = mysqli_fetch_array($querycoin);

                        if(!isset($coin['foto'])){
                            echo '<img src="common/public/images/monedas/moneda.png" width="auto" height="100%">';
                        }else{
                            echo '<img src="common/public/images/monedas/'.$coin['foto'].'" width="auto" height="100%">';
                        }
                    echo '</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <a href="editar.php?id='.$row['id'].'&destino=Editar Monedas - Extranjeras" type="button" class="btn btn-primary">Editar</a>
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

            <table id="tablamonedas" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Moneda</th>
                        <th>Valor</th>
                        <th>Año</th>
                        <th>País</th>
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
        $('#tablamonedas').DataTable({
            "ajax": {
                "url": "datos_extranjeras.php",
                "dataSrc": ""
            },
            "lengthMenu": [[ 10, 25, 50, -1 ], [ 10, 25, 50, "Todos" ]], // Define las opciones de cantidad de registros por página
            "pageLength": 10, // Define la cantidad de registros por página por defecto
            "language":	{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ monedas",
                "sZeroRecords":    "No se encontraron monedas",
                "sEmptyTable":     "Ninguna moneda disponible en esta tabla",
                "sInfo":           "Mostrando monedas del _START_ al _END_ de un total de _TOTAL_ monedas",
                "sInfoEmpty":      "Mostrando monedas del 0 al 0 de un total de 0 monedas",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ monedas)",
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
                        return '<a href="#" class="ver-moneda" data-bs-toggle="modal" data-bs-target="#monedaModal-' + row.id + '" title="Ver moneda">' + row.id + '</a>';                    
                    },
                 },
                { "data": "nombre" },
                { "data": "valor",
                   "render": function (data, type, row) {
                        return row.valor + ' ' + row.divisa;
                   }
                },
                { "data": "anno" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<img src="common/public/images/paises/' + row.bandera + '" title="' + row.nombrepais + '">';                    
                    },
                },
                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-primary btn-outline ver-moneda" data-bs-toggle="modal" data-bs-target="#monedaModal-' + row.id + '" title="Ver moneda"><i class="fas fa-eye"></i></a> <a href="#" class="btn btn-danger btn-outline eliminar-moneda" data-id="' + row.id + '" title="Eliminar moneda"><i class="fas fa-trash"></i></a>';
                    }, 
                    "orderable": false, // Última columna no ordenable
                    "width": "100px" 
                }
            ]
        });

        // Agregamos el botón dentro del contenedor de búsqueda
        $('.dataTables_filter').append('<a href="nueva.php" class="btn btn-dark ms-2" title="Añadir nueva moneda"><i class="fas fa-plus"></i> Moneda</a>');

        // Manejar el clic en el botón "Ver moneda"
        $('#tablamonedas').on('click', '.ver-moneda', function () {
            // Obtener el ID de la moneda desde el atributo data-id del botón
            var monedaId = $(this).data('id');
            // Abrir el modal correspondiente
            $('#monedaModal-' + monedaId).modal('show');
        });

        // Manejar el clic en el botón "Eliminar moneda"
        $('#tablamonedas').on('click', '.eliminar-moneda', function (e) {
            e.preventDefault();

            // Obtener el ID de la moneda desde el atributo data-id del botón
            var monedaId = $(this).data('id');

            // Preguntar al usuario si realmente desea eliminar la moneda
            var confirmacion = window.confirm('¿Estás seguro de que deseas eliminar esta moneda?');

            if (confirmacion) {
                // Realizar la operación AJAX
                $.ajax({
                    url: 'eliminarmoneda.php',
                    method: 'POST',
                    data: { id: monedaId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Mostrar el mensaje de éxito
                            mostrarMensaje('Moneda eliminada correctamente');

                            // Ocultar el mensaje después de 1 segundo
                            setTimeout(function () {
                                ocultarMensaje();
                            }, 1000);

                            // Recargar la tabla
                            $('#tablamonedas').DataTable().ajax.reload();
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
