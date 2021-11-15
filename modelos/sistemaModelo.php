<?php
if ($peticionAjax) {
    require_once '../core/mainModel.php';
} else {
    require_once './core/mainModel.php';
}
class sistemaModelo extends mainModel
{


    public static  function backupDatabaseTables($host, $user, $pass, $dbname, $tables = '*')
    {

    $db_host = $host; //Host del Servidor MySQL
	$db_name = $dbname; //Nombre de la Base de datos
	$db_user = $user; //Usuario de MySQL
	$db_pass = $pass; //Password de Usuario MySQL
    
	}
}