<?php
if ($peticionAjax) {
    require_once "../modelos/gastosModelo.php";
} else {
    require_once "./modelos/gastosModelo.php";
}

class gastosControlador extends gastosModelo
{

    public static function agregar_gasto_controlador()
    {

        //Variables
        $id_ordencli = mainModel::limpiar_cadena($_POST['id_orden_banco']);
        $id_banco = mainModel::limpiar_cadena($_POST['id_banco']);
        $desc_gasto = mainModel::limpiar_cadena($_POST['descripcion_gasto']);
        $monto_gasto = mainModel::limpiar_cadena($_POST['monto_gasto']);
        $dataGasto = [

            "id_ordencli" => $id_ordencli,
            "id_banco" => $id_banco,
            "desc_gasto" => $desc_gasto,
            "monto_gasto" => $monto_gasto
            

        ];

        $guardarGasto = gastosModelo::agregar_gasto_modelo($dataGasto);
        if ($guardarGasto->rowCount() >= 1) {


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
                "Texto" => "No se pudo agregar Gasto. ¡Ups!",
                "Tipo" => "error"
            ];
        }
        
        return mainModel::sweet_alert($alerta); 
    }

    
    public function lista_gastos_controlador($pagina, $registros,$id_orden)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

           
        $consulta = "SELECT * FROM DistribucionGastos ga INNER JOIN Banco ba ON ga.id_banco=ba.id_banco WHERE id_ordencli='$id_orden'";
       
       

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

    $tabla .= ' <thead>
                    <tr>
                    <th>Descripcion</th>
                    <th>Monto Retirado</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                    </tr>
                </thead>';





        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $total=0;
            foreach ($datos as $rows) {
                $total=$total+$rows["monto_gasto"];
                $tabla .= '
                <tbody>
                      <tr>
                        <td>
                          <p class="mb-n1 font-weight-medium">'.$rows["nombre_banco"].'</p>
                          <small class="text-gray">'.$rows["desc_gasto"].'</small>
                        </td>
                        <td class="font-weight-medium mr-sm-2">'.$rows["monto_gasto"].'</td>
                        <td class="font-weight-medium mr-sm-2">'.$rows["fecha_gasto"].'</td>
                        <td class="text-danger font-weight-medium">
                          <div class="badge badge-danger">Eliminar</div>
                        </td>
                      </tr>
                </tbody>';
           
            
                $contador++;
            }
            $tabla.='
            <tr>
              <td>
                <p class="mb-n1 font-weight-medium">Total</p>
              </td>
              <td class="font-weight-medium mr-sm-2">'.$total.'</td>';

              
              $tabla.='<td>
              <p class="mb-n1 font-weight-medium">Monto de Proyecto</p>
              </td>';  
          
          
                      $montoProyecto=0;          
                      $result = mainModel::ejecutar_consulta_simple("SELECT  total_ordencli  FROM OrdenCliente WHERE id_ordencli ='$id_orden'");
                          

                      foreach ($result as $key => $rows4) {
                          $montoProyecto=$rows4["total_ordencli"];
                      }
                      $restante=$montoProyecto-$total;
                      $tabla.='
                      <td class="font-weight-medium">S/'.$montoProyecto.'</td>
                          </tr>
                          <tr>
                  
                          <td>
                          <p class="mb-n1 font-weight-medium"></p>
                      </td>
                      <td class="font-weight-medium"></td>
                          
                      <td>
                      <p class="mb-n1 font-weight-medium">Monto Restante</p>
                  </td>
                  <td class="font-weight-medium">S/'.$restante.'</td>';
              
            $tabla.='</tr>';
        } else {

            if ($total >= 1) {

                $tabla .= '
				<tr>
					<td colspan="5">
						<a href="' . SERVERURL . '/banco/" class="btn btn-sm btn-info btn-raised"> 
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
}