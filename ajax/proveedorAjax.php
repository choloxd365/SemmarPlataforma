
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/proveedorControlador.php';
$instancearProveedor = new proveedorControlador();

if(isset($_POST['id_tipo_persona_reg']) && isset($_POST['raz-social-reg'])) {
	

	echo $instancearProveedor->agregar_proveedor_controlador();


}elseif(isset($_POST['idPersonaDel'])){

	echo $instancearProveedor->eliminar_proveedor_controlador($_POST['idPersonaDel']);

}elseif(isset($_POST['dataPersona'])){

	echo $instancearProveedor->actualizar_proveedor_controlador();

}elseif(isset($_POST['textoBusqueda'])){

	echo $instancearProveedor->busqueda_proveedor_controlador("seleccionar",$_POST['tipo']);
	
}elseif(isset($_POST['listadoBusqueda'])){

	echo $instancearProveedor->busqueda_proveedor_controlador("",$_POST['tipo']);
	
}elseif(isset($_POST['id_persona'])){

	echo $instancearProveedor->datos_cliente_orden_controlador($_POST['id_persona']);

}elseif(isset($_POST['id_persona_cot'])){

	echo $instancearProveedor->datos_proveedor_controlador($_POST['id_persona_cot']);

}elseif(isset($_POST['delEmail'])){

	echo $instancearProveedor->eliminar_Emailproveedor_controlador($_POST['delEmail']);

}elseif(isset($_POST['agregarEmail']) && isset($_POST['idPer']) ){

	echo $instancearProveedor->agregar_Emailproveedor_controlador();

}elseif(isset($_POST['retornar_id'])){

	return '<script>alert("jeje")</script>';

}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
