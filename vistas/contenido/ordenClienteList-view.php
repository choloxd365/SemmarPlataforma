
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
                    <a class="nav-link active " href="<?php echo SERVERURL ?>ordenClienteList/">LISTA DE ORDENES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo SERVERURL ?>ordenClienteListEmerg/">ORDENES DE EMERGENCIAS</b></a>
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

            <div id="tablaresultado">
            </div>
            <div class="item-wrapper" id="tabla">


              <?php require_once './controladores/ordenClienteControlador.php';
              $lista = new ordenClienteControlador();


              $pagina = explode("/", $_GET['views']);

              echo $lista->paginador_orden_cliente_controlador($pagina[1], 10,"lista","");
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
          url: "<?php echo SERVERURL; ?>ajax/ordenCliente.php",
          method: "POST",
          data: {
            "busqueda": texto
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
  function actualizar_estado(id){
    var param = {
    id_orden: document.getElementById("id_orden").value,
    id_estado: id.value

    };
        $.ajax({
        url: "<?php echo SERVERURL; ?>ajax/ordenCliente.php",
        method: "POST",
        data: {
          "id_estado_up": param.id_estado,
          "id_orden":param.id_orden
        },
        success: function(respuesta) {
          $("#tablaresultado").attr("disabled", false);
          $("#tablaresultado").html(respuesta);
        },
        error: function(respuesta){
          print_r(respuesta);
        }
      
      })
  }
  </script>
  