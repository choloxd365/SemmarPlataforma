<?php
if ($peticionAjax) {
    require_once "../modelos/cotizacionModelo.php";
} else {
    require_once "./modelos/cotizacionModelo.php";
}

class cotizacionControlador extends cotizacionModelo
{




    public static function agregar_cotizacion_controlador()
    {

        $id_persona = mainModel::limpiar_cadena($_POST['id_per']);
        $nota = mainModel::limpiar_cadena($_POST['nota']);
        //array 
        $correo = mainModel::limpiar_cadena($_POST['correo']);
        //
        $cod_cot = mainModel::limpiar_cadena($_POST['cod_cot']);
        $nombreCotizacion = mainModel::limpiar_cadena($_POST['nombreCot']);
        $cantidadInputs = mainModel::limpiar_cadena($_POST['cantidadInputs']);

        $consulta = mainModel::ejecutar_consulta_simple("SELECT id_cotizacion FROM cotizacion ");
        //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
        $numero = ($consulta->rowCount()) + 1;

        //generar codigo para cada cuenta
        $codigo = mainModel::generar_codigo_aleatorio("REQ-", 7, $numero);

        if ($id_persona == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "Por Favor seleccionar el cliente !",
                "Tipo" => "error"
            ];
        } else {
            $dataCotizacion = [


                "id_cotizacion" => $codigo,
                "cod_cot" => $cod_cot,
                "nombre_cotizacion" => $nombreCotizacion,
                "nota" => $nota

            ];

            $guardarCotizacion = cotizacionModelo::agregar_cotizacion_modelo($dataCotizacion);
            if ($guardarCotizacion->rowCount() >= 1) {


                if ($cantidadInputs != 0) {
                    $descripcion = mainModel::limpiar_cadena($_POST['descripcion']);
                    $cantidad = mainModel::limpiar_cadena($_POST['cantidad']);
                    $unidad = mainModel::limpiar_cadena($_POST['unidad']);

                    for ($i = 0; $i < $cantidadInputs; $i++) {
                        $dataDetalleCotizacion = [
                            "id_persona" => $id_persona,
                            "cod_det_cot" => $cod_cot,
                            "id_cotizacion" => $codigo,
                            "cantidad_det" => $cantidad[$i],
                            "unidad_det" => $unidad[$i],
                            "desc_det" => $descripcion[$i]

                        ];
                        $guardarDetalleCotizacion = cotizacionModelo::agregar_detallecotizacion_modelo($dataDetalleCotizacion);

                    }

                        if ($guardarDetalleCotizacion->rowCount() >= 1) {
                           
                            $correosArray=array();
                            $cantidadCorreo=count($correo);
                            for ($i=0; $i < $cantidadCorreo; $i++) { 
                                array_push($correosArray,$correo[$i]);
                            }
                            $array=mainModel::enviar_array($correosArray);

                
                            $alerta = [

                                "Alerta" => "redireccionar",
                                "Titulo" => "Exito al registrar",
                                "Texto" => "La cotización fue correctamente registrada ",
                                "Tipo" => "success",
                                "Contenido" => "vistas/pdf/impresionbook-view.php?id=$codigo&cant=$cantidadCorreo&id_email=$array",
                                "Variable" => ""
                            ];
                        } else {
                            $alerta = [
                                "Alerta" => "simple",
                                "Titulo" => "Algo salió mal",
                                "Texto" => "No se pudo registrar Cotizacion. ¡Ups!",
                                "Tipo" => "error"
                            ];
                        }
                }
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo registrar Cotizacion. ¡Ups!1",
                    "Tipo" => "error"
                ];
            }
        }



        return mainModel::sweet_alert($alerta);
    }

    public function paginador_cotizacion_controlador($pagina, $registros, $tipo, $busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if ($tipo == "lista") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.fecha_cot,co.cod_cot,co.id_cotizacion, pe.id_persona,pe.razon_social,pe.representante,pe.telefono,co.nombre_cot, co.estado_cot FROM cotizacion co INNER JOIN detallecotizacion de ON co.id_cotizacion= de.id_cotizacion 
        INNER JOIN persona pe ON de.id_persona=pe.id_persona WHERE co.estado_cot='Solicitud' ORDER BY fecha_cot DESC LIMIT $inicio,$registros";
            $paginaurl = "proveedorCotList";
        } elseif ($tipo == "aceptada") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.fecha_cot,co.cod_cot,co.id_cotizacion, pe.id_persona,pe.razon_social,pe.representante,pe.telefono,co.nombre_cot, co.estado_cot FROM cotizacion co INNER JOIN detallecotizacion de ON co.id_cotizacion= de.id_cotizacion 
        INNER JOIN persona pe ON de.id_persona=pe.id_persona WHERE co.estado_cot='Aceptada' ORDER BY fecha_cot DESC LIMIT $inicio,$registros";
            $paginaurl = "cotAceptada";
        } elseif ($tipo == "busquedaSolicitud" && isset($busqueda) && $busqueda != "") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.fecha_cot,co.cod_cot,co.id_cotizacion, pe.id_persona,pe.razon_social,pe.representante,pe.telefono,co.nombre_cot, co.estado_cot FROM cotizacion co INNER JOIN detallecotizacion de ON co.id_cotizacion= de.id_cotizacion 
        INNER JOIN persona pe ON de.id_persona=pe.id_persona WHERE co.estado_cot='Solicitud' and (pe.razon_social like '%$busqueda%') ORDER BY fecha_cot DESC LIMIT $inicio,$registros";
            $paginaurl = "proveedorCotList";

        }elseif ($tipo == "busquedaAceptada" && isset($busqueda) && $busqueda != "") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.fecha_cot,co.cod_cot,co.id_cotizacion, pe.id_persona,pe.razon_social,pe.representante,pe.telefono,co.nombre_cot, co.estado_cot FROM cotizacion co INNER JOIN detallecotizacion de ON co.id_cotizacion= de.id_cotizacion 
        INNER JOIN persona pe ON de.id_persona=pe.id_persona WHERE co.estado_cot='Aceptada' and (pe.razon_social like '%$busqueda%') ORDER BY fecha_cot DESC LIMIT $inicio,$registros";
            $paginaurl = "cotAceptada";
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
                    <th style="color:#F28165;"><b>NOMBRE DE COTIZACION</th>
                    <th style="color:#F28165;"><b>RAZON SOCIAL</th>
                        <th style="color:#F28165;"><b>ATENCION</th>
                        <th style="color:#F28165;"><b>TELEFONO</th>
                        <th style="color:#F28165;"><b>VER PDF</th>';

        if ($tipo == "lista" || $tipo=="busquedaSolicitud") {
            $tabla .= '
                        <th style="color:#F28165;"><b>ORD. COMPRA</th>
                        <th style="color:#F28165;"><b>ELIMINAR</th>';
        } else {
            $tabla .= '
                            <th>Fecha</th>';
        }
        $tabla .= '
                    <th>Estado</th>';

        $tabla .= '</tr>';




        $tabla .= '			
                    </thead>
                    <tbody>
';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {

                $data = $rows['cod_cot'];
                $tabla .= '
    <tr >
    <td class="d-flex align-items-center border-top-0">';
    if ($tipo == "lista") {
        $tabla.='<img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cotizacion/reloj.jpg" alt="profile image">';
    }elseif($tipo == "aceptada"){

        $tabla.='<img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cotizacion/cotizacion.jpg" alt="profile image">';
   
    }elseif($tipo == "busquedaSolicitud"){
        
        $tabla.='<img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cotizacion/reloj.jpg" alt="profile image">';
   
    }elseif($tipo == "busquedaAceptada"){
        
        $tabla.='<img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cotizacion/cotizacion.jpg" alt="profile image">';
   
    }
      
      $tabla.='<span>' . $rows['nombre_cot'] . '</span>
    </td>
    <td>' . $rows['razon_social'] . '</td>
    <td>' . $rows['representante'] . '</td>
    <td>' . $rows['telefono'] . '</td>
    <td>';
                $path = "././vistas/pdf/cotizaciones/";
                $i = 0;
                if (file_exists($path)) {
                    $directorio = opendir($path);
                    while ($archivo = readdir($directorio)) {
                        if (!is_dir($archivo) && $i++ == 0) {


                            $tabla .= '
							<a href="' . SERVERURL . 'vistas/pdf/cotizaciones/' . $rows['id_cotizacion'] . '.pdf" ><img width="30" src="' . SERVERURL . 'vistas/images/pdf/logo.png" alt="Los Tejos" /></a>';
                        }
                    }
                } else {
                    $path = ".././vistas/pdf/cotizaciones/";
                    $i = 0; $directorio = opendir($path);
                    while ($archivo = readdir($directorio)) {
                        if (!is_dir($archivo) && $i++ == 0) {


                            $tabla .= '
							<a href="' . SERVERURL . 'vistas/pdf/cotizaciones/' . $rows['id_cotizacion'] . '.pdf" ><img width="30" src="' . SERVERURL . 'vistas/images/pdf/logo.png" alt="Los Tejos" /></a>';
                        }
                    }
                }

                if ($tipo == "lista" || $tipo=="busquedaSolicitud") {
                    $tabla .= '</td><td>
        <form action="' . SERVERURL . 'ordenCompra/" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" hidden name="id_persona" value="' . $rows['id_persona'] . '">
            <input type="hidden" hidden name="id_cotizacion" value="' . $rows['id_cotizacion'] . '">
            <input type="hidden" hidden name="cod_cot" value="' . $rows['cod_cot'] . '">
            <input class="btn btn-inverse-success" type="submit" value="Ord.Compra" >
        </form>
        
    </td>
    <td>    

        <form   action="' . SERVERURL . 'ajax/cotizacionAjax.php" method="POST" data-form="delete" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="id_cotizacion" value="' . $rows['id_cotizacion'] . '">
        <input type="hidden" name="codigo_cot" value="' . $rows['cod_cot'] . '">
        <input type="submit" name="eliminar-proveedor" value="Eliminar" class="btn btn-inverse-danger">
    </form>
    <div id="RespuestaAjax"></div>
    </td>';
                } else {
                    $tabla .= '<td>' . $rows['fecha_cot'] . '</td>';
                }

                $tabla .= ' <td><button type="button" onclick="ObtenerIdCotizacion(String(' . $data . '));" class="btn btn-outline-success btn-rounded" data-toggle="modal" data-target="#previewModal">Ver</button></td>';


                $tabla .= '</tr>';

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


    public static function list_detalle_cot($idCot)
    {


        $result = mainModel::ejecutar_consulta_simple("SELECT DISTINCT * FROM DetalleCotizacion WHERE cod_det_cot='$idCot' GROUP BY desc_det ");

        $select = "";

        $select .= '<div class="grid table-responsive">
                <table class="table table-stretched">
                  <thead>
                    <tr>
                      <th>Nombre de Producto</th>
                      <th>Unidad</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>';



        foreach ($result as $key => $row) {

            $select .= ' <tr>
                <td>
                  <p class="mb-n1 font-weight-medium">' . $row["desc_det"] . '</p>
                </td>
                <td class="font-weight-medium">' . $row["unidad_det"] . '</td>
                <td class="text-danger font-weight-medium">
                  <div class="badge badge-success">' . $row["cantidad_det"] . '</div>
                </td>
              </tr>';
        }

        $select .= '</tbody>
                </table>
              </div>';

        return $select;
    }

    public static  function eliminar_cotizacion_controlador()
    {
        $id_cotizacion = mainModel::limpiar_cadena($_POST["id_cotizacion"]);
        $cod_cot = mainModel::limpiar_cadena($_POST["codigo_cot"]);

        $dataEliminar = [
            "id_cotizacion" => $id_cotizacion,
            "cod_cot" => $cod_cot
        ];
        $eliminar = cotizacionModelo::eliminar_cotizacion_modelo($dataEliminar);
        if ($eliminar->rowCount() >= 1) {

            $file="../vistas/pdf/cotizaciones/".$id_cotizacion.".pdf";
            if(is_file($file)){
				chmod($file,0777);
				if(!unlink($file)){
					$alerta = [
                        "Alerta" => "recargar",
                        "Titulo" => "Cotizacion Eliminada",
                        "Texto" => "Exito al eliminar cotizacion",
                        "Tipo" => "success"
                    ];
				}else{
					
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Algo salió mal",
                        "Texto" => "No se pudo eliminar Cotizacion. ¡Ups!",
                        "Tipo" => "error"
                    ];
				}
			}
            



            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Cotizacion Eliminada",
                "Texto" => "Exito al eliminar cotizacion",
                "Tipo" => "success"
            ];
        } else {

            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo eliminar Cotizacion. ¡Ups!1",
                "Tipo" => "error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }
}
