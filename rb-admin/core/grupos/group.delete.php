<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$id=$_GET['id'];
$q = "DELETE FROM usuarios_grupos WHERE id= $id";
if($objDataBase->Consultar($q)){			
	$enlace=G_SERVER.'/rb-admin/index.php?pag=gru';
	header('Location: '.$enlace);
}else{
	echo "[!] Problemas";
}	
?>