<?php

if ($peticionAjax) {
    require_once "../modelos/sistemaModelo.php";
} else {
    require_once "./modelos/sistemaModelo.php";
}


class sistemaControlador extends sistemaModelo
{

    public static function crear_backup_controlador(){

    $consulta=sistemaModelo::backupDatabaseTables(SERVER,USER,PASS,DB);
    
    }
}
