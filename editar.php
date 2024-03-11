<?php

//Mostramos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['pagina'] = 'Editar Monedas - España';

include_once 'includes/header.php';

$idmoneda = $_GET['id'];

$sql = "SELECT * FROM monedas WHERE id = ".$idmoneda;
$query = mysqli_query($con,$sql) or die(mysqli_errno($con));
$total = mysqli_num_rows($query);
$row = mysqli_fetch_array($query);

?>

<div class="container">
    <div class="container mt-3 mb-3">

        <!-- Div para mostrar resultado de operaciones -->
        <div id="mensajeResultado" class="alert alert-success" style="display: none;"></div>

        <div class="container-fluid">
            <form role="form" class="form-inline" id="editarMonedaForm" enctype="multipart/form-data" method="post" action="update_moneda.php">
                <div class="row mb-3">
                    <div class="col col-md-6">
                        <div class="form-group row">
                            <div class="col col-md-9">
                                <label for="nombre">
                                    Moneda
                                </label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre'];?>" />
                            </div>
                            <div class="col col-md-3">
                                <label for="anno">
                                    Año
                                </label>
                                <input type="text" class="form-control text-center" name="anno" value="<?php echo $row['anno'];?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col col-md-12 mt-2 mb-3">
                                <label for="pais">
                                    País
                                </label>
                                <?php
                                    //Vamos a obtener la lista de países de la BB.DD.
                                    $sqlpaises = "SELECT * FROM paises ORDER BY nombre";
                                    $querypaises = mysqli_query($con,$sqlpaises) or die(mysqli_errno($con));

                                    //Vamos a generar un select para mostrar el pais
                                    echo '<select name="pais" id="pais" class="form-control select-pais">
                                            <option value="">SELECCIONE UN PAÍS</option>';
                                    while ($paises = mysqli_fetch_array($querypaises)){
                                        $banderaURL = 'common/public/images/paises/'.urlencode($paises['id']).'.png';
                                        if($paises['id'] == $row['pais']) {
                                            echo '<option value="'.$paises['id'].'" data-img-src="'.$banderaURL.'" selected>'.$paises['nombre'].'</option>';
                                        }else{
                                            echo '<option value="'.$paises['id'].'" data-img-src="'.$banderaURL.'">'.$paises['nombre'].'</option>';
                                        }
                                    }
                                    echo '</select>';
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col col-md-4">
                                <label for="valor">
                                    Valor
                                </label>
                                <input type="text" class="form-control" name="valor" value="<?php echo $row['valor'];?>" />
                            </div>
                            <div class="col col-md-4">
                                <label for="unidad">
                                    Divisa
                                </label>
                                <?php
                                    //Vamos a obtener los tipos de monedas de los países
                                    $sqldivisas = "SELECT * FROM paises";
                                    $querydivisas = mysqli_query($con,$sqldivisas) or die(mysqli_errno($con));

                                    //Vamos a generar el SELECT para mostrar y/o elegir la divisa
                                    echo '<select name="unidad" id="unidad" class="form-control">';
                                    while ($divisa = mysqli_fetch_array($querydivisas)){
                                        if($divisa['id']==$row['pais']) {
                                            echo '<option value="'.$divisa['id'].'" selected>'.$divisa['divisa'].'</option>';
                                        }else{
                                            echo '<option value="'.$divisa['id'].'">'.$divisa['divisa'].'</option>';
                                        }
                                    }
                                    echo '</select>';
                                ?>
                            </div>
                            <div class="col col-md-4">
                                <label for="cantidad">
                                    Cantidad
                                </label>
                                <input type="text" class="form-control" name="cantidad" value="<?php echo $row['cantidad'];?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col col-md-12">
                                <label for="motivo">
                                    Motivo
                                </label>
                                <input type="text" class="form-control" name="motivo" value="<?php echo $row['motivo'];?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col col-md-12">
                                <label for="estado">
                                    Estado
                                </label>
                                <?php
                                    //Vamos a obtener la lista de estados de conservación de la BB.DD.
                                    $sqlestados = "SELECT * FROM estado ORDER BY descripcion";
                                    $queryestados = mysqli_query($con,$sqlestados) or die(mysqli_errno($con));

                                    //Vamos a generar un select para mostrar el pais
                                    echo '<select name="estado" id="estado" class="form-control">
                                            <option value="">SELECCIONE UN ESTADO DE CONSERVACION</option>';
                                    while ($estado = mysqli_fetch_array($queryestados)){
                                        if($estado['id'] == $row['estado']) {
                                            echo '<option value="'.$estado['id'].'" selected>'.$estado['descripcion'].'</option>';
                                        }else{
                                            echo '<option value="'.$estado['id'].'">'.$estado['descripcion'].'</option>';
                                        }
                                    }
                                    echo '</select>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card form-group row">
                            
                            <label for="exampleInputFile">
                                Fotografía
                            </label>
                            <?php
                                $sqlfoto = "SELECT * FROM fotos WHERE id_moneda = ".$row['id'].";";
                                $queryfoto = mysqli_query($con,$sqlfoto) or die(mysqli_errno($con));
                                $foto = mysqli_fetch_array($queryfoto);
                                $totalfoto = mysqli_num_rows($queryfoto);
                                if($totalfoto > 0){
                                    //Hay foto de la moneda
                                    echo '<p align="center"><a href="common/public/images/monedas/'.$foto['foto'].'" target="_blank"><img src="common/public/images/monedas/'.$foto['foto'].'" style="width:300px;height:auto;"></a></p>';
                                }else{
                                    //No hay foto de la moneda
                                    echo '<p align="center"><a href="common/public/images/monedas.png" target="_blank"><img src="common/public/images/monedas.png" style="width:300px;height:auto;"></a></p>';
                                }
                            ?>
                            <input type="file" class="form-control-file mb-2" name="cargarfoto" id="cargarfoto"/>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card col col-md-12">
                        <label for="observaciones">
                            Observaciones
                        </label>
                        <textarea class="form-control mb-2" cols="150" rows="5" style="resize:none;" name="observaciones"><?php echo $row['observaciones'];?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" id="bt-Modificar">Modificar</button>
                <a href="nacionales.php" type="button" class="btn btn-danger">Cancelar</a>
                <input type="hidden" name="idmoneda" value="<?php echo $row['id'];?>">
            </form>
        </div>

    </div>
</div>

<?php include_once 'includes/footer.php';?>

<script>

$(document).ready(function() {

    //Select2 para el campo pais
    $('#pais').select2({
        templateResult: formatCountry,
        templateSelection: formatCountry,
        escapeMarkup: function(m) { return m; },
    });

    function formatCountry(country) {
        if (!country.id) { return country.text; }
        var $country = $(
            '<span><img class="img-flag" src="' + $(country.element).data('img-src') + '" style="width: 20px; height: 15px;" class="img-flag" /> ' + country.text + '</span>'
        );
        return $country;
    }

    // Agrega un evento de escucha para el formulario
    $('#editarMonedaForm').submit(function(e) {
        e.preventDefault(); // Evita que el formulario se envíe de forma convencional

        // Serializa los datos del formulario
        var formData = new FormData(this);

        // Realiza la solicitud AJAX
        $.ajax({
            type: 'POST',
            url: 'update_moneda.php', // Nombre del nuevo archivo PHP
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Espera una respuesta en formato JSON
            success: function(response) {
                // Maneja la respuesta del servidor (puede mostrar un mensaje de éxito, redirigir, etc.)
                if (response.estado === 'success') {
                    // Mostrar el mensaje de éxito
                    mostrarMensaje(response.mensaje);

                    // Ocultar el mensaje después de 1 segundo
                    setTimeout(function () {
                        ocultarMensaje();
                    }, 1000);

                    // Recargar la página después de un breve retraso
                    setTimeout(function () {
                        location.reload();

                        // Limpiar el campo de entrada de tipo file después de recargar la página
                        $('#cargarfoto').val('');
                    }, 1000);

                } else {
                    // Mostrar el mensaje de error
                    mostrarMensaje(response.mensaje);

                    // Manejar el error, mostrar un mensaje, etc.
                    console.error(response.message);

                }
            },
            error: function() {
                // Maneja errores de la solicitud AJAX
                $('#mensajeResultado').html('<strong>Error al enviar la solicitud.</strong>').removeClass('alert-success').addClass('alert-danger').show();

                // Ocultar el mensaje después de 1 segundo
                setTimeout(function () {
                    ocultarMensaje();
                }, 1000);
            }
        });
    });

    // Función para mostrar el mensaje en el div
    function mostrarMensaje(mensaje, clase = 'alert-success') {
        $('#mensajeResultado').removeClass().addClass('alert ' + clase).text(mensaje).show();
    }

    // Función para ocultar el mensaje en el div
    function ocultarMensaje() {
        $('#mensajeResultado').hide();
    }

    $('.select-pais').change(function() {
        var selectedPais = $(this).val();

        // Realiza una solicitud AJAX para obtener las divisas del país seleccionado
        $.ajax({
            type: 'POST',
            url: 'get_divisas_por_pais.php', // Reemplaza con el nombre correcto de tu archivo PHP
            data: { pais: selectedPais },
            dataType: 'json',
            success: function(response) {
                // Limpiar y actualizar el select de divisas
                $('#unidad').empty();
                $.each(response.divisas, function(index, divisa) {
                    $('#unidad').append('<option value="' + divisa.id + '">' + divisa.divisa + '</option>');
                });
            },
            error: function() {
                console.error('Error al obtener divisas por país.');
            }
        });
    });

});

</script>
