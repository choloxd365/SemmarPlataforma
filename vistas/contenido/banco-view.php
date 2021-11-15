<?php 

if ($_SESSION['tipo_usuario_semmar']!="ADMINISTRADOR"){
    echo $lc->forzar_cierre_sesion_controlador();
    header("location:".SERVERURL."");
  }

?>


<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div class="viewport-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb has-arrow">
                    <li class="breadcrumb-item">
                        <a href="#"><b>INICIO</b></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#"><b>ADMINISTRACION</b></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><b>BANCOS</b></li>
                </ol>
            </nav>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo SERVERURL ?>banco/"><b>CUENTAS BANCARIAS</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo SERVERURL ?>banco/"></a>
                </li>
            </ul>
        </div>
        <div class="content-viewport">
            <div class="row">


                <div class="col-lg-6 equel-gid">
                    <div class="grid">
                        <p class="grid-header" style="color:#F28165;"><b>AGREGAR BANCO</b></p>


                        <div class="grid-body">
                            <div class="item-wrapper">
                                <form action="<?php echo SERVERURL; ?>ajax/bancoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                    <input type="text" name="id_orden" hidden value="<?php echo $id_orden; ?>">
                                    <div class="form-group">
                                        <label for="inputEmail1">Descripcion</label>
                                        <input type="text" class="form-control" name="nombre_banco" id="inputEmail1" placeholder="Ingresa la descripcion del gasto">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Moneda</label>

                                        <select class="form-control" name="moneda_banco" id="">
                                            <option value="Soles">Soles</option>
                                            <option value="Dolares">Dolares</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Tipo de Cuenta</label>

                                        <select class="form-control" name="tipo_cuenta_banco" id="">
                                            <option value="Ahorros">Ahorros</option>
                                            <option value="Credito">Credito</option>
                                        </select>
                                    </div>
                                    <input type="submit" class="btn btn-sm btn-primary" value="Añadir">
                                </form>

                                <div class="RespuestaAjax" id="RespuestaAjax">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 equel-gid">
                    <div class="grid">
                        <p class="grid-header" style="color:#F28165;"><b>LISTA DE CTA. BANCARIAS - AGREGAR <button onclick="addBanco();" type="button" id="add_banco" class="btn btn-outline-primary">+</button></b></p>

                        <div class="col-lg-12 col-md-6 equel-grid">
                            <div class="grid table-responsive">
                                <table class="table table-stretched">
                                    <?php require_once './controladores/bancoControlador.php';
                                    $lista = new bancoControlador();

                                    echo $lista->lista_banco_controlador(1, 100);
                                    ?>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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




        <div class="modal fade" id="modalAbonar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Actualización de Gasto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div id="datosAbono"></div>



                </div>
            </div>
        </div>


        <div class="modal fade" id="modalBanco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Añadir Categoría</h5>
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
                                            <form action="<?php echo SERVERURL; ?>ajax/bancoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                                <input hidden name="agregar_categoria" value="1">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputState">Seleccionar Banco</label>

                                                        <select name="id_banco" class="form-control">
                                                            <?php

                                                            require_once "./core/mainModel.php";
                                                            $result = mainModel::ejecutar_consulta_simple("SELECT * FROM Banco");
                                                            while ($row = $result->fetch()) {
                                                                echo '<option value="' . $row["id_banco"] . '">' . $row["nombre_banco"] . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label for="inputCity">Nombre de Categoría</label>
                                                        <input type="text" class="form-control" name="nombre_cate_reg">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputZip">Monto Inicial</label>
                                                        <input type="number" min="1" class="form-control" name="monto_cate_reg">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Agregar Categoría</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        <body>
            <div class="row">
                <div class="col-12">
                    <br>
                    <h1 style="color:#F28165;">TRANSACCIONES</h1>
                    <br>

                    <div class="input-group">
                        <input type="text" onkeyup="obtenerBusqueda()" onkeydown="obtenerBusqueda()" onkeypress="obtenerBusqueda()" class="form-control" id="texto" name="texto" placeholder="Search">
                    </div>

                    <div id="tabla" class="table-responsive">
                            <?php require_once './controladores/bancoControlador.php';
                            $lista = new bancoControlador();


                            $pagina = explode("/", $_GET['views']);
                            echo $lista->lista_transaccion_controlador($pagina[1], 20, '');
                            ?>



                    </div>
                    <div id="tablaresultado" class="table-responsive">

                    </div>
                </div>
            </div>
            </main>
        </body>



        <script>
            function enviarDatosRetiro(id) {

                $.ajax({
                    url: "<?php echo SERVERURL; ?>ajax/bancoAjax.php",
                    method: "POST",
                    data: {
                        "id_cat_banco": id
                    },
                    success: function(respuesta) {
                        $("#datos").attr("disabled", false);
                        $("#datos").html(respuesta);
                    }
                })
            }

            function enviarDatosAbono(id) {

                $.ajax({
                    url: "<?php echo SERVERURL; ?>ajax/bancoAjax.php",
                    method: "POST",
                    data: {
                        "abonar_monto": id
                    },
                    success: function(respuesta) {
                        $("#datosAbono").attr("disabled", false);
                        $("#datosAbono").html(respuesta);
                    }
                })
            }
        </script>

        <script>
            function addBanco() {

                $('#modalBanco').modal('show');
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
                        url: "<?php echo SERVERURL; ?>ajax/bancoAjax.php",
                        method: "POST",
                        data: {
                            "busqueaTra": texto
                        },
                        success: function(respuesta) {
                            $("#tablaresultado").attr("disabled", false);
                            $("#tablaresultado").html(respuesta);
                        }
                    })
                }
            }
        </script>