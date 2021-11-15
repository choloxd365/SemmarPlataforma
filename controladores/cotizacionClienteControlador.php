<?php
if ($peticionAjax) {
    require_once "../modelos/cotizacionClienteModelo.php";
} else {
    require_once "./modelos/cotizacionClienteModelo.php";
}

class cotizacionClienteControlador extends cotizacionClienteModelo
{




    public static function agregar_cotizacion_cliente_controlador()
    {
        //ESTO ES UN ARRAY//
        $descripcion = mainModel::limpiar_cadena($_POST['descripcion']);
        $precio = mainModel::limpiar_cadena($_POST['precio']);
        $cantidad = mainModel::limpiar_cadena($_POST['cantidad']);
        $unidad = mainModel::limpiar_cadena($_POST['unidad']);
        // FIN DE ARRAY//


        $cantidadInputs = mainModel::limpiar_cadena($_POST['cantidadInputs']);
        $id_persona = mainModel::limpiar_cadena($_POST['id_persona']);
        $cod_cot = mainModel::limpiar_cadena($_POST['cod_cot']);
        $igv_option = mainModel::limpiar_cadena($_POST['igv_option']);
        $igv=0;
        
        $subtotal= mainModel::limpiar_cadena($_POST['subtotal']);
        $igv= mainModel::limpiar_cadena($_POST['igv']);
        $total= mainModel::limpiar_cadena($_POST['total']);
        
        $moneda = mainModel::limpiar_cadena($_POST['moneda']);
        $nota = mainModel::limpiar_cadena($_POST['nota']);
        $correo = mainModel::limpiar_cadena($_POST['correo']);

        $consulta = mainModel::ejecutar_consulta_simple("SELECT id_cotcli FROM CotizacionCliente ");
        //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
        $numero = ($consulta->rowCount()) + 1;

        //generar codigo para cada cuenta
        $codigo = mainModel::generar_codigo_aleatorio("COT-", 7, $numero);

        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT cod_cot FROM CotizacionCliente where cod_cot='$cod_cot'");
        //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
        $numero2 = ($consulta2->rowCount());
         
        if($numero2==0){
            if ($id_persona == "") {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "Por Favor seleccionar el cliente !",
                    "Tipo" => "error"
                ];
            } else {
                $dataCotizacion = [
                    "id_cotcli" => $codigo,
                    "cod_cot" => $cod_cot,
                    "id_persona" => $id_persona,
                    "cantidad_cotcli" => $cantidadInputs,
                    "subtotal_cotcli" => $subtotal,
                    "igv_cotcli" => $igv,
                    "total_cotcli" => $total,
                    "moneda_cotcli" => $moneda,
                    "nota_cotcli" => $nota
    
                ];
    
                $guardarCotizacion = cotizacionClienteModelo::agregar_cotizacion_cliente_modelo($dataCotizacion);
                if ($guardarCotizacion->rowCount() >= 1) {
    
                    $correosArray=array();
                    $cantidadCorreo=count($correo);
                    for ($i=0; $i < $cantidadCorreo; $i++) { 
                        array_push($correosArray,$correo[$i]);
                    }
                    $array=mainModel::enviar_array($correosArray);

                    //for para datos de arreglo//
                    for ($i=0; $i < $cantidadInputs; $i++) { 
                        $datosDetalleCotCli=[
                        

                            "id_cotcli" => $codigo,
                            "desc_det_cotcli" => $descripcion[$i],
                            "precio_det_cotcli" => $precio[$i],
                            "cantidad_det_cotcli" => $cantidad[$i],
                            "unidad_det_cotcli" => $unidad[$i]
                            
                            
                            ];
                      
                            $guardarDetalleCotizacion = cotizacionClienteModelo::agregar_detalle_cotizacion_cliente_modelo($datosDetalleCotCli);
                        }
                      if ($guardarDetalleCotizacion->rowCount() >= 1) {
    
                        $alerta = [

                            "Alerta" => "redireccionar",
                            "Titulo" => "Exito al registrar",
                            "Texto" => "La cotización fue correctamente registrada ",
                            "Tipo" => "success",
                            "Contenido" => "vistas/pdf/cotizacionPrint-view.php?id=$codigo&id_email=$array",
                            "Variable" => ""
                        ];
                    }else{
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Algo salió mal",
                            "Texto" => "No se pudo registrar Cotizacion. ¡Ups! :c",
                            "Tipo" => "error"
                        ];
                    }

                } else {
                                $alerta = [
                                    "Alerta" => "simple",
                                    "Titulo" => "Algo salió mal",
                                    "Texto" => "No se pudo registrar Cotizacion. ¡Ups! :c",
                                    "Tipo" => "error"
                                ];
                }
                    
            }

        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "Por favor recargar la página",
                "Tipo" => "error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }



    
    public function paginador_cotizacion_cliente_controlador($pagina, $registros, $tipo,$busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if ($tipo == "Pendiente") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.cod_cot,pe.id_persona,pe.razon_social,pe.representante,co.id_cotcli,subtotal_cotcli,igv_cotcli,total_cotcli,co.fecha_cotcli,co.estado FROM CotizacionCliente co INNER JOIN DetalleCotizacionCliente det ON co.id_cotcli=det.id_cotcli INNER JOIN Persona pe ON co.id_persona=pe.id_persona WHERE co.estado='Pendiente' ORDER BY co.fecha_cotcli DESC LIMIT $inicio,$registros";
            $paginaurl = "clienteCotList";
        } elseif($tipo == "Aceptada"){

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.cod_cot,pe.id_persona,pe.razon_social,pe.representante,co.id_cotcli,subtotal_cotcli,igv_cotcli,total_cotcli,co.fecha_cotcli,co.estado FROM CotizacionCliente co INNER JOIN DetalleCotizacionCliente det ON co.id_cotcli=det.id_cotcli INNER JOIN Persona pe ON co.id_persona=pe.id_persona WHERE co.estado='Aceptada' ORDER BY co.fecha_cotcli DESC LIMIT $inicio,$registros";
            $paginaurl = "clienteCotListAceptad";
        }elseif($tipo=="CotPendiente" && isset($busqueda) && $busqueda!=""){
            
            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.cod_cot,pe.id_persona,pe.razon_social,pe.representante,co.id_cotcli,subtotal_cotcli,igv_cotcli,total_cotcli,co.fecha_cotcli,co.estado
                         FROM CotizacionCliente co 
                         INNER JOIN DetalleCotizacionCliente det ON co.id_cotcli=det.id_cotcli
                          INNER JOIN Persona pe ON co.id_persona=pe.id_persona
                           WHERE co.estado='Pendiente' AND (pe.razon_social like '%$busqueda%'
                                                         OR det.desc_det_cotcli LIKE '%$busqueda%'
                                                        OR co.cod_cot LIKE '%$busqueda%') 
                                                        ORDER BY co.fecha_cotcli DESC LIMIT $inicio,$registros";
                                                        
            $paginaurl = "clienteCotList";
            
        }elseif($tipo == "CotAceptada" && isset($busqueda) && $busqueda!=""){

            $consulta = "SELECT SQL_CALC_FOUND_ROWS DISTINCT co.cod_cot,pe.id_persona,pe.razon_social,pe.representante,co.id_cotcli,subtotal_cotcli,igv_cotcli,total_cotcli,co.fecha_cotcli,co.estado 
                        FROM CotizacionCliente co 
                        INNER JOIN DetalleCotizacionCliente det ON co.id_cotcli=det.id_cotcli
                         INNER JOIN Persona pe ON co.id_persona=pe.id_persona
                          WHERE co.estado='Aceptada' AND (pe.razon_social like '%$busqueda%' 
                                                        OR det.desc_det_cotcli LIKE '%$busqueda%'
                                                        OR co.cod_cot LIKE '%$busqueda%')
                                                         ORDER BY co.fecha_cotcli DESC LIMIT $inicio,$registros";
            $paginaurl = "clienteCotListAceptad";
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
                    <th style="color:#F28165;"><b>RAZON SOCIAL</th>
                    <th style="color:#F28165;"><b>NUM. REQ.</th>
                        <th style="color:#F28165;"><b>DESCRIPCION</th>
                        <th style="color:#F28165;"><b>SUB TOTAL</th>
                        <th style="color:#F28165;"><b>IGV</th>
                        <th style="color:#F28165;"><b>TOTAL</th>
                        <th style="color:#F28165;"><b>FECHA</th>
                        <th style="color:#F28165;"><b>VER PDF</th>';
                        if($tipo=="Pendiente" || $tipo=="CotPendiente"){
                            $tabla .= '<th style="color:#F28165;"><b>ORD. COMPRA</th>
                        <th style="color:#F28165;"><b>ELIMINAR</b></th>';
                        }else{

                        }
                        $tabla .= ' </tr>';


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
    if ($tipo=="Pendiente"||$tipo=="CotPendiente") {
        $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cotizacion/reloj.jpg" alt="profile image">';
    }elseif($tipo=="Aceptada"||$tipo=="CotAceptada"){

        $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cotizacion/cotizacion.jpg" alt="profile image">';
  
    }
       $tabla .= '<span>' . $rows['razon_social'] . '</span>
      
    </td>
    <td>
    <span>' . $rows['cod_cot'] . '</span>
    </td>
    <td>
    <select  style="width:260px"  class="form-control form-control-lg">' ;
            
        $idCot=$rows['id_cotcli'];
        $result = mainModel::ejecutar_consulta_simple("SELECT  * FROM DetalleCotizacionCliente WHERE id_cotcli='$idCot'");
            

        foreach ($result as $key => $rows2) {
            
            
           $tabla.='<option >'. $rows2["desc_det_cotcli"].'</option>
               ';

        }  
        $tabla.=' </select>
        ';

    
    $tabla.='
    <td>' . $rows['subtotal_cotcli'] . '</td>
    <td>' . $rows['igv_cotcli'] . '</td>
    <td>' . $rows['total_cotcli'] . '</td>
    <td>' . $rows['fecha_cotcli'] . '</td>
    <td>';
                $path = "././vistas/pdf/cotizacionesClientes/";
                $i = 0;
                if (file_exists($path)) {
                    $directorio = opendir($path);
                    while ($archivo = readdir($directorio)) {
                        if (!is_dir($archivo) && $i++ == 0) {


                            $tabla .= '
							<a href="' . SERVERURL . 'vistas/pdf/cotizacionesClientes/' . $rows['id_cotcli'] . '.pdf" ><img width="30" src="' . SERVERURL . 'vistas/images/pdf/logo.png" alt="Los Tejos" /></a>';
                        }
                    }
                } else {
                    $path = ".././vistas/pdf/cotizacionesClientes/";
                    $i = 0; $directorio = opendir($path);
                    while ($archivo = readdir($directorio)) {
                        if (!is_dir($archivo) && $i++ == 0) {


                            $tabla .= '
							<a href="' . SERVERURL . 'vistas/pdf/cotizacionesClientes/' . $rows['id_cotcli'] . '.pdf" ><img width="30" src="' . SERVERURL . 'vistas/images/pdf/logo.png" alt="Los Tejos" /></a>';
                        }
                    }
                }

                    $tabla .= '</td>';
                    
                    if($tipo=="Pendiente" || $tipo=="CotPendiente"){
                        $tabla .= '<td>
        <form action="'.SERVERURL.'ordenCliente/" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
            
        <input type="hidden" hidden name="id_cotcli" value="'.$rows['id_cotcli'].'">
        <input type="hidden" hidden name="id_persona" value="'.$rows['id_persona'].'">
            <input class="btn btn-inverse-success" type="submit" value="Ord.Compra" >
        </form>
        
    </td>
    <td>    

        <form  action="' . SERVERURL . 'ajax/cotizacionClienteAjax.php" method="POST" data-form="delete" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="eliminarCotizacionCliente" value="' . $rows['id_cotcli'] . '">
        <input type="submit" name="eliminar-proveedor" value="Eliminar" class="btn btn-inverse-danger">
    </form>
    <div id="RespuestaAjax"></div>
    </td>';}
               
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


            $contarPaginas = 0;
            for ($i = 1; $i < $Npaginas; $i++) {
                $contarPaginas++;


                if ($pagina == $i) {
                    $tabla .= '<li class="page-item active">
                            <a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($i) . '">' . $i . '<span class="sr-only">(current)</span></a>
                          </li>';
                } else {
                }
            }
            if ($contarPaginas > 3) {

                $tabla .= ' <li class="page-item"><a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($i) . '">' . '...' . '</a></li>';

                $tabla .= ' <li class="page-item"><a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($i) . '">' . $contarPaginas . '</a></li>';
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
    public static function eliminar_cotizacion_cliente_controlador($id)
    {

        $eliminarProveedor = cotizacionClienteModelo::eliminar_cotizacion_cliente_modelo($id);

        if ($eliminarProveedor->rowCount() >= 1) {


                $file="../vistas/pdf/cotizacionesClientes/".$id.".pdf";
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
                            "Texto" => "No se pudo eliminar Cotizacion. ¡Ups!1",
                            "Tipo" => "error"
                        ];
                    }
                }
                
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Cotizacion Eliminada",
                "Texto" => "La cotización fue eliminado correctamente ",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo eliminar la cotizacion",
                "Tipo" => "error"
            ];
        }


        return mainModel::sweet_alert($alerta);
    }


}
