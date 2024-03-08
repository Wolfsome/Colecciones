<?php

//Mostramos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['pagina'] = 'Monedas - España';

include_once 'includes/header.php';

//Vamos a obtener todas las monedas de España
$sql= "SELECT * FROM monedas WHERE pais = 'es';";
$query = mysqli_query($con,$sql) or die(mysqli_errno($con));
  
while ($row = mysqli_fetch_array($query)){

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
                            <b>Valor:</b> '.$row['valor'].' '.$row['unidad'].'
                            <br>
                            <b>Año:</b> '.$row['anno'].' 
                            <br>
                            <b>Estado:</b> '.$row['estado'].'
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
                    <a href="editar.php?id='.$row['id'].'" type="button" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>';

    //Fin del Modal
    
}

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
                "url": "datos_nacionales.php",
                "dataSrc": ""
            },
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
                { "data": "valor" },
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
                        return '<a href="#" class="btn btn-primary btn-outline ver-moneda" data-bs-toggle="modal" data-bs-target="#monedaModal-' + row.id + '" title="Ver moneda"><i class="fas fa-eye"></i></a> <a href="eliminarmoneda.php?id=" class="btn btn-danger btn-outline" title="Eliminar moneda"><i class="fas fa-trash"></i></a>';
                    }, 
                    "orderable": false, // Última columna no ordenable
                    "width": "100px" 
                }
            ]
        });

        // Manejar el clic en el botón "Ver moneda"
        $('#tablamonedas').on('click', '.ver-moneda', function () {
            // Obtener el ID de la moneda desde el atributo data-id del botón
            var monedaId = $(this).data('id');
            // Abrir el modal correspondiente
            $('#monedaModal-' + monedaId).modal('show');
        });

    });
</script>
