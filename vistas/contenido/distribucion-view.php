<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    display: none;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>

<div class="page-content-wrapper">
  <div class="page-content-wrapper-inner">
    <div class="viewport-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
          <li class="breadcrumb-item">
            <a href="#">Inicio</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">Administracion</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Distribucion de Gastos</li>
        </ol>
      </nav>

      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL ?>ordenClienteList/">Listado de Ordenes de Clientes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active disabled" href="#" tabindex="-1" aria-disabled="true">Distribución</a>
        </li>
      </ul>
    </div>
    <div class="content-viewport">
      <div class="row">

        <div class="col-lg-6 equel-gid">
          <div class="grid">
            <?php
            $USD = 0;
            if (isset($_POST["id_ordenCliente"])) {
              $idOrden = $_POST["id_ordenCliente"];
              require_once "./controladores/ordenClienteControlador.php";
              $classDoc = new ordenClienteControlador();
              $filesL = $classDoc->data_orden_cliente_controlador($idOrden);
              if ($filesL->rowCount() >= 1) {

                $campos = $filesL->fetch();
                $id_orden = $campos["id_ordencli"];
                $total = $campos["total_ordencli"];
                $estado = $campos["id_estado"];
              }
            } elseif (isset($_SESSION['id_orden'])) {

              require_once "./controladores/ordenClienteControlador.php";
              $classDoc = new ordenClienteControlador();
              $filesL = $classDoc->data_orden_cliente_controlador($_SESSION['id_orden']);
              if ($filesL->rowCount() >= 1) {

                $campos = $filesL->fetch();
                $id_orden = $campos["id_ordencli"];
                $total = $campos["total_ordencli"];
                $estado = $campos["id_estado"];
              }
            } else {

              header('Location: ' . $SERVERURL . 'login');
            }

            ?>
            <p class="grid-header bg-primary"><b style="color: white;">
                SERVICIO:
                <?php
                $result = mainModel::ejecutar_consulta_simple("SELECT MAX(id_det_ordencli) FROM DetalleOrdenCliente where id_ordencli='$id_orden'");
                $row = $result->fetch();
                $ultimo_id = $row[0];

                $result2 = mainModel::ejecutar_consulta_simple("SELECT desc_det_ordencli FROM DetalleOrdenCliente where id_det_ordencli='$ultimo_id'");
                $row2 = $result2->fetch();
                echo $row2[0];
                ?>
                <br>
                MONTO: "<?php echo mainModel::moneyFormat($total, "USD"); ?>"
              </b></p>


            <div class="grid-body">
              <div class="item-wrapper">
                <form action="<?php echo SERVERURL; ?>ajax/distribucionAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                  <input type="text" name="id_orden" hidden value="<?php echo $id_orden; ?>">

                  <div class="row">
                    <div class="col-7 my-8">
                      <label for="inputEmail1">Descripcion</label>
                      <input type="text" class="form-control" name="descripcion-reg" id="inputEmail1" placeholder="Ingresa la descripcion del gasto">


                    </div>
                    <div style="padding-top: 30px;" class="col-5 my-1">
                      <div class="custom-control custom-checkbox mr-sm-2">
                        <input name="credito-reg" onchange="ocultar_div();" type="checkbox" class="custom-control-input" id="customControlAutosizing">
                        <label class="custom-control-label" for="customControlAutosizing">A Crédito</label>
                      </div>
                    </div>
                  </div>
                  <br>

                  <div class="form-group">
                    <label for="inputEmail1">Categoria</label>

                    <div class="col-md-12 showcase_content_area">
                      <select name="categoria-reg" class="custom-select">
                        <option>Materiales</option>
                        <option>Comida</option>
                        <option>...</option>
                        <option>...</option>
                      </select>
                    </div>
                  </div>
                  <div id="banco_div" class='form-group'>
                    <label for="inputEmail1">Banco - ir a <a href="<?php echo SERVERURL; ?>banco/">Bancos</a></label>
                    <?php
                    $resultado = mainModel::ejecutar_consulta_simple("SELECT * FROM CategoriaBanco  ca INNER JOIN Banco ba on ca.id_banco=ba.id_banco");
                    if ($resultado->rowCount() <= 1) {
                      echo '
                      <div class="alert alert-danger" role="alert">
                       Por favor, agregar un banco  <a href="' . SERVERURL . 'banco/" class="alert-link">AQUÍ</a> Gracias.
                      </div>';
                    } else {
                    }

                    ?>
                    <select name='id-cat_banco-reg' class='custom-select'>
                      <?php
                      $result = mainModel::ejecutar_consulta_simple("SELECT * FROM CategoriaBanco  ca INNER JOIN Banco ba on ca.id_banco=ba.id_banco");

                      foreach ($result as $key => $rows) {
                        $moneda = $rows["moneda_banco"];
                        if ($moneda == "Soles") {
                          $simbolo = 'S/';
                        } else {
                          $simbolo = '$ ';
                        }
                        echo '
                                                 <option onclick="cambio_dolar(' . $moneda . ')" value="' . $rows["id_cat_banco"] . '">' . $rows["nombre_banco"] . ' - ' . $rows["nombre_cate"] . ' (' . $simbolo . ' ' . $rows["monto_retirado"] . ')</option>';
                      }  ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail1">Precio</label>
                    <input type="number" class="form-control" name="precio-reg" id="inputEmail1" placeholder="Ingrese precio S/">
                  </div>
                  <div id="moneda_div" class='form-group'>
                    <label>Moneda</label>
                    <div class="form-check">
                      <input class="form-check-input" onclick="tipo_cambio();" type="radio" name="moneda-reg" id="tipo_cambio_soles_id" value="Soles" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        Soles
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" onclick="tipo_cambio();" type="radio" name="moneda-reg" id="tipo_cambio_dolares_id" value="Dolares">
                      <label class="form-check-label" for="exampleRadios2">
                        Dolares
                      </label>
                    </div>
                  </div>
                  <div id="tipo-cambio" style="display: none;" class="form-group">
                    <label for="inputEmail1">Tipo de cambio actual</label>
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
                    <input type="text" class="form-control" value="1" id="input_tipo_cambio" name="tipo-cambio-reg" placeholder="Ingrese tipo de cambio en Soles">
                  </div>
                  <input type="submit" class="btn btn-sm btn-primary" value="Guardar Gasto">
                </form>

                <div class="RespuestaAjax" id="RespuestaAjax">
                </div>
              </div>
            </div>
          </div>
          <div class="row" hidden>
            <p class="grid-header">Listado de Retiros
            <div style="padding-left: 265px; padding-top: 10px;"><button class="btn btn-outline-primary btn-rounded" type="button" onclick="addGasto();">+</button></div>
            </p>
          </div>

          <div class="col-lg-12 col-md-6 equel-grid" hidden>
            <div class="grid table-responsive">

              <table class="table table-stretched">

                <?php require_once './controladores/gastosControlador.php';
                $lista = new gastosControlador();



                echo $lista->lista_gastos_controlador(1, 100, $id_orden);
                ?>

              </table>


            </div>
          </div>


          <div class="col-lg-6 equel-gid">

            <p class="grid-header" style="background: #FFBAA8;"><b style="color: white;">GASTOS</b></p>

            <div class="input-group">
              <?php
              ?>
              <input autocomplete="off" type="text" onkeyup="obtenerBusqueda()" onkeydown="obtenerBusqueda()" onkeypress="obtenerBusqueda()" class="form-control" id="texto" name="texto" placeholder="Buscar por descripción o categorías">
            </div>

            <div class="col-lg-12 col-md-6 equel-grid">
              <div class="grid table-responsive">

                <table id="busqueda" class="table table-stretched">
                </table>
                <table id="original" class="table table-stretched">

                  <?php require_once './controladores/distribucionControlador.php';
                  $lista = new distribucionControlador();



                  echo $lista->lista_distribucion_controlador(1, 100, $id_orden, "");
                  ?>

                </table>

              </div>

              <div class="equel-gid">
                <?php

                if ($estado == 5) {
                ?>




                  <div class="card text-white bg-info mb-3" style="max-width: auto;">
                    <div class="card-header"><b>DISTRIBUCION DE UTILIDAD BRUTA</b></div>
                    <div class="card-body">

                      <form action="<?php echo SERVERURL; ?>ajax/distribucionAjax.php" method="POST" data-form="save" class="FormularioAjax needs-validation" autocomplete="off" enctype="multipart/form-data">

                        <?php
                        require_once "./core/mainModel.php";
                        $result2 = mainModel::ejecutar_consulta_simple("SELECT  precio_dis,tipo_cambio_dis  FROM DistribucionCostos dis 
                                                                    INNER JOIN CategoriaBanco cat ON dis.id_cat_banco=cat.id_cat_banco OR dis.id_cat_banco is null
                                                                     INNER JOIN Banco ba ON cat.id_banco=ba.id_banco
                                                                     WHERE dis.id_ordencli='$id_orden' group by dis.id_dis");

                        $sumaDistribucion = 0;
                        foreach ($result2 as $key => $data2) {
                          $sumaDistribucion = $sumaDistribucion + $data2["precio_dis"] * $data2["tipo_cambio_dis"];
                        }
                        $liquidez = 0;
                        $result3 = mainModel::ejecutar_consulta_simple("SELECT pago_efectivo_ordencli,moneda_pago_efectivo_ordencli,tipo_cambio_efectivo_ordencli,total_ordencli  FROM OrdenCliente WHERE id_ordencli='$id_orden' ");
                        $data = $result3->fetch();
                        $liquidez = ($data[0] * $data[2]) - $sumaDistribucion;
                        ?>

                        <b class="btn-success" style="color: white;">PAGO EFECTIVO</b> (<?php echo mainModel::moneyFormat($data[0], "USD")  . " " . $data[1]; ?>) - <b style="color: white; background:#FFA08F">SUB TOTAL</b> : <?php echo mainModel::moneyFormat($data['total_ordencli'], "USD") ?> = <?php echo  mainModel::moneyFormat($data[0] * $data[2] - $data['total_ordencli'], "USD") . '<br>'; ?>
                        <b class="btn-success" style="color: white;">PAGO EFECTIVO</b> (<?php echo mainModel::moneyFormat($data[0], "USD")  . " " . $data[1] ?>)
                        - <b style="color: white; background:#FFA08F">INVERSION</b> (<?php echo mainModel::moneyFormat($sumaDistribucion, "USD") ?>) = <?php echo mainModel::moneyFormat($liquidez, "USD") ?></p>
                        <br>
                        <ul class="list-group" style="color: black;">
                          <li class="list-group-item">
                            <div class="form-row">
                              <input name="id_orden_igv" hidden value="<?php echo $id_orden ?>">
                              <?php
                              require_once "./core/mainModel.php";
                              $contador = 0;
                              $result = mainModel::ejecutar_consulta_simple("SELECT  * FROM Transacciones tra INNER JOIN CategoriaBanco ca 
                                                                              ON tra.id_cat_banco=ca.id_cat_banco INNER JOIN Banco ba ON ca.id_banco=ca.id_banco
                                                                               WHERE id_ordencli='$id_orden' AND tipo_tra='PAGO' GROUP BY id_transacciones");

                              while ($row2 = $result->fetch()) {
                                $contador++;
                                $id_cat = $row2["id_cat_banco"];


                                $result3 = mainModel::ejecutar_consulta_simple("SELECT  SUM(dis.precio_dis) AS precio_dis FROM DistribucionCostos dis 
                                  INNER JOIN CategoriaBanco cat ON dis.id_cat_banco=cat.id_cat_banco
                                  INNER JOIN Banco ba ON cat.id_banco=ba.id_banco
                                  
                                    WHERE dis.id_ordencli='$id_orden' and cat.id_cat_banco='$id_cat' GROUP BY cat.id_cat_banco ");
                                while ($row3 = $result3->fetch()) {
                                  $diferencia = $row3["precio_dis"] - $row2["monto_tra"];
                                }
                                if ($diferencia > 0) {



                              ?>



                                  <div class="col-md-4 mb-3">
                                    <label style="color: red;" for="validationTooltip01">Cancelado(<?php echo $row2["monto_tra"] ?>)</label>
                                    <input type="number" value="<?php echo $diferencia ?>" name="monto_banco_retorno_igv[]" class="form-control" id="validationTooltip01" placeholder="S/0.00" required>
                                    <input name="id_orden_igv" hidden value="<?php echo $id_orden ?>">
                                  </div>
                                  <input name="cantidad_inputs" hidden value="<?php echo $contador; ?>" type="text" id="numero_inputs">
                                  <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Seleccionar IGV</label>
                                    <select name="id_banco_retorno_igv[]" class="custom-select">
                                      <?php
                                      require_once "./core/mainModel.php";
                                      $result2 = mainModel::ejecutar_consulta_simple("SELECT DISTINCT * FROM CategoriaBanco ca INNER JOIN Banco ba on ca.id_banco = ba.id_banco group by id_cat_banco");
                                      ?>
                                      <option selected value="<?php echo $row2["id_cat_banco"] ?>"><?php echo $row2["nombre_banco"] ?> - <?php echo $row2["nombre_cate"] ?> (<?php echo $row2["monto_actual"] ?>)</option>
                                      <?php
                                      while ($row = $result2->fetch()) {
                                      ?>
                                        <option value="<?php echo $row["id_cat_banco"] ?>"><?php echo $row["nombre_banco"] ?> - <?php echo $row["nombre_cate"] ?> (<?php echo $row["monto_actual"] ?>)</option>
                                      <?php
                                      }
                                      ?>
                                    </select>
                                  </div>
                              <?php
                                }
                              }

                              ?>


                            </div>

                            <div id="nuevoform">
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-7 showcase_text_area">
                                <label for="inputType12">Agregar Campos</label>
                              </div>
                              <div class="col-md-6 showcase_text_area">
                                <button class="btn btn-outline-primary btn-rounded" type="button" onclick="addCancion(<?php echo $contador ?>);">+</button>
                              </div>
                            </div>


                            <div class="alert alert-danger" role="alert">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" aria-describedby="basic-addon1" id="basic-addon1">Utilidad</span>
                                </div>
                                <input type="number" readonly class="form-control" value="<?php echo $liquidez ?>" id="monto_restante">
                              </div>
                            </div>
                            <button class="btn btn-primary" type="submit">FINALIZAR ORDEN</button>
                      </form>




                      </li>
                      </ul>
                    </div>
                  </div>
                <?php
                } elseif ($estado == 4) {

                ?>
                  <div class="card text-white bg-info  mb-3" style="max-width: 38rem;">
                    <div class="card-header"><b>RETORNO $ A BANCOS</b></div>
                    <div class="card-body">
                      <h5 class="card-title" style="color: white;">Los gastos realizados en esta orden serán regresados al banco </h5><br> Detalle de Pago en Efectivo:
                      <br>
                      <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action ">


                          Pago efectivo (<?php
                                          $result = mainModel::ejecutar_consulta_simple("SELECT pago_efectivo_ordencli,moneda_pago_efectivo_ordencli,tipo_cambio_efectivo_ordencli FROM ordenCliente where id_ordencli='$id_orden'");
                                          $pago = '';
                                          $moneda = '';
                                          $tipo_cambio = '';
                                          foreach ($result as $key => $rows5) {
                                            $pago = $rows5["pago_efectivo_ordencli"];
                                            $moneda = $rows5["moneda_pago_efectivo_ordencli"];
                                            $tipo_cambio = $rows5["tipo_cambio_efectivo_ordencli"];
                                          }
                                          echo $pago . ")<br> Moneda (" . $moneda . ")<br> Tipo de Cambio(" . $tipo_cambio . ")";  ?><br>

                        </button>

                        <?php


                        require_once "./core/mainModel.php";
                        $result = mainModel::ejecutar_consulta_simple("SELECT  cat.nombre_cate,cat.id_cat_banco, ba.nombre_banco, SUM(dis.precio_dis) AS precio_dis FROM DistribucionCostos dis 
                                                                  INNER JOIN CategoriaBanco cat ON dis.id_cat_banco=cat.id_cat_banco
                                                                   INNER JOIN Banco ba ON cat.id_banco=ba.id_banco
                                                                   
                                                                     WHERE dis.id_ordencli='$id_orden' GROUP BY id_cat_banco ");

                        echo '<br>
                        <form action="' . SERVERURL . 'ajax/bancoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                         <div class="form-row align-items-center">';
                        $contador = 0;
                        while ($row = $result->fetch()) {
                          $contador++;
                          echo ' 
                            
                          <div class="col-md-4 mb-3">
                              <div class="input-group-prepend">
                              <label for="validationTooltip01">' . $row["nombre_banco"] . '(' . $row["nombre_cate"] . ')</label>
                              </div>
                              <input type="text" name="monto_retorno[]" class="form-control" value="' . $row["precio_dis"] . '">
                            </div>
                          --->>
                            
                          <div class="col-md-6 mb-3">
                          
                          <label for="validationTooltip02">Seleccionar Banco</label>
                            <select name="id_categoria_retorno[]" class="btn btn-outline-light dropdown-toggle" id="inputState" class="form-control">
                              <option value="' . $row["id_cat_banco"] . '">' . $row["nombre_banco"] . ' (' . $row["nombre_cate"] . '</option>';


                          $resulta = mainModel::ejecutar_consulta_simple("SELECT  * FROM CategoriaBanco ca INNER JOIN Banco ba on ca.id_banco = ba.id_banco GROUP BY id_cat_banco");


                          foreach ($resulta as $key => $rows2) {


                            echo '<option value="' . $rows2["id_cat_banco"] . '">' . $rows2["nombre_banco"] . ' (' . $rows2["nombre_cate"] . ')</option>
                                  ';
                          }
                          echo ' </select>
                            </select>
                            
                          </div>
                          
                                            
                                                    ';
                        }
                        echo '
                                                  
                              <br>             
                              <br>
                              
                      <div id="nuevoform">
                      </div>
                      <div class="col-auto>
                        <div class="col-md-7 showcase_text_area">
                          <label for="inputType12">Agregar Campos</label>
                        </div>
                        <div class="col-md-6 showcase_text_area">
                          <button class="btn btn-outline-primary btn-rounded" type="button" onclick="agregarCampos(' . $contador . ');">+</button>
                        </div>
                      </div>
                            <div class="col-auto">
                            <input type="text" name="id_retorno_banco_cliente" hidden value="' . $id_orden . '">
                            <input type="text" name="contador" id="contadorCampos" hidden value="' . $contador . '">
                      
                              <button type="submit" class="btn btn-primary mb-2">Guardar</button>
                            </div>
                          </div>
                          
                          </form>

                      <div class="RespuestaAjax" id="RespuestaAjax">
                      </div>';
                        ?>
                      </div>


                    </div>
                  </div>
                <?php
                } elseif ($estado == 3) {

                ?>
                  <div class="card text-white bg-info  mb-3" style="max-width: 38rem;">
                    <div class="card-header">Pago Efectivo</div>
                    <div class="card-body">
                      <br>
                      <div class="list-group">

                        <form action="<?php echo SERVERURL; ?>ajax/ordenCliente.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                          <div class="form-group">
                            <label for="exampleInputEmail1">Monto Pagado</label>
                            <input type="number" name="monto_pago_efectivo" class="form-control" aria-describedby="emailHelp" placeholder="0.00">
                          </div>
                          <div class='form-group'>
                            <label>Moneda</label>
                            <div class="form-check">
                              <input class="form-check-input" onclick="tipo_cambio_efectivo();" type="radio" name="moneda-pago-efectivo-reg" id="efectivo_soles_id" value="Soles" checked>
                              <label class="form-check-label" for="exampleRadios1">
                                Soles
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" onclick="tipo_cambio_efectivo();" type="radio" name="moneda-pago-efectivo-reg" id="efectivo_dolares_id" value="Dolares">
                              <label class="form-check-label" for="exampleRadios2">
                                Dolares
                              </label>
                            </div>
                          </div>
                          <div id="tipo-cambio-efectivo" style="display: none;" class="form-group">
                            <label for="inputEmail1">Tipo de cambio actual</label>
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
                            <input type="text" class="form-control" value="1" id="input_tipo_cambio_efectivo" name="tipo-cambio-efectivo-reg" placeholder="Ingrese tipo de cambio en Soles">
                          </div>
                          <input type="text" name="id_orden_pagoefectivo" hidden value="<?php echo $id_orden; ?>">
                          <input type="submit" style="color: white;" class="btn btn-grid" value="Guardar Pago">
                        </form>

                        <div class="RespuestaAjax" id="RespuestaAjax">
                        </div>

                      </div>
                    </div>
                  <?php
                } elseif ($estado == 6 ||$estado == 7) {
                  ?>
                    <div class="card text-white bg-primary mb-3" style="max-width: 38rem;">
                      <div class="card-header">PAGOS</div>

                      <div class="text-center">
                        <div class="col"><label for="">Orden Finalizada </label></div>
                        <div class="col"><label class="switch">
                          
                            <input <?php $consulta4=mainModel::ejecutar_consulta_simple("SELECT id_estado FROM OrdenCliente WHERE id_ordencli='$id_orden'") ;
                                $filas4 = $consulta4->fetch();
                                if ($filas4["id_estado"]=='7') {
                                  echo'checked';
                                }?> onchange="finalizarOrden();" name="checkFinalizar" id="checkFinalizar" type="checkbox">
                            <span class="slider round"></span>
                          </label></div>

                      </div>
                      
                      <div id="respuestaAlerta" name="respuestaAlerta"></div>



                      <div class="card-body">
                        <div class="row">
                          <div class="col-9">
                            <h5 class="card-title" style="color: white;">PRECIO DE ORDEN DE COMPRA <?php echo mainModel::moneyFormat($total, "USD"); ?></h5>
                          </div>
                          <div class="col-3">Nuevo Pago
                            <div data-toggle="modal" data-target="#modalUltimoPago" class="btn btn-outline-light btn-rounded">+</div>

                          </div>
                        </div>
                        <br>
                        <div class="card border-primary mb-3" style="max-width: 40rem;">
                          <?php


                          require_once "./core/mainModel.php";
                          $consulta1 = mainModel::ejecutar_consulta_simple("SELECT total_ordencli,pago_efectivo_ordencli, moneda_pago_efectivo_ordencli,tipo_cambio_efectivo_ordencli,tipo_cambio_ordencli FROM OrdenCliente WHERE id_ordencli='$id_orden';");
                          while ($filas1 = $consulta1->fetch()) {


                          ?>
                            <div class="card-header" style="color: black;"><b>PAGO EFECTIVO (<?php echo $filas1["pago_efectivo_ordencli"] * $filas1["tipo_cambio_efectivo_ordencli"] . "</b> " . $filas1["moneda_pago_efectivo_ordencli"]; ?>)</b></div>
                            <div class="card-body text-dark">

                              <p class="card-text" style="color: black;">



                                <?php
                                $a_cuenta = ($filas1["total_ordencli"] * $filas1["tipo_cambio_ordencli"]) - $filas1["pago_efectivo_ordencli"];
                                if ($a_cuenta > 0) {
                                  echo " <div class='alert alert-warning' role='alert'> SALDO: <b>" . $a_cuenta . "</b> " . $filas1["moneda_pago_efectivo_ordencli"] . '</b></div>';
                                }

                                ?>





                              <?php
                            }
                              ?>
                              </p>
                            </div>
                            <div class="card-header" style="color: black;"><b>DETALLE DE INVERSION</b></div>
                            <div class="card-body text-dark">
                              <?php


                              require_once "./core/mainModel.php";
                              $consulta2 = mainModel::ejecutar_consulta_simple("SELECT  cat.nombre_cate,cat.id_cat_banco, ba.nombre_banco, SUM(dis.precio_dis) AS precio_dis FROM DistribucionCostos dis 
                                          INNER JOIN CategoriaBanco cat ON dis.id_cat_banco=cat.id_cat_banco
                                           INNER JOIN Banco ba ON cat.id_banco=ba.id_banco
                                           
                                             WHERE dis.id_ordencli='$id_orden' GROUP BY id_cat_banco ");
                              while ($filas2 = $consulta2->fetch()) {


                              ?>

                                <div class="alert alert-danger" role="alert">
                                  <p class="card-text" style="color: black;"><b><?php echo mainModel::moneyFormat($filas2["precio_dis"], "USD") ?></b> (<b><?php echo $filas2["nombre_banco"] ?> - <?php echo $filas2["nombre_cate"] ?></b>)</p>
                                </div>
                              <?php
                              }

                              ?>
                            </div>
                            <div class="card-header" style="color: black;"><b>RETORNO A BANCOS</b></div>
                            <div class="card-body text-dark">
                              <?php


                              require_once "./core/mainModel.php";
                              $consulta3 = mainModel::ejecutar_consulta_simple("SELECT  * FROM Transacciones tra INNER JOIN CategoriaBanco ca 
                            ON tra.id_cat_banco=ca.id_cat_banco INNER JOIN Banco ba ON ca.id_banco=ba.id_banco
                             WHERE id_ordencli='$id_orden' AND tipo_tra='PAGO' GROUP BY id_transacciones");

                              while ($filas3 = $consulta3->fetch()) {


                              ?>
                                <div class="alert alert-success" role="alert">

                                  <p class="card-text" style="color: black;"> <b><?php echo mainModel::moneyFormat($filas3["monto_tra"], "USD") ?></b> (<b><?php echo $filas3["nombre_banco"] ?> - <?php echo $filas3["nombre_cate"] ?></b>)</p>
                                </div>
                              <?php
                              }

                              ?>
                            </div>
                        </div>
                      </div>
                    </div>
                  <?php
                }
                  ?>
                  </div>

              </div>




            </div>
          </div>
        </div>

        <!-- Modal Agregar pago -->


        <div class="modal fade" id="modalUltimoPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Registrar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="content-viewport">
                <div class="row">
                  <div class="col-lg-12 equel-gid">
                    <div class="grid">
                      <div class="grid-body">
                        <div class="item-wrapper">
                          <form action="<?php echo SERVERURL; ?>ajax/distribucionAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                            <input name="id_orden_igv" hidden value="<?php echo $id_orden; ?>">
                            <div id="nuevoform"></div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-7 showcase_text_area">
                                <label for="inputType12">Agregar Campos</label>
                              </div>
                              <?php $contador = 0; ?>
                              <div id="nuevoform"></div>
                              <div class="col-md-6 showcase_text_area">
                                <button class="btn btn-outline-primary btn-rounded" type="button" onclick="addCancion();">+</button>
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Agegar Pago</button>
                          </form>
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
        </div>
        <!-- fin Modal -->








        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Actualización de Gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>


              <div id="datos"></div>



            </div>
          </div>
        </div>





        <!-- Modal Gastos -->
        <div class="modal fade" id="modalGastos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Añadir Retiro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>



              <form action="<?php echo SERVERURL; ?>ajax/gastosAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $id_orden ?>" name="id_orden_banco">
                <div class="modal-body">
                  <div class="form-row">
                    <div class="col-6">
                      <label class="mr-sm-2" for="inlineFormCustomSelect">Descripción de Gasto</label>
                      <input type="text" class="form-control" name="descripcion_gasto" value="" placeholder="Descripción">
                    </div>
                    <div class="col-6 showcase_content_area">
                      <label class="mr-sm-2" for="inlineFormCustomSelect">Cuenta</label>
                      <select name="id_banco" class="custom-select">


                        <?php
                        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM Banco ");

                        $inputsLlenos = '';

                        foreach ($result as $key => $rows) {

                          echo '<option value="' . $rows["id_banco"] . '">' . $rows["nombre_banco"] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-6">
                      <label class="mr-sm-2" for="inlineFormCustomSelect">Monto</label>
                      <input type="text" name="monto_gasto" class="form-control" value="" placeholder="0.00">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-inverse-success" value="Añadir">

                    <button type="button" id="cerrar" class="btn btn-inverse-dark" data-dismiss="modal">Salir</button>
                  </div>
                </div>
              </form>




            </div>
          </div>
        </div>
        <script>
          function enviarDatosDistribucion(id) {

            $.ajax({
              url: "<?php echo SERVERURL; ?>ajax/distribucionAjax.php",
              method: "POST",
              data: {
                "id_dis_up": id
              },
              success: function(respuesta) {
                $("#datos").attr("disabled", false);
                $("#datos").html(respuesta);
              }
            })
          }
        </script>
        <script>
          function calcularUtitilidadRestante() {

            var restante = <?php echo $liquidez ?>;
            var precio = $("input[name='monto_banco_retorno_igv\\[\\]']").map(function() {
              return parseInt($(this).val());
            }).get();

            var suma = 0;
            for (let j = 0; j < precio.length; j++) {

              suma = suma + precio[j];

            }
            suma = restante - suma;
            document.getElementById("monto_restante").value = suma;

          }
        </script>
        <script>
          function obtenerBusqueda() {
            var texto = $("#texto").val();
            if (texto == '') {


              document.getElementById("original").style.display = "block";
              document.getElementById("busqueda").style.display = "none";

            } else {
              document.getElementById("original").style.display = "none";
              document.getElementById("busqueda").style.display = "block";
              $.ajax({
                url: "<?php echo SERVERURL; ?>ajax/distribucionAjax.php",
                method: "POST",
                data: {
                  "busqueda": texto,
                  "id_orden_dis": '<?php echo $id_orden ?>'
                },
                success: function(respuesta) {
                  $("#busqueda").attr("disabled", false);
                  $("#busqueda").html(respuesta);
                }
              })
            }
          }

          function addGasto() {

            $('#modalGastos').modal('show');
          }

          function tipo_cambio() {
            if (document.getElementById("tipo_cambio_soles_id").checked == true) {

              document.getElementById("input_tipo_cambio").value = 0;
              document.getElementById("tipo-cambio").style.display = "none";

            } else {

              document.getElementById("tipo-cambio").style.display = "block";
              document.getElementById("input_tipo_cambio").value = <?php echo $USD; ?>;
            }
          }

          function tipo_cambio_efectivo() {
            if (document.getElementById("efectivo_soles_id").checked == true) {

              document.getElementById("input_tipo_cambio_efectivo").value = 0;
              document.getElementById("tipo-cambio-efectivo").style.display = "none";

            } else {

              document.getElementById("tipo-cambio-efectivo").style.display = "block";
              document.getElementById("input_tipo_cambio_efectivo").value = <?php echo $USD; ?>;
            }
          }

          function ocultar_div() {
            if (document.getElementById("customControlAutosizing").checked == true) {

              document.getElementById("banco_div").style.display = "none";

            } else {

              document.getElementById("banco_div").style.display = "block";
            }
          }
        </script>

        <script>
          a = <?php echo $contador; ?>;

          function addCancion() {

            a++;

            var div = document.createElement('div');
            div.innerHTML = '<div id="' + a + '" class="form-group row showcase_row_area"><div class="form-row"><div class="col-md-4 mb-3"><label for="validationTooltip01">Monto</label><input type="number" min="1" pattern="^[0-9]+" onkeyup="calcularUtitilidadRestante()" onkeydown="calcularUtitilidadRestante()" onkeypress="calcularUtitilidadRestante()"   name="monto_banco_retorno_igv[]" class="form-control" id="validationTooltip01" placeholder="S/0.00" required></div><div class="col-md-6 mb-3"><label for="validationTooltip02">Seleccionar IGV</label><select name="id_banco_retorno_igv[]" class="custom-select"><?php require_once "./core/mainModel.php";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      $result = mainModel::ejecutar_consulta_simple("SELECT DISTINCT * FROM CategoriaBanco ca INNER JOIN Banco ba on ca.id_banco = ba.id_banco group by id_cat_banco");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      while ($row = $result->fetch()) { ?><option value="<?php echo $row["id_cat_banco"] ?>"><?php echo $row["nombre_banco"] ?> (<?php echo $row["nombre_cate"]; ?>)</option><?php } ?></select></div><input hidden name="numero_inputs" value="'+a+'"> <input  name="cantidad_inputs" hidden value="' + a + '" type="text" id="numero_inputs"> <div class="col-2 mb-1"> <label for="validationTooltip01">Eliminar</label><button class="btn btn-outline-primary btn-rounded mdi mdi-delete" type="button"  onclick="eliminar(' + a + ')"></button></div></div></div>';
            document.getElementById('nuevoform').appendChild(div);

            document.getElementById("numero_inputs").value = a + 1;
          }

          function agregarCampos(cantidad) {
            a++;

            var div = document.createElement('div');
            div.innerHTML = '<div id="' + a + '" class="form-group row showcase_row_area"><div class="form-row"><div class="col-md-4 mb-3"><label for="validationTooltip01">Monto</label><input type="number"  name="monto_retorno[]" class="form-control" id="validationTooltip01" placeholder="S/0.00" required></div><div class="col-md-6 mb-3"><label for="validationTooltip02">Seleccionar IGV</label><select name="id_categoria_retorno[]" class="custom-select"><?php require_once "./core/mainModel.php";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $result = mainModel::ejecutar_consulta_simple("SELECT DISTINCT * FROM CategoriaBanco ca INNER JOIN Banco ba on ca.id_banco = ba.id_banco group by id_cat_banco");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        while ($row = $result->fetch()) { ?><option value="<?php echo $row["id_cat_banco"] ?>"><?php echo $row["nombre_banco"] ?> (<?php echo $row["nombre_cate"]; ?>)</option><?php } ?></select></div><div class="col-2 mb-1"> <label for="validationTooltip01">Eliminar</label><button class="btn btn-outline-primary btn-rounded mdi mdi-delete" type="button"  onclick="eliminar(' + a + ')"></button></div></div></div>';
            document.getElementById('nuevoform').appendChild(div);

            document.getElementById("contadorCampos").value = cantidad + 1;
          }
          let eliminar = function(n) {
            jQuery("div").remove(`#${n}`);
            a = a - 1;
            if (a <= 0) {
              a = 0;
            }
            document.getElementById("contadorCampos").value = cantidad - 1;
          }
        </script>

        <script>
          function finalizarOrden() {
            var id_estado_final=0;
            if ($('#checkFinalizar').prop('checked')) {
              id_estado_final=7;
            }else{
              id_estado_final=6;
            }

            var param = {
              id_orden: '<?php echo $id_orden ?>',
              id_estado:id_estado_final

            };
            $.ajax({
              url: "<?php echo SERVERURL; ?>ajax/ordenCliente.php",
              method: "POST",
              data: {
                "id_estado_up": param.id_estado,
                "id_orden": param.id_orden
              },
              success: function(respuesta) {
                $("#respuestaAlerta").attr("disabled", false);
                $("#respuestaAlerta").html(respuesta);
              },
              error: function(respuesta) {
                $("#respuestaAlerta").attr("disabled", false);
                $("#respuestaAlerta").html(respuesta);
              }

            })
          }
        </script>