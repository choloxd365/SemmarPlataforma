<?php

	$peticionAjax=true;
	require_once '../core/configGeneral.php';
	require_once "../controladores/sistemaControlador.php";
	$logout=new sistemaControlador();
	if (isset($_POST['back_up'])){

	    echo $logout->crear_backup_controlador();
		
	}else{
		session_start(['name'=>'SEMMAR']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}