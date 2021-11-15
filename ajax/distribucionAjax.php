
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/distribucionControlador.php';
$instancearDistribucion = new distribucionControlador();

if(isset($_POST['id_orden'])){

	
	echo $instancearDistribucion->agregar_distribucion_controlador();
}elseif(isset($_POST["id_dis_up"])){

	
	echo $instancearDistribucion->datos_distribucion_controlador($_POST["id_dis_up"]);
}elseif(isset($_POST['id_dis_actualizar'])){

	
	echo $instancearDistribucion->actualizar_distribucion_controlador();
}elseif(isset($_POST['id_dis_eliminar'])){

	
	echo $instancearDistribucion->eliminar_distribucion_controlador();
}elseif(isset($_POST['busqueda']) && isset($_POST["id_orden_dis"])){

	
	echo $instancearDistribucion->lista_distribucion_controlador(1, 100,$_POST["id_orden_dis"],$_POST["busqueda"]);
}elseif(isset($_POST['monto_banco_retorno_igv'])||isset($_POST['id_orden_igv'])){

	
	echo $instancearDistribucion->retorno_igv_controlador();
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
