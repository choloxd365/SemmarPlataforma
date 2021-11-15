
<?php

$peticionAjax=true;
require_once '../core/configGeneral.php';

require_once '../controladores/cotizacionControlador.php';
$instancearCotizacion = new cotizacionControlador();

if(isset($_POST['registrar_cotizacion'])){

	echo $instancearCotizacion->agregar_cotizacion_controlador();
}elseif(isset($_POST['codigo_cot']) && isset($_POST['id_cotizacion'])){

	echo $instancearCotizacion->eliminar_cotizacion_controlador();

}elseif(isset($_POST['cod_cot'])){

	echo $instancearCotizacion->list_detalle_cot($_POST['cod_cot']);

}elseif(isset($_POST['buscarCotSoli'])){

	echo $instancearCotizacion->paginador_cotizacion_controlador(0, 40,"busquedaSolicitud",$_POST['buscarCotSoli']);
	
}elseif(isset($_POST['buscarCotAce'])){

	echo $instancearCotizacion->paginador_cotizacion_controlador(0, 40,"busquedaAceptada",$_POST['buscarCotAce']);
	
}else{

	echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
}
