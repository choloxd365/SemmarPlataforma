
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/ordenControlador.php';
$instancearOrden = new ordenControlador();

if(isset($_POST['nombre_orden_reg'])){

	
	echo $instancearOrden->agregar_orden_controlador();
}elseif(isset($_POST['texto'])){

	
	echo $instancearOrden->buscar_orden_proveedor($_POST["texto"],$_POST['tipo']);
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
