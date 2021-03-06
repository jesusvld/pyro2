<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

// Asignando valores
$valores = [
	'titulo' => trim($_POST['titulo']),
	'descripcion' => trim($_POST['descripcion']),
	'foto_id' => trim($_POST['foto_id']),
	'url' => rb_cambiar_nombre(utf8_encode(trim($_POST['titulo'])))
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('boletin_areas', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Area registrado', 'id' => $r['insert_id'], 'continue' => true ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('boletin_areas', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Area actualizado', 'continue' => true ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
