
<?php 
  
  $datos=explode("/", $_GET['views']);

    require_once "./controladores/proveedorControlador.php";
  $classDoc = new proveedorControlador();
  $filesL=$classDoc->data_proveedor_controlador($datos[1]);
  if ($filesL->rowCount()>=1) {

      $campos=$filesL->fetch();
    
    ?>

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
                <li class="breadcrumb-item active" aria-current="page">Actualizacion de  Proveedor</li>
              </ol>
            </nav>
          </div>
          <div class="content-viewport">
            <div class="row">
              <div class="col-lg-12">
                <div class="grid">
      						<form action="<?php echo SERVERURL;?>ajax/proveedorAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                              <input name="dataPersona" value="je " hidden=>
                                <input name="id_personaa" value="<?php echo $campos['id_persona'] ?>" hidden=>
                    <p class="grid-header">Actualizacion de  Proveedor</p>
                    <div class="grid-body">
                      <div class="item-wrapper">
                        <div class="row mb-3">
                          <div class="col-md-8 mx-auto">
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType12">Email</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                
                               <a class="btn btn-outline-primary btn-rounded" href="<?php echo SERVERURL?>emailUp/<?php echo $campos['id_persona'] ?>">Administrar Email</a>
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType1">Tipo de Persona</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                              <select name="id_tipo_persona" class="custom-select">
                                <option <?php if ($campos['id_tipo_persona']=="1") { echo'selected=""';} ?> value="1">Natural</option>
                                <option <?php if ($campos['id_tipo_persona']=="2") { echo'selected=""';} ?> value="2">Jurídica</option>
                              </select>  
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType1">Tipo de Beneficiario</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                              <select name="id_beneficiario_reg" class="custom-select">
                                <option  <?php if ($campos['id_beneficiario']=="1") { echo'selected=""';} ?>  value="1">Cliente</option>
                                <option   <?php if ($campos['id_beneficiario']=="2") { echo'selected=""';} ?>  value="2">Proveedor</option>
                              </select>  
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType1">Razón Social</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" value="<?php echo $campos['razon_social'] ?>" required="" class="form-control" name="raz-social-reg" id="inputType1" placeholder="Hayduk">
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType1">Representante</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" value="<?php echo $campos['representante'] ?>" required="" class="form-control" name="representante-reg" id="inputType1" placeholder="César Raúl">
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType1">Ruc</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" value="<?php echo $campos['ruc'] ?>" class="form-control" name="ruc-reg" id="inputType1" placeholder="8637387654356">
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="inputType1">Teléfono</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" value="<?php echo $campos['telefono'] ?>" class="form-control" name="telefono-reg" id="inputType1" placeholder="923263158">
                              </div>
                            </div>
                              <div class="d-flex justify-content-center">
                          <input type="submit" class="btn btn-outline-primary btn-rounded" value="Actualizar Proveedor">
                  </form>
                              </div>
                                <div class="RespuestaAjax" id="RespuestaAjax">
                              </div>
                           
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
<?php  }else{

    echo "<h4>No se pudo recuperar los datos</h4>";
} 
?>