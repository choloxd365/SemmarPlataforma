

<!DOCTYPE html>
<html lang="en">
  


    <!-- INICIO DE HEADER -->
    

    <!-- FIN DE HEADER -->


  <body class="header-fixed">



        <!-- CONTENIDO -->
        <?php 
        session_start(['name'=>'SEMMAR']);
	$peticionAjax=false;
	require_once "./controladores/vistasControlador.php";

		$vt = new vistasControlador();
		$vistasR =$vt -> obtener_vistas_controlador();

		if ($vistasR=="login"|| $vistasR=="404"){
			if ($vistasR=="login") {
                include "modulos/header.php";
                require_once"./vistas/contenido/login-view.php";
                include "modulos/link.php";
			}else{
                include "modulos/header.php";
                require_once"./vistas/contenido/error-view.php";
                
                include "modulos/link.php";
			}
			
		}
		else{
            

			

      include "./controladores/loginControlador.php";
      $lc = new loginControlador();
      
   if (!isset($_SESSION['token_semmar'])){
    echo $lc->forzar_cierre_sesion_controlador();
    header("location:".SERVERURL."");
  }



    ?>
    
    <?php include "modulos/header.php";?>

    
    <?php include "modulos/sidebar.php";?>
	<?php require_once $vistasR; ?>
        <!-- FIN DE CONTENIDO-->

        <?php include "modulos/nav.php";?>
        

        <!-- INICIO DE FOOTER -->
        <?php include "modulos/footer.php";?>
        <!-- FIN DE FOOTER -->
        
      </div>
      <!-- page content ends -->
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    
    <?php include "modulos/link.php";?>
    <!-- endbuild -->
  </body>
  <?php include "modulos/logoutScript.php";?>
</html>
<?php

        }
        ?>