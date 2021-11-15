<?php 
	if ($peticionAjax) {
			require_once '../core/mainModel.php';
		}else{
			require_once './core/mainModel.php';
		}
	class proveedorModelo extends mainModel{

		protected function agregar_proveedor_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO persona(id_tipo_persona,id_beneficiario,razon_social,representante,ruc,telefono,estado) 
			VALUES (:id_tipo_persona,:id_beneficiario,:razon_social,:representante,:ruc,:telefono,'Activo')");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_tipo_persona",$datos['id_tipo_persona']);
			$sql->bindParam(":id_beneficiario",$datos['id_beneficiario']);
			$sql->bindParam(":razon_social",$datos['razon_social']);
			$sql->bindParam(":representante",$datos['representante']);
			$sql->bindParam(":ruc",$datos['ruc']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->execute();
			return $sql;
		}
		protected function agregar_emailproveedor_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO Email(id_persona,email) 
			VALUES (:id_persona,:email)");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":email",$datos['email']);
			$sql->execute();
			return $sql;
		}
		protected function actualizar_proveedor_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE Persona SET id_tipo_persona=:id_tipo_persona,id_beneficiario=:id_beneficiario,razon_social=:razon_social,representante=:representante,ruc=:ruc,telefono=:telefono WHERE id_persona=:id_persona");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":id_tipo_persona",$datos['id_tipo_persona']);
			$sql->bindParam(":id_beneficiario",$datos['id_beneficiario']);
			$sql->bindParam(":razon_social",$datos['razon_social']);
			$sql->bindParam(":representante",$datos['representante']);
			$sql->bindParam(":ruc",$datos['ruc']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->execute();
			return $sql;
		}
		protected function data_proveedor_modelo($id){
			$sql=mainModel::conectar()->prepare("SELECT * FROM Persona WHERE id_persona='$id'");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos
			$sql->execute();
			return $sql;
		}
		protected function data_Emailproveedor_modelo($id){
			$sql=mainModel::conectar()->prepare("SELECT * FROM Email WHERE id_persona='$id' order by id_email DESC");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos
			$sql->execute();
			return $sql;
		}
		protected function eliminar_proveedor_modelo($id){
			$sql=mainModel::conectar()->prepare("UPDATE Persona SET estado='Inactivo' WHERE id_persona='$id'");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos
			$sql->execute();
			return $sql;
		}
		

		protected function eliminar_Emailproveedor_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM Email WHERE id_email='$id'");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos
			$sql->execute();
			return $sql;
		}
		
		
		protected function pago_proveedor_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO PagoProveedor(id_persona,id_cat_banco,desc_pago,monto_pago,fecha_pago) 
			VALUES (:id_persona,:id_cat_banco,:desc_pago,:monto_pago,now())");
			//le ponemos 'dni' y mas porque en el controlador definimos ese array de datos 
			$sql->bindParam(":id_persona",$datos['id_persona']);
			$sql->bindParam(":id_cat_banco",$datos['id_cat_banco']);
			$sql->bindParam(":desc_pago",$datos['desc_pago']);
			$sql->bindParam(":monto_pago",$datos['monto_pago']);
			$sql->execute();
			return $sql;
		}
    }