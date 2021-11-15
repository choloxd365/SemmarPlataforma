<?php
if ($peticionAjax) {
    require_once "../modelos/distribucionModelo.php";
    require_once "../modelos/bancoModelo.php";
    require_once "../modelos/ordenClienteModelo.php";
} else {
    require_once "./modelos/distribucionModelo.php";
    require_once "./modelos/bancoModelo.php";
    require_once "./modelos/ordenClienteModelo.php";
}

class distribucionControlador extends distribucionModelo
{

    public static function agregar_distribucion_controlador()
    {

        //Variables
        $id_orden = mainModel::limpiar_cadena($_POST['id_orden']);
        $id_cat_banco = mainModel::limpiar_cadena($_POST['id-cat_banco-reg']);
        $desc_dis = mainModel::limpiar_cadena($_POST['descripcion-reg']);
        $precio_dis = mainModel::limpiar_cadena($_POST['precio-reg']);
        $moneda_dis = mainModel::limpiar_cadena($_POST['moneda-reg']);
        $tipo_cambio_dis = mainModel::limpiar_cadena($_POST['tipo-cambio-reg']);
        $categoria_dis = mainModel::limpiar_cadena($_POST['categoria-reg']);
        $credito = mainModel::limpiar_cadena($_POST['credito-reg']);

        
        $datos=mainModel::ejecutar_consulta_simple("SELECT monto_retirado FROM CategoriaBanco WHERE id_cat_banco='$id_cat_banco'");
        $fila=$datos->fetch();
        $monto=$fila[0];

        if ( $credito==""&& $precio_dis>$monto) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "El monto supera al retiro actual, que sea menor a $monto",
                "Tipo" => "error"
            ];
        }elseif($credito!=""){

            $dataDistribucion = [

                "id_ordencli" => $id_orden,
                "id_cat_banco" => NULL,
                "desc_dis" => $desc_dis,
                "precio_dis" => $precio_dis,
                "moneda_dis" => $moneda_dis,
                "tipo_cambio_dis" => $tipo_cambio_dis,
                "categoria_dis" => $categoria_dis
                
    
            ];
    
            $guardarOrdenCliente = distribucionModelo::agregar_distribucion_modelo($dataDistribucion);
            if ($guardarOrdenCliente->rowCount() >= 1) {
    
               
                        
                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Completado",
                            "Texto" => "Exito al registrar Gasto",
                            "Tipo" => "success"
                        ];
                    }else{
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Algo salió mal",
                            "Texto" => "No se pudo agregar gasto. ¡Ups!",
                            "Tipo" => "error"
                        ];
                    }
                        
    
    
    
        }else{


            
            $dataDistribucion = [

                "id_ordencli" => $id_orden,
                "id_cat_banco" => $id_cat_banco,
                "desc_dis" => $desc_dis,
                "precio_dis" => $precio_dis,
                "moneda_dis" => $moneda_dis,
                "tipo_cambio_dis" => $tipo_cambio_dis,
                "categoria_dis" => $categoria_dis
                
    
            ];
    
            $guardarOrdenCliente = distribucionModelo::agregar_distribucion_modelo($dataDistribucion);
            if ($guardarOrdenCliente->rowCount() >= 1) {
    
                $data=[
                    "id_cat_banco"=>$id_cat_banco,
                    "monto"=>$precio_dis
                ];
                $guardarGasto=bancoModelo::gasto_distribucion_modelo($data);
    
                if ($guardarGasto->rowCount()>=1) {
                    
                    $data2=[
                        "id_persona" => NULL,
                        "id_ordencli" => $id_orden,
                        "id_cat_banco"=>$id_cat_banco,
                        "monto_tra"=>$precio_dis,
                        "tipo_tra"=>"DISTRIBUCION"
                    ];
                    $guardarTransaccion=bancoModelo::agregar_transaccion_modelo($data2);
                    
                    if ($guardarTransaccion) {
                        
                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Completado",
                            "Texto" => "Exito al registrar Gasto",
                            "Tipo" => "success"
                        ];
                    }else{
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Algo salió mal",
                            "Texto" => "No se pudo agregar gasto. ¡Ups!",
                            "Tipo" => "error"
                        ];
                    }
                        
                }else{
    
                     $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo agregar gasto. ¡Ups!",
                    "Tipo" => "error"
                ];
    
                }
    
    
                
                
    
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo agregar gasto. ¡Ups!",
                    "Tipo" => "error"
                ];
            }
    
        }

        
        return mainModel::sweet_alert($alerta); 
    }

    public function lista_distribucion_controlador($pagina, $registros,$id_orden,$busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

         if (isset($busqueda) && $busqueda!='') {
              
        $consulta = "SELECT SQL_CALC_FOUND_ROWS dis.id_cat_banco,tipo_cambio_dis,dis.moneda_dis,ba.nombre_banco,ca.nombre_cate,id_dis,desc_dis,precio_dis,categoria_dis,fecha_dis 
        FROM  DistribucionCostos dis INNER JOIN CategoriaBanco  ca ON dis.id_cat_banco=ca.id_cat_banco 
        INNER JOIN Banco ba ON ca.id_banco=ba.id_banco WHERE  (desc_dis LIKE '%$busqueda%' OR categoria_dis LIKE '%$busqueda%' OR 
        nombre_banco LIKE '%$busqueda%' OR nombre_cate LIKE '%$busqueda%'  OR 
        fecha_dis LIKE '%$busqueda%' )  
        and id_ordencli='$id_orden' ORDER BY fecha_dis DESC LIMIT $inicio,$registros";
        
        }else{
               
        $consulta = "SELECT SQL_CALC_FOUND_ROWS dis.id_cat_banco,tipo_cambio_dis,dis.moneda_dis,ba.nombre_banco,ca.nombre_cate,id_dis,desc_dis,precio_dis,categoria_dis,fecha_dis
         FROM DistribucionCostos dis INNER JOIN CategoriaBanco  ca ON dis.id_cat_banco=ca.id_cat_banco  OR dis.id_cat_banco IS NULL
                                     INNER JOIN Banco ba ON ca.id_banco=ba.id_banco
          WHERE id_ordencli='$id_orden'GROUP BY dis.id_dis  ORDER BY fecha_dis  DESC  LIMIT $inicio,$registros";
        
        }
       

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

        $tabla .= ' <thead class="thead-dark">
                        <tr>
                        <th scope="col">Descripción de Inversión</th>
                        <th scope="col">Banco</th>
                        <th scope="col">S/ Inversion</th>
                        <th scope="col">Fecha</th>
                         <th scope="col">Actualizar</th>
                        </tr>
                    </thead><tbody>';





        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $total=0;
            foreach ($datos as $rows) {
                $total=$total+ $rows['precio_dis']*$rows['tipo_cambio_dis'];
                
                $data = $rows["id_dis"];
                $simbolo='';
                if ($rows["moneda_dis"]=="Soles") {
                    $simbolo='S/';
                }else{
                    $simbolo='$ ';
                }
                $tabla .= '
                <tr>
                <td>
                  <p class="mb-n1 font-weight-medium">' . $rows['categoria_dis'] . '</p>
                  <small class="text-gray">' . $rows['desc_dis'] . '</small>
                </td>

                <td>
                  <p class="mb-n1 font-weight-medium">';
                  if ($rows["id_cat_banco"]==NULL) {
                     $tabla.='A CREDITO';
                  }else{
                    $tabla.=$rows['nombre_banco'];
                  }
                $tabla.='</p>
                  <small class="text-gray">';
                  if ($rows["id_cat_banco"]==null) {
                     $tabla.='Pago a plazo';
                  }else{
                    $tabla.= $rows['nombre_cate'] ;
                  }
                $tabla.='</small>
                </td>
                  <td class="font-weight-medium">'.$simbolo.'' .mainModel::moneyFormat($rows['precio_dis'],"USD") . '</td>
                  <td class="font-weight-medium">' . $rows['fecha_dis'] . '</td>
                  <td class="text-danger font-weight-medium">

                    
                  <div onclick="enviarDatosDistribucion('.$data.');"  style="cursor: pointer" class="badge badge-success" data-toggle="modal" data-target="#exampleModalCenter">Administrar</div>
                    
                  </td>
                </tr>';
           
            
                $contador++;
            }
            $tabla.='<tr>
            
            <td></td>
            <td>
            <button type="button" class="btn btn-outline-danger mb-n1 font-weight-medium">Total de Inversion</button>
        </td>
        
        <td class="font-weight-medium">S/' .mainModel::moneyFormat($total,"USD"). '</td>';
            if (isset($busqueda) && $busqueda!='') {
                
        
            }else{
                $tabla.='
                
            <td>
            <button type="button" class="btn btn-outline-info mb-n1 font-weight-medium">Monto de Proyecto</button>
        </td>
             ';  
            
            
                        $montoProyecto=0;          
                        $result = mainModel::ejecutar_consulta_simple("SELECT  total_ordencli  FROM OrdenCliente WHERE id_ordencli ='$id_orden'");
                            

                        foreach ($result as $key => $rows4) {
                            $montoProyecto=$rows4["total_ordencli"];
                        }
                        $restante=$montoProyecto-$total;
                        $tabla.='
                        <td class="font-weight-medium">S/'.mainModel::moneyFormat($montoProyecto,"USD").'</td>
                            </tr>
                            <tr>
                    
                            <td>
                            <p class="mb-n1 font-weight-medium"></p>
                        </td>
                        <td class="font-weight-medium"></td>
                            
                        <td></td>
                        <td>
            <button type="button" class="btn btn-outline-success mb-n1 font-weight-medium">Utilidad Bruta</button>
        </td>
                        
                    
                    <td class="font-weight-medium">S/'.mainModel::moneyFormat($restante,"USD").'</td>';
            }
            $tabla.='</tr>
                    </tbody>
                    ';
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
					<td colspan="5">No Hay registros</td>
				</tr>
			';
            }
        }

        $tabla .= '</tbody></table></div>';


        return $tabla;
    }

    public  function datos_distribucion_controlador($id){

        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM distribucioncostos WHERE id_dis='$id'");

        $inputsLlenos='';
      
        foreach ($result as $key => $rows) {
            
            $inputsLlenos.='
            <form action="'.SERVERURL.'ajax/distribucionAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" value="'.$id.'" name="id_dis_actualizar">
            <input type="hidden" value="'.$rows["id_ordencli"].'" name="id_ordenn">
            <div class="modal-body">
            <div class="form-row">
              <div class="col-6">
              <label class="mr-sm-2" for="inlineFormCustomSelect">Descripción</label>
                <input type="text" class="form-control" name="descripcion-reg" value="'.$rows["desc_dis"].'" placeholder="Descripción">
              </div>
              <div class="col-6 showcase_content_area">
              <label class="mr-sm-2" for="inlineFormCustomSelect">Categoría</label>
              <select name="categoria-reg" class="custom-select">
              <option>'.$rows["categoria_dis"].'</option>
              <option>Materiales</option>
              <option>Comida</option>
              <option>...</option>
            </select>  
              </div>';
              $buscarBanco=$rows["id_cat_banco"];
              if ($buscarBanco==NULL) {
                 $inputsLlenos.='
              <div class="col-6 showcase_content_area">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Banco</label>
              <select name="id_banco_gasto" class="custom-select">';
              
                    $result = mainModel::ejecutar_consulta_simple("SELECT * FROM CategoriaBanco ca INNER JOIN Banco ba ON ca.id_banco=ba.id_banco");

                    foreach ($result as $key => $rows2) {
                        $inputsLlenos.='<option value="'.$rows2["id_cat_banco"].'">'.$rows2["nombre_banco"]." ".$rows2["nombre_cate"].'('.$rows2["monto_retirado"].')</option>';
                    }
              $inputsLlenos.='</select>  
              </div>';
              }
              
             
              $inputsLlenos.='<div class="col-6">
              <label class="mr-sm-2" for="inlineFormCustomSelect">Precio</label>
                <input type="text" name="precio-reg" class="form-control" value="'.$rows["precio_dis"].'" placeholder="Precio">
              </div>
            </div>
              <div class="modal-footer">
              <input type="submit"  class="btn btn-inverse-success" value="Actualizar">
              
          </form>
          <form action="'.SERVERURL.'ajax/distribucionAjax.php" method="POST" data-form="delete" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
         
          <input type="hidden" value="'.$rows["id_ordencli"].'" name="id_orden_delete">
              <input type="hidden" value="'.$id.'" name="id_dis_eliminar">
              <input type="submit"  class="btn btn-inverse-danger" value="Eliminar">
          </form>
              <button type="button" id="cerrar" class="btn btn-inverse-dark" data-dismiss="modal">Salir</button>
            </div>
            <div class="RespuestaAjax" id="RespuestaAjax">
          </div>    
            ';
        }


        return $inputsLlenos;
    }



    public static function actualizar_distribucion_controlador()
    {

        //Variables
        $id_orden = mainModel::limpiar_cadena($_POST['id_dis_actualizar']);
        $id_ordencli = mainModel::limpiar_cadena($_POST['id_ordenn']);
        $desc_dis = mainModel::limpiar_cadena($_POST['descripcion-reg']);
        $precio_dis = mainModel::limpiar_cadena($_POST['precio-reg']);
        $categoria_dis = mainModel::limpiar_cadena($_POST['categoria-reg']);
        $dataDistribucion = [

            "id_dis" => $id_orden,
            "desc_dis" => $desc_dis,
            "precio_dis" => $precio_dis,
            "categoria_dis" => $categoria_dis
        ];

        $guardarOrdenCliente = distribucionModelo::actualizar_distribucion_modelo($dataDistribucion);
        
        if (isset($_POST["id_banco_gasto"])) {
            $id_cat_banco=$_POST["id_banco_gasto"];
            $data_up_banco = [

                "id_dis" => $id_orden,
                "id_cat_banco" => $id_cat_banco
            ];
            
            $guardarOrdenCliente = distribucionModelo::actualizar_banco_distribucion_modelo($data_up_banco);
            if ($guardarOrdenCliente->rowCount() >= 1) {
    
                $data=[
                    "id_cat_banco"=>$id_cat_banco,
                    "monto"=>$precio_dis
                ];
                $guardarGasto=bancoModelo::gasto_distribucion_modelo($data);
    
                if ($guardarGasto->rowCount()>=1) {
                    
                    $data2=[
                        "id_persona" => NULL,
                        "id_ordencli" => $id_ordencli,
                        "id_cat_banco"=>$id_cat_banco,
                        "monto_tra"=>$precio_dis,
                        "tipo_tra"=>"DISTRIBUCION"
                    ];
                    $guardarTransaccion=bancoModelo::agregar_transaccion_modelo($data2);
    
                }
            }
        }
        
            session_start(['name'=>'SEMMAR']);
            
            $_SESSION['id_orden'] = $id_ordencli;
                
            $respuesta=header("location: ".SERVERURL."distribucion");
       
        
    }

    public static function eliminar_distribucion_controlador(){
        $id=mainModel::limpiar_cadena($_POST["id_dis_eliminar"]);
        $id_ordencli=mainModel::limpiar_cadena($_POST["id_orden_delete"]);
        $modelo=distribucionModelo::eliminar_distribucion_modelo($id);
        if ($modelo->rowCount()>=1) {
            

            session_start();
            
            $_SESSION['id_orden'] = $id_ordencli;
            
           $respuesta=header("location: ".SERVERURL."distribucion");
            
        }else{
            

        }

    }
    public static function retorno_igv_controlador()
    {

        //ARRAY
        $id_cat_banco = mainModel::limpiar_cadena($_POST['id_banco_retorno_igv']);
        $monto = mainModel::limpiar_cadena($_POST['monto_banco_retorno_igv']);
        //ID
        $id_orden = mainModel::limpiar_cadena($_POST['id_orden_igv']);
        $cantidad_inputs = mainModel::limpiar_cadena($_POST['numero_inputs']);
        if ($cantidad_inputs==0) {
            
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Completado",
                "Texto" => "Exito al finalizar orden",
                "Tipo" => "success"
            ];
        }else{
           
            
        for ($i=0; $i < $cantidad_inputs ; $i++) { 
            
            $dataBanco = [
                "id_cat_banco" => $id_cat_banco[$i],
                "monto" => $monto[$i]
            ];
    
            $guardarBanco = bancoModelo::abonar_monto_modelo($dataBanco);
            if ($guardarBanco->rowCount() >= 1) {
                    
                $data_transaccion=[
                    

                    "id_persona" => NULL,
                    "id_ordencli" => $id_orden,
                    "id_cat_banco" => $id_cat_banco[$i],
                    "monto_tra" => $monto[$i],
                    "tipo_tra" => "PAGO"
                    ];
                    
                $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);
                    
                   
                    if ($agregarTransaccion->rowCount()>=1) { 
                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Completado",
                            "Texto" => "Exito al registrar Pago",
                            "Tipo" => "success"
                        ];
                    }else{
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Algo salió mal",
                            "Texto" => "No se pudo agregar pago. ¡Ups! 1",
                            "Tipo" => "error"
                        ];
                    }
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo agregar pago. ¡Ups! 2 ",
                    "Tipo" => "error"
                ];
            } 
        }
        }
            
                

                
        $datos = [
            "id_orden" => $id_orden,
            "id_estado" => "6"
        ];
        $actualizarEstado = ordenClienteModelo::update_ordencliente_modelo($datos);
        
        return mainModel::sweet_alert($alerta);
        
         
    }


}