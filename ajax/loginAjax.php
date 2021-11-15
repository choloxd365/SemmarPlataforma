<?php

	$peticionAjax=true;
	require_once '../core/configGeneral.php';
	require_once"../controladores/loginControlador.php";
	$logout=new loginControlador();
	if (isset($_GET['Token'])){

	    echo $logout->cerrar_sesion_controlador();
		
	}else{
		session_start(['name'=>'SEMMAR']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}