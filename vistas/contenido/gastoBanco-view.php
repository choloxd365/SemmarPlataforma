<div class="page-content-wrapper">
  <div class="page-content-wrapper-inner">
    <div class="viewport-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
          <li class="breadcrumb-item">
            <a href="#">Inicio</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">Listas</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Gastos de Banco</li>
        </ol>
      </nav>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link  " href="<?php echo SERVERURL ?>gastoBanco/">Listado</a>
                </li>
            </ul>

    </div>
    <div class="content-viewport">
      <div class="row">
        <div class="col-lg-12">
          <div class="grid">
            <p class="grid-header">Lista de Retiros</p>

            <div class="input-group">
              <input type="text" onkeyup="obtenerBusqueda()" onkeydown="obtenerBusqueda()" onkeypress="obtenerBusqueda()" class="form-control" id="texto" name="texto" placeholder="Buscar por NRO Orden, Por banco">
            </div>

            <div id="tablaresultado">
            </div>
            <div class="item-wrapper" id="tabla">


              <?php require_once './controladores/bancoControlador.php';
              $lista = new bancoControlador();


              $pagina = explode("/", $_GET['views']);

              echo $lista->paginador_orden_banco_controlador($pagina[1], 100,"");
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
          url: "<?php echo SERVERURL; ?>ajax/bancoAjax.php",
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