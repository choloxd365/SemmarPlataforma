
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/ordenClienteControlador.php';
$instancearOrden = new ordenClienteControlador();

if(isset($_POST['registrar_cotizacion_cliente'])){

	
	echo $instancearOrden->agregar_orden_cliente_controlador();
}elseif(isset($_POST["busqueda"])){
	
	echo $instancearOrden->paginador_orden_cliente_controlador(1, 100,"busqueda",$_POST["busqueda"]);
}elseif(isset($_POST["tipo"])){
	
	echo $instancearOrden->paginador_orden_cliente_controlador(1, 100,$_POST["tipo"],$_POST["buscar"]);
}elseif(isset($_POST["id_estado_up"])){
	
	echo $instancearOrden->update_ordencliente_controlador();
	
}elseif(isset($_POST["monto_pago_efectivo"])){
	
	echo $instancearOrden->update_pagoefectivo_ordencliente_controlador();
	
}elseif(isset($_POST["unir_ordenes_id"])){
	
	echo $_POST["unir_ordenes_id"][0];
	
}elseif(isset($_POST["desc_union_orden"])){
	
	echo $instancearOrden->unir_ordenes_controlador();
	
}elseif(isset($_POST["id_ordencli_up"])){
	
	echo $instancearOrden->actualizar_orden_controlador();
	
}elseif(isset($_POST["id_orden_num_orden"])){
	
	echo $instancearOrden->actualizar_numero_orden_controlador();
	
}elseif(isset($_POST["delNumOrden"])){
	
	echo $instancearOrden->eliminar_numero_orden_controlador();
	
}elseif(isset($_POST["id_ordenCliente_eliminar"])){
	
	echo $instancearOrden->eliminar_orden_cliente_controlador($_POST["id_ordenCliente_eliminar"]);
	
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
