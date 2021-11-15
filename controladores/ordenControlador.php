<?php
if ($peticionAjax) {
    require_once "../modelos/ordenModelo.php";
    require_once "../modelos/cotizacionModelo.php";
} else {
    require_once "./modelos/ordenModelo.php";
    require_once "./modelos/cotizacionModelo.php";
}

class ordenControlador extends ordenModelo
{

    public static function agregar_orden_controlador()
    {
        //IDS PARA ELIMINAR COTIZACION Y DETALLES
        $id_cotizacion = mainModel::limpiar_cadena($_POST['idCotDel']);
        $cod_cot = mainModel::limpiar_cadena($_POST['cod_cotDel']);

        //ID DE LAS RELACIONES
        $id_persona = mainModel::limpiar_cadena($_POST['id_persona']);


        //ARREGLOS
        $desc_pro = mainModel::limpiar_cadena($_POST['producto']);
        $cant_pro = mainModel::limpiar_cadena($_POST['cantidad']);
        $precio_pro = mainModel::limpiar_cadena($_POST['precio']);
        $unidad_pro = mainModel::limpiar_cadena($_POST['unidad']);
        //DATOS DE ORDEN DE COMPRA

        $nombre_orden = mainModel::limpiar_cadena($_POST['nombre_orden_reg']);
        $subtotal_ord = mainModel::limpiar_cadena($_POST['subtotal']);
        $igv_ord = mainModel::limpiar_cadena($_POST['igv']);
        $total_ord = mainModel::limpiar_cadena($_POST['total']);
        $nota_ord = mainModel::limpiar_cadena($_POST['nota']);
        $correo = mainModel::limpiar_cadena($_POST['correo']);


        $consulta = mainModel::ejecutar_consulta_simple("SELECT id_orde FROM ordencompra ");
        //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
        $numero = ($consulta->rowCount()) + 1;

        //generar codigo para cada cuenta
        $codigo = mainModel::generar_codigo_aleatorio("ORD", 7, $numero);

        if($id_persona==''){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "Por favor seleccionar cliente",
                "Tipo" => "error"
            ];

        }else{
            $dataOrden = [


                "id_orden" => $codigo,
                "nombre_ord" => $nombre_orden,
                "subtotal_ord" => $subtotal_ord,
                "igv_ord" => $igv_ord,
                "total_ord" => $total_ord,
                "nota_ord" => $nota_ord
    
            ];
    
            $guardarOrden = ordenModelo::agregar_orden_modelo($dataOrden);
            if ($guardarOrden->rowCount() >= 1) {
                $cantidad = count($precio_pro);
                for ($i = 0; $i < $cantidad; $i++) {
    
                    $dataDetalle = [
                        "id_orden" => $codigo,
                        "id_persona" => $id_persona,
                        "cantidad_ord" => $cant_pro[$i],
                        "unidad_ord" => $unidad_pro[$i],
                        "desc_ord" => $desc_pro[$i],
                        "precio_uni" => $precio_pro[$i]
                    ];
    
                    $guardarDetalle = ordenModelo::agregar_detalle_orden_modelo($dataDetalle);
                }
                if ($guardarDetalle->rowCount() >= 1) {
    
                    if ($id_cotizacion!="" && $cod_cot!="") {
                        
                    $dataeliminarCotizacion = [
                        "id_cotizacion" => $id_cotizacion,
                        "cod_cot" => $cod_cot
                    ];
    
                    $eliminarCot = cotizacionModelo::eliminar_codigocotizacion_modelo($dataeliminarCotizacion);
    
                    if ($guardarDetalle->rowCount() >= 1) {
                        
                        $aceptarCot=cotizacionModelo::aceptar_cotizacion_modelo($id_cotizacion);
                        $aceptarCot=cotizacionModelo::update_fecha_cot_modelo($id_cotizacion);
                        
    
                        if ($aceptarCot->rowCount() >= 1) {
                            $correosArray=array();
                            $cantidadCorreo=count($correo);
                            for ($i=0; $i < $cantidadCorreo; $i++) { 
                                array_push($correosArray,$correo[$i]);
                            }
                            $array=mainModel::enviar_array($correosArray);
                            $alerta = [
    
                                "Alerta" => "redireccionar",
                                "Titulo" => "Exito al registrar",
                                "Texto" => "La cotización fue correctamente registrada",
                                "Tipo" => "success",
                                "Contenido" => "vistas/pdf/ordenPrint.php?id=$codigo&id_email=$array",
                                "Variable" => ""
                            ];
                        }
                        else{
                            $alerta = [
                                "Alerta" => "simple",
                                "Titulo" => "Algo salió mal",
                                "Texto" => "No se pudo actualizar la cotizacion a aceptada ",
                                "Tipo" => "error"
                            ];
                        }
                    }
                    }else{
                        $alerta = [
    
                            "Alerta" => "redireccionar",
                            "Titulo" => "Exito al registrar",
                            "Texto" => "La cotización fue correctamente registrada",
                            "Tipo" => "success",
                            "Contenido" => "vistas/pdf/ordenPrint.php?id=$codigo&correo=$correo",
                            "Variable" => ""
                        ];
                    }
                } else {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Algo salió mal",
                        "Texto" => "No se pudo registrar el detalle ",
                        "Tipo" => "error"
                    ];
                }
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo agregar la orden ",
                    "Tipo" => "error"
                ];
            }
        }
        return mainModel::sweet_alert($alerta);
    }

    
    

    public function paginador_orden_controlador($pagina, $registros,$idBeneficiario)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $idBeneficiario = mainModel::limpiar_cadena($idBeneficiario);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if ($idBeneficiario=="1") {
        $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT ord.id_orden,per.id_beneficiario,per.razon_social,per.representante,per.telefono,ord.nombre_ord,ord.fecha_ord,ord.total_ord FROM ordencompra ord INNER JOIN detalleorden det ON ord.id_orden=det.id_orden INNER JOIN persona per ON det.id_persona=per.id_persona WHERE per.id_beneficiario='1' ORDER BY fecha_ord DESC LIMIT $inicio,$registros";
        $paginaurl = "ordenClienteList";
        }elseif($idBeneficiario=="2"){
            
        $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT ord.id_orden,per.id_beneficiario,per.razon_social,per.representante,per.telefono,ord.nombre_ord,ord.fecha_ord,ord.total_ord FROM ordencompra ord INNER JOIN detalleorden det ON ord.id_orden=det.id_orden INNER JOIN persona per ON det.id_persona=per.id_persona WHERE per.id_beneficiario='2' ORDER BY fecha_ord DESC LIMIT $inicio,$registros";
        $paginaurl = "ordenProveeList";
        }


        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

        $tabla .= '
					<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
                            <tr>
                                <th>Razon Social</th>
                                <th>Representante</th>
                                <th>Nombre Orden</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Ver Pdf</th>
                            </tr>';




        $tabla .= '			
							</thead>
							<tbody>
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
            <tr >
            <td class="d-flex align-items-center border-top-0">';

                if ($rows['id_beneficiario'] == 1) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cliente/ordenCliente.jpg" alt="profile image">';
                } elseif ($rows['id_beneficiario'] == 2) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/proveedor/ordenProvee.png" alt="profile image">';
                }
                $tabla .= '  <span>' . $rows['razon_social'] . '</span>
            </td>
            <td>' . $rows['representante'] . '</td>
            <td>' . $rows['nombre_ord'] . '</td>
            <td>' . $rows['fecha_ord'] . '</td>
            <td>S/ ' . $rows['total_ord'] . '</td>';
            $path = "././vistas/pdf/orden/";
            $i = 0;
            if (file_exists($path)) {
                $directorio = opendir($path);
                while ($archivo = readdir($directorio)) {
                    if (!is_dir($archivo) && $i++ == 0) {


                        $tabla .= '<td>
                        <a href="' . SERVERURL . 'vistas/pdf/orden/' . $rows['id_orden'] . '.pdf" ><img width="30" src="' . SERVERURL . 'vistas/images/pdf/logo.png" alt="Los Tejos" /></a></td>';
                    }
                }
            }
            
                $contador++;
            }
        } else {

            if ($total >= 1) {

                $tabla .= '
				<tr>
					<td colspan="5">
						<a href="' . SERVERURL . '/ordenProveeList/" class="btn btn-sm btn-info btn-raised"> 
							Haga click para recargar el listado
						</a>
					</td>
				</tr>
			';
            } else {
                $tabla .= '
				<tr>
					<td colspan="5">No ay registros</td>
				</tr>
			';
            }
        }

        $tabla .= '</tbody></table></div>';


        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '<div class="d-flex justify-content-center">
            <nav aria-label="...">
      <ul class="pagination">';
            if ($pagina == 1) {
                $tabla .= '<li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>';
            } else {
                $tabla .= '<li class="page-item">
                <a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($pagina - 1) . '" tabindex="-1">Previous</a></li>';
            }


            for ($i = 1; $i < $Npaginas; $i++) {
                if ($pagina == $i) {
                    $tabla .= '<li class="page-item active">
                        <a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($i) . '">' . $i . '<span class="sr-only">(current)</span></a>
                      </li>';
                } else {

                    $tabla .= ' <li class="page-item"><a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($i) . '">' . $i . '</a></li>';
                }
            }


            if ($pagina == $Npaginas) {
                $tabla .= '<li class="page-item disabled">
                <a class="page-link" href="#">Siguiente</a>
              </li>';
            } else {
                $tabla .= '
                <li class="page-item">
                    <a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($pagina + 1) . '">Siguiente</a>
                 </li>';
            }


            $tabla .= '</ul></nav>';
        } else {
            echo '';
        }

        return $tabla;
    }






    public static function buscar_orden_proveedor($texto,$tipo)
    {
       
         
        $registros = 100;
        $pagina = 0;
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


        if ($tipo=="OrdenProveedor" && isset($texto) && $texto!="" ) {

      
            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT ord.id_orden,per.id_beneficiario,per.razon_social,per.representante,per.telefono,ord.nombre_ord,ord.fecha_ord,ord.total_ord FROM ordencompra ord INNER JOIN detalleorden det ON ord.id_orden=det.id_orden INNER JOIN persona per ON det.id_persona=per.id_persona WHERE per.razon_social like '%$texto%' and per.id_beneficiario='2' ORDER BY fecha_ord DESC LIMIT $inicio,$registros";
         
        }elseif($tipo=="OrdenCliente" && isset($texto) && $texto!="" ){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT ord.id_orden,per.id_beneficiario,per.razon_social,per.representante,per.telefono,ord.nombre_ord,ord.fecha_ord,ord.total_ord FROM ordencompra ord INNER JOIN detalleorden det ON ord.id_orden=det.id_orden INNER JOIN persona per ON det.id_persona=per.id_persona WHERE  per.razon_social like '%$texto%' and per.id_beneficiario='1' ORDER BY fecha_ord DESC LIMIT $inicio,$registros";
      
        }

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);
        
        $tabla .= '
					<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
                            <tr>
                                <th>Razon Social</th>
                                <th>Representante</th>
                                <th>Nombre Orden</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Ver Pdf</th>
                            </tr>';




        $tabla .= '			
							</thead>
							<tbody>
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
            <tr >
            <td class="d-flex align-items-center border-top-0">';

                if ($rows['id_beneficiario'] == 1) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cliente/ordenCliente.jpg" alt="profile image">';
                } elseif ($rows['id_beneficiario'] == 2) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/proveedor/ordenProvee.png" alt="profile image">';
                }
                $tabla .= '  <span>' . $rows['razon_social'] . '</span>
            </td>
            <td>' . $rows['representante'] . '</td>
            <td>' . $rows['nombre_ord'] . '</td>
            <td>' . $rows['fecha_ord'] . '</td>
            <td>S/ ' . $rows['total_ord'] . '</td>';
            $path = ".././vistas/pdf/orden/";
            $i = 0;
            if (file_exists($path)) {
                $directorio = opendir($path);
                while ($archivo = readdir($directorio)) {
                    if (!is_dir($archivo) && $i++ == 0) {


                        $tabla .= '<td>
                        <a href="' . SERVERURL . 'vistas/pdf/orden/' . $rows['id_orden'] . '.pdf" ><img width="30" src="' . SERVERURL . 'vistas/images/pdf/logo.png" alt="Los Tejos" /></a></td>';
                    }
                }
            }
            
                $contador++;
            }
        } else {

            if ($total >= 1) {
                $tabla .= '
				<tr>
					<td colspan="5">
						<a href="' . SERVERURL . '/adminlist/" class="btn btn-sm btn-info btn-raised"> 
							Haga click para recargar el listado
						</a>
					</td>
				</tr>
			';
            } else {
                $tabla .= '
				<tr>
					<td colspan="5">No ay registros</td>
				</tr>
			';
            }
        }

        $tabla .= '</tbody></table></div>';
        return $tabla;
    }
}
