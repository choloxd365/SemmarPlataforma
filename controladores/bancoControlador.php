<?php
if ($peticionAjax) {
    require_once "../modelos/bancoModelo.php";
    require_once "../modelos/ordenClienteModelo.php";
} else {
    require_once "./modelos/bancoModelo.php";
    require_once "./modelos/ordenClienteModelo.php";
}

class bancoControlador extends bancoModelo
{

    public static function agregar_banco_controlador()
    {

        //Variables
        $nombre_banco = mainModel::limpiar_cadena($_POST['nombre_banco']);
        $moneda_banco = mainModel::limpiar_cadena($_POST['moneda_banco']);
        $tipo_cuenta_banco = mainModel::limpiar_cadena($_POST['tipo_cuenta_banco']);
        $dataBanco = [

            "nombre_banco" => $nombre_banco,
            "moneda_banco" => $moneda_banco,
            "tipo_cuenta_banco" => $tipo_cuenta_banco


        ];

        $guardarBanco = bancoModelo::agregar_banco_modelo($dataBanco);
        if ($guardarBanco->rowCount() >= 1) {


            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Completado",
                "Texto" => "Exito al registrar Banco",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo agregar Banco. ¡Ups!",
                "Tipo" => "error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }


    public static function agregar_categoria_controlador()
    {

        //Variables
        $id_banco = mainModel::limpiar_cadena($_POST['id_banco']);
        $nombre_cate_reg = mainModel::limpiar_cadena($_POST['nombre_cate_reg']);
        $monto_cate_reg = mainModel::limpiar_cadena($_POST['monto_cate_reg']);
        $dataBanco = [

            "id_banco" => $id_banco,
            "nombre_cate" => $nombre_cate_reg,
            "monto_actual" => $monto_cate_reg


        ];

        $guardarBanco = bancoModelo::agregar_categoria_modelo($dataBanco);
        if ($guardarBanco->rowCount() >= 1) {


            $datos = mainModel::ejecutar_consulta_simple("SELECT MAX(id_cat_banco) FROM CategoriaBanco");
            $fila = $datos->fetch();
            $id = $fila[0];


            $data_transaccion = [


                "id_persona" => NULL,
                "id_ordencli" => NULL,
                "id_cat_banco" => $id,
                "monto_tra" => $monto_cate_reg,
                "tipo_tra" => "ABONO"
            ];

            $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);

            if ($agregarTransaccion->rowCount() >= 1) {


                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Completado",
                    "Texto" => "Exito al registrar Categoria de Banco",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudo agregar Banco. ¡Ups! 1",
                    "Tipo" => "error"
                ];
            }
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo agregar Banco. ¡Ups! 2",
                "Tipo" => "error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }
    public function lista_banco_controlador($pagina, $registros)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";
        $total_monto = 0;
        $total_monto_retirado = 0;

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


        $consulta = "SELECT SQL_CALC_FOUND_ROWS  ba.moneda_banco,ca.id_cat_banco,ba.nombre_banco,ca.nombre_cate,ca.monto_actual,
                    ca.monto_retirado from CategoriaBanco ca INNER JOIN Banco ba ON ca.id_banco=ba.id_banco;";



        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

        $tabla .= '
    <table class="table table-bordered">
    <thead>
        <tr class="text-center">
            <th scope="col" style="color:#F28165;"><b>#</b></th>
            <th scope="col" style="color:#F28165;"><b>BANCO</b></th>
            <th scope="col" style="color:#F28165;"><b>CATEGORIA</b></th>
            <th scope="col" class="text-center" style="color:#F28165;"><b>MONTO TOTAL</b></th>
            <th scope="col" class="text-right" style="color:#F28165;"><b>MONTO RETIRADO</b></th>
            <th scope="col" class="text-center" style="color:#F28165;"><b>RETIRAR</b></th>
            <th scope="col" class="text-center" style="color:#F28165;"><b>ABONAR</b></th>
            <th scope="col" class="text-center" style="color:#F28165;"><b>PAGO TERCERO</b></th>
        </tr>
    </thead>
   
    
    ';





        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $total = 0;
            //table-primary color oscurp// 
            foreach ($datos as $rows) {
                $color = "";
                $numero = $contador / 2;
                $total_monto = $total_monto + $rows["monto_actual"];
                $total_monto_retirado = $total_monto_retirado + $rows["monto_retirado"];


                $partes = explode(".", $numero);
                if (isset($partes[1])) {

                    $color = "";
                } else {
                    $color = "table-primary";
                }



                $data = $rows["id_cat_banco"];
                $tabla .= '
                <tbody>
        
        <tr class="text-center" class="' . $color . '">
            <td scope="row">' . $contador . '</td>
            <td>' . $rows["nombre_banco"] . '</td>
            <td>' . $rows["nombre_cate"] . '</td>
            <td class="text-center">';
                if ($rows["moneda_banco"] == "Soles") {
                    $tabla .= 'S/';
                } else {
                    $tabla .= '$ ';
                }

                $tabla .= mainModel::moneyFormat($rows["monto_actual"], "USD") . '</td>
            <td class="text-right">';
                if ($rows["moneda_banco"] == "Soles") {
                    $tabla .= 'S/';
                } else {
                    $tabla .= '$ ';
                }

                $tabla .= mainModel::moneyFormat($rows["monto_retirado"], "USD") . '</td>';
                if ($rows["monto_actual"] >= 1) {
                    $tabla .= ' <td class="text-danger font-weight-medium">
               <div onclick="enviarDatosRetiro(' . $data . ');"  style="cursor: pointer" class="badge badge-danger" data-toggle="modal" data-target="#exampleModalCenter">Retirar</div>
                      
              </td>';
                } else {
                    $tabla .= '<td></td>';
                }



                $tabla .= '<td class="text-danger font-weight-medium">
            <div onclick="enviarDatosAbono(' . $data . ');"  style="cursor: pointer" class="badge badge-success" data-toggle="modal" data-target="#modalAbonar">Abonar</div>
                   
           </td>
           <td class="text-danger font-weight-medium"> <a href="' . SERVERURL . 'pagosExternos/' . $data . '/" class="badge badge-info">Pagos</a>     
          </td>
           
        </tr>
    </tbody>
    
';


                $contador++;
            }

            $tabla .= '<tfoot>
            <tr class="btn-success">
                <td colspan="3"><strong  style="color:white;" >TOTAL BANCOS</strong></td>
                <td class="text-right"><strong  style="color:white;">S/' . mainModel::moneyFormat($total_monto, "USD") . '</strong></td>
                <td class="text-right"><strong  style="color:white;">S/' . mainModel::moneyFormat($total_monto_retirado, "USD") . '</strong></td>
                
                <td></td><td></td><td></td>
                
            </tr>
        </tfoot>';
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



    public function paginador_orden_banco_controlador($pagina, $registros, $busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS  ord.id_ordencli, ba.nombre_banco,pe.razon_social,ord.desc_ordencli,monto_gasto,desc_gasto FROM distribuciongastos dis INNER JOIN ordencliente ord ON dis.id_ordencli=ord.id_ordencli INNER JOIN banco ba ON dis.id_banco=ba.id_banco INNER JOIN persona pe ON ord.id_persona=pe.id_persona WHERE ord.id_ordencli LIKE '%$busqueda%' OR nombre_banco LIKE '%$busqueda%' ORDER BY fecha_gasto DESC LIMIT $inicio,$registros";
            $paginaurl = "proveedorList";
        } else {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS  ord.id_ordencli, ba.nombre_banco,pe.razon_social,ord.desc_ordencli,monto_gasto,desc_gasto FROM distribuciongastos dis INNER JOIN ordencliente ord ON dis.id_ordencli=ord.id_ordencli INNER JOIN banco ba ON dis.id_banco=ba.id_banco INNER JOIN persona pe ON ord.id_persona=pe.id_persona ORDER BY fecha_gasto DESC LIMIT $inicio,$registros";
            $paginaurl = "gastoBanco";
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
                                <th>Nombre de Banco</th>
                                <th>NRO ORDEN</th>
                                <th>Razon Social</th>
                                <th>Descripción de orden</th>
                                <th>Descripción de retiro</th>
                                <th>Monto</th>
                            </tr>
                            </thead>
							<tbody>
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {

                $tabla .= '
            <tr>
                <td class="d-flex align-items-center border-top-0">
                    <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/banco/bancco.png" alt="profile image">
                    <span>' . $rows['nombre_banco'] . '</span>
                </td>
                <td>' . $rows['id_ordencli'] . '</td>
                <td>' . $rows['razon_social'] . '</td>
                <td>' . $rows['desc_ordencli'] . '</td>
                <td>' . $rows['desc_gasto'] . '</td>
                <td>-' . mainModel::moneyFormat($rows['monto_gasto'], "USD") . '</td>';

                $tabla .= '</tr>';
            }
            $contador++;
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


        if ($total >= 1 && $pagina <= $Npaginas && $busqueda == "") {
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

    public static function agregar_retiro_controlador()
    {

        //Variables
        $id_cat_banco = mainModel::limpiar_cadena($_POST['retirar_monto']);
        $monto = mainModel::limpiar_cadena($_POST['monto']);
        $monto_actual = mainModel::limpiar_cadena($_POST['monto_actual_banco']);

        if ($monto_actual >= $monto) {
            $dataBanco = [
                "id_cat_banco" => $id_cat_banco,
                "monto" => $monto
            ];

            $guardarBanco = bancoModelo::agregar_retiro_modelo($dataBanco);


            if ($guardarBanco->rowCount() >= 1) {

                $data_disminuar_actual = [

                    "id_cat_banco" => $id_cat_banco,
                    "monto" => $monto
                ];

                $actualizarMonto = bancoModelo::disminuir_monto_actual_modelo($data_disminuar_actual);

                if ($actualizarMonto->rowCount() >= 1) {

                    $data_transaccion = [


                        "id_persona" => NULL,
                        "id_ordencli" => NULL,
                        "id_cat_banco" => $id_cat_banco,
                        "monto_tra" => $monto,
                        "tipo_tra" => "RETIRO"
                    ];

                    $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);


                    if ($agregarTransaccion) {
                        $respuesta = header("location: " . SERVERURL . "banco/");
                    } else {
                        echo '
                        <div class="row">
                            <div id="content" class="col-lg-12">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Error de Sistema</h4>
                                <p>No se pudo agregar transacción </p>
                                <hr>
                                <a href="' . SERVERURL . 'banco/" class="mb-0">Regresar a la gestion de bancos</a>
                            </div>
                        </div>';
                    }
                } else {

                    echo '
                <div class="row">
                    <div id="content" class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Error de Sistema</h4>
                        <p>Comunicar a Cesar Baca</p>
                        <hr>
                        <a href="' . SERVERURL . 'banco/" class="mb-0">Regresar a la gestion de bancos</a>
                    </div>
                </div>';
                }
            } else {

                echo '
                <div class="row">
                    <div id="content" class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Monto Insuficiente</h4>
                        <p>El monto a retirar debe ser menor al monto actual.</p>
                        <hr>
                        <a href="' . SERVERURL . 'banco/" class="mb-0">Regresar a la gestion de bancos</a>
                    </div>
                </div>';
            }
        } else {

            echo '
            <div class="row">
                <div id="content" class="col-lg-12">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Monto Insuficiente</h4>
                    <p>El monto a retirar debe ser menor al monto actual.</p>
                    <hr>
                    <a href="' . SERVERURL . 'banco/" class="mb-0">Regresar a la gestion de bancos</a>
                </div>
            </div>';
        }
    }

    public static function agregar_abono_controlador()
    {

        //Variables
        $id_cat_banco = mainModel::limpiar_cadena($_POST['id_abono']);
        $monto = mainModel::limpiar_cadena($_POST['monto']);


        $dataBanco = [
            "id_cat_banco" => $id_cat_banco,
            "monto" => $monto
        ];

        $guardarBanco = bancoModelo::abonar_monto_modelo($dataBanco);
        if ($guardarBanco->rowCount() >= 1) {

            $data_transaccion = [


                "id_persona" => NULL,
                "id_ordencli" => NULL,
                "id_cat_banco" => $id_cat_banco,
                "monto_tra" => $monto,
                "tipo_tra" => "ABONO"
            ];

            $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);


            if ($agregarTransaccion) {
                $respuesta = header("location: " . SERVERURL . "banco/");
            } else {
                echo '
                            <div class="row">
                                <div id="content" class="col-lg-12">
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Error de Sistema</h4>
                                    <p>No se pudo agregar transacción </p>
                                    <hr>
                                    <a href="' . SERVERURL . 'banco/" class="mb-0">Regresar a la gestion de bancos</a>
                                </div>
                            </div>';
            }
        } else {

            echo '
                <div class="row">
                    <div id="content" class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Error de Sistema</h4>
                        <p>Comunicar a Cesar Baca</p>
                        <hr>
                        <a href="' . SERVERURL . 'banco/" class="mb-0">Regresar a la gestion de bancos</a>
                    </div>
                </div>';
        }
    }

    public  function datos_retiro_controlador($id)
    {

        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM CategoriaBanco ca INNER JOIN Banco ba  ON ca.id_banco = ba.id_banco WHERE id_cat_banco='$id'");

        $inputsLlenos = '';

        foreach ($result as $key => $rows) {
            $simbolo = '';
            if ($rows["moneda_banco"] == "Soles") {
                $simbolo = "S/";
            } else {

                $simbolo = "$ ";
            }
            $inputsLlenos .= '
            <form action="' . SERVERURL . 'ajax/bancoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" value="' . $id . '" name="retirar_monto">
            <div class="modal-body">
            <div class="form-row">
            <div class="col-3">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Banco</label>
              <input type="text" readonly class="form-control" name="descripcion-reg" value="' . $rows["nombre_banco"] . '" placeholder="Descripción">
            </div>
            <div class="col-3">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Categoria</label>
              <input type="text" readonly class="form-control" name="descripcion-reg" value="' . $rows["nombre_cate"] . '" placeholder="Descripción">
            </div>
            <div class="col-3">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Monto Actual</label>
              <input type="text" readonly class="form-control" name="monto_actual_banco" value="' . $rows["monto_actual"] . '" placeholder="Descripción">
            </div>
              <div class="col-3">
              <label class="mr-sm-2" for="inlineFormCustomSelect">Retirar</label>
                <input type="text" name="monto" class="form-control"  placeholder="' . $simbolo . '0.00">
              </div>
            </div>
              <div class="modal-footer">
              <input type="submit"  class="btn btn-inverse-success" value="Retirar">
              
          </form>
              <button type="button" id="cerrar" class="btn btn-inverse-dark" data-dismiss="modal">Salir</button>
            </div>
            <div class="RespuestaAjax" id="RespuestaAjax">
          </div>    
            ';
        }


        return $inputsLlenos;
    }

    public  function datos_abono_controlador($id)
    {

        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM CategoriaBanco ca INNER JOIN Banco ba  ON ca.id_banco = ba.id_banco WHERE id_cat_banco='$id'");

        $inputsLlenos = '';

        foreach ($result as $key => $rows) {
            $inputsLlenos .= '
            <form action="' . SERVERURL . 'ajax/bancoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" value="' . $id . '" name="id_abono">
            <div class="modal-body">
            <div class="form-row">
            <div class="col-3">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Banco</label>
              <input type="text" readonly class="form-control" name="descripcion-reg" value="' . $rows["nombre_banco"] . '" placeholder="Descripción">
            </div>
            <div class="col-3">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Categoria</label>
              <input type="text" readonly class="form-control" name="descripcion-reg" value="' . $rows["nombre_cate"] . '" placeholder="Descripción">
            </div>
              <div class="col-6">
              <label class="mr-sm-2" for="inlineFormCustomSelect">Monto de Deposito</label>
                <input type="text" name="monto" class="form-control"  placeholder="S/0.00">
              </div>
            </div>
              <div class="modal-footer">
              <input type="submit"  class="btn btn-inverse-success" value="Abonar">
              
          </form>
              <button type="button" id="cerrar" class="btn btn-inverse-dark" data-dismiss="modal">Salir</button>
            </div>
            <div class="RespuestaAjax" id="RespuestaAjax">
          </div>    
            ';
        }


        return $inputsLlenos;
    }



    public function lista_transaccion_controlador($pagina, $registros, $busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


        if (isset($busqueda) && $busqueda != "") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM transacciones tra 
             INNER JOIN CategoriaBanco ca  ON tra.id_cat_banco = ca.id_cat_banco 
             INNER JOIN Banco ba ON ca.id_banco= ba.id_banco
             WHERE (ba.nombre_banco LIKE '%$busqueda%' OR ca.nombre_cate LIKE '%$busqueda%' OR
                    fecha_tra LIKE '%$busqueda%' OR tra.id_ordencli LIKE '%$busqueda%')
             ORDER BY fecha_tra DESC LIMIT $inicio,$registros";

            $paginaurl = "banco";
        } else {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM transacciones tra 
             INNER JOIN CategoriaBanco ca  ON tra.id_cat_banco = ca.id_cat_banco 
             INNER JOIN Banco ba ON ca.id_banco= ba.id_banco
             ORDER BY fecha_tra DESC LIMIT $inicio,$registros";
            $paginaurl = "banco";
        }

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

        $tabla .= '
        <table class="table">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th style="color:#F28165;">BANCO</th>
                                        <th style="color:#F28165;">CATEGORIA</th>
                                        <th style="color:#F28165;">TIPO DE MOVIMIENTO</th>
                                        <th style="color:#F28165;">FECHA</th>
                                        <th style="color:#F28165;">MONTO</th>
                                    </tr>
                                </thead>
                                <tbody>';



        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tipo = $rows["tipo_tra"];
                $tabla .= '
                    
                
                                        <tr class="text-center">
                                            <td><b>' . $rows["nombre_banco"] . '</b></td>
                                            <td>' . $rows["nombre_cate"] . '</td>
                                            <td>
                                            <div ';

                if ($rows["id_ordencli"] != "") {
                    $id_orden_cli = $rows["id_ordencli"];
                    $texto = mainModel::ejecutar_consulta_simple("SELECT * FROM OrdenCliente ord
                                                                                             INNER JOIN DetalleOrdenCliente det ON ord.id_ordencli = det.id_ordencli 
                                                                                             WHERE ord.id_ordencli='$id_orden_cli'");
                    $campos = $texto->fetch();
                    $tabla .= 'title="CODIGO: ' . $campos["id_ordencli"] . ' || DESCRIPCION: ' . $campos["desc_det_ordencli"] . ' || MONTO: ' . $campos["total_ordencli"] . ' "';
                }

                $tabla .= ' style="cursor: pointer" class="badge badge-';

                if ($tipo == "RETIRO") {
                    $tabla .= "danger";
                } else if ($tipo == "DISTRIBUCION") {

                    $tabla .= "warning";
                } else if ($tipo == "PAGO TERCERO") {

                    $tabla .= "danger";
                } else if ($tipo == "PAGO") {

                    $tabla .= "success";
                } else if ($tipo == "ABONO") {

                    $tabla .= "success";
                }
                $tabla .= '">' . $rows["tipo_tra"];

                if ($rows["id_ordencli"] != "") {
                    $tabla .= " (" . $rows["id_ordencli"] . ")";
                }
                $simbolo = '';
                if ($rows["moneda_banco"] == "Soles") {
                    $simbolo = 'S/';
                } else {
                    $simbolo = '$ ';
                }

                $tabla .= '</div>
                                            </td>
                                            <td>' . $rows["fecha_tra"] . '</td>
                                            <td><b>' . $simbolo;
                if ($tipo == "RETIRO") {
                    $tabla .= "-";
                } else if ($tipo == "PAGO") {

                    $tabla .= "+";
                } else if ($tipo == "DISTRIBUCION") {

                    $tabla .= "-";
                } else if ($tipo == "PAGO TERCERO") {

                    $tabla .= "-";
                } else if ($tipo == "ABONO") {

                    $tabla .= "+";
                }


                $tabla .= mainModel::moneyFormat($rows["monto_tra"], "USD") . '</b></td>
                                        </tr>';
            }
            $tabla .= '
                        </tbody>
                        </table>';
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
                        <td colspan="5">No hay registros</td>
                    </tr>
                ';
            }
        }

        $tabla .= '</tbody></table> <br>';


        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '<div class="d-flex justify-content-center">
                <nav aria-label="...">
          <ul class="pagination">';
            if ($pagina == 1) {
                $tabla .= '<li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Atrás</a>
        </li>';
            } else {
                $tabla .= '<li class="page-item">
                    <a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($pagina - 1) . '" tabindex="-1">Atrás</a></li>';
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


            $tabla .= '</ul></nav>
                </div>';
        } else {
            echo '';
        }

        return $tabla;
    }

    public function retornar_gasto_banco_controlador()
    {

        $id_orden = mainModel::limpiar_cadena($_POST["id_retorno_banco_cliente"]);
        $datos = mainModel::ejecutar_consulta_simple("SELECT ca.id_cat_banco,dis.precio_dis FROM DistribucionCostos dis
                                                    INNER JOIN CategoriaBanco ca on dis.id_cat_banco=ca.id_cat_banco
                                                    WHERE dis.id_ordencli ='$id_orden'; ");

        foreach ($datos as $key => $rows) {
            $id_categoria = $rows["id_cat_banco"];
            $monto = $rows["precio_dis"];


            $dataBanco = [
                "id_cat_banco" => $id_categoria,
                "monto" => $monto
            ];

            $guardarBanco = bancoModelo::abonar_monto_modelo($dataBanco);


            if ($guardarBanco->rowCount() >= 1) {

                $data_transaccion = [
                    "id_persona" => NULL,
                    "id_ordencli" => $id_orden,
                    "id_cat_banco" => $id_categoria,
                    "monto_tra" => $monto,
                    "tipo_tra" => "PAGO"
                ];

                $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);

                if ($agregarTransaccion->rowCount() >= 1) {
                    $alerta = [
                        "Alerta" => "recargar",
                        "Titulo" => "Completado",
                        "Texto" => "Exito al Retornar Gastos",
                        "Tipo" => "success"
                    ];
                } else {

                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Algo salió mal",
                        "Texto" => "No se pudo retornar. ¡Ups!",
                        "Tipo" => "error"
                    ];
                }
            } else {

                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudoretornar. ¡Ups!",
                    "Tipo" => "error"
                ];
            }
        }
        $datos = [
            "id_orden" => $id_orden,
            "id_estado" => "4"
        ];
        $actualizarEstado = ordenClienteModelo::update_ordencliente_modelo($datos);

        return mainModel::sweet_alert($alerta);
    }

    public function retornar_gasto_orden_banco_controlador()
    {

        $id_orden = mainModel::limpiar_cadena($_POST["id_retorno_banco_cliente"]);
        $id_categoria = mainModel::limpiar_cadena($_POST["id_categoria_retorno"]);
        $monto = mainModel::limpiar_cadena($_POST["monto_retorno"]);
        $contador = mainModel::limpiar_cadena($_POST["contador"]);

        for ($i = 0; $i < $contador; $i++) {

            $dataBanco = [
                "id_cat_banco" => $id_categoria[$i],
                "monto" => $monto[$i]
            ];

            $guardarBanco = bancoModelo::abonar_monto_modelo($dataBanco);


            if ($guardarBanco->rowCount() >= 1) {

                $data_transaccion = [
                    "id_persona" => NULL,
                    "id_ordencli" => $id_orden,
                    "id_cat_banco" => $id_categoria[$i],
                    "monto_tra" => $monto[$i],
                    "tipo_tra" => "PAGO"
                ];

                $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);

                if ($agregarTransaccion->rowCount() >= 1) {

                    $datos = [
                        "id_orden" => $id_orden,
                        "id_estado" => "5"
                    ];
                    $actualizarEstado = ordenClienteModelo::update_ordencliente_modelo($datos);
                    
                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Completado",
                            "Texto" => "Exito al Retornar Gastos",
                            "Tipo" => "success"
                        ];
                   
                } else {

                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Algo salió mal",
                        "Texto" => "No se pudo retornar. ¡Ups!",
                        "Tipo" => "error"
                    ];
                }
            } else {

                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Algo salió mal",
                    "Texto" => "No se pudoretornar. ¡Ups1!",
                    "Tipo" => "error"
                ];
            }
        }


        return mainModel::sweet_alert($alerta);
    }

    public function data_cate_banco_controlador($id)
    {
        return bancoModelo::data_cate_banco_modelo($id);
    }

    public static function agregar_pago_externo_controlador()
    {

        //Variables
        $id_cat_banco = mainModel::limpiar_cadena($_POST['id_cat_banco_pago_externo']);
        $desc_pago = mainModel::limpiar_cadena($_POST['descripcion-pago']);
        $monto_pago = mainModel::limpiar_cadena($_POST['monto-pago']);
        $tipo_cambio_pago = mainModel::limpiar_cadena($_POST['tipo-cambio-reg']);
        $dataBanco = [


            "id_cat_banco" => $id_cat_banco,
            "desc_pago" => $desc_pago,
            "monto_pago" => $monto_pago,
            "tipo_cambio_pago" => $tipo_cambio_pago


        ];

        $guardarBanco = bancoModelo::agregar_pago_tercero_modelo($dataBanco);
        if ($guardarBanco->rowCount() >= 1) {

            $dataBanco = [
                "id_cat_banco" => $id_cat_banco,
                "monto" => $monto_pago
            ];

            $guardarBanco = bancoModelo::gasto_tercero_modelo($dataBanco);
            if ($guardarBanco->rowCount() >= 1) {

                $data_transaccion = [

                    "id_persona" => NULL,
                    "id_ordencli" => NULL,
                    "id_cat_banco" => $id_cat_banco,
                    "monto_tra" => $monto_pago,
                    "tipo_tra" => "PAGO TERCERO"
                ];

                $agregarTransaccion = bancoModelo::agregar_transaccion_modelo($data_transaccion);

                if ($agregarTransaccion->rowCount() >= 1) {
                    $alerta = [
                        "Alerta" => "recargar",
                        "Titulo" => "Pago registrado",
                        "Texto" => "El pago de S/ $monto_pago fue realizado correctamente",
                        "Tipo" => "success"
                    ];
                }
            }
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Algo salió mal",
                "Texto" => "No se pudo registrar Pago. ¡Ups!",
                "Tipo" => "error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }


    public function lista_pagos_externos_controlador($pagina, $registros, $id)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM PagoExterno pa
                         INNER JOIN CategoriaBanco ca  ON pa.id_cat_banco = ca.id_cat_banco 
                         INNER JOIN Banco ba ON ca.id_banco=ba.id_banco
                     WHERE pa.id_cat_banco='$id' ORDER BY fecha_pago DESC LIMIT $inicio,$registros";
        $paginaurl = "pagosExternos/" . $id;

        $moneda = '';
        $result = mainModel::ejecutar_consulta_simple("SELECT  moneda_banco  FROM Banco ba
                                                                         INNER JOIN CategoriaBanco ca ON ba.id_banco=ca.id_banco WHERE id_cat_banco ='$id'");


        foreach ($result as $key => $rows4) {
            $moneda = $rows4["moneda_banco"];
        }

        $tabla = '<thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-left">Descripción de Pago</th>
                        <th scope="col" class="text-left">Banco</th>
                        <th scope="col" class="text-center">Monto</th>';
        if ($moneda == "Dolares") {
            $tabla .= '<th scope="col" class="text-center">Tipo Cambio</th>';
        } else {
        }
        $tabla .= '
                        <th scope="col" class="text-center">fecha</th>
                        <th scope="col" class="text-center">Editar</th>
                    </tr>
                    </thead>
                <tbody>';
        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {

                $tabla .= '
                <tr>
                <td scope="row">' . $contador . '</td>
                
                <td class="d-flex align-items-center border-top-0">
                    <img class="profile-img img-sm img-rounded mr-2" src="' . SERVERURL . 'vistas/images/banco/bancco.png" alt="profile image">
                    <span>' . $rows['desc_pago'] . '</span>
                </td>
                <td>
                  <p class="mb-n1 font-weight-medium">' . $rows['nombre_banco'] . '</p>
                  <small class="text-gray">' . $rows['nombre_cate'] . '</small>
                </td>
                <td scope="row"> ';
                if ($moneda == "Dolares") {
                    $tabla .= '$ ';
                } else {

                    $tabla .= 'S/ ';
                }

                $tabla .= $rows['monto_pago'] . '</td>';

                if ($moneda == "Dolares") {
                    $tabla .= '<td scope="row">S/ ' . $rows['tipo_cambio_pago'] . '</td>';
                } else {
                }

                $tabla .= '<td scope="row">' . $rows['fecha_pago'] . '</td>
                <td><div class="btn btn-success">Editar</div></td>
                </tr>';

                $contador++;
            }
        } else {

            if ($total >= 1) {

                $tabla .= '
				<tr>
					<td colspan="5">
						<a href="' . SERVERURL . '/' . $paginaurl . '/" class="btn btn-sm btn-info btn-raised"> 
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



        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '<div class="d-flex justify-content-center">
            <nav aria-label="...">
      <ul class="pagination">';
            if ($pagina == 1) {
                $tabla .= '<li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Atrás</a>
    </li>';
            } else {
                $tabla .= '<li class="page-item">
                <a class="page-link" href="' . SERVERURL . $paginaurl . '/' . ($pagina - 1) . '" tabindex="-1">Atrás</a></li>';
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
}
