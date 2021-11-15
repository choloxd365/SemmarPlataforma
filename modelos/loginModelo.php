<?php 
if ($peticionAjax) {
	require_once '../core/mainModel.php';
}else{
	require_once './core/mainModel.php';
}

class loginModelo extends mainModel
{
	
	protected function iniciar_sesion_modelo($datos){

		$sql=mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario=:Usuario  AND password=:Clave ;");
		$sql->bindParam('Usuario',$datos["Usuario"]);
		$sql->bindParam('Clave',$datos["Clave"]);
		$sql->execute();
		return $sql;
	}

	protected function cerrar_sesion_modelo($datos){
		if ( $datos['Token_S']==$datos['Token']) {
			
			session_unset();
			session_destroy();
			$respuesta="true";
		}else{
			$respuesta="false";
			
			
		}
		return $respuesta;
	}
}