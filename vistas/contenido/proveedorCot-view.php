<div class="page-content-wrapper">
  <div class="page-content-wrapper-inner">
    <div class="viewport-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
          <li class="breadcrumb-item">
            <a href="#">INICIO</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">PROVEEDOR</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><b>REGISTRO DE PROVEEDOR A PROVEEDOR</li>
        </ol>
      </nav>

      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo SERVERURL ?>proveedorCot/">REGISTRO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL ?>proveedorCotList/">COTIZACIONES PENDIENTES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo SERVERURL ?>cotAceptada/">COTIZACIONES ACEPTADAS</a>
        </li>
      </ul>
    </div>





    <div class="content-viewport">
      <div class="row">

        <div class="col-lg-6 equel-gid">
          <div class="grid">
            <p class="grid-header" style="color:#F28165;"><b>SELECCIONAR PROVEEDOR</b></p>
            <div class="grid-body">
              <div class="item-wrapper">
                <div class="form-group">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Buscar 
                  </button>
                </div>




                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Seleccionar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="input-group">
                          <input type="text" autocomplete="off" onkeyup="obtenerBusqueda()" onkeydown="obtenerBusqueda()" onkeypress="obtenerBusqueda()" class="form-control" id="texto" name="texto" placeholder="Search">

                        </div>

                        <div id="tablaresultado">

                        </div>
                        <div class="item-wrapper" id="tabla">


                          <?php require_once './controladores/proveedorControlador.php';
                          $lista = new proveedorControlador();


                          $pagina = explode("/", $_GET['views']);

                          echo $lista->paginador_proveedor_controlador($pagina[1], 5, "proveedorSeleccionarCot");
                          ?>


                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="cerrar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                      </div>
                    </div>
                  </div>
                </div>



                <div class="form-group"> </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 equel-grid">
          <div class="grid">
            <div class="grid-body">
              <div class="item-wrapper">

                <form action="<?php echo SERVERURL; ?>ajax/cotizacionAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                <p class="grid-header" style="color:#F28165;"><b>DATOS DEL PROVEEDOR</p>
                <div id="campos">
                </div>
            <p class="grid-header" style="color:#F28165;"><b>DATOS DE COTIZACION</p>
                  <div class="form-group">
                    <label for="inputEmail1">Nro. Cotizacion</label>
                    <input name="cod_cot" value="<?php
                                  
                      $consulta = mainModel::ejecutar_consulta_simple("SELECT id_cotizacion FROM cotizacion ");
                      //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
                      $numero = ($consulta->rowCount()) + 1;

                      //generar codigo para cada cuenta
                      $codigo = mainModel::generar_codigo_aleatorio("", 7, $numero);
                      echo $codigo
                      
                    ?>" type="text" readonly class="form-control" id="inputType1" placeholder="Proyecto de Cilindros">
                  </div>
                <div class="form-group">
                    <label for="inputEmail1">Nombre de Cotización</label>
                    <input name="nombreCot" type="text" class="form-control" id="inputType1" placeholder="Proyecto de Cilindros">
                  </div>
                  <div class="form-group">
                    <label for="inputEmail1">Cantidad de Productos</label>
                    <input name="cantidadInputs" type="text" onkeyup="crearCampos(this.value);" class="form-control" id="inputType1" placeholder="ejemplo: 1">
                  </div>



                  <input type="hidden" hidden="" name="registrar_cotizacion">

                  <input type="hidden" hidden="" name="id_per" class="form-control" id="id_persona">

                  <table class="col-12" id="tablaUsuarios">

                  </table>

                  <div class="form-group">
                    <label for="inputEm1ail1">Nota</label>
                    <textarea class="form-control" name="nota" id="inputType9" cols="12" rows="5">
- TIEMPO DE ENTREGA: 10 DIAS
- FORMA DE PAGO: CREDITO COMERCIAL 30 DIAS
- MONEDA: DOLARES


                    </textarea>
                  </div>
                  <div class="d-flex justify-content-center">
                    <input type="submit" class="btn btn-outline-primary btn-rounded" value="Registrar Cotización a  Proveedor">
                </form>
              </div>
              <div class="RespuestaAjax" id="RespuestaAjax">
              </div>
          <div id="alerta">
          </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  


  <script type="text/javascript">
    function EnviarDatosProveedor(datos) {

      $('#id_persona').val(datos);

      $('#cerrar').click();

    }

    $(document).ready(function() {
      $('#cerrar').click();
    })
  </script>
  <script>
    function obtenerBusqueda() {
      var texto = $("#texto").val();
      if (texto == '') {


        document.getElementById("tabla").style.display = "block";
        document.getElementById("tablaresultado").style.display = "none";

      } else {

        document.getElementById("tabla").style.display = "none";
        document.getElementById("tablaresultado").style.display = "block";
        $.ajax({
          url: "<?php echo SERVERURL; ?>ajax/proveedorAjax.php",
          method: "POST",
          data: {
            "textoBusqueda": texto,
            "tipo":"proveedor"
          },
          success: function(respuesta) {
            $("#tablaresultado").attr("disabled", false);
            $("#tablaresultado").html(respuesta);
          }
        })
      }
    }

    function crearDatosProveedor(id) {
      $.ajax({
        url: "<?php echo SERVERURL; ?>ajax/proveedorAjax.php",
        method: "POST",
        data: {
          "id_persona_cot": id
        },
        success: function(respuesta) {
          $("#campos").attr("disabled", false);
          $("#campos").html(respuesta);
        }
      })
    }
  </script>
  <script>
    $(function() {
      $('#myTab li:last-child a').tab('show')
    })
  </script>
  