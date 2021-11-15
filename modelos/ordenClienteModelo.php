<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class ordenClienteModelo extends mainModel{

		public static function agregar_orden_cliente_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO OrdenCliente(id_ordencli,id_cotcli,id_persona,
			igv_ordencli, moneda_ordencli, tipo_cambio_ordencli, subtotal_ordencli, total_ordencli, pago_efectivo_ordencli, tipo_servicio, numero_guia, 
             fecha_ordencli, fecha_factura, id_estado) 
			VALUES (:id_ordencli, :id_cotcli, :id_persona,
			:igv_ordencli, :moneda_ordencli, :tipo_cambio_ordencli,:subtotal_ordencli,
            :total_ordencli, 0, :tipo_servicio, :numero_guia, now(), '', :id_estado)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_cotcli",$datos['id_cotcli']);
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":igv_ordencli",$datos['igv_ordencli']);
			$sql->bindParam(":moneda_ordencli",$datos['moneda_ordencli']);
			$sql->bindParam(":tipo_cambio_ordencli",$datos['tipo_cambio_ordencli']);
			$sql->bindParam(":subtotal_ordencli",$datos['subtotal_ordencli']);
			$sql->bindParam(":total_ordencli",$datos['total_ordencli']);
			$sql->bindParam(":tipo_servicio",$datos['tipo_servicio']);
			$sql->bindParam(":numero_guia",$datos['numero_guia']);
			$sql->bindParam(":id_estado",$datos['id_estado']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function agregar_detalle_orden_cliente_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO DetalleOrdenCliente(id_ordencli,desc_det_ordencli
			,unidad_det_ordencli,cantidad_det_ordencli,precio_det_ordencli) 
			VALUES (:id_ordencli,:desc_det_ordencli,:unidad_det_ordencli,:cantidad_det_ordencli,:precio_det_ordencli)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":desc_det_ordencli",$datos['desc_det_ordencli']);
			$sql->bindParam(":unidad_det_ordencli",$datos['unidad_det_ordencli']);
			$sql->bindParam(":cantidad_det_ordencli",$datos['cantidad_det_ordencli']);
			$sql->bindParam(":precio_det_ordencli",$datos['precio_det_ordencli']);
			$sql->execute();
			return $sql;
		
		
		}
		public static function agregar_num_orden_cliente_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO NumOrden(num_orden,id_ordencli) 
			VALUES (:num_orden,:id_ordencli)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":num_orden",$datos['num_orden']);
			$sql->execute();
			return $sql;
		
		
		}	
		public static function data_orden_cliente_modelo($id){

			$sql=mainModel::conectar()->prepare("SELECT * FROM OrdenCliente WHERE id_ordencli='$id'");
			$sql->execute();
			return $sql;
		
		
		}
		
		public static function data_numero_orden_cliente_modelo($id){

			$sql=mainModel::conectar()->prepare("SELECT * FROM NumOrden WHERE id_ordencli='$id'");
			$sql->execute();
			return $sql;
		
		
		}
		public static function delete_numero_orden_modelo($id){

			$sql=mainModel::conectar()->prepare("DELETE  FROM NumOrden WHERE id_numero_orden='$id'");
			$sql->execute();
			return $sql;
		
		}
		
		public static function update_ordencliente_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE OrdenCliente SET id_estado=:id_estado WHERE id_ordencli=:id_orden");
			$sql->bindParam(":id_orden",$datos['id_orden']);
			$sql->bindParam(":id_estado",$datos['id_estado']);
			$sql->execute();
			return $sql;
		
		}

		public static function actualizar_ordencliente_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE OrdenCliente SET total_ordencli=:total_ordencli,
																	   subtotal_ordencli=:subtotal_ordencli,
																	   igv_ordencli=:igv_ordencli,
																	   tipo_cambio_ordencli=:tipo_cambio_ordencli,
																	   tipo_servicio=:tipo_servicio,
																	   numero_guia=:numero_guia,
																	   moneda_ordencli=:moneda_ordencli,
																	   id_estado=:id_estado
																	    WHERE id_ordencli=:id_ordencli");
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":total_ordencli",$datos['total_ordencli']);
			$sql->bindParam(":subtotal_ordencli",$datos['subtotal_ordencli']);
			$sql->bindParam(":igv_ordencli",$datos['igv_ordencli']);
			$sql->bindParam(":tipo_servicio",$datos['tipo_servicio']);
			$sql->bindParam(":numero_guia",$datos['numero_guia']);
			$sql->bindParam(":moneda_ordencli",$datos['moneda_ordencli']);
			$sql->bindParam(":tipo_cambio_ordencli",$datos['tipo_cambio_ordencli']);
			$sql->bindParam(":id_estado",$datos['id_estado']);
			$sql->execute();
			return $sql;
		
		}
		public static function update_pagoefectivo_ordencliente_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE OrdenCliente SET pago_efectivo_ordencli=:monto,
														tipo_cambio_efectivo_ordencli=:tipo_cambio_efectivo_ordencli,
														moneda_pago_efectivo_ordencli=:moneda_pago_efectivo_ordencli 
														WHERE id_ordencli=:id_orden");
			$sql->bindParam(":id_orden",$datos['id_orden']);
			$sql->bindParam(":monto",$datos['monto']);
			$sql->bindParam(":tipo_cambio_efectivo_ordencli",$datos['tipo_cambio_efectivo_ordencli']);
			$sql->bindParam(":moneda_pago_efectivo_ordencli",$datos['moneda_pago_efectivo_ordencli']);
			$sql->execute();
			return $sql;
		
		}
		public static function update_numero_orden_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE NumOrden SET id_ordencli=:id_ordencli WHERE id_ordencli=:id_ordencli_antigua");
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_ordencli_antigua",$datos['id_ordencli_antigua']);
			$sql->execute();
			return $sql;
		
		}
		public static function delete_orden_modelo($id){

			$sql=mainModel::conectar()->prepare("UPDATE ordencliente set id_estado=8 WHERE id_ordencli='$id'");
			$sql->execute();
			return $sql;
		
		}
		public static function update_detalle_orden_modelo($datos){

			$sql=mainModel::conectar()->prepare("UPDATE DetalleOrdenCliente SET id_ordencli=:id_ordencli WHERE id_ordencli=:id_ordencli_antigua");
			$sql->bindParam(":id_ordencli",$datos['id_ordencli']);
			$sql->bindParam(":id_ordencli_antigua",$datos['id_ordencli_antigua']);
			$sql->execute();
			return $sql;
		
		}


	}