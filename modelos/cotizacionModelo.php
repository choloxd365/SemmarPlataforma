<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class cotizacionModelo extends mainModel{

		
		protected function agregar_cotizacion_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO cotizacion (id_cotizacion,cod_cot,fecha_cot,nombre_cot,nota_cot,estado_cot)
			VALUES(:id_cotizacion,:cod_cot,now(),:nombre_cotizacion,:nota,'Solicitud')");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_cotizacion",$datos['id_cotizacion']);
			$sql->bindParam(":cod_cot",$datos['cod_cot']);
			$sql->bindParam(":nombre_cotizacion",$datos['nombre_cotizacion']);
			$sql->bindParam(":nota",$datos['nota']);
			$sql->execute();
			return $sql;
		}
		protected function agregar_detallecotizacion_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO detallecotizacion(id_persona,cod_det_cot,id_cotizacion,cantidad_det,unidad_det,desc_det)
			VALUES(:id_persona,:cod_det_cot,:id_cotizacion,:cantidad_det,:unidad_det,:desc_det)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":cod_det_cot",$datos['cod_det_cot']);
			$sql->bindParam(":id_cotizacion",$datos['id_cotizacion']);
			$sql->bindParam(":cantidad_det",$datos['cantidad_det']);
			$sql->bindParam(":unidad_det",$datos['unidad_det']);
			$sql->bindParam(":desc_det",$datos['desc_det']);
			$sql->execute();
			return $sql;
		}
		function eliminar_codigocotizacion_modelo($datos){
		   $sql=mainModel::conectar()->prepare("DELETE FROM DetalleCotizacion WHERE cod_det_cot=:cod_cot and id_cotizacion!=:id_cotizacion; DELETE FROM Cotizacion WHERE cod_cot=:cod_cot and id_cotizacion!=:id_cotizacion");
		   //le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
		   $sql->bindParam(":cod_cot",$datos['cod_cot']);
		   $sql->bindParam(":id_cotizacion",$datos['id_cotizacion']);
		   $sql->execute();
		   return $sql;
	   }
	   protected function eliminar_cotizacion_modelo($datos){
		  $sql=mainModel::conectar()->prepare("DELETE FROM DetalleCotizacion WHERE cod_det_cot=:cod_cot and id_cotizacion=:id_cotizacion; DELETE FROM Cotizacion WHERE cod_cot=:cod_cot and id_cotizacion=:id_cotizacion");
		  //le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
		  $sql->bindParam(":cod_cot",$datos['cod_cot']);
		  $sql->bindParam(":id_cotizacion",$datos['id_cotizacion']);
		  $sql->execute();
		  return $sql;
	  }
	  public function aceptar_cotizacion_modelo($id){
		 $sql=mainModel::conectar()->prepare("UPDATE cotizacion SET estado_cot='Aceptada' WHERE  id_cotizacion='$id'");
		 $sql->execute();
		 return $sql;
	 }
	 public function update_fecha_cot_modelo($id){
		$sql=mainModel::conectar()->prepare("UPDATE cotizacion SET fecha_cot=now() WHERE  id_cotizacion='$id'");
		$sql->execute();
		return $sql;
	}

    }