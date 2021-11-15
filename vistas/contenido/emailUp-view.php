<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div class="viewport-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb has-arrow">
                    <li class="breadcrumb-item">
                        <a href="#">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Proveedor</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Actualizar Email</li>
                </ol>
            </nav>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo SERVERURL ?>emailUp/">Actualizar Email</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
        <div class="content-viewport">
            <div class="row">
                <div class="col-lg-12">
                    <div class="grid">


                        <?php

                        $datos = explode("/", $_GET['views']);

                        require_once "./controladores/proveedorControlador.php";
                        $classDoc = new proveedorControlador();
                        $filesL = $classDoc->data_proveedor_controlador($datos[1]);
                        if ($filesL->rowCount() >= 1) {

                            $campos = $filesL->fetch();

                        ?>

                            <p class="grid-header">Administración de Email (<?php echo $campos['razon_social'] ?>)</p>
                            <form action="<?php echo SERVERURL; ?>ajax/proveedorAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                            <div class="grid-body">
                                <div class="item-wrapper">
                                    <div class="row mb-3">
                                        <div class="col-md-8 mx-auto">
                                            <div class="form-group row showcase_row_area">
                                                <div class="col-3 showcase_text_area">
                                                    <label for="inputType12">Nuevo email: </label>
                                                </div>

               
                                                    <div class="col-6 showcase_content_area">
                                                        <input name="idPer" value="<?php echo $campos['id_persona'] ?>" hidden=>
                                                        <input type="email" required="" class="form-control" name="agregarEmail" id="inputType2" placeholder="ejemplo@gmail.com">
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

                        require_once "./controladores/proveedorControlador.php";
                        $classDoc = new proveedorControlador();
                        $filesL = $classDoc->data_Emailproveedor_controlador($datos[1]);
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
                                                        <label for="inputType12">Email <?php echo $contador; ?></label>
                                                    </div>
                                                    <div class="col-6 showcase_content_area">
                                                        <input type="email" required="" value="<?php echo $campos["email"]; ?>" class="form-control" name="email-reg" id="inputType2" placeholder="hayduk@gmail.com">
                                                    </div>
                                                <form action="<?php echo SERVERURL; ?>ajax/proveedorAjax.php" method="POST" data-form="delete" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                                    <div class="col-1 showcase_content_area">
                                                        <input type="text" name="delEmail" hidden value="<?php echo $campos["id_email"]; ?>" >
                                                        
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
                                                    <h4>No se agregó email a este usuario</h4>

                                                    </div>
                                               

                                        
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }
                        ?>
        </div>
    </div>

</div>
</div>
</div>