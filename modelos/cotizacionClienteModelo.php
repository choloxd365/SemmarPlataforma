<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class cotizacionClienteModelo extends mainModel{

		
		protected function agregar_cotizacion_cliente_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO CotizacionCliente (id_cotcli,cod_cot,id_persona,cantidad_cotcli,subtotal_cotcli,igv_cotcli,total_cotcli,moneda_cotcli,nota_cotcli,fecha_cotcli,estado)
			VALUES(:id_cotcli,:cod_cot,:id_persona,:cantidad_cotcli,:subtotal_cotcli,:igv_cotcli,:total_cotcli,:moneda_cotcli,:nota_cotcli,now(),'Pendiente')");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cotcli",$datos['id_cotcli']);
			$sql->bindParam(":cod_cot",$datos['cod_cot']);
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":cantidad_cotcli",$datos['cantidad_cotcli']);
			$sql->bindParam(":subtotal_cotcli",$datos['subtotal_cotcli']);
			$sql->bindParam(":igv_cotcli",$datos['igv_cotcli']);
			$sql->bindParam(":total_cotcli",$datos['total_cotcli']);
			$sql->bindParam(":moneda_cotcli",$datos['moneda_cotcli']);
			$sql->bindParam(":nota_cotcli",$datos['nota_cotcli']);
			$sql->execute();
			return $sql;
		}
		protected function agregar_detalle_cotizacion_cliente_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO DetalleCotizacionCliente (id_cotcli,desc_det_cotcli
			,precio_det_cotcli,cantidad_det_cotcli,unidad_det_cotcli)
			VALUES(:id_cotcli,:desc_det_cotcli,:precio_det_cotcli,:cantidad_det_cotcli,:unidad_det_cotcli)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cotcli",$datos['id_cotcli']);
			$sql->bindParam(":desc_det_cotcli",$datos['desc_det_cotcli']);
			$sql->bindParam(":precio_det_cotcli",$datos['precio_det_cotcli']);
			$sql->bindParam(":cantidad_det_cotcli",$datos['cantidad_det_cotcli']);
			$sql->bindParam(":unidad_det_cotcli",$datos['unidad_det_cotcli']);
			$sql->execute();
			return $sql;
		}
		protected function eliminar_cotizacion_cliente_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM CotizacionCliente WHERE id_cotcli='$id'");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos
			$sql->execute();
			return $sql;
		}
		public function actualizar_cotizacion_cliente_modelo($id){
			$sql=mainModel::conectar()->prepare("UPDATE CotizacionCliente SET estado='Aceptada' WHERE id_cotcli='$id'");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos
			$sql->execute();
			return $sql;
		}
    }
