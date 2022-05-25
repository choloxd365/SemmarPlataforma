
<?php
 
 $datos = explode("/", $_GET['views']);

    require_once "./controladores/bancoControlador.php";
    
    $classDoc = new bancoControlador();
    echo $classDoc->eliminar_banco_controlador($datos[1]);
echo '2';





?>