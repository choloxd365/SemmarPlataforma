
<?php if (isset($_SESSION['tipo_usuario_semmar']) && isset($_SESSION['token_semmar'])): 
header("location:".SERVERURL."home/");

   ?>
<?php else: ?>
  <body>
    <div class="authentication-theme auth-style_1">
      <div class="row">
        <div class="col-12 logo-section">
          <a href="../../index.html" class="logo">
            <img width="600" height="80" src="<?php echo SERVERURL?>vistas/images/logo/logo.jpg" alt="logo" />
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
          <div class="grid">
            <div class="grid-body">
              <div class="row">
                <div class="col-lg-7 col-md-8 col-sm-9 col-12 mx-auto form-wrapper">
                  <form action="" method="POST">
                    <div class="form-group input-rounded">
                      <input type="text" name="Usuario" class="form-control" placeholder="Username" />
                    </div>
                    <div class="form-group input-rounded">
                      <input type="password" name="Clave" class="form-control" placeholder="Password" />
                    </div>
                    <div class="form-inline">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" class="form-check-input" />Remember me <i class="input-frame"></i>
                        </label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"> Login </button>
                  </form>
                  <div class="signup-link">
                    <p>Don't have an account yet?</p>
                    <a href="#">Sign Up</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="auth_footer">
        <p class="text-muted text-center">© SEMMAR MANUFACTURIN 2021</p>
      </div>
    </div>
   
    <!-- endbuild -->
  </body>
</html>

<?php require_once './controladores/loginControlador.php';
    $login = new loginControlador();
    if (isset($_POST['Usuario']) && isset($_POST['Clave'])) {
     
      echo $login->iniciar_sesion_controlador();
    }   
  
?>
<?php endif ?>