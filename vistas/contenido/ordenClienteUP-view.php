<script>
    document.addEventListener("DOMContentLoaded", function() {
        tipo_cambio();
    });
</script>
<?php

$datos = explode("/", $_GET['views']);

require_once "./controladores/ordenClienteControlador.php";
$classDoc = new ordenClienteControlador();
$filesL = $classDoc->data_orden_cliente_controlador($datos[1]);
if ($filesL->rowCount() >= 1) {

  $campos = $filesL->fetch();

?>


  <div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="#">Inicio</a>
            </li>
            <li class="breadcrumb-item">
              <a href="#">Orden</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Actualizacion de Orden</li>
          </ol>
        </nav>

      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-lg-12">
            <div class="grid">
              <form action="<?php echo SERVERURL; ?>ajax/ordenCliente.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <input name="dataPersona" value="je " hidden=>
                <input name="id_ordencli_up" value="<?php echo $campos['id_ordencli'] ?>" hidden=>
                <p class="grid-header">Actualizacion de Orden</p>
                <div class="grid-body">
                  <div class="item-wrapper">
                    <div class="row mb-3">
                      <div class="col-md-8 mx-auto">
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType12"># Orden</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" name="id_orden_upp" hidden value="<?php echo $datos[1];?>">
                            <a class="btn btn-outline-primary btn-rounded" href="<?php echo SERVERURL ?>numeroOrdenUP/<?php echo $campos['id_ordencli'] ?>">Administrar numero de orden</a>
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType1">Tipo de Servicio</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            
                          <select name='tipo_servicio_up' class='custom-select'>
                          
                            <option selected value='<?php echo $campos['tipo_servicio'] ?>'><?php echo $campos['tipo_servicio'] ?></option>
                                            <option  value='Fabricación'>Fabricación</option>
                                            <option value='2'>...</option>
                                            <option value='3'>...</option>
                                        </select></div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail1">Estado</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                                        <select name='id_estado_upp' class='custom-select'>
                                            <?php
                                            $result = mainModel::ejecutar_consulta_simple("SELECT * FROM EstadoOrdenCliente ");
                                            $input='';
                                            foreach ($result as $key => $rows) {
                                              
                                                $input.= '<option ';
                                                if($campos["id_estado"]==$rows["id_estado"]){
                                                  $input.='selected';
                                                }
                                                $input.=' value="' . $rows["id_estado"] . '">' . $rows["nombre_estado"] . '</option>';
                                                
                                            } 
                                            echo $input; ?>
                                        </select>
                            </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType1">Numero de Guía</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" name="numero_guia_up" value="<?php echo $campos['numero_guia'] ?>" class="form-control"id="inputType1" placeholder="8637387654356">
                          </div>
                        </div>
                        
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType1">Sub Total</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" name="sub_total_up"  value="<?php echo $campos['subtotal_ordencli']; ?>" required="" class="form-control" id="inputType1" placeholder="Hayduk">
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType1">IGV</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" name="igv_up" value="<?php echo $campos['igv_ordencli']; ?>" required="" class="form-control" id="inputType1" placeholder="Hayduk">
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType1">Total</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" name="total_up" value="<?php echo $campos['total_ordencli']; ?>" required="" class="form-control" id="inputType1" placeholder="Hayduk">
                          </div>
                        </div>

                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType1">Moneda</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <div id="moneda_div" class="form-group col-md-6">
                              <div class="form-check">
                                <input class="form-check-input" name="moneda_up" <?php if($campos['moneda_ordencli']=="Soles"){echo'checked';} ?> onloadstart="" onclick="tipo_cambio();" type="radio"  id="tipo_cambio_soles_id" value="Soles" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                  Soles
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" name="moneda_up" <?php if($campos['moneda_ordencli']=="Dolares"){echo'checked';} ?> onclick="tipo_cambio();" type="radio"  id="tipo_cambio_dolares_id" value="Dolares">
                                <label class="form-check-label" for="exampleRadios2">
                                  Dolares
                                </label>
                              </div>
                            </div>
                            </div>
                            </div>
                            
                        <div class="form-group row showcase_row_area">
                          <div id="div_cambio_label" class="col-md-3 showcase_text_area">
                            <label for="inputType1">Tipo de cambio actual</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <div id="tipo-cambio" style="display: none;" class="form-group">
                              <?php
                              // Datos
                              $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
                              $ruc = '2021-06-23';

                              // Iniciar llamada a API
                              $curl = curl_init();

                              curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha=',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 2,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'GET',
                                CURLOPT_HTTPHEADER => array(
                                  'Referer: https://apis.net.pe/tipo-de-cambio-sunat-api',
                                  'Authorization: Bearer ' . $token
                                ),
                              ));

                              $response = curl_exec($curl);

                              curl_close($curl);
                              // Datos listos para usar
                              $data = json_decode($response, true);
                              $USD = $data['venta'];

                              ?>
                              <input type="text" name="tipo_cambio_up" class="form-control" value="1" id="input_tipo_cambio" <?php echo $campos['tipo_cambio_ordencli']?>  placeholder="Ingrese tipo de cambio en Soles">
                              
                            </div>
                          </div>
                        </div>
                        

                        <div class="d-flex justify-content-center">
                          <input type="submit" class="btn btn-outline-primary btn-rounded" value="Actualizar Proveedor">
              </form>
            </div>
            <div class="RespuestaAjax" id="RespuestaAjax">
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
  </div>
  </div>
  <script>
    function tipo_cambio() {
      if (document.getElementById("tipo_cambio_soles_id").checked == true) {

        document.getElementById("input_tipo_cambio").value = 1;
        document.getElementById("tipo-cambio").style.display = "none";
        document.getElementById("div_cambio_label").style.display = "none";


      } else {

        document.getElementById("div_cambio_label").style.display = "block";
        document.getElementById("tipo-cambio").style.display = "block";
        document.getElementById("input_tipo_cambio").value = <?php echo $USD; ?>;
      }
    }
  </script>
<?php  } else {

  echo "<h4>No se pudo recuperar los datos</h4>";
}
?>