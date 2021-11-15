
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/BancoControlador.php';
$instancearBanco= new BancoControlador();

if(isset($_POST['nombre_banco'])){

	
	echo $instancearBanco->agregar_banco_controlador();
}elseif(isset($_POST['busqueda'])){
	
	
	echo $instancearBanco->paginador_orden_banco_controlador(1, 100,$_POST["busqueda"]);
}elseif(isset($_POST['agregar_categoria'])){
	
	
	echo $instancearBanco->agregar_categoria_controlador();
}elseif(isset($_POST["id_cat_banco"])){

	
	echo $instancearBanco->datos_retiro_controlador($_POST["id_cat_banco"]);
}elseif(isset($_POST["retirar_monto"])){

	
	echo $instancearBanco->agregar_retiro_controlador();
}elseif(isset($_POST["abonar_monto"])){

	
	echo $instancearBanco->datos_abono_controlador($_POST["abonar_monto"]);
}elseif(isset($_POST["id_abono"])){

	
	echo $instancearBanco->agregar_abono_controlador();
}elseif(isset($_POST["id_retorno_banco_cliente"])){

	
	echo $instancearBanco->retornar_gasto_orden_banco_controlador();
}elseif(isset($_POST["id_cat_banco_pago_externo"])){

	
	echo $instancearBanco->agregar_pago_externo_controlador();
}elseif(isset($_POST["busqueaTra"])){

	
	echo $instancearBanco->lista_transaccion_controlador(1, 100,$_POST["busqueaTra"]);
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
