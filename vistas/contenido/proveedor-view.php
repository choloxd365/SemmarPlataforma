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
          <li class="breadcrumb-item active" aria-current="page"><b>REGISTRO DE PROVEEDOR</li>
        </ol>
      </nav>

      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo SERVERURL ?>proveedor/"><b>REGISTRO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL ?>proveedorList/"><b>LISTA</a>
        </li>
      </ul>
    </div>
    <div class="content-viewport">
      <div class="row">
        <div class="col-lg-12">
          <div class="grid">
            <form action="<?php echo SERVERURL; ?>ajax/proveedorAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
              <div class="grid-body">
                <div class="item-wrapper">
                  <div class="row mb-3">
                    <div class="col-md-8 mx-auto">
                      <div class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType1">Tipo de Persona</label>
                        </div>
                        <div class="col-md-9 showcase_content_area">
                          <select name="id_tipo_persona_reg" class="custom-select">
                            <option value="1">Natural</option>
                            <option value="2">Jurídica</option>
                          </select>
                        </div>
                      </div>
                      <div hidden class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType1">Tipo de Beneficiario</label>
                        </div>
                        <div class="col-md-9 showcase_content_area">
                          <select name="id_beneficiario_reg" class="custom-select">
                            <option value="2">Proveedor</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType1">Razón Social</label>
                        </div>
                        <div class="col-md-9 showcase_content_area">
                          <input type="text" required="" class="form-control" name="raz-social-reg" id="inputType1" placeholder="Hayduk">
                        </div>
                      </div>
                      <div class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType1">Usuario</label>
                        </div>
                        <div class="col-md-9 showcase_content_area">
                          <input type="text" required="" class="form-control" name="representante-reg" id="inputType1" placeholder="César Raúl">
                        </div>
                      </div>
                      <div class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType12">Agregar Email</label>
                        </div>
                        <div class="col-3 showcase_content_area">
                          <button class="btn btn-outline-primary btn-rounded" type="button" onclick="addCancion();">+</button>

                        </div>

                      </div>
                      <div id="nuevoform">

                      </div>
                      <div class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType1">Ruc</label>
                        </div>
                        <div class="col-md-9 showcase_content_area">
                          <input type="text" maxlength="11" class="form-control" name="ruc-reg" id="inputType1" placeholder="8637387654356">
                        </div>
                      </div>
                      <div class="form-group row showcase_row_area">
                        <div class="col-md-3 showcase_text_area">
                          <label for="inputType1">Teléfono</label>
                        </div>
                        <div class="col-md-9 showcase_content_area">
                          <input type="text" maxlength="12" class="form-control" name="telefono-reg" id="inputType1" placeholder="923263158">
                        </div>
                      </div>
                      <div class="d-flex justify-content-center">
                        <input type="submit" class="btn btn-outline-primary btn-rounded" value="Registrar Proveedor">
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






<script>
  a = 0;

  function addCancion() {
    a++;

    var div = document.createElement('div');
    div.innerHTML = '<div id="' + a + '" class="form-group row showcase_row_area"><div class="col-md-3 showcase_text_area"><label for="inputType12">Email ' + a + '</label></div><div class="col-6 showcase_content_area"><input type="email" required="" class="form-control" name="email[]" id="email' + a + '"" placeholder="hayduk@gmail.com"></div><div class="col-3 showcase_content_area"><button class="btn btn-outline-primary btn-rounded mdi mdi-delete" type="button"  onclick="eliminar(' + a + ')"></button></div></div>';
    document.getElementById('nuevoform').appendChild(div);
    document.getElementById("email" + a).focus();
  }
  let eliminar = function(n) {
    jQuery("div").remove(`#${n}`);
    a = a - 1;
    if (a <= 0) {
      a = 0;
    }
    document.getElementById("email" + a).focus();
  }
</script>