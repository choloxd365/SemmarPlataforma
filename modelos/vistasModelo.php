<?php 
	class vistasModelo{
		protected function obtener_vistas_modelo($vistas){
			$listaBlanca=["home","tablas","forms","proveedor","proveedorList","proveedorCot","proveedorCotList","ordenCompra","proveedorup","cotAceptada",
			"ordenProveeList","ordenClienteList","cliente","clienteList","emailUp","clienteCot","clienteCotList","cotCliAceptada","ordenCliente",
			"clienteCotListAceptad","distribucion","ordenClienteListEmerg","banco","gastoBanco","pagosExternos","ordenClienteUP","joinOrden","backUP",
			"numeroOrdenUP","eliminarBanco"];
			if(in_array($vistas, $listaBlanca)){
				if(is_file("./vistas/contenido/".$vistas."-view.php")){
					$contenido="./vistas/contenido/".$vistas."-view.php";
				}else{
					$contenido="login";
				}
			}elseif($vistas=="login"){
				$contenido="login";
			}elseif($vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}