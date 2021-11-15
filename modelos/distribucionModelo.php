<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class distribucionModelo extends mainModel{

		public static function agregar_distribucion_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO DistribucionCostos(id_ordencli,id_cat_banco,desc_dis,precio_dis,
			moneda_dis,tipo_cambio_dis,categoria_dis,fecha_dis) 
			VALUES ( :id_ordencli,:id_cat_banco,:desc_dis,:precio_dis,:moneda_dis,:tipo_cambio_dis,:categoria_dis,now())");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":desc_dis",$datos['desc_dis']);
			$sql->bindParam(":precio_dis",$datos['precio_dis']);
			$sql->bindParam(":moneda_dis",$datos['moneda_dis']);
			$sql->bindParam(":tipo_cambio_dis",$datos['tipo_cambio_dis']);
			$sql->bindParam(":categoria_dis",$datos['categoria_dis']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function actualizar_distribucion_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE DistribucionCostos SET desc_dis=:desc_dis,precio_dis=:precio_dis,categoria_dis=:categoria_dis WHERE id_dis=:id_dis; ");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_dis",$datos['id_dis']);
			$sql->bindParam(":desc_dis",$datos['desc_dis']);
			$sql->bindParam(":precio_dis",$datos['precio_dis']);
			$sql->bindParam(":categoria_dis",$datos['categoria_dis']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function actualizar_banco_distribucion_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE DistribucionCostos SET id_cat_banco=:id_cat_banco WHERE id_dis=:id_dis; ");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_dis",$datos['id_dis']);
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function eliminar_distribucion_modelo($id){

			$sql=mainModel::conectar()->prepare("DELETE FROM DistribucionCostos WHERE id_dis='$id'");
			$sql->execute();
			return $sql;

		}
		public static function unir_distribucion_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE DistribucionCostos SET id_ordencli=:id_ordencli WHERE id_ordencli=:id_ordencli_antigua");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_ordencli_antigua",$datos['id_ordencli_antigua']);
			$sql->execute();
			return $sql;
		
		
		}	


	}