<?php

//Mostramos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['pagina'] = 'Monedas - Paises y Divisas';

include_once 'includes/header.php';

    // Modal Ver País
    echo'
    <div class="modal fade modal-md" id="paisModal" tabindex="-1" aria-labelledby="paisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header mb-2">
                    <h1 class="modal-title fs-5" id="paisModalLabel">PAÍSES Y DIVISAS</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-8 mb-2">
                            <label for="nombre">País: </label>
                            <span id="nombre"></span>
                        </div>
                        <div class="col col-4 mb-2">
                            <label for="bandera">Bandera: </label>
                            <span id="bandera"></span>
                        </div>
                        <div class="col col-8">
                            <label for="moneda">Moneda: </label>
                            <span id="moneda"></span>
                        </div>
                        <div class="col col-4">
                            <label for="iso">Código ISO: </label>
                            <span id="iso"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <!-- <a href="#" class="btn btn-primary btn-outline editar-estado" data-bs-toggle="modal" data-bs-target="#editarpaisModal" title="Editar estado">Editar</a> -->
                </div>
            </div>
        </div>
    </div>';

    //Fin del Modal

?>

<div class="container text-center">
        <div class="container mt-3 mb-3">

            <!-- Div para mostrar resultado de operaciones -->
            <div id="mensajeResultado" class="alert alert-success" style="display: none;"></div>

            <table id="tablapaises" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Bandera</th>
                        <th>Divisa</th>
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
        $('#tablapaises').DataTable({
            "ajax": {
                "url": "datos_paises.php",
                "dataSrc": ""
            },
            "lengthMenu": [[ 10, 25, 50, -1 ], [ 10, 25, 50, "Todos" ]], // Define las opciones de cantidad de registros por página
            "pageLength": 10, // Define la cantidad de registros por página por defecto
            "aaSorting": [[1, "asc"]],
            "language":	{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ países",
                "sZeroRecords":    "No se encontraron países",
                "sEmptyTable":     "Ningún país disponible en esta tabla",
                "sInfo":           "Mostrando estados del _START_ al _END_ de un total de _TOTAL_ países",
                "sInfoEmpty":      "Mostrando países del 0 al 0 de un total de 0 países",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ países)",
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
                        return '<a href="#" class="ver-pais" data-bs-toggle="modal" data-bs-target="#paisModal" data-id="' + row.id + '" title="Ver país">' + row.id + '</a>';                    
                    },
                },
                { "data": "nombre" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<img src="common/public/images/paises/' + row.bandera + '" title="' + row.nombre +'"></img>';
                    }
                },
                { "data": "divisa" },
                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-primary ver-pais" data-bs-toggle="modal" data-bs-target="#paisModal" data-id="' + row.id + '" title="Ver país"><i class="fas fa-eye"></i></a> <a href="#" class="btn btn-danger eliminar-pais" data-id="' + row.id + '" title="Eliminar pais"><i class="fas fa-trash"></i></a>';
                    }, 
                    "orderable": false, // Última columna no ordenable
                    "width": "100px" 
                }
            ]
        });

        $('#tablapaises').on('click','.ver-pais',function () {

            // Obtener el ID de la moneda desde el atributo data-id del botón
            var paisId = $(this).data('id');

            // Realizar la operación AJAX
            $.ajax({
                url: 'get_pais.php',
                method: 'POST',
                data: { id: paisId },
                dataType: 'json',
                success: function (response) {
                    $('#nombre').text(response.data[0].nombre);
                    $('#bandera').html('<img src="common/public/images/paises/'+response.data[0].bandera+'" title="'+response.data[0].nombre+'">');
                    $('#moneda').text(response.data[0].divisa);
                    $('#iso').text(response.data[0].codigo_iso);
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                    console.error(error);
                }
            });

        });

    });

</script>