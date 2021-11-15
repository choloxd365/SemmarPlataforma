<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class gastosModelo extends mainModel{

		public static function agregar_gasto_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO DistribucionGastos(id_ordencli,id_banco,desc_gasto,monto_gasto,fecha_gasto) 
			VALUES ( :id_ordencli,:id_banco,:desc_gasto,:monto_gasto,now())");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_banco",$datos['id_banco']);
			$sql->bindParam(":desc_gasto",$datos['desc_gasto']);
			$sql->bindParam(":monto_gasto",$datos['monto_gasto']);
			$sql->execute();
			return $sql;
		
		
		}	
		

	}