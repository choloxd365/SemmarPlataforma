<script>
    document.addEventListener("DOMContentLoaded", function() {
        calcular_precio();
        contarinputs(a);
    });
</script>
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
                    <a class="nav-link active " href="<?php echo SERVERURL ?>ordenCliente/"><b>REGISTRO DE ORDEN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo SERVERURL ?>ordenClienteList/">LISTA DE ORDENES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo SERVERURL ?>ordenClienteListEmerg/">ORDENES DE EMERGENCIAS</b></a>
                </li>
            </ul>
        </div>
        <div class="content-viewport">
            <div class="row">

                <div class="col-lg-6 equel-gid">
                    <div class="grid">
                        <p class="grid-header" style="color:#F28165;"><b>DATOS DEL CLIENTE</b></p>
                        <div class="grid-body">
                            <div class="item-wrapper">
                                <div class="form-group">
                                    <!-- Button trigger modal -->
                                    <?php

                                    if (isset($_POST["id_persona"])) {

                                        $id = $_POST["id_persona"];

                                        require_once "./core/mainModel.php";
                                        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM persona WHERE id_persona='$id'");
                                        while ($row = $result->fetch()) {
                                            echo '
                                                <div class="form-group">
                                                <label for="inputEmail1">Razon Social</label>
                                                <input type="text" readonly="" class="form-control" id="razonsocial" value="' . $row['razon_social'] . '" >

                                                <input type="hidden"  hidden id="id_persona" value="' . $row['id_persona'] . '" >

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
                                                    <label for="inputEmail1">Teléfono</label>
                                                    <input type="text" readonly="" class="form-control" id="telefono" value="' . $row['telefono'] . '">
                                                </div>';
                                        }
                                    } else {
                                        echo '
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                          Buscar Cliente
                                        </button>';
                                    }

                                    ?>

                                </div>
                                <div id="campos">
                                </div>


                            </div>
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




                        <p class="grid-header"style="color:#F28165;"><b>DATOS DE COTIZACION</b></p>
                        <div class="grid-body">
                            <div class="item-wrapper">
                                <div class="form-group">
                                    <!-- Button trigger modal -->
                                    <?php

                                    if (isset($_POST["id_cotcli"])) {

                                        $id = $_POST["id_cotcli"];

                                        require_once "./core/mainModel.php";
                                        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM CotizacionCliente WHERE id_cotcli='$id'");
                                        while ($row = $result->fetch()) {
                                            echo '
                                                <div class="form-group">
                                                <label for="inputEmail1">Codigo de Cotizacion</label>
                                                <input type="text" readonly="" class="form-control" id="razonsocial" value="' . $row['id_cotcli'] . '" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail1">Monto</label>
                                                    <input type="text" readonly="" class="form-control" id="ruc" value="S/ ' . $row['total_cotcli'] . '">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail1">Fecha</label>
                                                    <input type="text" readonly="" class="form-control" id="telefono" value="' . $row['fecha_cotcli'] . '">
                                                </div>';
                                        }
                                    } else {
                                        echo '
                                        
                                        <a>No proviene de ninguna cotización</a>';
                                    }

                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 equel-grid">
                    <div class="grid">
                        <p  class='grid-header'style="color:#F28165;"><b>DATOS DE ORDEN</b></p>
                        <div class="grid-body">
                            <div class="item-wrapper">

                                <form action="<?php echo SERVERURL; ?>ajax/ordenCliente.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">



                                    <input type="hidden" hidden="" name="registrar_cotizacion_cliente">



                                    <?php

                                    if (isset($_POST["id_cotcli"])) {

                                        $id = $_POST["id_cotcli"];
                                    } else {
                                        $id = '';
                                    }
                                    if (isset($_POST["id_persona"])) {

                                        echo '<input  hidden name="id_persona" value="' . $_POST["id_persona"] . '">';
                                    }

                                    ?>

                                    <div id="idenpersona"></div>


                                    <input type="hidden" hidden="" value="<?php echo $id ?>" name="id_cotizacion">

                                    <div class='form-group'>
                                        <label for='inputEmail1'>Nro. O/C</label>
                                        <input required name='numero-orden' id="numero-orden" type='text' class='form-control' placeholder='Ejemplo: 10203040'>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Nro. G/R</label>
                                        <input required name="numero-guia" id="numero-guia" type="text" class="form-control" placeholder="Ejemplo: 50607080">
                                    </div>
                                    <div class='form-group'>
                                        <label for="inputEmail1">Tipo de Servicio</label>
                                        <select name='servicio' class='custom-select'>
                                            <option selected value='FABRICACION'>FABRICACION</option>
                                            <option value='MECANIZADO'>MECANIZADO</option>
                                            <option value='ESTRUCTURA'>ESTRUCTURA</option>
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <label for="inputEmail1">Estado</label>
                                        <select name='id_estado' class='custom-select'>
                                            <?php
                                            $result = mainModel::ejecutar_consulta_simple("SELECT * FROM EstadoOrdenCliente ");

                                            $inputsLlenos = '';

                                            foreach ($result as $key => $rows) {

                                                echo '
                                                 <option value="' . $rows["id_estado"] . '">' . $rows["nombre_estado"] . '</option>';
                                            }  ?>
                                        </select>
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
                                    <div id="div_tipo_cambio" style="display: none;" class="form-group">
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
                                    <div class='form-group'>
                                        <label>IGV</label>
                                        <div class="form-check">
                                            <input onclick="calcular_precio();" class="form-check-input" type="radio" name="igv_option" id="id_igv" value="si">
                                            <label class="form-check-label" for="exampleRadios3">
                                                Con IGV
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input onclick="calcular_precio()" class="form-check-input" type="radio" name="igv_option" value="no" checked>
                                            <label class="form-check-label" for="exampleRadios4">
                                                Sin IGV
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <?php

                                            $contador = 0;
                                            if (isset($_POST['id_cotcli'])) {
                                                $id = $_POST['id_cotcli'];
                                                $result =  mainModel::ejecutar_consulta_simple("SELECT * FROM DetalleCotizacionCliente  WHERE id_cotcli='$id'");
                                                while ($row = $result->fetch()) {
                                                    $contador++;

                                            ?>
                                            <section id="<?php echo $contador; ?>">
                                                <div class="row">
                                                    <p style="color:lightcoral" class="grid-header">Item <?php echo $contador ?></p>
                                                    <div style="margin-left: 150px; " class="item-wrapper">
                                                        <div class="icon-showcase">
                                                            <div class="icon-showcase-cell"><i class="mdi mdi-close-circle" onclick="eliminar('<?php echo $contador; ?>')"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="inputs">
                                                    <div class="form-group"><label for="inputEmail1">Descripción</label><input value="<?php echo $row["desc_det_cotcli"] ?>" type="text" class="form-control" id="producto" name="descripcion[]" placeholder="Descripcion"></div>
                                                    <div class="form-group"><label for="inputEmail1">Cantidad</label><input value="<?php echo $row["cantidad_det_cotcli"] ?>" type="texxt" class="form-control" id="cantidad" name="cantidad[]" placeholder="Cantidad"> </div>
                                                    <div class="form-group"><label for="inputEmail1">Precio</label><input onkeyup="calcular_precio()" onload="calcular_precio()" value="<?php echo $row["precio_det_cotcli"] ?>" type="text" class="form-control" id="precio" name=precio[] placeholder="Precio"></div>
                                                    <div class="form-group"><label for="inputEmail1">Unidad</label><select name="unidad[]" class="custom-select">
                                                            <option selected><?php echo $row["unidad_det_cotcli"] ?></option>
                                                            <option>METROS CUBICOS</option>
                                                            <option>MTRS</option>
                                                        </select></div>
                                                </div><br>
                                            </section>

                                        <?php
                                                }
                                            } else {
                                        ?>



                                        <div id="inputs">
                                            <div class="row">
                                                <p style="color:orangered" class="grid-header">Item 1</p>
                                            </div>
                                            <div class="inputs">
                                                <div class="form-group">
                                                    <label for="inputEmail1">Descripción</label>
                                                    <input type="text" class="form-control" id="Descripción" name="descripcion[]" placeholder="Descripcion">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail1">Cantidad</label>
                                                    <input type="number" class="form-control" id="cantidad" name="cantidad[]" placeholder="Ejemplo: 3">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail1">Precio</label>
                                                    <input type="number" onkeyup="calcular_precio()" onload="calcular_precio()" class="form-control" id="precio" name="precio[]" placeholder="Precio">
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

                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-outline-primary btn-rounded" type="button" onclick="addCancion();">Agregar</button>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="inputEmail1" style="color:#F28165;"><b>Sub total</b></label>
                                            <input required name="subtotal" id="subtotal" type="text" class="form-control" id="inputType1" placeholder="Pre x Can">
                                        </div>
                                        <div id="mostrar_igv" class="form-group col-3">
                                            <label for="inputEmail1"style="color:#F28165;"><b>IGV</b></label>
                                            <input required name="igv" id="igv" type="text" class="form-control" id="inputType1" placeholder="18%">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="inputEmail1"style="color:#F28165;"><b>Total</b></label>
                                            <input required name="total" id="total" type="text" class="form-control" id="inputType1" placeholder="sub + igv">

                                            <input hidden name="cantidadInputs" id="cantidadInputs" type="text" class="form-control" id="cantidadInputs" value="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <input type="submit" name="enviarFormulario" id="enviarFormulario" hidden class="btn btn-outline-primary btn-rounded" value="Registrar Cotización a  Cliente">

                                        <div onclick="enviardatos();" class="btn btn-primary btn-block mt-0">Realizar Orden (Cliente)</div>

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
    <script>
        
        function tipo_cambio() {
            if (document.getElementById("tipo_cambio_soles_id").checked == true) {

              document.getElementById("input_tipo_cambio").value = 0;
              document.getElementById("div_tipo_cambio").style.display = "none";

            } else {

              document.getElementById("div_tipo_cambio").style.display = "block";
              document.getElementById("input_tipo_cambio").value = <?php echo $USD; ?>;
            }
          }

          
        function calcular_precio() {


            var cantidad = $("input[name='cantidad\\[\\]']").map(function() {
                return $(this).val();
            }).get();
            var precio = $("input[name='precio\\[\\]']").map(function() {
                return $(this).val();
            }).get();

            let suma = 0;
            for (let i = 0; i < precio.length; i++) {
                suma = suma + (cantidad[i] * precio[i]);

            }



            if (document.getElementById("id_igv").checked == true) {

                var valor = suma;
                var tasa = 18;
                var igv = (valor * tasa) / 100;
                var total = parseInt(valor + igv);
                document.getElementById("subtotal").value = valor.toFixed(2);
                document.getElementById("igv").value = igv.toFixed(2);
                document.getElementById("total").value = total.toFixed(2);
            } else {

                var valor = suma;
                var tasa = 18;
                var igv = (valor * tasa) / 100;
                var total = parseInt(valor + igv);
                document.getElementById("subtotal").value = valor.toFixed(2);
                document.getElementById("igv").value = 0;
                document.getElementById("total").value = valor.toFixed(2);
            }


        }
    </script>

    <script>
        function enviardatos() {
            var bool = true;

            var descripcion = $("#descripcion").val();
            var precio = $("#precio").val();
            var cantidad = $("#cantidad").val();
            var guia = $("#numero-guia").val();
            var nroorden = $("#numero-orden").val();

            if (descripcion == '' || precio == '' || cantidad == '' || guia == '' || nroorden == '') {
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
        function EnviarDatosProveedor(datos) {

            $('#id_persona').val(datos);

            $('#cerrar').click();

        }

        $(document).ready(function() {
            $('#cerrar').click();
        })

        function crearDatosProveedor(id) {
            $.ajax({
                url: "<?php echo SERVERURL; ?>ajax/proveedorAjax.php",
                method: "POST",
                data: {
                    "id_persona": id
                },
                success: function(respuesta) {
                    $("#campos").attr("disabled", false);
                    $("#campos").html(respuesta);

                    $("#idenpersona").html('<input type="hidden" name="id_persona" value="' + id + '">');

                }
            })

        }
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



        a = <?php echo $contador; ?>;
        if (a == 0) {
            a = 1;
        }

        function addCancion() {
            a++;

            var div = document.createElement('div');
            div.innerHTML = '<section id="' + a + '"><div class="row"> <p style="color:mediumvioletred" class="grid-header">Item ' + a + '</p></p><div style="margin-left: 150px; " class="item-wrapper"><div class="icon-showcase"><div class="icon-showcase-cell"><i class="mdi mdi-close-circle" onclick="eliminar(' + a + ')"></i></div></div></div></div><div class="inputs"><div class="form-group"><label for="inputEmail1">Producto</label><input type="text" class="form-control" id="descripcion" name="descripcion[]" placeholder="Nombre de Producto"></div><div class="form-group"><label for="inputEmail1">Cantidad</label><input type="text" class="form-control" id="cantidad" name="cantidad[]" placeholder="Ingresar la cantidad"> </div><div class="form-group"><label for="inputEmail1">Precio</label><input type="text" class="form-control" id="precio" name=precio[] onkeyup="calcular_precio();" placeholder="Precio"></div><div class="form-group"><label for="inputEmail1">Unidad</label><select name="unidad[]" class="custom-select"><option selected>Unidad</option></select></div></div><br></section>';
            document.getElementById('nuevoform').appendChild(div);
            contarinputs(a);
        }
        let eliminar = function(n) {
            jQuery("section").remove(`#${n}`);
            a = a - 1;
            if (a <= 0) {
                a = 0;
            }
            calcular_precio();

            contarinputs(a);
        }

        function contarinputs(valor) {
            if (valor == 0) {
                valor = 1
            }
            $("#cantidadInputs").val(valor);
        }
        
    </script>
    