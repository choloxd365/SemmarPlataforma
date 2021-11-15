
         <div class="page-content-wrapper">
  <div class="page-content-wrapper-inner">
    <div class="viewport-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
          <li class="breadcrumb-item">
            <a href="#"><b>INICIO</b></a>
          </li>
          <li class="breadcrumb-item">
            <a href="#"><b>REGISTRO</b></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">ORDEN DE COMPRA A CLIENTE</li>
        </ol>
      </nav>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link  " href="<?php echo SERVERURL ?>ordenCliente/"><b>REGISTRO DE ORDEN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="<?php echo SERVERURL ?>ordenClienteList/">LISTA DE ORDENES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo SERVERURL ?>ordenClienteListEmerg/">ORDENES DE EMERGENCIAS</b></a>
        </li>
      </ul>
    </div>
    <div class="content-viewport">
      <div class="row">
        <div class="col-lg-12">
          <div class="grid">
            <p class="grid-header">Lista de Ordenes de compras</p>

            <div class="input-group">
              <input type="text" onkeyup="obtenerBusqueda()" onkeydown="obtenerBusqueda()" onkeypress="obtenerBusqueda()" class="form-control" id="texto" name="texto" placeholder="Search">
            </div>

            <br>
            <div class="btn btn-danger" onclick="juntarOrden();">UNIR ORDENES</div>

            <br>

            <br>
            <div id="resultado">
            </div>
            <div id="tablaresultado">
            </div>
            <div class="item-wrapper" id="tabla">


              <?php require_once './controladores/ordenClienteControlador.php';
              $lista = new ordenClienteControlador();


              $pagina = explode("/", $_GET['views']);

              echo $lista->paginador_orden_cliente_controlador($pagina[1], 20, "Emergente", "");
              ?>


            </div>


          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="grid-header">Detalle de Cotización</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div id="detalle_cotizacion"></div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->


  <!-- Modal -->
  <div class="modal fade" id="modalOrdenes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="grid-header">Union de Ordenes</p>
          <button type="button" onclick="eliminarCajaResumen();" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <form id="FormUnionOrdenes">

              <div id="ordenesApiladas" class="form-group col-md-12"></div>
            <div class="form-group col-md-6">
              <label for="inputEmail4" style="color:#F28165;"><b>TOTAL</b></label>
              <input type="number" readonly class="form-control" id="total_suma_orden" placeholder="0.00">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail1" style="color:#F28165;"><b>Seleccionar Cliente</b></label>
              <select name='id_persona_union_orden' class='custom-select'>
                <?php

                $result = mainModel::ejecutar_consulta_simple("SELECT * FROM Persona  WHERE id_tipo_persona='1'");

                foreach ($result as $key => $rows) {

                  echo '
                                                 <option value="' . $rows["id_persona"] . '">' . $rows["razon_social"] . '</option>';
                }  ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4" style="color:#F28165;"><b>DESCRIPCION DE ORD</b></label>
              <input type="text" name="desc_union_orden" class="form-control" id="inputEmail4" placeholder="Descripcion">
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4" style="color:#F28165;"><b>NRO. O/C</b></label>
              <input type="text" name="orden_union_orden" class="form-control" id="inputEmail4" placeholder="Descripcion">
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4" style="color:#F28165;"><b>NRO G/R</b></label>
              <input type="text" name="guia_union_orden" class="form-control" id="inputEmail4" placeholder="23423-234">
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4" style="color:#F28165;"><b>PRECIO</b></label>
              <input type="number" name="precio_union_orden" class="form-control" id="inputEmail4" placeholder="0.00">
            </div>

            <div id="moneda_div" class="form-group col-md-6">

              <label style="color:#F28165;"><b>Moneda</b></label>
              <div class="form-check">
                <input class="form-check-input" onclick="tipo_cambio();" type="radio" name="moneda_union_orden" id="tipo_cambio_soles_id" value="Soles" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Soles
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" onclick="tipo_cambio();" type="radio" name="moneda_union_orden" id="tipo_cambio_dolares_id" value="Dolares">
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
              <input type="text" class="form-control" value="1" id="input_tipo_cambio" name="tipo_cambio_union_orden" placeholder="Ingrese tipo de cambio en Soles">
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div id="btn-ingresar" onclick="enviarbb();" class="btn btn-primary">Guardar</div>
          </form>
          <div id="respuesta"></div>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="eliminarCajaResumen();" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->

  <script>
          function sumarTotalesOrdenes() {

            var precio = $("input[name='monto_orden_uni\\[\\]']").map(function() {
              return parseInt($(this).val());
            }).get();
            
            var suma = 0;
            for (let j = 0; j < precio.length; j++) {

              suma = suma + precio[j];

            }
            document.getElementById("total_suma_orden").value = suma;

      }

      function enviarbb() {


        var url = "../ajax/ordenCliente.php";
        $.ajax({
          type: "POST",
          url: url,
          data: $("#FormUnionOrdenes").serializeArray(),
          success: function(data) {
            alert('Exito al unir Ordenes');
            location.reload();
          }
        });

      }


      function obtenerBusqueda() {
        var texto = $("#texto").val();
        if (texto == '') {


          document.getElementById("tabla").style.display = "block";
          document.getElementById("tablaresultado").style.display = "none";

        } else {

          document.getElementById("tabla").style.display = "none";
          document.getElementById("tablaresultado").style.display = "block";
          $.ajax({
            url: "<?php echo SERVERURL; ?>ajax/ordenCliente.php",
            method: "POST",
            data: {
              "buscar": texto,
              "tipo": 'busquedaEmergente'
            },
            success: function(respuesta) {
              $("#tablaresultado").attr("disabled", false);
              $("#tablaresultado").html(respuesta);
            }
          })
        }
      }
  </script>
  <script>
    function actualizar_estado(id) {
      var param = {
        id_orden: document.getElementById("id_orden").value,
        id_estado: id.value

      };
      $.ajax({
        url: "<?php echo SERVERURL; ?>ajax/ordenCliente.php",
        method: "POST",
        data: {
          "id_estado_up": param.id_estado,
          "id_orden": param.id_orden
        },
        success: function(respuesta) {
          $("#tablaresultado").attr("disabled", false);
          $("#tablaresultado").html(respuesta);
        },
        error: function(respuesta) {
          print_r(respuesta);
        }

      })
    }
  </script>
  <script type="text/javascript">
    a = 0;

    function juntarOrden() {

      var arrTodo = new Array();
      var id_orden = $("input:checkbox:checked").map(function() {
        return $(this).val();
      }).get();

      for (let index = 0; index < id_orden.length; index++) {

        var item = {};
        item = id_orden[index];

        arrTodo.push(item);

      }
      var toPost = JSON.stringify(arrTodo);
      console.log(toPost);
      var url = "../ajax/ordenClienteService.php";


      $.ajax({
          type: 'POST',
          url: url,
          data: {
            json: toPost
          },
          dataType: 'json'
        })
        .done(function(data) {

          var div = document.createElement('div');
          div.innerHTML = data;
          $("#ordenesApiladas").empty();
          document.getElementById('ordenesApiladas').appendChild(div);
          console.log('done');
          console.log(data);
        })
        .fail(function(data) {
          var div = document.createElement('div');
          div.innerHTML = data.responseText;
          $("#ordenesApiladas").empty();
          document.getElementById('ordenesApiladas').appendChild(div);
          console.log('done');
          console.log(data);
        });


      $("#modalOrdenes").modal("show");

    }


    function eliminarCajaResumen() {
      //Si existe la caja o el div...
      var div = document.getElementById('ordenesApiladas');
      if (div !== null) {
        while (div.hasChildNodes()) {
          div.removeChild(div.lastChild);
        }
      } else {
        alert("No existe la caja previamente creada.");
      }
    }
  </script>
  <script>
    let eliminar = function(n) {
      jQuery("section").remove(`#${n}`);
      a = a - 1;
      if (a <= 0) {
        a = 0;
      }
    }


    function tipo_cambio() {
      if (document.getElementById("tipo_cambio_soles_id").checked == true) {

        document.getElementById("input_tipo_cambio").value = 1;
        document.getElementById("tipo-cambio").style.display = "none";

      } else {

        document.getElementById("tipo-cambio").style.display = "block";
        document.getElementById("input_tipo_cambio").value = <?php echo $USD; ?>;
      }
    }
  </script>
  <script>

  </script>