<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$dpto_id = $_GET['dpto_id'];

$res_prov = $objDataBase->Ejecutar("SELECT * FROM ubprovincia WHERE idDepa=".$dpto_id);
$prov = $res_prov->fetch_all(MYSQLI_ASSOC);
die( json_encode($prov) );