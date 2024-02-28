<?php
  //Iniciamos la sesión
  session_start();

  //Usamos las funciones
  include_once('includes/funciones.php');

  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  
  //Comprobamos que nos envían un NIF para ver la inscripción
  if (!isset($_POST['dni'])) header('Location:index.php');

  //Llamamos al archivo para conectarnos a la base de datos
  //y comprobar si es un socio o no, o si está inscrito
  require_once('includes/conexion.php');

  $dni = $_POST['dni'];
  $dni = preg_replace("/[^0-9A-za-z]/", "", $dni);

  $socios="SELECT * FROM socios where (dni='".$dni."');";
  $resultado_socios = mysqli_query($con,$socios) or die($con);
  $datos_socio = mysqli_fetch_assoc($resultado_socios);
  $numero_socios = mysqli_num_rows($resultado_socios);

  //Definimos la variable para mostrar o no el botón del justificante
  $justificante='';

  //Realizamos al operación de inserción del ciclista en la BB.DD.
  if (isset($_POST['inscripcion']) && ($_POST['inscripcion']='Inscribirme')){
      
    //Búsqueda del último código para asignar el siguiente al nuevo inscrito
    $sql="SELECT MAX(codigo) AS maximo FROM crono ";
    $resultadomaximo = mysqli_query($con,$sql) or die($con);
    $row = mysqli_fetch_array($resultadomaximo);
    $codigo = $row['maximo'];
    if($codigo>0) {
      $maximo= $codigo + 1;
    }else {
      $maximo=1;
    }

    if(obtener_edad_segun_fecha($_POST['fecha_nacimiento']) > 17){

      $edad = obtener_edad_segun_fecha($_POST['fecha_nacimiento']);
      $categoria = obtener_categoria_segun_edad($edad);

      //Inserción en la BB.DD. del nuevo inscrito
      $inscripcion = "INSERT INTO crono (
        codigo,
        nombre,
        apellidos,
        dni,
        sexo,
        club,
        direccion,
        poblacion,
        codigopostal,
        provincia,
        telefono,
        fijo,
        email,
        pagado,
        fecha_nacimiento,
        categoria,
        bici,
        talla) 
      VALUES ('".$maximo."','".strtoupper(dropAccents($_POST['nombre']))."','".strtoupper(dropAccents($_POST['apellidos']))."','".strtoupper($dni)."','".$_POST['sexo']."','".strtoupper(dropAccents($_POST['club']))."','".strtoupper(dropAccents($_POST['direccion']))."','".strtoupper(dropAccents($_POST['poblacion']))."','".strtoupper($_POST['codigopostal'])."','".strtoupper(dropAccents($_POST['provincia']))."','".$_POST['movil']."','".$_POST['fijo']."','".strtolower($_POST['email'])."','0','".$_POST['fecha_nacimiento']."','".$categoria."','".$_POST['bici']."','".$_POST['talla']."')";
      $resultado_inscripcion = mysqli_query($con,$inscripcion) or die($con);

      $justificante='visible';

    }else{
      echo '<div class="alert alert-danger" role="alert">
              No es posible la inscripción de menores de edad
            </div>';
    }

    //Búsqueda para comprobar si existe ya una inscripcion con ese DNI
    $consulta = "SELECT * FROM crono WHERE dni='".$dni."';";
    $resultado = mysqli_query($con,$consulta) or die($con);
    $resultado_inscritos = mysqli_fetch_assoc($resultado);
    $total = mysqli_num_rows($resultado);
    
    if ($total>0) $justificante='visible';

  }

  include_once 'includes/header.php';
  
?>

          <div class="container">
            <div class="col-lg-12">

              <div class="row" style="text-align:justify;">
                <div class="col-lg-12 lg-light rounded" style="text-align:justify;">
                  <div class="col-lg-12 login-from-row" style="text-align:right;">
                    <a href="index.php">Salir <i class="fas fa-power-off"></i></a>
                  </div>

                  <form name="inscripcion" method="post" action="#" class="col-md-12 login-from-row">

                    <?php if ($numero_socios>0) { ?>

                      <div class="col-lg-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                        <span>Nombre y Apellidos:</span> <input type="text" size="10" name="nombre" class="outlinenone" placeholder="Nombre" value="<?php echo strtoupper($datos_socio['nombre']);?>" readonly> <input type="text" name="apellidos" size="15" class="outlinenone" placeholder="Apellidos" value="<?php echo strtoupper($datos_socio['apellidos']);?>" readonly>
                        <br>
                        <span>Doc. de Identidad:</span> <input type="text" size="10" name="dni" class="outlinenone" placeholder="Doc. de Identidad" value="<?php echo strtoupper($datos_socio['dni']);?>" readonly>
                        <br>
                        <span>Sexo:</span>
                        <?php if($justificante=='visible'){
                          if($resultado_inscritos['sexo']='M') {
                            echo 'MASCULINO';
                          }else{
                            echo 'FEMENINO';
                          }
                        }else{ ?>
                        <select name="sexo" required>
                          <option value="" selected>SELECCIONE SEXO</option>
                          <option value="F">FEMENINO</option>
                          <option value="M">MASCULINO</option>
                        </select>
                        <?php } ?>
                        <br>
                        <span>Club:</span> <input type="text" size="20" name="club" class="outlinenone" placeholder="Club" value="<?php echo 'C.D. CHANATA BIKE';?>" readonly>
                        <br>
                        <span>Dirección:</span> <input type="text" size="30" name="direccion" class="outlinenone" placeholder="Dirección del Participante" value="<?php echo strtoupper($datos_socio['direccion']);?>" required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Población:</span> <input type="text" size="20" name="poblacion" class="outlinenone" placeholder="Población" value="<?php echo strtoupper($datos_socio['poblacion']);?>" required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Código Postal:</span> <input type="text" size="10" name="codigopostal" class="outlinenone" placeholder="Código Postal" value="<?php echo $datos_socio['codigopostal'];?>" required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Provincia:</span> <input type="text" size="10" name="provincia" class="outlinenone" placeholder="Población" value="ALMERIA" required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Teléfonos:</span> <input type="text" size="8" name="movil" class="outlinenone" placeholder="Teléfono Móvil" value="<?php echo $datos_socio['movil'];?>" required <?php if($justificante=='visible') echo 'readonly' ?>> <input type="text" name="fijo" size="8" class="outlinenone" placeholder="Otro teléfono" value="<?php if(isset($datos_socio['fijo']) && ($datos_socio['fijo']<>'')) echo ' - '.$datos_socio['fijo']; ?>" <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Email:</span> <input type="text" name="email" class="outlinenone" placeholder="Correo electrónico" value="<?php echo strtolower($datos_socio['email']); ?>" required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Fecha de Nacimiento:</span> <input type="date" name="fecha_nacimiento" class="outlinenone" value="<?php echo $datos_socio['fecha_nacimiento'];?>" required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Tipo de Bicicleta:</span>
                        <?php if($justificante=='visible'){
                          if($resultado_inscritos['bici']='MTB') {
                            echo 'MTB';
                          }else{
                            echo 'E-BIKE';
                          }
                        }else{ ?>
                        <select name="bici" required>
                          <option value="" selected>SELECCIONA TIPO DE BICI</option>
                          <option value="MTB">MTB</option>
                          <option value="EBIKE">E-BIKE</option>
                        </select>
                        <?php } ?>
                        <br>
                        <span>Talla Camiseta:</span>
                        <?php if($justificante=='visible'){
                          echo $resultado_inscritos['talla'];
                        }else{ ?>
                        <select name="talla" required>
                          <option value="" selected>SELECCIONE TALLA</option>
                          <option value="S">S</option>
                          <option value="M">M</option>
                          <option value="L">L</option>
                          <option value="XL">XL</option>
                          <option value="XXL">XXL</option>
                        </select>
                        <?php } ?>
                        <br>
                      </div>
                      <br>

                    <?php 
                      }else{ 
                        //Búsqueda para comprobar si existe ya una inscripcion con ese DNI
                        $consulta = "SELECT * FROM crono WHERE dni='".$dni."';";
                        $resultado = mysqli_query($con,$consulta) or die($con);
                        $resultado_inscritos = mysqli_fetch_array($resultado);
                        $total = mysqli_num_rows($resultado);

                        if($total>0){
                    ?>

                      <div class="col-lg-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                        <span>Nombre y Apellidos:</span> <input type="text" size="10" name="nombre" class="outlinenone" placeholder="Nombre del Participante" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['nombre'].'"';?> required> <input type="text" name="apellidos" size="15" class="outlinenone" placeholder="Apellidos del Participante" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['apellidos'].'"';?> required>
                        <br>
                        <span>Doc. de Identidad:</span> <input type="text" size="10" name="dni" class="outlinenone" value="<?php echo strtoupper($dni);?>" placeholder="Doc. de Identidad" required>
                        <br>
                        <span>Sexo:</span>
                        <?php if($justificante=='visible'){
                          if($resultado_inscritos['sexo']='M') {
                            echo 'MASCULINO';
                          }else{
                            echo 'FEMENINO';
                          }
                        }else{ ?>
                        <select name="sexo" required>
                          <option value="" selected>SELECCIONE SEXO</option>
                          <option value="F">FEMENINO</option>
                          <option value="M">MASCULINO</option>
                        </select>
                        <?php } ?>
                        <br>
                        <span>Club:</span> <input type="text" size="20" name="club" class="outlinenone" placeholder="Club" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['club'].'"';?>>
                        <br>
                        <span>Dirección:</span> <input type="text" size="20" name="direccion" class="outlinenone" placeholder="Dirección del Participante" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['direccion'].'"';?> required>
                        <br>
                        <span>Población:</span> <input type="text" size="10" name="poblacion" class="outlinenone" placeholder="Población" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['poblacion'].'"';?> required>
                        <br>
                        <span>Código Postal:</span> <input type="text" size="10" name="codigopostal" class="outlinenone" placeholder="Código Postal" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['codigopostal'].'"';?> required>
                        <br>
                        <span>Provincia:</span> <input type="text" size="10" name="provincia" class="outlinenone" placeholder="Población" value="ALMERIA" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['provincia'].'"';?> required <?php if($justificante=='visible') echo 'readonly' ?>>
                        <br>
                        <span>Teléfonos:</span> <input type="text" size="8" name="movil" class="outlinenone" placeholder="Teléfono Móvil" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['telefono'].'"';?> required> <input type="text" name="fijo" size="8" class="outlinenone" placeholder="Otro teléfono" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['fijo'].'"';?>>
                        <br>
                        <span>Email:</span> <input type="text" name="email" class="outlinenone" placeholder="Correo electrónico" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['email'].'"';?> required>
                        <br>
                        <span>Fecha de Nacimiento:</span> <input type="date" name="fecha_nacimiento" class="outlinenone" <?php if($justificante=='visible') echo 'value="'.$resultado_inscritos['fecha_nacimiento'].'"';?> required>
                        <br>
                        <span>Tipo de Bicicleta:</span>
                        <?php if($justificante=='visible'){
                          if($resultado_inscritos['bici']='MTB') {
                            echo 'MTB';
                          }else{
                            echo 'E-BIKE';
                          }
                        }else{ ?>
                        <select name="bici" required>
                          <option value="" selected>SELECCIONA TIPO DE BICI</option>
                          <option value="MTB">MTB</option>
                          <option value="EBIKE">E-BIKE</option>
                        </select>
                        <?php } ?>
                        <br>
                        <span>Talla Camiseta:</span>
                        <?php if($justificante=='visible'){
                          echo $resultado_inscritos['talla'];
                        }else{ ?>
                        <select name="talla" required>
                          <option value="" selected>SELECCIONE TALLA</option>
                          <option value="S">S</option>
                          <option value="M">M</option>
                          <option value="L">L</option>
                          <option value="XL">XL</option>
                          <option value="XXL">XXL</option>
                        </select>
                        <?php } ?>
                        <br>
                      </div>
                      <br>

                    <?php 
                        }else{ ?>


                          <div class="col-lg-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                            <span>Nombre y Apellidos:</span> <input type="text" size="10" name="nombre" class="outlinenone" placeholder="Nombre del Participante" required> <input type="text" name="apellidos" size="15" class="outlinenone" placeholder="Apellidos del Participante" required>
                            <br>
                            <span>Doc. de Identidad:</span> <input type="text" size="10" name="dni" class="outlinenone" value="<?php echo strtoupper($dni);?>" placeholder="Doc. de Identidad" required>
                            <br>
                            <span>Sexo:</span>
                            <?php if($justificante=='visible'){
                              if($resultado_inscritos['sexo']='M') {
                                echo 'MASCULINO';
                              }else{
                                echo 'FEMENINO';
                              }
                            }else{ ?>
                            <select name="sexo" required>
                              <option value="" selected>SELECCIONE SEXO</option>
                              <option value="F">FEMENINO</option>
                              <option value="M">MASCULINO</option>
                            </select>
                            <?php } ?>
                            <br>
                            <span>Club:</span> <input type="text" size="20" name="club" class="outlinenone" placeholder="Club" >
                            <br>
                            <span>Dirección:</span> <input type="text" size="20" name="direccion" class="outlinenone" placeholder="Dirección del Participante" required>
                            <br>
                            <span>Población:</span> <input type="text" size="10" name="poblacion" class="outlinenone" placeholder="Población" required>
                            <br>
                            <span>Código Postal:</span> <input type="text" size="10" name="codigopostal" class="outlinenone" placeholder="Código Postal" required>
                            <br>
                            <span>Provincia:</span> <input type="text" size="10" name="provincia" class="outlinenone" placeholder="Población" value="ALMERIA" required <?php if($justificante=='visible') echo 'readonly' ?>>
                            <br>
                            <span>Teléfonos:</span> <input type="text" size="8" name="movil" class="outlinenone" placeholder="Teléfono Móvil" required> <input type="text" name="fijo" size="8" class="outlinenone" placeholder="Otro teléfono" >
                            <br>
                            <span>Email:</span> <input type="text" name="email" class="outlinenone" placeholder="Correo electrónico" required>
                            <br>
                            <span>Fecha de Nacimiento:</span> <input type="date" name="fecha_nacimiento" class="outlinenone" required>
                            <br>
                            <span>Tipo de Bicicleta:</span>
                            <?php if($justificante=='visible'){
                              if($resultado_inscritos['bici']='MTB') {
                                echo 'MTB';
                              }else{
                                echo 'E-BIKE';
                              }
                            }else{ ?>
                            <select name="bici" required>
                              <option value="" selected>SELECCIONA TIPO DE BICI</option>
                              <option value="MTB">MTB</option>
                              <option value="EBIKE">E-BIKE</option>
                            </select>
                            <?php } ?>
                            <br>
                            <span>Talla Camiseta:</span>
                            <?php if($justificante=='visible'){
                              echo $resultado_inscritos['talla'];
                            }else{ ?>
                            <select name="talla" required>
                              <option value="" selected>SELECCIONE TALLA</option>
                              <option value="S">S</option>
                              <option value="M">M</option>
                              <option value="L">L</option>
                              <option value="XL">XL</option>
                              <option value="XXL">XXL</option>
                            </select>
                            <?php } ?>
                            <br>
                          </div>
                          <br>

                    <?php }
                      } 

                      if($justificante=='visible') {
                        echo '<a href="justificante.php?dni='.$_POST['dni'].'" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Imprimir Justificante e Instrucciones de Pago</a>';
                        echo '<div class="col-lg-12 login-from-row" style="text-align:center;">
                                <div class="alert alert-primary" role="alert">Participante Inscrito</div>
                              </div>';
                      }else{
                        /* Inicio del Modal */ 
                        $reglamento = "1. Los participantes respetarán durante todo el recorrido el entorno por el que discurre la prueba, pudiendo ser expulsados de la misma por los organizadores en caso de arrojar desperdicios o basura.<br>
                        2. El recorrido de la prueba se realiza por una pista pública que permanecerá abierta al tráfico, por lo que todos deberemos respetar con rigurosidad las Leyes de Seguridad Vial y el Código de Circulación. La organización no se hace responsable de ninguna negligencia de los participantes por el incumplimiento de dichas leyes, que serán responsabilidad del infractor. Los participantes atenderán en todo momento las indicaciones de la organización.<br>
                        3. La prueba se dará por terminada en el punto de meta, establecida en la Balsa de la Chanata.<br>
                        4. Se establece un límite de participantes de 100, quedando asignadas las plazas en función del orden de pago.<br>
                        5. Se recuerda la obligatoriedad del uso del casco protector en todo momento.<br>
                        6. La organización se reserva el derecho de modificar cualquier aspecto de la prueba, con el fin de mantenerla en óptimas condiciones; e incluso suspenderla o posponerla por causas de fuerza mayor.<br>
                        7. Podrán participar todos aquellos ciclistas mayores de edad en posesión o no de la licencia federativa.<br>
                        8. Los tiempos de llegada serán tomados por personal propio de la organización y serán facilitados durante la comida posterior para la referencia de los participantes.<br>
                        9. La retirada de dorsales se hará entre las 9:00h y 9:45h antes de la salida en la Plaza de la Iglesia. La salida del primer participante será a las 10:15h. La hora prevista para la comida es las 14:00 h.<br>
                        10. El participante reconoce que para participar en la prueba debe de tener un buen estado físico, necesario para la actividad a realizar.<br>
                        11. Por medio del presente escrito y haciendo uso de mi derecho a no realizar un reconocimiento médico previo a la prueba, asumo las consecuencias que sobre mi salud puedan derivarse de mi participación, eximiendo al organizador de cualquier tipo de responsabilidad.<br>
                        12. El hecho de inscribirse supone la total aceptación del reglamento de la prueba. Todos los participantes deberán firmar este documento aceptando el reglamento y los posibles riesgos en la prueba.<br>
                        13. La aportación general de cada participante para cubrir parte de los gastos es de 25 Euros. Esta aportación da derecho al avituallamiento en la meta, a la comida de convivencia posterior y al regalo preparado al efecto.<br><br>
                        Todos los participantes se deben de considerar en excursión personal, respetando las normas de Tráfico vigentes, ya que la circulación no será cortada. La Organización no se responsabiliza de ningún accidente ocasionado por el incumplimiento de las recomendaciones de la prueba. Por medio del presente escrito y haciendo uso de mi derecho a no realizar un reconocimiento médico previo a la prueba, asumo las consecuencias que sobre mi salud puedan derivarse de mi participación, eximiendo al organizador de cualquier tipo de responsabilidad. Así mismo, por el mero hecho de realizar la inscripción acepto el reglamento de la misma.";

                        $pago = "La inscripción no queda realizada hasta la recepción del pago de 25 Euros, mediante ingreso bancario en la cuenta corriente del club ES36-3058-0129-3327-2001-7524. Habrá que indicar en el concepto 'DNI + Cronoescalada 2024'. Así mismo, se deberá comunicar a la organización mediante email adjuntando justificante de transferencia al email: info@chanatabike.com";
                         echo '
                              <div class="modal" id="myModal">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Reglamento Crono Escalada ChanataBike 2024 </h4>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <div class="row" style="text-align:justify;">
                                        <div class="row" style="text-align:justify;">
                                          <div class="col-md-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                                            <h3>FORMAS DE PAGO</h3>
                                          </div>
                                          <div class="col-md-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                                            '.$pago.'
                                          </div>                                          
                                          <div class="col-md-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                                            <h3>REGLAMENTO</h3>
                                          </div>
                                          <div class="col-md-12 bg-light rounded inscripcion-form-font-header" style="text-align:justify;">
                                            '.$reglamento.'
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                          /* Fin del Modal */
                      ?>

                    <div class="terms">
                      <input type="checkbox" name="terms" id="terms" onChange="enableSending()">
                      <label for="terms">He leído y acepto el <a href="#" data-bs-toggle="modal" data-bs-target="#myModal">reglamento de la Crono Escalada ChanataBike 2024</a></label>
                    </div>
                    <br>
                    <input name="inscripcion" id="inscripcion" value="Inscribirme" type="submit" class="btn btn-success btn-sm" disabled="">
                    <button name="cancelar" value="cancelar" type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i> Cancelar</button>

                    <!-- Script para activar el botón de inscribirse -->
                    <script type="text/javascript">
                      function enableSending(){
                        let btn = document.getElementById("inscripcion");
                        let checkbox = document.getElementById("terms");
                        btn.disabled = !checkbox.checked;
                      }
                    </script>
                    <!-- Fin del script para activar el botón de inscribirse -->

                    <?php } ?>

                  </form>
                  <br>

                  <?php include_once 'includes/footer.php' ?>