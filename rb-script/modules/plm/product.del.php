<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_GET['id'];

// Borrar de la DB
$r = $objDataBase->Ejecutar('DELETE FROM plm_products WHERE id='.$id);
if(G_ACCESOUSUARIO){
	if($r){
		$arr = ['resultado' => true, 'contenido' => 'Elemento eliminado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{
	$arr = ['resultado' => false, 'contenido' => 'Usuario no inicio sesion'];
}
die(json_encode($arr));
?>
