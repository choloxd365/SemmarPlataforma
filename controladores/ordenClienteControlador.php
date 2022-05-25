<?php
if ($peticionAjax) {
    require_once "../modelos/bancoModelo.php";
    require_once "../modelos/distribucionModelo.php";
    require_once "../modelos/ordenClienteModelo.php";
    require_once "../modelos/cotizacionClienteModelo.php";
} else {
    require_once "./modelos/bancoModelo.php";
    require_once "./modelos/distribucionModelo.php";
    require_once "./modelos/ordenClienteModelo.php";
    require_once "./modelos/cotizacionClienteModelo.php";
}

class ordenClienteControlador extends ordenClienteModelo
{

    public static function agregar_orden_cliente_controlador()
    {   //arrays jeje :D
        $desc_orden = mainModel::limpiar_cadena($_POST['descripcion']);
        $unidad_orden = mainModel::limpiar_cadena($_POST['unidad']);
        $cant_orden = mainModel::limpiar_cadena($_POST['cantidad']);
        $precio_orden = mainModel::limpiar_cadena($_POST['precio']);

        //Variables
        $numero_orden = mainModel::limpiar_cadena($_POST['numero-orden']);



        $id_cotizacion = mainModel::limpiar_cadena($_POST['id_cotizacion']);
        $id_persona = mainModel::limpiar_cadena($_POST['id_persona']);
        $moneda = mainModel::limpiar_cadena($_POST['moneda-reg']);
        $tipo_cambio_ordencli = mainModel::limpiar_cadena($_POST['tipo-cambio-reg']);
        $igv_option = mainModel::limpiar_cadena($_POST['igv_option']);
        $servicio_orden = mainModel::limpiar_cadena($_POST['servicio']);
        $guia_orden = mainModel::limpiar_cadena($_POST['numero-guia']);
        $numero_factura = mainModel::limpiar_cadena($_POST['numero-factura']);
        $id_estado_orden = mainModel::limpiar_cadena($_POST['id_estado']);
        $cantidadInputs = mainModel::limpiar_cadena($_POST['cantidadInputs']);
        // subtotal
        $igv = mainModel::limpiar_cadena($_POST['igv']);
        $total_orden = mainModel::limpiar_cadena($_POST['total']);
        $subtotal_orden = mainModel::limpiar_cadena($_POST['subtotal']);



        $consulta = mainModel::ejecutar_consulta_simple("SELECT id_ordencli FROM ordencliente");
        //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
        $numero = ($consulta->rowCount()) + 1;

        //generar codigo para cada cuenta
        $codigo = mainModel::generar_codigo_aleatorio("ORD", 7, $numero);

        if ($id_cotizacion == '') {
            $id_cotizacion = null;
        }



        $dataOrdenCliente = [

            "id_ordencli" => $codigo,
            "id_cotcli" => $id_cotizacion,
            "id_persona" => $id_persona,
            "moneda_ordencli" => $moneda,
            "tipo_cambio_ordencli" => $tipo_cambio_ordencli,
            "subtotal_ordencli" => $subtotal_orden,
            "igv_ordencli" => $igv,
            "total_ordencli" => $total_orden,
            "tipo_servicio" => $servicio_orden,
            "numero_guia" => $guia_orden,
            "numero_factura" => $numero_factura,
            "id_estado" => $id_estado_orden,

        ];


        $guardarOrdenCliente = ordenClienteModelo::agregar_orden_cliente_modelo($dataOrdenCliente);
        if ($guardarOrdenCliente->rowCount() >= 1) {




            for ($i = 0; $i < $cantidadInputs; $i++) {
                $datosDetalleOrdCli = [

                    "id_ordencli" => $codigo,
                    "desc_det_ordencli" => $desc_orden[$i],
                    "unidad_det_ordencli" => $unidad_orden[$i],
                    "cantidad_det_ordencli" => $cant_orden[$i],
                    "precio_det_ordencli" => $precio_orden[$i]

                ];

                $guardarDetalleOrdenCliente = ordenClienteModelo::agregar_detalle_orden_cliente_modelo($datosDetalleOrdCli);
            }


            $dataNumOrden = [

                "num_orden" => $numero_orden,
                "id_ordencli" => $codigo
            ];

            $guardarNumeroOrdenCliente = ordenClienteModelo::agregar_num_orden_cliente_modelo($dataNumOrden);
            if ($guardarNumeroOrdenCliente->rowCount() >= 1) {

                if ($guardarDetalleOrdenCliente->rowCount() >= 1) {
                    $CotizacionUP = cotizacionClienteModelo::actualizar_cotizacion_cliente_modelo($id_cotizacion);

                    if ($CotizacionUP->rowCount() >= 1) {

                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Completado",
                            "Texto" => "Exito al registrar orden",
                            "Tipo" => "success"
                        ];
                    } else {
                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Completado",
                            "Texto" => "Exito al registrar orden",
                            "Tipo" => "success"
                        ];
                    }
                }
            } else {

                print_r($dataNumOrden);
            }
            # code...
        } else {
            echo 'error';
        }



        return mainModel::sweet_alert($alerta);
    }

    public function paginador_orden_cliente_controlador($pagina, $registros, $tipo, $busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if ($tipo == "busqueda" && isset($busqueda) && $busqueda != "") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS *FROM ordencliente ord 
             INNER JOIN cotizacioncliente co ON ord.id_cotcli=co.id_cotcli
              INNER JOIN persona pe ON co.id_persona=pe.id_persona 
              INNER JOIN estadoordencliente es ON ord.id_estado=es.id_estado
              INNER JOIN numorden num ON ord.id_ordencli=num.id_ordencli
              INNER JOIN detalleordencliente det ON ord.id_ordencli=det.id_ordencli
                        
               WHERE
               (pe.razon_social LIKE '%$busqueda%' AND  num_orden LIKE '%$busqueda%')
               and ord.id_estado!='1005'
                ORDER BY ord.fecha_ordencli DESC LIMIT $inicio,$registros";
            $paginaurl = "ordenClienteList";
        } elseif ($tipo == "busquedaEmergente" && isset($busqueda) && $busqueda != "") {

            $consulta = "SELECT  SQL_CALC_FOUND_ROWS  * FROM ordencliente ord 
                        INNER JOIN persona pe ON ord.id_persona=pe.id_persona
                        INNER JOIN estadoordencliente es ON ord.id_estado=es.id_estado 
                        INNER JOIN numorden num ON ord.id_ordencli=num.id_ordencli
                        INNER JOIN detalleordencliente det ON ord.id_ordencli=det.id_ordencli
                        WHERE ord.id_cotcli is null  and ord.id_estado!='8'and
               (pe.razon_social LIKE '%$busqueda%' AND num_orden LIKE '%$busqueda%')
                        GROUP BY ord.id_ordencli 
                        
                        ORDER BY ord.fecha_ordencli DESC LIMIT $inicio,$registros";
            $paginaurl = "ordenClienteListEmerg";
        } elseif ($tipo == "Emergente") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS *FROM ordencliente ord
                        INNER JOIN persona pe ON ord.id_persona=pe.id_persona 
                        INNER JOIN estadoordencliente es ON ord.id_estado=es.id_estado
                        WHERE ord.id_cotcli is null and ord.id_estado!='8'
                        ORDER BY ord.fecha_ordencli DESC LIMIT $inicio,$registros";
                        $paginaurl = "ordenClienteListEmerg";
        } else {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS numero_factura,igv_ordencli,ord.subtotal_ordencli,ord.total_ordencli,ord.moneda_ordencli,es.nombre_estado,ord.id_ordencli,ord.id_estado,ord.id_ordencli,pe.razon_social,pe.representante,co.id_cotcli,ord.tipo_servicio,subtotal_ordencli,total_ordencli,ord.fecha_ordencli FROM ordencliente ord INNER JOIN cotizacioncliente co ON ord.id_cotcli=co.id_cotcli INNER JOIN persona pe ON co.id_persona=pe.id_persona INNER JOIN estadoordencliente es ON ord.id_estado=es.id_estado WHERE ord.id_estado!='8' ORDER BY ord.fecha_ordencli DESC LIMIT $inicio,$registros";
            $paginaurl = "ordenClienteList";
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
							<thead class="thead-dark bg-danger" >
                            <tr >
                            
                            <th style="color:#F28165;"><b>ORD. COMPRA</b></th>
                            <th style="color:#F28165;"><b>ID</b></th>
                                <th style="color:#F28165;"><b>RAZON SOCIAL</b></th>
                                <th style="color:#F28165;"><b>COTIZACION</b></th>
                                <th style="color:#F28165;"><b>DESCRIPCION</b></th>
                                <th style="color:#F28165;"><b>NUMERO FACTURA</b></th>
                                <th style="color:#F28165;"><b>TIPO SERVICIO</b></th>
                                <th style="color:#F28165;"><b>ESTADO</b></th>
                                <th style="color:#F28165;"><b>MONEDA</b></th>';
                                $sumaSubtotal = 0;
                                $result5 = mainModel::ejecutar_consulta_simple($consulta);
                        
                        
                                foreach ($result5 as $key => $rows9) {
                                    $sumaSubtotal = $sumaSubtotal + $rows9["subtotal_ordencli"];
                                }
                        
                                $tabla .= '<th style="color:#F28165;"><b>SUB TOTAL ( S/ ' . mainModel::moneyFormat($sumaSubtotal , "USD") . ')</b></th>';
        $sumaTotaligv = 0;
        $result1 = mainModel::ejecutar_consulta_simple($consulta);


        foreach ($result1 as $key => $rows3) {
            $sumaTotaligv = $sumaTotaligv + $rows3["totaligv"];
        }

        $sumaTotaligv2 = 0;
        $result2 = mainModel::ejecutar_consulta_simple($consulta);


        foreach ($result2 as $key => $rows4) {
            $sumaTotaligv2 = $sumaTotaligv2 + $rows4["subtotal_ordencli"] * 0.18;
        }

        $tabla .= '

                                <th style="color:#F28165;"><b>IGV ( S/ ' . mainModel::moneyFormat($sumaTotaligv + $sumaTotaligv2, "USD") . ')</b></th>';

        $sumaTotal = 0;
        $result3 = mainModel::ejecutar_consulta_simple($consulta);


        foreach ($result3 as $key => $rows3) {
            $sumaTotal = $sumaTotal + ($rows3["total_ordencli"]*$rows3["tipo_cambio_ordencli"]);
        }

        $tabla .= '
                                <th style="color:#F28165;"><b>TOTAL ( S/ ' . mainModel::moneyFormat($sumaTotal+$sumaTotaligv2, "USD") . ')</b></th>
                                <th style="color:#F28165;"><b>INVERSION</b></th>
                                <th style="color:#F28165;"><b>FECHA ORD.</b></th>
                                <th style="color:#F28165;"><b>DISTRIBUCION DE GASTOS</b></th>
                                <th style="color:#F28165;"><b>EDITAR</b></th>
                                <th style="color:#F28165;"><b>ELIMINAR</b></th>
                            </tr>';




        $tabla .= '			
							</thead>
							<tbody>
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $id_estado = $rows["id_estado"];
                $idcot = '';

                if (isset($rows['id_cotcli'])) {
                    $idcot = $rows['id_cotcli'];
                } else {
                    $idcot = 'Sin Cotización';
                }
                $tabla .= '
                <input hidden value="' . $rows['id_ordencli'] . '" id="id_orden">
            <tr >
            <td class="d-flex align-items-center border-top-0"><div class="input-group mb-3">
            <div class="input-group-prepend" style="padding-top:12px;">
              <div class="input-group-text">
              
                <input value="' . $rows['id_ordencli'] . '" name="unir_ordenes_id[]" type="checkbox" >
              
                
                </div>
              </div>
              </div>';



                $tabla .= ' 
                 <span>
                  
                <select  style="width:160px"  class="form-control form-control-lg">';

                $id_orden = $rows['id_ordencli'];
                $result = mainModel::ejecutar_consulta_simple("SELECT  * FROM numorden  WHERE id_ordencli='$id_orden' ORDER BY id_numero_orden desc");


                foreach ($result as $key => $rows2) {


                    $tabla .= '<option >' . $rows2["num_orden"] . '</option>
                    ';
                }
                $tabla .= ' </select>
                </span>
            </td>
            <td>' . $rows['id_ordencli'] . '</td>
            <td>' . $rows['razon_social'] . '</td>
            <td>' . $idcot . '</td>
            <td>
            
            <select  style="width:260px"  class="form-control form-control-lg">';

                $idCot = $rows['id_ordencli'];
                $result = mainModel::ejecutar_consulta_simple("SELECT  * FROM detalleordencliente WHERE id_ordencli='$idCot' ORDER BY id_det_ordencli desc ");


                foreach ($result as $key => $rows2) {


                    $tabla .= '<option >' . $rows2["desc_det_ordencli"] . ' (' . $rows2["precio_det_ordencli"] . ')</option>
                ';
                }
                $tabla .= ' </select>
            ';


                $tabla .= '
        </td>
        <td>' . $rows['numero_factura'] . '</td>
        <td>' . $rows['tipo_servicio'] . '</td>
            <td>
                <select id="select_estado"  name="id_estado" style="width:140px" onchange="actualizar_estado(this);" class="form-control form-control-lg">';

                if ($rows['id_estado'] == 4) {

                    $tabla .= '<option disable selected  value="' . $rows['id_estado'] . '">' . $rows["nombre_estado"] . '</option>';
                } elseif($rows['id_estado'] == 7) {
                   
                    $tabla .= '<option disable selected  value="FINALIZADO">FINALIZADO</option>';
              
                }else{
                    $result = mainModel::ejecutar_consulta_simple("SELECT * FROM estadoordencliente WHERE id_estado!='$id_estado' and ( id_estado!=4 AND id_estado!=5 AND id_estado!=6 AND id_estado!=7 AND id_estado!=8 AND id_estado!=1005)  ORDER BY id_estado ");

                    $tabla .= '<option selected  value="' . $rows['id_estado'] . '">' . $rows["nombre_estado"] . '</option>';

                    foreach ($result as $key => $rows2) {


                        $tabla .= '<option  value="' . $rows2["id_estado"] . '">' . $rows2["nombre_estado"] . '</option>
                   ';
                    }
                }

                $tabla .= ' </select>
            </td>
            <td>' . $rows['moneda_ordencli'] . '</td>
            <td>' . mainModel::moneyFormat($rows['subtotal_ordencli'], "USD") . '</td>';

                if ($rows["igv_ordencli"] == 0) {
                    $tabla .= '<td>' . mainModel::moneyFormat($rows['subtotal_ordencli'] * 0.18, "USD") . '</td>';
                } else {
                    $tabla .= '<td>' . mainModel::moneyFormat($rows['igv_ordencli'], "USD") . '</td>';
                }


                $tabla .= '<td>' . mainModel::moneyFormat($rows['total_ordencli']+$rows['subtotal_ordencli'] * 0.18, "USD") . '</td>';

                $id_orden = $rows['id_ordencli'];
                $montoGastado = 0;
                $result = mainModel::ejecutar_consulta_simple("SELECT precio_dis  FROM distribucioncostos WHERE id_ordencli ='$id_orden'");


                foreach ($result as $key => $rows5) {
                    $montoGastado = $montoGastado + $rows5["precio_dis"];
                }

                $tabla .= '<td>' . mainModel::moneyFormat($montoGastado, "USD") . '</td>
            <td>' . $rows['fecha_ordencli'] . '</td>
            <td>
            <form action="' . SERVERURL . 'distribucion" method="POST">
            <input hidden name="id_ordenCliente" value="' . $rows['id_ordencli'] . '">
            <input class="btn btn-inverse-success" type="submit" value="Distribución" >
            </form>
            </td>
            <td>
            <a href="' . SERVERURL . 'ordenClienteUP/' . $rows['id_ordencli'] . '" class="btn btn-inverse-info" >ACTUALIZAR</a>
            </td>
            <td>
            <form action="' . SERVERURL . 'ajax/ordenCliente.php"  method="POST" data-form="delete" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

            <input hidden name="id_ordenCliente_eliminar" value="' . $rows['id_ordencli'] . '">
            <input class="btn btn-inverse-danger" type="submit" value="Eliminar" >
            </form>
            <div class="RespuestaAjax" id="RespuestaAjax">
            </div>
            </td>';


                $contador++;
            }
        } else {

            if ($total >= 1) {

                $tabla .= '
				<tr>
					<td colspan="5">
						<a href="' . SERVERURL . '/ordenClienteList/" class="btn btn-sm btn-info btn-raised"> 
							Haga click para recargar el listado
						</a>
					</td>
				</tr>
			';
            } else {
                $tabla .= '
				<tr>
					<td colspan="5">No hay registros</td>
				</tr>
			';
            }
        }

        $tabla .= '</tbody></table></div>';


        if ($total >= 1 && $pagina <= $Npaginas && ($tipo == "lista" || $tipo == "Emergente")) {
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

    public function data_orden_cliente_controlador($id)
    {
        return ordenClienteModelo::data_orden_cliente_modelo($id);
    }

    public function data_numero_orden_cliente_controlador($id)
    {
        return ordenClienteModelo::data_numero_orden_cliente_modelo($id);
    }

    
    public static function actualizar_numero_orden_controlador()
    {   //arrays jeje :D
        $id_orden = mainModel::limpiar_cadena($_POST['id_orden_num_orden']);
        $num_orden = mainModel::limpiar_cadena($_POST['numero_orden']);

        $dataUP=[
            "id_ordencli"=>$id_orden,
            "num_orden"=>$num_orden
        ];
        $ejecutarConsulta=ordenClienteModelo::agregar_num_orden_cliente_modelo($dataUP);

        if ($ejecutarConsulta->rowCount()>=1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Completado",
                "Texto" => "Exito al agregar Numero orden",
                "Tipo" => "success"

            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo agregar Numero orden. ¡Ups!",
                "Tipo" => "error"
            ];
        }
        return mainModel::sweet_alert($alerta);
    }
    
    public static function eliminar_numero_orden_controlador()
    {   //arrays jeje :D
        $id_num_orden = mainModel::limpiar_cadena($_POST['delNumOrden']);

        $ejecutarConsulta=ordenClienteModelo::delete_numero_orden_modelo($id_num_orden);

        if ($ejecutarConsulta->rowCount()>=1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Completado",
                "Texto" => "Exito al eliminar Numero orden",
                "Tipo" => "success"

            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo eliminar Numero orden. ¡Ups!",
                "Tipo" => "error"
            ];
        }
        return mainModel::sweet_alert($alerta);
    }



    public static function update_ordencliente_controlador()
    {
        $id_estado = mainModel::limpiar_cadena($_POST["id_estado_up"]);
        $id_orden = mainModel::limpiar_cadena($_POST["id_orden"]);
        $datos = [
            "id_orden" => $id_orden,
            "id_estado" => $id_estado
        ];
        $actualizarEstado = ordenClienteModelo::update_ordencliente_modelo($datos);
        if ($actualizarEstado->rowCount()>=1) {
            # code.if ($ejecutarConsulta->rowCount()>=1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Completado",
                "Texto" => "Exito al actualizar estado.",
                "Tipo" => "success"

            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo actualizar...",
                "Tipo" => "error"
            ];
        }
        return mainModel::sweet_alert($alerta);




    }
    public static function update_pagoefectivo_ordencliente_controlador()
    {
        $monto_pago_efectivo = mainModel::limpiar_cadena($_POST["monto_pago_efectivo"]);
        $moneda_pago_efectivo = mainModel::limpiar_cadena($_POST["moneda-pago-efectivo-reg"]);
        $tipo_cambio_efectivo = mainModel::limpiar_cadena($_POST["tipo-cambio-efectivo-reg"]);
        $id_orden = mainModel::limpiar_cadena($_POST["id_orden_pagoefectivo"]);
        $datos = [
            "id_orden" => $id_orden,
            "monto" => $monto_pago_efectivo,
            "tipo_cambio_efectivo_ordencli" => $tipo_cambio_efectivo,
            "moneda_pago_efectivo_ordencli" => $moneda_pago_efectivo
        ];
        $actualizarPagoEfectivo = ordenClienteModelo::update_pagoefectivo_ordencliente_modelo($datos);
        if ($actualizarPagoEfectivo->rowCount() >= 1) {


            $datos = [
                "id_orden" => $id_orden,
                "id_estado" => 4
            ];
            $actualizarEstado = ordenClienteModelo::update_ordencliente_modelo($datos);

            if ($actualizarEstado->rowCount() >= 1) {
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Pago Efectivo Registrado",
                    "Texto" => "Exito al guardar pago efectivo",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo registrar pago efectivo",
                    "Tipo" => "error"
                ];
            }
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo registrar pago efectivo",
                "Tipo" => "error"
            ];
        }
        return mainModel::sweet_alert($alerta);
    }


    public function listar_union_ordenes_controlador()
    {

        $decodificar = $_POST["json"];
        $id_ordenes = json_decode($decodificar, true);
        $cantidad = count($id_ordenes);
        $contador = 0;
        $totalOrdenes=0;
        for ($i = 0; $i < $cantidad; $i++) {
            $contador++;
            $tabla = '';
            $result = mainModel::ejecutar_consulta_simple("SELECT  * FROM ordencliente ord
             INNER JOIN detalleordencliente det on ord.id_ordencli=det.id_ordencli  
             WHERE ord.id_ordencli ='$id_ordenes[$i]';");
            $total=0;
            while ($row = $result->fetch()) {
                $total=$total+$row["total_ordencli"];
                $contador++;
                $idOrd=$id_ordenes[$i];
                $tabla .= '
                <section id="' . $contador . '">
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="inputEmail4" style="color:#F28165;"><b>NRO O/C</b></label>
                        <input hidden name="cantidadInputs" type="Text" value="' . $contador . '"> 
                        <input type="Text" value="' . $row["id_ordencli"] . '" name="id_ordenes_union_orden[]" class="form-control"  placeholder="Numero de Orden">
                    </div>
                    <div class="form-group col-4">
                    
                    <label for="inputEmail4" style="color:#F28165;"><b>Descripcion</b></label>
                    <select  class="form-control form-control-lg">';

                    $idCot = $row['id_ordencli'];
                    $total_detalle=0;
                    $result = mainModel::ejecutar_consulta_simple("SELECT  * FROM detalleordencliente WHERE id_ordencli='$idOrd' ORDER BY id_det_ordencli desc ");
    
    
                    foreach ($result as $key => $rows2) {
    
                        $total_detalle=$total_detalle+$rows2['precio_det_ordencli'];
    
                        $tabla .= '<option >' . $rows2["desc_det_ordencli"] . ' (' . $rows2["precio_det_ordencli"] . ')</option>
                    ';
                    }
                    $tabla .= ' </select>
                ';
    
                    $totalOrdenes=$totalOrdenes+$total_detalle;
                    $tabla .= '
             </div>
                    <div class="form-group col-2">
                        <label for="inputEmail4" style="color:#F28165;"><b>MONTO</b></label>
                    <select  class="form-control form-control-lg">
                    <option>' . $total_detalle. '</option>
                    </select>
                        </div>
                    <div class="form-group col-2">
                        <label for="inputEmail4" style="color:#F28165;"><b>QUITAR</b></label>
                        <button class="btn btn-outline-primary btn-rounded mdi mdi-delete form-control " type="button"  onclick="eliminar(' . $contador . ')"></button>
                    </div>
                </div>
                </section>';
            }

            print($tabla);
        }
        echo ' 
        <div class="form-group col-6">
            <label for="inputEmail4" style="color:#F28165;"><b>MONTO TOTAL</b></label>
        
            <input class="form-control" name="cantidadInputs" type="Text" value="' . $totalOrdenes . '"> 
            </div><script>
        document.addEventListener("DOMContentLoaded", function() {
          sumarTotalesOrdenes();
        });
    </script>';
    }


    public static function unir_ordenes_controlador()
    {   //arrays jeje :D
        $id_ordenes_antiguas = mainModel::limpiar_cadena($_POST['id_ordenes_union_orden']);

        //campos normales
        $nro_orden = mainModel::limpiar_cadena($_POST['orden_union_orden']);
        $desc_orden = mainModel::limpiar_cadena($_POST['desc_union_orden']);
        $id_persona = mainModel::limpiar_cadena($_POST['id_persona_union_orden']);
        $moneda = mainModel::limpiar_cadena($_POST['moneda_union_orden']);
        $tipo_cambio_ordencli = mainModel::limpiar_cadena($_POST['tipo_cambio_union_orden']);
        $precio_orden = mainModel::limpiar_cadena($_POST['precio_union_orden']);
        $subtotal_orden = mainModel::limpiar_cadena($_POST['precio_union_orden']);
        $total_orden = mainModel::limpiar_cadena($_POST['precio_union_orden']);
        $guia_orden = mainModel::limpiar_cadena($_POST['guia_union_orden']);
        $numero_factura = mainModel::limpiar_cadena($_POST['numero_factura']);
        $cantidadInputs = mainModel::limpiar_cadena($_POST['cantidadInputs']);



        $consulta = mainModel::ejecutar_consulta_simple("SELECT id_ordencli FROM ordencliente");
        //numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
        $numero = ($consulta->rowCount()) + 1;

        //generar codigo para cada cuenta
        $codigo = mainModel::generar_codigo_aleatorio("ORD", 7, $numero);


        $dataOrdenCliente = [

            "id_ordencli" => $codigo,
            "id_cotcli" => null,
            "id_persona" => $id_persona,
            "moneda_ordencli" => $moneda,
            "tipo_cambio_ordencli" => $tipo_cambio_ordencli,
            "subtotal_ordencli" => $subtotal_orden,
            "igv_ordencli" => 0,
            "total_ordencli" => $total_orden,
            "tipo_servicio" => 'FABRICACION',
            "numero_guia" => $guia_orden,
            "numero_factura" => $numero_factura,
            "id_estado" => 1

        ];


        $guardarOrdenCliente = ordenClienteModelo::agregar_orden_cliente_modelo($dataOrdenCliente);
        


        $datosDetalleOrdCli = [

            "id_ordencli" => $codigo,
            "desc_det_ordencli" => $desc_orden,
            "unidad_det_ordencli" => "UNIDAD",
            "cantidad_det_ordencli" => 1,
            "precio_det_ordencli" => $precio_orden

        ];

        $guardarDetalleOrdenCliente = ordenClienteModelo::agregar_detalle_orden_cliente_modelo($datosDetalleOrdCli);


        if ($guardarDetalleOrdenCliente->rowCount() >= 1) {

            $dataNumOrden = [

                "num_orden" => $nro_orden,
                "id_ordencli" => $codigo
            ];

            $guardarNumeroOrdenCliente = ordenClienteModelo::agregar_num_orden_cliente_modelo($dataNumOrden);
            if ($guardarNumeroOrdenCliente->rowCount()>=1) {

                for ($i = 0; $i < $cantidadInputs; $i++) {

                    $datosUpdateDetalle = [
                        "id_ordencli" => $codigo,
                        "id_ordencli_antigua" => $id_ordenes_antiguas[$i]
                    ];
                    $eliminar_orden = ordenClienteModelo::update_detalle_orden_modelo($datosUpdateDetalle);
                    $eliminar_detalle_orden = ordenClienteModelo::delete_orden_modelo($id_ordenes_antiguas[$i]);


                    $datosNumeroOrden = [
                        "id_ordencli" => $codigo,
                        "id_ordencli_antigua" => $id_ordenes_antiguas[$i]
                    ];
                    $updateNroOrden = ordenClienteModelo::update_numero_orden_modelo($datosNumeroOrden);
                    

                    $id_ordenes=$id_ordenes_antiguas[$i];
                    $consulta = mainModel::ejecutar_consulta_simple("SELECT id_dis FROM distribucioncostos WHERE id_ordencli='$id_ordenes'");
                    if ($consulta->rowCount()>=1) {
                        
                    $datos = [
                        "id_ordencli" => $codigo,
                        "id_ordencli_antigua" => $id_ordenes_antiguas[$i]
                    ];
                    $DistribucionUp = distribucionModelo::unir_distribucion_modelo($datos);
                    
                    $datosTransacciones = [
                        "id_ordencli" => $codigo,
                        "id_ordencli_antigua" => $id_ordenes_antiguas[$i]
                    ];
                    $DistribucionUp = bancoModelo::update_id_orden_transaccion_modelo($datosTransacciones);

                    }else{

                    }
                 

                }




                
            } else {

                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo unir ordenes. ¡Ups!",
                    "Tipo" => "error"
                ];
            }
        }
        
          


        return "HOLA";
    }

    
    public static function actualizar_orden_controlador()
    {   //arrays jeje :D
        $id_orden = mainModel::limpiar_cadena($_POST['id_orden_upp']);
        $tipo_servicio_up = mainModel::limpiar_cadena($_POST['tipo_servicio_up']);
        $id_estado_up = mainModel::limpiar_cadena($_POST['id_estado_upp']);
        $numero_guia_up = mainModel::limpiar_cadena($_POST['numero_guia_up']);
        $numero_factura_up = mainModel::limpiar_cadena($_POST['numero_factura_up']);
        $sub_total_up = mainModel::limpiar_cadena($_POST['sub_total_up']);
        $igv_up = mainModel::limpiar_cadena($_POST['igv_up']);
        $total_up = mainModel::limpiar_cadena($_POST['total_up']);
        $moneda_up = mainModel::limpiar_cadena($_POST['moneda_up']);
        $tipo_cambio_up = mainModel::limpiar_cadena($_POST['tipo_cambio_up']);

        $dataUP=[
            "id_ordencli"=>$id_orden,
            "total_ordencli"=>$total_up,
            "subtotal_ordencli"=>$sub_total_up,
            "igv_ordencli"=>$igv_up,
            "tipo_servicio"=>$tipo_servicio_up,
            "numero_guia"=>$numero_guia_up,
            "numero_factura"=>$numero_factura_up,
            "moneda_ordencli"=>$moneda_up,
            "tipo_cambio_ordencli"=>$tipo_cambio_up,
            "id_estado"=>$id_estado_up,

        ];
        $ejecutarConsulta=ordenClienteModelo::actualizar_ordencliente_modelo($dataUP);

        if ($ejecutarConsulta->rowCount()>=1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Completado",
                "Texto" => "Exito al actualizar orden",
                "Tipo" => "success"

            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo actualizar orden. ¡Ups!",
                "Tipo" => "error"
            ];
        }
        return mainModel::sweet_alert($alerta);
    }
    public static function eliminar_orden_cliente_controlador($id)
    {

        $eliminarProveedor = ordenClienteModelo::delete_orden_modelo($id);

        header('Location: '.SERVERURL.'ordenClienteListEmerg/');
    }
}
