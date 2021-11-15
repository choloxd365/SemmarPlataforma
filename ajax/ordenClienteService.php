<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/ordenClienteControlador.php';
$controladores= new ordenClienteControlador();

if(isset($_POST["json"])){

	
	echo $controladores->listar_union_ordenes_controlador();
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
