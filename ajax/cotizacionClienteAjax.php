
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/cotizacionClienteControlador.php';
$instancearCotizacion = new cotizacionClienteControlador();

if(isset($_POST['registrar_cotizacion_cliente'])){

	echo $instancearCotizacion->agregar_cotizacion_cliente_controlador();
}elseif(isset($_POST['eliminarCotizacionCliente'])){

	echo $instancearCotizacion->eliminar_cotizacion_cliente_controlador($_POST['eliminarCotizacionCliente']);
}elseif(isset($_POST['buscarCotCliPendiente'])){

	echo $instancearCotizacion->paginador_cotizacion_cliente_controlador(1,100,$_POST["tipo"],$_POST["buscarCotCliPendiente"]);
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
