<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class bancoModelo extends mainModel{

		public static function agregar_banco_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO Banco(nombre_banco,moneda_banco,tipo_cuenta_banco) 
			VALUES ( :nombre_banco,:moneda_banco,:tipo_cuenta_banco)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":nombre_banco",$datos['nombre_banco']);
			$sql->bindParam(":moneda_banco",$datos['moneda_banco']);
			$sql->bindParam(":tipo_cuenta_banco",$datos['tipo_cuenta_banco']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function agregar_categoria_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO CategoriaBanco(id_banco,nombre_cate,monto_actual,monto_retirado) 
			VALUES ( :id_banco,:nombre_cate,:monto_actual,0)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_banco",$datos['id_banco']);
			$sql->bindParam(":nombre_cate",$datos['nombre_cate']);
			$sql->bindParam(":monto_actual",$datos['monto_actual']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function agregar_retiro_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE CategoriaBanco SET monto_retirado=monto_retirado+:monto WHERE id_cat_banco=:id_cat_banco");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":monto",$datos['monto']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function disminuir_monto_actual_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE CategoriaBanco SET monto_actual=monto_actual - :monto WHERE id_cat_banco=:id_cat_banco");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":monto",$datos['monto']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function abonar_monto_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE CategoriaBanco SET monto_actual=monto_actual + :monto WHERE id_cat_banco=:id_cat_banco");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":monto",$datos['monto']);
			$sql->execute();
			return $sql;
		
		
		}
		public static function agregar_transaccion_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO Transacciones(id_persona,id_ordencli,id_cat_banco,monto_tra,tipo_tra,fecha_tra) 
			VALUES ( :id_persona,:id_ordencli,:id_cat_banco,:monto_tra,:tipo_tra,now())");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":monto_tra",$datos['monto_tra']);
			$sql->bindParam(":tipo_tra",$datos['tipo_tra']);
			$sql->execute();
			return $sql;
		
		
		}	
		
		public static function gasto_distribucion_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE CategoriaBanco SET monto_retirado=monto_retirado - :monto WHERE id_cat_banco=:id_cat_banco");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":monto",$datos['monto']);
			$sql->execute();
			return $sql;
		
		
		}
		public static function gasto_tercero_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE CategoriaBanco SET monto_actual=monto_actual - :monto WHERE id_cat_banco=:id_cat_banco");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":monto",$datos['monto']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function data_cate_banco_modelo($id){

			$sql=mainModel::conectar()->prepare("SELECT * FROM CategoriaBanco ca INNER JOIN Banco ba ON ca.id_banco=ba.id_banco where id_cat_banco='$id'");
			$sql->execute();
			return $sql;
		
		
		}	
		
		public static function agregar_pago_tercero_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO PagoExterno(id_cat_banco,desc_pago,monto_pago,tipo_cambio_pago,fecha_pago) 
			VALUES ( :id_cat_banco,:desc_pago,:monto_pago,:tipo_cambio_pago,now())");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":desc_pago",$datos['desc_pago']);
			$sql->bindParam(":monto_pago",$datos['monto_pago']);
			$sql->bindParam(":tipo_cambio_pago",$datos['tipo_cambio_pago']);
			$sql->execute();
			return $sql;
		
		
		}	

		
		public static function update_id_orden_transaccion_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE Transacciones SET id_ordencli=:id_ordencli WHERE id_ordencli=:id_ordencli_antigua");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_ordencli_antigua",$datos['id_ordencli_antigua']);
			$sql->execute();
			return $sql;
		
		
		}
		public static function eliminar_banco_modelo($id){

			$sql=mainModel::conectar()->prepare("UPDATE categoriabanco SET estado='inactivo' WHERE id_cat_banco=$id");
			
			$sql->execute();
			return $sql;
		
		
		}

	}