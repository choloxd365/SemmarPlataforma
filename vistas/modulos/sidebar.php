<!-- partial -->
<div class="page-body ">
  <!-- partial:partials/_sidebar.html -->
  <div class="sidebar bg-primary">
    <div class="user-profile bg-primary">
      <div class="display-avatar animated-avatar">
        <img class="profile-img img-lg rounded-circle" style="back: red;" src="<?php echo SERVERURL ?>vistas/images/logo.png" alt="profile image">
      </div>
      <div class="info-wrapper bg-primary">
        <p class="user-name text-light"><?php echo $_SESSION['nombres_semmar']; ?></p>
        <h6 class="display-income text-light"><?php echo $_SESSION['tipo_usuario_semmar']; ?></h6>
      </div>
    </div>



    <div class="sidebar bg-primary">
      <small class="text-muted px-3">HOME</small>
      <ul>
        <li><a class="text-light" href="<?php echo SERVERURL ?>home"><i class="far fa-calendar-alt"></i>Inicio</a></li>
      </ul>

      <small class="text-muted px-3">CLIENTE</small>
      <ul>
        <li><a class="text-light" href="<?php echo SERVERURL ?>cliente/">Registro de Clientes</a></li>
        <li><a class="text-light" href="<?php echo SERVERURL ?>clienteList/">Lista de Clientes</a></li>
      </ul>

      <small class="text-muted px-3">PROVEEDOR</small>
      <ul>
        <li><a class="text-light" href="<?php echo SERVERURL ?>proveedor/">Registro de Proveedores</a></li>
        <li><a class="text-light" href="<?php echo SERVERURL ?>proveedorList/">Lista de Proveedores</a></li>
      </ul>

      <small class="text-muted px-3">COTIZACION PROVEEDOR</small>
      <ul>
        <li><a class="text-light" href="<?php echo SERVERURL ?>proveedorCot/">Registro de Cotizaciones</a></li>
        <li><a class="text-light" href="<?php echo SERVERURL ?>proveedorCotList/">Cotizaciones</a></li>
      </ul>

      <small class="text-muted px-3">COTIZACION CLIENTE</small>
      <ul>
        <li><a class="text-light" href="<?php echo SERVERURL ?>clienteCot/">Registro de Cotizacion</a></li>
        <li><a class="text-light" href="<?php echo SERVERURL ?>clienteCotList/">Lista de Cotizaciones</a></li>
      </ul>

      <small class="text-muted px-3">ORDEN PROVEEDOR</small>
      <ul>
        <li><a class="text-light" href="<?php echo SERVERURL ?>ordenCompra/">Registro de Orden</a></li>
        <li><a class="text-light" href="<?php echo SERVERURL ?>ordenProveeList/">Listado de Orden Provee</a></li>
      </ul>

      <small class="text-muted px-3">ORDEN CLIENTE</small>
      <ul>
        <li>
          <a class="text-light" href="<?php echo SERVERURL ?>ordenCliente/">Registro de Orden</a>
        </li>
        <li>
          <a class="text-light" href="<?php echo SERVERURL ?>ordenClienteList/">Listado de Orden Clientes</a>
        </li>
        <li>
          <a class="text-light" href="<?php echo SERVERURL ?>ordenClienteListEmerg/">Listado de Orden Emergencia</a>
        </li>
      </ul>

      <?php
      
if ($_SESSION['tipo_usuario_semmar']=="ADMINISTRADOR"){
      ?>
      
      <small class="text-muted px-3">BANCOS</small>
      <ul>
        <li>
          <a class="text-light" href="<?php echo SERVERURL ?>banco/">Gestion de Bancos</a>
        </li>

      </ul>
      <?php
    }

      ?>

      <small class="text-muted px-3">RESTAURACION</small>
      <ul>
        <li>
          <a class="text-light" href="<?php echo SERVERURL ?>backUP/">Realizar Restauración</a>
        </li>

      </ul>
    </div>

  <div class="sidebar-upgrade-banner">
    <p class="text-gray">Upgrade to <b class="text-primary">PRO</b> for more exciting features</p>
    <a class="btn upgrade-btn" target="_blank" href="http://www.uxcandy.co/product/label-pro-admin-template/">Upgrade to PRO</a>
  </div>
</div>
<!-- partial -->