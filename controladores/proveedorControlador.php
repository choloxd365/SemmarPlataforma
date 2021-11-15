<?php
if ($peticionAjax) {
    require_once "../modelos/proveedorModelo.php";
    require_once "../modelos/bancoModelo.php";
} else {
    require_once "./modelos/proveedorModelo.php";
    require_once "./modelos/bancoModelo.php";
}

class proveedorControlador extends proveedorModelo
{

    public static function agregar_proveedor_controlador()
    {

        $id_tipo_persona = mainModel::limpiar_cadena($_POST['id_tipo_persona_reg']);
        $id_beneficiario = mainModel::limpiar_cadena($_POST['id_beneficiario_reg']);
        $razon_social = mainModel::limpiar_cadena($_POST['raz-social-reg']);
        $email = mainModel::limpiar_cadena($_POST['email']);
        $representante = mainModel::limpiar_cadena($_POST['representante-reg']);
        $ruc = mainModel::limpiar_cadena($_POST['ruc-reg']);
        $telefono = mainModel::limpiar_cadena($_POST['telefono-reg']);


         $cantidad = count($email);
            for ($i = 0; $i < $cantidad; $i++) {

               
        $consulta1 = mainModel::ejecutar_consulta_simple("SELECT email FROM email WHERE email='$email[$i]'");
            }

        //rowcount devuelve numero de fila afectadas por la consulta
        // if, si hay un dni identico al q queremos registrar, mandamos un error
        if ($consulta1->rowCount() >= 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "El email ya está registrado",
                "Tipo" => "error"
            ];
        } else {
            $dataPE = [
                "id_tipo_persona" => $id_tipo_persona,
                "id_beneficiario" => $id_beneficiario,
                "razon_social" => $razon_social,
                "representante" => $representante,
                "ruc" => $ruc,
                "telefono" => $telefono
            ];

            $guardarCuenta = proveedorModelo::agregar_proveedor_modelo($dataPE);

            if ($guardarCuenta->rowCount() >= 1) {
                
                $obtenerid=mainmodel::ejecutar_consulta_simple("SELECT MAX(id_persona) as id from persona");
                $id=$obtenerid->fetch();
                $cantidad = count($email);
            for ($i = 0; $i < $cantidad; $i++) {

                $dataDetalle = [
                    "id_persona" => $id['id'],
                    "email" => $email[$i],
                ];

                $guardarEmail = proveedorModelo::agregar_emailproveedor_modelo($dataDetalle);
                
                 
            }
                if ($guardarEmail->rowCount() >= 1) {
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Datos guardados",
                    "Texto" => "Almacenado correctamente ",
                    "Tipo" => "success"
                ];
            }
               
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "El email ya está registrado",
                    "Tipo" => "error"
                ];
            }
        }

        return mainModel::sweet_alert($alerta);
    }


    public static function actualizar_proveedor_controlador()
    {

        $id_persona = mainModel::limpiar_cadena($_POST['id_personaa']);
        $id_tipo_persona = mainModel::limpiar_cadena($_POST['id_tipo_persona']);
        $id_beneficiario = mainModel::limpiar_cadena($_POST['id_beneficiario_reg']);
        $razon_social = mainModel::limpiar_cadena($_POST['raz-social-reg']);
        $representante = mainModel::limpiar_cadena($_POST['representante-reg']);
        $ruc = mainModel::limpiar_cadena($_POST['ruc-reg']);
        $telefono = mainModel::limpiar_cadena($_POST['telefono-reg']);
        $dataPE = [
            "id_persona" => $id_persona,
            "id_tipo_persona" => $id_tipo_persona,
            "id_beneficiario" => $id_beneficiario,
            "razon_social" => $razon_social,
            "representante" => $representante,
            "ruc" => $ruc,
            "telefono" => $telefono
        ];
        $personaUP = proveedorModelo::actualizar_proveedor_modelo($dataPE);

        if ($personaUP->rowCount() >= 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos Actualizados",
                "Texto" => "El proveedor fue actualizado correctamente ",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo actualizar el usuario",
                "Tipo" => "error"
            ];
        }


        return mainModel::sweet_alert($alerta);
    }

    public function paginador_proveedor_controlador($pagina, $registros, $motivo)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


        if($motivo=="listarClientes"){

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE estado='Activo' and id_beneficiario='1' ORDER BY razon_social ASC LIMIT $inicio,$registros";
            $paginaurl = "clienteList";
        }elseif($motivo=="listarProveedor"){
            
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE estado='Activo'and id_beneficiario='2'  ORDER BY razon_social ASC LIMIT $inicio,$registros";
        $paginaurl = "proveedorList";

        }elseif($motivo=="proveedorOrden"){

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE estado='Activo'and id_beneficiario='2'  ORDER BY razon_social ASC LIMIT $inicio,$registros";
            $paginaurl = "ordenCompra";
        }elseif($motivo=="proveedorSeleccionarCot"){

        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE estado='Activo' and id_beneficiario='2'  ORDER BY razon_social ASC LIMIT $inicio,$registros";
        $paginaurl = "proveedorList";

        }elseif($motivo=="clienteSeleccionarCot"){

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE estado='Activo' and id_beneficiario='1'  ORDER BY razon_social ASC LIMIT $inicio,$registros";
            $paginaurl = "proveedorList";
        }else{
            
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE estado='Activo' ORDER BY razon_social ASC LIMIT $inicio,$registros";
        $paginaurl = "proveedorList";
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
                                <th style="color:#F28165;"><b>RUC</th>
                                <th style="color:#F28165;"><b>TELEFONO</th>
                                <th style="color:#F28165;"><b>CORREO</th>';
        if ($motivo == "" || $motivo=="listarProveedor" || $motivo=="listarClientes") {
         
            $tabla .= '
                                
                                    <th style="color:#F28165;"><b>ACTUALIZAR</th>
                                    <th style="color:#F28165;"><b>ELIMINAR<b></th>';
        }
        $tabla .= '</tr>';




        $tabla .= '			
							</thead>
							<tbody>
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {

                $data = $rows[0];
                $tabla .= '
            <tr  style="cursor:pointer;" onclick="EnviarDatosProveedor(' . $data . '); crearDatosProveedor(' . $data . ');">
            <td class="d-flex align-items-center border-top-0">';

                if ($rows['id_beneficiario'] == 1) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cliente/cliente.jpg" alt="profile image">';
                } elseif ($rows['id_beneficiario'] == 2) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/proveedor/proveedor.png" alt="profile image">';
                }
                $tabla .= '<b> </b> <span>' . $rows['razon_social'] . '</span>
            </td>
            <td>' . $rows['ruc'] . '</td>
            </td>
            <td>' . $rows['telefono'] . '</td>
            <td>';


            
            $result = mainModel::ejecutar_consulta_simple("SELECT email FROM email WHERE id_persona=".$rows['id_persona']);

            while ($row= $result->fetch()) {
                $tabla .= $row['email'].' - ';
              
            }

            $tabla .= '</td>';

                if ($motivo == ""|| $motivo=="listarProveedor" || $motivo=="listarClientes") {
                    
                    $tabla .= ' 
                    
                    <td>
                    <a href="' . SERVERURL . 'proveedorup/' . $rows['id_persona'] . '" class="btn btn-inverse-success">Actualizar</a> 
                    </td>
                
            <td>

            <form action="' . SERVERURL. 'ajax/proveedorAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="idPersonaDel" value="' . $rows['id_persona'] . '">
                <input type="submit" name="eliminar-proveedor" value="Eliminar" class="btn btn-inverse-danger">
            </form>
            <div class="RespuestaAjax" id="RespuestaAjax">
            </div>
            </td>
          </tr>';
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


        if ($total >= 1 && $pagina <= $Npaginas && $motivo == "") {
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

    public static function busqueda_proveedor_controlador($motivo,$tipo)
    {
        if (isset($_POST['listadoBusqueda'])) {
            $texto = mainModel::limpiar_cadena($_POST['listadoBusqueda']);
            $tipo = mainModel::limpiar_cadena($_POST['tipo']);
        } else {
            $texto = mainModel::limpiar_cadena($_POST['textoBusqueda']);
            $tipo = mainModel::limpiar_cadena($_POST['tipo']);
        }
        
        $registros = 5;
        $pagina = 0;
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


        if (isset($texto) && $texto != "" && $motivo!="seleccionar" ) {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE razon_social LIKE '%$texto%' and estado='Activo' and id_beneficiario='$tipo'  ORDER BY razon_social";
        } elseif($motivo=="seleccionar" && $tipo!="proveedor"){

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE razon_social LIKE '%$texto%' and estado='Activo' and id_beneficiario='1'   ORDER BY razon_social";
        }elseif($tipo="proveedor"){
            
            $consulta = "SELECT SQL_CALC_FOUND_ROWS *FROM persona WHERE razon_social LIKE '%$texto%' and id_beneficiario='2' and estado='Activo'   ORDER BY razon_social";
        }elseif($tipo="cliente"){
            
            $consulta = "SELECT SQL_CALC_FOUND_ROWS *FROM persona WHERE razon_social LIKE '%$texto%' and id_beneficiario='1' and estado='Activo'   ORDER BY razon_social";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE  estado='Activo'   ORDER BY razon_social";
       
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
                                <th>Ruc</th>
                                <th>Telefono</th>
                                <th>Correo</th>';
        if ($motivo == "") {
            $tabla .= '
                                <th>Actualizar</th>
                                <th>Eliminar</th>
                            </tr>';
        }





        $tabla .= '			
							</thead>
							<tbody>
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $data = $rows[0];
                $tabla .= '
                <tr  style="cursor:pointer;" onclick="EnviarDatosProveedor(' . $data . '); crearDatosProveedor(' . $data . ');">
                
            <td class="d-flex align-items-center border-top-0">';

                if ($rows['id_beneficiario'] == 1) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/cliente/cliente.jpg" alt="profile image">';
                } elseif ($rows['id_beneficiario'] == 2) {

                    $tabla .= ' <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/proveedor/proveedor.png" alt="profile image">';
                }

                $tabla .= ' <span>' . $rows['razon_social'] . '</span>
            </td>
            <td>' . $rows['ruc'] . '</td>
            </td>
            <td>' . $rows['telefono'] . '</td>
             <td>';


            
            $result = mainModel::ejecutar_consulta_simple("SELECT email FROM email WHERE id_persona=".$rows['id_persona']);

            while ($row= $result->fetch()) {
                $tabla .= $row['email'].', ';
              
            }

            $tabla .= '</td>';


                if ($motivo == "") {
                    $tabla .= '
            <td>
        <button type="button" class="btn btn-inverse-success">Actualizar</button> </td>
            <td class="">
              
        <button type="button" class="btn btn-inverse-danger">Eliminar</button>
            </td>';
                }
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
        return $tabla;
    }


    public static function datos_proveedor_controlador($id_persona)
    {


        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM persona WHERE id_persona='$id_persona'");

        $inputsLlenos = "";





        foreach ($result as $key => $row) {

            $inputsLlenos = '
                <div class="form-group">
                <label for="inputEmail1">Razon Social</label>
                <input type="hidden" readonly="" class="form-control" name="id_persona" value="' . $row['id_persona'] . '" >
                <input type="text" readonly="" class="form-control" id="razonsocial" value="' . $row['razon_social'] . '" >
                
                <input type="hidden" readonly="" class="form-control" name="id_persona" id="id_persona" value="' . $row['id_persona'] . '" >
                
                 </div>
                <div id="campos">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Representante</label>
                    <input type="text" readonly="" class="form-control" id="representante" value="' . $row['representante'] . '">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Ruc</label>
                    <input type="text" readonly="" class="form-control" id="ruc" value="' . $row['ruc'] . '">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Teléfono</label>
                    <input type="text" readonly="" class="form-control" id="telefono" value="' . $row['telefono'] . '">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Correo para enviar el pdf</label>
                </div>
                <div class="form-group">';


                $result2 = mainModel::ejecutar_consulta_simple("SELECT * FROM email WHERE id_persona='$id_persona'");

        foreach ($result2 as $key => $row2) {
                
                 $inputsLlenos.='
                                    <div class="radio">
                                    <label class="radio-label">
                                        <input name="correo[]" value="' . $row2['id_email'] . '" checked type="checkbox">' . $row2['email'] . '<i class="input-frame"></i>
                                    </label>

                                    
                                    </div>
                                
                ';
            }
            $inputsLlenos.='</div>';
        }


        return $inputsLlenos;
    }

    public static function datos_cliente_orden_controlador($id_persona)
    {


        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM persona WHERE id_persona='$id_persona'");

        $inputsLlenos = "";





        foreach ($result as $key => $row) {

            $inputsLlenos = '
                <div class="form-group">
                <label for="inputEmail1">Razon Social</label>
                <input type="hidden" readonly="" class="form-control" name="id_persona" value="' . $row['id_persona'] . '" >
                <input type="text" readonly="" class="form-control" id="razonsocial" value="' . $row['razon_social'] . '" >
                
                <input type="hidden" readonly="" class="form-control" name="id_persona" id="id_persona" value="' . $row['id_persona'] . '" >
                
                 </div>
                <div id="campos">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Representante</label>
                    <input type="text" readonly="" class="form-control" id="representante" value="' . $row['representante'] . '">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Ruc</label>
                    <input type="text" readonly="" class="form-control" id="ruc" value="' . $row['ruc'] . '">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Teléfono</label>
                    <input type="text" readonly="" class="form-control" id="telefono" value="' . $row['telefono'] . '">
                </div>      
                ';
            $inputsLlenos.='</div>';
        }


        return $inputsLlenos;
    }

    public static function data_proveedor_controlador($id)
    {
        return proveedorModelo::data_proveedor_modelo($id);
    }

    public static function data_Emailproveedor_controlador($id)
    {
        return proveedorModelo::data_Emailproveedor_modelo($id);
    }

    public static function agregar_Emailproveedor_controlador()
    {
        $email = mainModel::limpiar_cadena($_POST['agregarEmail']);
        $idPersona = mainModel::limpiar_cadena($_POST['idPer']);
        $dataEmail=[
            "id_persona"=>$idPersona,
            "email"=>$email

        ];
        $guardarEmail= proveedorModelo::agregar_Emailproveedor_modelo($dataEmail);

        if ($guardarEmail->rowCount() >= 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Email registrado",
                "Texto" => "El email fue agregado correctamente ",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo agregar el email",
                "Tipo" => "error"
            ];
        }
        
        return mainModel::sweet_alert($alerta);
    }


    public static function eliminar_proveedor_controlador($id)
    {

        $eliminarProveedor = proveedorModelo::eliminar_proveedor_modelo($id);

        if ($eliminarProveedor->rowCount() >= 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Usuario Eliminado",
                "Texto" => "El usuario fue eliminado correctamente ",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo eliminar el usuario",
                "Tipo" => "error"
            ];
        }


        return mainModel::sweet_alert($alerta);
    }

    public static function eliminar_Emailproveedor_controlador($id)
    {

        $eliminarProveedor = proveedorModelo::eliminar_Emailproveedor_modelo($id);

        if ($eliminarProveedor->rowCount() >= 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Email Eliminado",
                "Texto" => "El email fue eliminado correctamente ",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo eliminar el email",
                "Tipo" => "error"
            ];
        }


        return mainModel::sweet_alert($alerta);
    }

    
    


    
    
}
