<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class ordenModelo extends mainModel{

		public static function agregar_orden_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO OrdenCompra(id_orden,nombre_ord,fecha_ord,subtotal_ord,igv_ord,total_ord,nota_ord,estado_ord) 
			VALUES (:id_orden,:nombre_ord,now(),:subtotal_ord,:igv_ord,:total_ord,:nota_ord,'Activo')");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_orden",$datos['id_orden']);
			$sql->bindParam(":nombre_ord",$datos['nombre_ord']);
			$sql->bindParam(":subtotal_ord",$datos['subtotal_ord']);
			$sql->bindParam(":igv_ord",$datos['igv_ord']);
			$sql->bindParam(":total_ord",$datos['total_ord']);
			$sql->bindParam(":nota_ord",$datos['nota_ord']);
			$sql->execute();
			return $sql;
		
		
		}
		public static function agregar_detalle_orden_modelo($datos){

			$sql=mainModel::conectar()->prepare("INSERT INTO DetalleOrden(id_orden,id_persona,cantidad_ord,unidad_ord,desc_ord,precio_uni,precio_total) 
			VALUES (:id_orden,:id_persona,:cantidad_ord,:unidad_ord,:desc_ord,:precio_uni,:precio_total)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$precio=$datos['precio_uni'];
			$cantidad=$datos['cantidad_ord'];
			$total=$precio*$cantidad;
			$sql->bindParam(":id_orden",$datos['id_orden']);
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":cantidad_ord",$datos['cantidad_ord']);
			$sql->bindParam(":unidad_ord",$datos['unidad_ord']);
			$sql->bindParam(":desc_ord",$datos['desc_ord']);
			$sql->bindParam(":precio_uni",$datos['precio_uni']);
			$sql->bindParam(":precio_total",$total);
			$sql->execute();
			return $sql;
		
		
		}
	}