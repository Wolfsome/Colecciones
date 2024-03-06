<?php

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $_SESSION['pagina'] = 'Monedas - España';

  include_once 'includes/header.php';
  
?>

    <div class="container text-center">
        <div class="container mt-3 mb-3">

            <table id="tablamonedas" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Moneda</th>
                        <th>Valor</th>
                        <th>Año</th>
                        <th>País</th>
                        <th></th>
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

        // Inicializa el DataTable y guárdalo en una variable
        var tablaMonedas = $('#tablamonedas').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todas"]],
            "language": {
                "sLengthMenu":"Mostrar _MENU_ monedas",
                "sInfo":"Mostrando monedas desde la _START_ al _END_ de un total de _TOTAL_ monedas",
                "sInfoEmpty":"No hay monedas",
                "sSearch":"Buscar:",
                "sInfoFiltered":"(filtrado de un total de _MAX_ monedas)",
                "sZeroRecords":"No se encontraron monedas",
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
            "columnDefs":[
                { "orderable": true, "targets": 0 },
                { "orderable": true, "targets": 1 },
                { "orderable": true, "targets": 2 },
                { "orderable": true, "targets": 3 },
                { "orderable": false, "targets": 4 },
                { "orderable": false, "targets": 5 }
            ],
            "order":[
                [0,'asc']
            ]
        });

        $.ajax({
            url: 'datos_nacionales.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){

                // Destruye la instancia actual del DataTable
                tablaMonedas.destroy();

                // Limpia el cuerpo de la tabla
                $('#tablamonedas tbody').empty();
            
                // Itera sobre los datos y agrega filas a la tabla
                $.each(data, function(index, item){
                        $('#tablamonedas tbody').append('<tr>'+
                            '<td><a href="vermoneda.php?id='+item.id+'">' + item.id + '</a></td>' +
                            '<td>' + item.nombre + '</td>' +
                            '<td>' + item.valor + '</td>' +
                            '<td>' + item.anno + '</td>' +
                            '<td><img title="' + item.nombrepais + '" src="common/public/images/' + item.bandera + '"></td>' +
                            '<td><a href="vermoneda.php?id='+item.id+'" class="btn btn-outline btn-success"><i class="fas fa-eye"></a></td>' +
                            '<td><a href="borrarmoneda.php?id='+item.id+'" class="btn btn-outline btn-danger"><i class="fas fa-trash"></a></td>' +
                        '</tr>');
                });

                tablaMonedas = $('#tablamonedas').DataTable({
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todas"]],
                    "language": {
                        "sLengthMenu":"Mostrar _MENU_ monedas",
                        "sInfo":"Mostrando monedas desde la _START_ al _END_ de un total de _TOTAL_ monedas",
                        "sInfoEmpty":"No hay monedas",
                        "sSearch":"Buscar:",
                        "sInfoFiltered":"(filtrado de un total de _MAX_ monedas)",
                        "sZeroRecords":"No se encontraron monedas",
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
                    "columnDefs":[
                        { "orderable": true, "targets": 0 },
                        { "orderable": true, "targets": 1 },
                        { "orderable": true, "targets": 2 },
                        { "orderable": true, "targets": 3 },
                        { "orderable": false, "targets": 4 },
                        { "orderable": false, "targets": 5 }
                    ],
                    "order":[
                        [0,'asc']
                    ]
                });
            
            },
            
            error: function(){
                // Si hay un error en la solicitud, maneja el error aquí
                console.error('Error al cargar los datos');
            }
            
        });
    });

</script>