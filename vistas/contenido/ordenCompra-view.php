<?php $id_persona = "";
?>
<div class="page-content-wrapper">
  <div class="page-content-wrapper-inner">
    <div class="viewport-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
          <li class="breadcrumb-item">
            <a href="#">INICIO</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">LISTA</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><b>ORDEN DE COMPRA A PROVEEDORES</b></li>
        </ol>
      </nav>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active " href="<?php echo SERVERURL ?>ordenCompra/"><b>REGISTRO DE ORDEN</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL ?>ordenProveeList/">LISTA DE ORDENES</a>
        </li>
      </ul>

    </div>
    <div class="content-viewport">
      <div class="row">

        <div class="col-lg-6 equel-gid">
          <div class="grid">
            <p class="grid-header">SELECCIONAR PROVEEDOR</p>
            <div class="grid-body">
              <div class="item-wrapper">
                <div class="form-group">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Buscar Proveedor
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

                          echo $lista->paginador_proveedor_controlador($pagina[1], 5, "proveedorOrden");
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

          <form action="<?php echo SERVERURL; ?>ajax/ordenAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

            <p class="grid-header"style="color:#F28165;"><b>DATOS DE USUARIO</p>
            <div id="campos">
              <?php if (isset($_POST["id_persona"])) {

                $id = $_POST["id_persona"];
                $id_persona = $_POST["id_persona"];
                $cod_cot = $_POST["cod_cot"];


                $result = mainModel::ejecutar_consulta_simple("SELECT * FROM persona WHERE id_persona='$id' ");
                while ($row = $result->fetch()) {
                  echo '
                      <div class="form-group">
                      <label for="inputEmail1">Razon Social</label>
                      <input type="text" readonly="" class="form-control" id="razonsocial" value="' . $row['razon_social'] . '" >
                    
                      <input type="hidden"  hidden id="id_persona" value="' . $row['id_persona'] . '" >
                    
                       </div>
                      <div id="campos">
                      </div>
                      <div class="form-group">
                          <label for="inputEmail1">Representante</label>
                          <input type="text" readonly="" class="form-control" id="ruc" value="' . $row['representante'] . '">
                      </div>
                      <div class="form-group">
                          <label for="inputEmail1">Ruc</label>
                          <input type="text" readonly="" class="form-control" id="ruc" value="' . $row['ruc'] . '">
                      </div>
                      <div class="form-group">
                          <label for="inputEmail1">Correo</label>
                          
                      </div>
                      <div class="form-group">
                          <label for="inputEmail1">Teléfono</label>
                          <input type="text" readonly="" class="form-control" id="telefono" value="' . $row['telefono'] . '">
                      </div>';
                  $idPer = $row['id_persona'];
                  $result2 = mainModel::ejecutar_consulta_simple("SELECT * FROM email WHERE id_persona='$idPer'");

                  foreach ($result2 as $key => $row2) {

                    echo '
                                                  <div class="radio">
                                                  <label class="radio-label">
                                                      <input name="correo[]" value="' . $row2['id_email'] . '" checked type="checkbox">' . $row2['email'] . '<i class="input-frame"></i>
                                                  </label>
              
                                                  
                                                  </div>
                                              
                              ';
                  }
                }
              } else {
              }
              ?>
            </div>

            <?php
            if (isset($_POST["id_cotizacion"]) && isset($_POST["cod_cot"])) {

              $id_cotizacion = $_POST["id_cotizacion"];
              $cod_cot = $_POST["cod_cot"];
            } else {
              $id_cotizacion = "";
              $cod_cot = "";
            }



            ?>
            <input hidden name="idCotDel" value="<?php echo $id_cotizacion ?>" type="text">
            <input hidden name="cod_cotDel" value="<?php echo $cod_cot ?>" type="text">

            <div class="grid">
              <p class="grid-header"style="color:#F28165;"><b>DATOS DE ORDEN DE COMPRA</p>

              <div class="form-group">
                <label for="inputEmail1">Nombre de Orden</label>
                <input type="text" class="form-control" id="nombre_orden_reg" name="nombre_orden_reg" placeholder="Cilindros de acero">
              </div>



              <input type="hidden" hidden name="insertar_orden">
              <div id="datoPersona">

                <input type="text" hidden id="id_persona" name="id_persona" value="<?php echo $id_persona ?>">
              </div>

            </div>



            <div class="grid-body">
              <div id="formulario" class="item-wrapper">



                <?php

                $contador = 0;
                if (isset($_POST['id_cotizacion'])) {
                  $id = $_POST['id_cotizacion'];
                  $result =  mainModel::ejecutar_consulta_simple("SELECT * FROM detallecotizacion det INNER JOIN persona pe ON  det.id_persona=pe.id_persona
									INNER JOIN cotizacion co ON det.id_cotizacion=co.id_cotizacion 
                                    WHERE co.id_cotizacion='$id'");
                  while ($row = $result->fetch()) {
                    $contador++;

                ?>
                    <section id="<?php echo $contador; ?>">
                      <div class="row">
                        <p style="color:lightcoral" class="grid-header">DESCRIPCION <?php echo $contador ?></p>
                        <div style="margin-left: 150px; " class="item-wrapper">
                          <div class="icon-showcase">
                            <div class="icon-showcase-cell"><i class="mdi mdi-close-circle" onclick="eliminar('<?php echo $contador; ?>')"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="inputs">
                        <div class="form-group"><label for="inputEmail1">Producto</label><input value="<?php echo $row["desc_det"] ?>" type="text" class="form-control" id="producto" name="producto[]" placeholder="Nombre de producto"></div>
                        <div class="form-group"><label for="inputEmail1">Cantidad</label><input value="<?php echo $row["cantidad_det"] ?>" type="texxt" class="form-control" id="cantidad" name="cantidad[]" placeholder="Cantidad"> </div>
                        <div class="form-group"><label for="inputEmail1">Precio</label><input type="text" class="form-control" id="precio" name=precio[] placeholder="Precio"></div>
                        <div class="form-group"><label for="inputEmail1">Unidad</label><select name="unidad[]" class="custom-select">
                            <option selected>Unidad</option>
                          </select></div>
                      </div><br>
                    </section>

                  <?php
                  }
                } else {
                  ?>



                  <div id="inputs">
                    <div class="row">
                      <p style="color:orangered" class="grid-header">DESCRIPCION </p>
                    </div>
                    <div class="inputs">
                      <div class="form-group">
                        <label for="inputEmail1">Producto</label>
                        <input type="text" class="form-control" id="producto" name="producto[]" placeholder="Nombre de Producto">
                      </div>
                      <div class="form-group">
                        <label for="inputEmail1">Cantidad</label>
                        <input type="text" class="form-control" id="canitdad" name=cantidad[] placeholder="Cantidad">
                      </div>
                      <div class="form-group">
                        <label for="inputEmail1">Precio</label>
                        <input type="text" class="form-control" id="precio" name=precio[] placeholder="Precio">
                      </div>
                      
                      <div class='form-group'>
                                        <label>IGV</label>
                                        <div class="form-check">
                                            <input onclick="calcular_precio();" class="form-check-input" type="radio" name="igv" id="conigv" value="si">
                                            <label class="form-check-label" for="exampleRadios3">
                                                Con IGV
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input onclick="calcular_precio()" class="form-check-input" type="radio" name="igv" id="sinigv" value="no" checked>
                                            <label class="form-check-label" for="exampleRadios4">
                                                Sin IGV
                                            </label>
                                        </div>
                                    </div>

                      <div class="form-group">
                        <label for="inputEmail1">Unidad</label>
                        <select name="unidad[]" class="custom-select">
                          <option selected>Unidad</option>
                        </select>
                      </div>
                    </div>
                  </div>


                <?php
                }
                ?>
                <div id="nuevoform">

                </div>

                <div id="subtotal">

                </div>

                <div class="d-flex justify-content-center">
                  <button class="btn btn-outline-primary btn-rounded" type="button" onclick="addCancion();">Agregar</button>
                </div>
                <br>

                <div class="form-group">
                  <label for="inputEm1ail1">Nota</label>
                  <textarea class="form-control" name="nota" id="inputType9" cols="12" rows="5">
- TIEMPO DE ENTREGA: 10 DIAS
- FORMA DE PAGO: CREDITO COMERCIAL 30 DIAS
- MONEDA: DOLARES

                  </textarea>
                </div>
                <div class="d-flex justify-content-center">
                  <div onclick="enviardatos();" class="btn btn-primary btn-block mt-0">Realizar Orden de compra</div>
                  <input type="submit" name="enviarFormulario" id="enviarFormulario" hidden value="Reaizar Orden de compra">
                </div>
          </form>
          <div class="RespuestaAjax" id="RespuestaAjax">
          </div>
          <br>
          <div id="alerta">
          </div>


          <script>
            a = <?php if($contador>=1){echo $contador;}else{echo 1;} ?>;

            function addCancion() {
              a++;

              var div = document.createElement('div');
              div.innerHTML = '<section id="' + a + '"><div class="row"> <p style="color:mediumvioletred" class="grid-header">Item ' + a + '</p></p><div style="margin-left: 150px; " class="item-wrapper"><div class="icon-showcase"><div class="icon-showcase-cell"><i class="mdi mdi-close-circle" onclick="eliminar(' + a + ')"></i></div></div></div></div><div class="inputs"><div class="form-group"><label for="inputEmail1">Producto</label><input type="text" class="form-control" id="producto" name="producto[]" placeholder="Nombre de Producto"></div><div class="form-group"><label for="inputEmail1">Cantidad</label><input type="text" class="form-control" id="cantidad" name="cantidad[]" placeholder="Ingresar la cantidad"> </div><div class="form-group"><label for="inputEmail1">Precio</label><input type="text" class="form-control" id="precio" name=precio[] placeholder="Precio"></div><div class="form-group"><label for="inputEmail1">Unidad</label><select name="unidad[]" class="custom-select"><option selected>Unidad</option></select></div></div><br></section>';
              document.getElementById('nuevoform').appendChild(div);
            }
            let eliminar = function(n) {
              jQuery("section").remove(`#${n}`);
              a = a - 1;
              if (a <= 0) {
                a = 0;
              }
            }

            function enviardatos() {

              var producto = $("input[name='producto\\[\\]']").map(function() {
                return $(this).val();
              }).get();
              var cantidad = $("input[name='cantidad\\[\\]']").map(function() {
                return $(this).val();
              }).get();
              var precio = $("input[name='precio\\[\\]']").map(function() {
                return $(this).val();
              }).get();

              var bool = true;
              for (let k = 0; k < producto.length; k++) {
                if (precio[k] == '') {
                  bool = false;
                }
              }

              if (bool != true) {
                $("#alerta").html('<div class="alert alert-warning" role="alert">Por favor, rellenar todos los campos</div>');

              } else {

                document.getElementById("alerta").style.display = "none";

                var text;

                text = '<div class="equel-grid"> <div class="grid table-responsive"><table class="table table-stretched"><thead><tr><th style="color:#F28165;"><b>PRODUCTO</th><th style="color:#F28165;"><b>CANTIDAD</th><th style="color:#F28165;"><b>P/U</th><th style="color:#F28165;"><b>PRECIO TOTAL</th></tr></thead><tbody>';


                for (var i = 0; i < producto.length; i++) {
                  text += '<tr><td><small class="text-gray">' + producto[i] + '</small></td><td class="font-weight-medium">' + cantidad[i] + '</td><td class="font-weight-medium">' + precio[i] + '</td><td class="font-weight-medium">' + precio[i] * cantidad[i] + '</td></tr>';

                }


                text += '<tr><td></td><td></td><td style="color:#F28165;"><b>SUB TOTAL:</td>';
                var suma = 0;
                var subtotal = 0;
                for (var j = 0; j < producto.length; j++) {
                  suma = precio[j] * cantidad[j];
                  subtotal = subtotal + suma;
                }
                
                
    
    
                var impuesto=0;
    if ($('#conigv').prop('checked')) {
             
      impuesto=0.18;
            }else{
      impuesto=0;
            }

                var igv = parseFloat(subtotal * impuesto);
                var total = parseFloat(igv + subtotal);
                $("#subtotal").html("<input hidden name='subtotal' value='" + subtotal + "'><input hidden name='igv' value='" + igv + "'><input hidden name='total' value='" + total + "'>");
                text += '<td class="font-weight-medium">' + subtotal + '</td>';
                text += '</tr><tr><td></td><td></td><td style="color:#F28165;"><b>IGV:</td><td class="font-weight-medium">' + igv + '</td></tr></tr><tr><td></td><td></td><td style="color:#F28165;"><b>TOTAL:</td><td class="font-weight-medium">' + total + '</td></tr></tbody> </table></div></div>';
                $("#datosmodal").html(text);
                $("#previewModal").modal("show");
              }



            }
          </script>



          <script>



          </script>

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
        <p class="grid-header">Detalle de Orden de Compra</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="datosmodal">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" onclick="enviarForm();" class="btn btn-primary">Realizar Orden</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  function enviarForm() {
    document.getElementById("enviarFormulario").click();
  }

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
          "tipo": "proveedor"
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

        $("#id_persona").remove();
        $("#datoPersona").html("<input hidden name='id_persona' value='" + id + "'>");
      }
    })
  }
</script>