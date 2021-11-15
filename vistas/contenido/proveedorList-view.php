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
          <li class="breadcrumb-item active" aria-current="page"><b>LISTA DE PROVEEDOR</li>
        </ol>
      </nav>

      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL ?>proveedor/"><b>REGISTRO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo SERVERURL ?>proveedorList/"><b>LISTA</a>
        </li>
      </ul>
    </div>
    <div class="content-viewport">
      <div class="row">
        <div class="col-lg-12">
          <div class="grid">

            <div class="input-group">
              <input type="text" onkeyup="obtenerBusqueda()" onkeydown="obtenerBusqueda()" onkeypress="obtenerBusqueda()" class="form-control" id="texto" name="texto" placeholder="Search">
            </div>

            <div id="tablaresultado">
            </div>
            <div class="item-wrapper" id="tabla">


              <?php require_once './controladores/proveedorControlador.php';
              $lista = new proveedorControlador();


              $pagina = explode("/", $_GET['views']);

              echo $lista->paginador_proveedor_controlador($pagina[1], 10, "listarProveedor");
              ?>


            </div>
          </div>
        </div>

      </div>
    </div>
  </div>



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
            "listadoBusqueda": texto,
            "tipo": 2
          },
          success: function(respuesta) {
            $("#tablaresultado").attr("disabled", false);
            $("#tablaresultado").html(respuesta);
          }
        })
      }
    }
  </script>