
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/gastosControlador.php';
$instancearGasto= new gastosControlador();

if(isset($_POST['id_orden_banco'])){

	
	echo $instancearGasto->agregar_gasto_controlador();
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
