<div class="page-content-wrapper">
  <div class="page-content-wrapper-inner">
    <div class="viewport-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
          <li class="breadcrumb-item">
            <a href="#">INICIO</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">FORMULARIO</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><b>COTIZACION A CLIENTE</b></li>
        </ol>
      </nav>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo SERVERURL ?>clienteCot/"><b>REGISTRO</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL ?>clienteCotList/"><b>COTIZACIONES PENDIENTES</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo SERVERURL ?>clienteCotListAceptad/"><b>COTIZACIONES ACEPTADAS</b></a>
        </li>
      </ul>
    </div>
    <div class="content-viewport">
      <div class="row">

        <div class="col-lg-6 equel-gid">
          <div class="grid">
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Cliente y Proveedores</h5>
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

                          echo $lista->paginador_proveedor_controlador($pagina[1], 5, "clienteSeleccionarCot");
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

                <form action="<?php echo SERVERURL; ?>ajax/cotizacionClienteAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                  <p class="grid-header" style="color:#F28165;"><b>DATOS DE USUARIO</b></p>
                  <div id="campos">
                  </div>
                  
                  <input type="hidden" hidden="" name="registrar_cotizacion_cliente">


                  <p  class='grid-header'style="color:#F28165;"><b>PROYECTO</b></p>

                  <div class='form-group'>
                    <label>Numero de Requerimiento</label>
                    <input name="cod_cot" value="" type="text"   class="form-control" id="inputType1" placeholder="Ejemplo : 102903320">
                  </div>
                  <div class='form-group'>
                    <label>Tipo de Servicio</label>
                    <select name='unidad' class='custom-select'>
                      <option selected value='Unidad'>FABRICACION</option>
                      <option  value='Unidad'>MECANIZADO</option>
                      <option  value='Unidad'>ESTRUCTURA</option>
                    </select>
                  </div>
                  <div class='form-group'>
                    <label>Moneda</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="moneda" id="exampleRadios1" value="Soles" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        Soles
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="moneda" id="exampleRadios2" value="Dolares">
                      <label   class="form-check-label" for="exampleRadios2">
                        Dolares
                      </label>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label>IGV</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="igv_option" id="id_igv" onclick="option_igv(this.value);operacionCalamiento();" value="si" >
                      <label class="form-check-label" for="exampleRadios3">
                        Con IGV
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="igv_option" checked onclick="option_igv(this.value); operacionCalamiento();" value="no">
                      <label class="form-check-label" for="exampleRadios4">
                        Sin IGV
                      </label>
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <label for="inputEmail1">Cantidad de Productos</label>
                    <input name="cantidadInputs" type="text" onkeyup="crearCamposCliente(this.value);" class="form-control" id="inputType1" placeholder="ejemplo: 1">
                  </div>



                  <table class="col-12" id="detalleCotizacion">

                  </table>
                  <div class="row">
                  <div class="form-group col-4">
                    <label   style="color:#F28165;"  for="inputEmail1">Subtotal</label>
                    <input required   name="subtotal"  id="subtotal" type="text" class="form-control" id="inputType1" placeholder="Pre x Can">
                  </div>
                  <div id="mostrar_igv" class="form-group col-4">
                    <label   style="color:#F28165;"  for="inputEmail1">IGV</label>
                    <input required  name="igv" id="igv" type="text" class="form-control" id="inputType1" placeholder="18%">
                  </div>
                  <div class="form-group col-4">
                    <label   style="color:#F28165;"  for="inputEmail1">Total</label>
                    <input required  name="total" id="total" type="text" class="form-control" id="inputType1" placeholder="sub + igv">
                  </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEm1ail1">Nota</label>
                    <textarea required class="form-control" name="nota" id="inputType9" cols="12" rows="5">
CONDICIONES Y TERMINOS
- VALIDEZ DE LA OFERTA:
- LOS PRECIOS INCLUYEN EL IGV
- TIEMPO DE ENTREGA: 10 DIAS
- FORMA DE PAGO: CREDITO COMERCIAL 30 DIAS
- MONEDA: SOLES
                    </textarea>
                  </div>
                  <div class="d-flex justify-content-center">
                    <input type="submit"  name="enviarFormulario" id="enviarFormulario" hidden  class="btn btn-outline-primary btn-rounded" value="Registrar Cotización a  Cliente">
                    
                    <div onclick="enviardatos();" class="btn btn-primary btn-block mt-0">Realizar Cotización</div>
                   
                  </div>
                </form>
              </div>
              <br>
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
            "tipo": "cliente"
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
  <script>
  function enviardatos(){
  var bool = true;

  var descripcion = $("#id_persona").val();
                if (descripcion == '') {
                  bool = false;
                }
              

              if (bool != true) {
                $("#alerta").html('<div class="alert alert-warning" role="alert">Por favor, rellenar todos los campos</div>');

              } else {

                document.getElementById("alerta").style.display = "none";
                
               document.getElementById("enviarFormulario").click();
              }

            }
  </script>
  <script>

  function option_igv(value){
    if (value=="no") {
      
      document.getElementById("mostrar_igv").style.display = "none";
    }else{

      document.getElementById("mostrar_igv").style.display = "block";
    }
  }

  
  function operacionCalamiento(){
    
              var cantidad = $("input[name='cantidad\\[\\]']").map(function() {
                return $(this).val();
              }).get();
              var precio = $("input[name='precio\\[\\]']").map(function() {
                return $(this).val();
              }).get();

              var contador=0;
              var suma= 0;
              for (let j = 0; j < precio.length; j++) {
                
                    suma=suma+precio[j]*cantidad[j];
                    
              }


                   document.getElementById("subtotal").value = suma.toFixed(2);
                   
                  if (document.getElementById("id_igv").checked == true) {
          
          var valor= suma;
          var tasa=18;
          var igv=(valor*tasa)/100;
          var total=parseInt(valor+igv);
          document.getElementById("igv").value = igv.toFixed(2);
          document.getElementById("total").value = total.toFixed(2);
          }else{
            
          var valor= suma;
          var tasa=18;
          var igv=(valor*tasa)/100;
          var total=parseInt(valor+igv);
          document.getElementById("igv").value = 0;
          document.getElementById("total").value = valor.toFixed(2);
          }
  }
  </script>