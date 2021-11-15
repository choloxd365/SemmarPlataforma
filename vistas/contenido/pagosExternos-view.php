<script>
    window.addEventListener("load", function(){
    tipo_cambio();
});
</script>


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
                    <li class="breadcrumb-item active" aria-current="page">Pago a Proveedor</li>
                </ol>
            </nav>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo SERVERURL ?>proveedor/">Registro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo SERVERURL ?>proveedorList/">Listado de Proveedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active " href="#" tabindex="-1" aria-disabled="true">Pago</a>
                </li>
            </ul>
        </div>
        <?php

        $USD = 0;
        $datos = explode("/", $_GET['views']);

        require_once "./controladores/bancoControlador.php";
        $classDoc = new bancoControlador();
        $filesL = $classDoc->data_cate_banco_controlador($datos[1]);
        if ($filesL->rowCount() >= 1) {
            $moneda = '';
            $campos = $filesL->fetch();
            if ($campos["moneda_banco"] == "Soles") {
                $moneda = 'S/';
            } else {
                $moneda = '$';
            }
        }

        ?>
        <div class="content-viewport">
            <div class="row">

                <div class="col-lg-6 equel-gid">
                    <div class="grid">
                        <p class="grid-header">Realizar un pago de <?php echo $campos["nombre_banco"]; ?> (<?php echo $campos["nombre_cate"]; ?>) con un monto total de <?php echo $moneda; ?> <?php echo $campos["monto_actual"]; ?></p>


                        <div class="grid-body">
                            <div class="item-wrapper">
                                <form action="<?php echo SERVERURL; ?>ajax/bancoAjax.php" method="POST" data-form="save" class="FormularioAjax needs-validation" autocomplete="off" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label for="inputEmail1">Descripcion</label>
                                        <input type="text" hidden  name="id_cat_banco_pago_externo" value="<?php echo $campos["id_cat_banco"] ?>">
                                        <input type="text" required class="form-control" name="descripcion-pago" id="inputEmail1" placeholder="Ingresa la descripcion del gasto">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Monto</label>
                                        <input type="number" required class="form-control" name="monto-pago" id="inputEmail1" placeholder="Ingrese precio en <?php if ($campos["moneda_banco"]=="Soles"){echo 'Soles';}else{echo 'Dolares'; } ?>">
                                    </div>
                                    <div class='form-group'>
                                        <label>Moneda</label>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled onclick="tipo_cambio();" <?php if($campos["moneda_banco"]=="Soles"){echo'checked';} ?> type="radio" name="moneda-reg" id="tipo_cambio_soles_id" value="Soles" >
                                            <label class="form-check-label" for="exampleRadios1">
                                                Soles
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled onclick="tipo_cambio();"<?php if($campos["moneda_banco"]=="Dolares"){echo'checked';} ?> type="radio" name="moneda-reg" id="tipo_cambio_dolares_id" value="Dolares">
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
                                    <input type="submit" class="btn btn-sm btn-primary" value="Registrar Pago">
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
                        <p class="grid-header">Listado de Pagos</p>

                        <div class="col-lg-12 col-md-6 equel-grid">
                            <div class="grid table-responsive">

                                <table class="table table-bordered">
                                    

                                        <?php require_once './controladores/bancoControlador.php';
                                        $lista = new bancoControlador();
                                        $pagina = explode("/", $_GET['views']);
                                        echo $lista->lista_pagos_externos_controlador($pagina[2], 10, $pagina[1]);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>








                <script>
                    function tipo_cambio() {
                        if (document.getElementById("tipo_cambio_soles_id").checked == true) {

                            document.getElementById("input_tipo_cambio").value = 0;
                            document.getElementById("tipo-cambio").style.display = "none";

                        } else {

                            document.getElementById("tipo-cambio").style.display = "block";
                            document.getElementById("input_tipo_cambio").value = <?php echo $USD; ?>;
                        }
                    }

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
                </script>