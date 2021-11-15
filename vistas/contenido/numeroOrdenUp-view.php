<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div class="viewport-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb has-arrow">
                    <li class="breadcrumb-item">
                        <a href="#">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Numero de Orden</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Actualizar # Orden</li>
                </ol>
            </nav>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo SERVERURL ?>emailUp/">Actualizar</a>
                </li>
            </ul>
        </div>
        <div class="content-viewport">
            <div class="row">
                <div class="col-lg-12">
                    <div class="grid">


                        <?php

                        $datos = explode("/", $_GET['views']);

                        require_once "./controladores/ordenCLienteControlador.php";
                        $classDoc = new ordenCLienteControlador();
                        $filesL = $classDoc->data_orden_cliente_controlador($datos[1]);
                        if ($filesL->rowCount() >= 1) {

                            $campos = $filesL->fetch();
                            $id_orden= $campos["id_ordencli"];

                        ?>

                            <p class="grid-header">ACTUALIZAR # ORDEN DE: <br><?php
                            $contador=0;
                            $consulta=mainModel::ejecutar_consulta_simple("SELECT id_det_ordencli,desc_det_ordencli FROM DetalleOrdenCliente where id_ordencli='$id_orden' order by id_det_ordencli desc;");
                            while ($datos=$consulta->fetch()) {
                                $contador++;
                              echo "-";
                              if ($contador==1) {
                                  echo"<b>";
                              }
                              echo $datos["desc_det_ordencli"];
                              if ($contador==1) {
                                echo"</b>";
                            }
                              echo "<br>";
                            }
                            ?></p>
                            <form action="<?php echo SERVERURL; ?>ajax/OrdenCliente.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                            <div class="grid-body">
                                <div class="item-wrapper">
                                    <div class="row mb-3">
                                        <div class="col-md-8 mx-auto">
                                            <div class="form-group row showcase_row_area">
                                                <div class="col-3 showcase_text_area">
                                                    <label for="inputType12">Agregar Num. de Orden: </label>
                                                </div>

               
                                                    <div class="col-6 showcase_content_area">
                                                        <input name="id_orden_num_orden" value="<?php echo $campos['id_ordencli'] ?>" hidden>
                                                        <input name="numero_orden" type="text" required="" class="form-control"  id="inputType2" placeholder="S-2120">
                                                    </div>
                                                    <div class="col-3 showcase_content_area">
                                                        <input type="submit" class="btn btn-outline-primary btn-rounded" value="+">
                                                    </div>
                                                </form>

                                                <div class="RespuestaAjax" id="RespuestaAjax">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  } else {

                            echo "<h4>No se pudo recuperar los datos</h4>";
                        }
                        ?>

                        <?php

                        $datos = explode("/", $_GET['views']);

                        require_once "./controladores/ordenCLienteControlador.php";
                        $classDoc = new ordenCLienteControlador();
                        $filesL = $classDoc->data_numero_orden_cliente_controlador($datos[1]);
                        if ($filesL->rowCount() >= 1) {
                            $contador=0;

                            while ($campos = $filesL->fetch()) {
                                $contador++;




                        ?>

                           

                                <div class="grid-body">
                                    <div class="item-wrapper">
                                        <div class="row mb-3">
                                            <div class="col-md-8 mx-auto">
                                                <div class="form-group row showcase_row_area">
                                                    <div class="col-3 showcase_text_area">
                                                        <label for="inputType12">Num. Orden <?php echo $contador; ?></label>
                                                    </div>
                                                    <div class="col-6 showcase_content_area">
                                                        <input type="email"  value="<?php echo $campos["num_orden"]; ?>" class="form-control" name="email-reg" id="inputType2" placeholder="hayduk@gmail.com">
                                                    </div>
                                                <form action="<?php echo SERVERURL; ?>ajax/ordenCliente.php" method="POST" data-form="delete" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                                    <div class="col-1 showcase_content_area">
                                                        <input type="text" name="delNumOrden" hidden value="<?php echo $campos["id_numero_orden"]; ?>" >
                                                        
                                                        <button class="btn btn-outline-primary btn-rounded mdi mdi-delete" type="submit" ></button>

                                                    </div>
                                                </form>
                                                    <div class="RespuestaAjax" id="RespuestaAjax">
                                                    </div> 
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                        <?php }
                        } else {

                            echo '<div class="grid-body">
                            <div class="item-wrapper">
                                <div class="row mb-3">
                                    <div class="col-md-8 mx-auto">

                                    <div class="form-group row showcase_row_area">
                                                    <div class="col-3 showcase_text_area">
                                                       
                                                    </div>
                                                    <div class="col-6 showcase_content_area">
                                                    <h4>No se agregó Numero de orden</h4>

                                                    </div>
                                               

                                        
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }
                        ?>
        </div>
        <a class="btn btn-primary btn-lg btn-block" href="<?php echo SERVERURL?>ordenClienteListEmerg/">Regresar al listado de Ordenes</a>
    </div>

</div>
</div>
</div>