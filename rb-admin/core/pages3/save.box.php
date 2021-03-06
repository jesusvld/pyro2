<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$id = $_POST['box_itemid'];
$nom = $_POST['box_name'];
$cont = $_POST['box_content'];
$typ = $_POST['box_type'];

$columns_vals = [
  'nombre' => $nom,
  'contenido' => $cont,
	'tipo' => $typ
];
header('Content-type: application/json; charset=utf-8');
if($id==0):
	$result = $objDataBase->Insert(G_PREFIX.'pages_blocks', $columns_vals);
	if($result['result']){
		$arr = array('resultado' => true, 'contenido' => 'Informacion almacenada en base de datos', 'id' => $result['insert_id']);
		die(json_encode($arr));
	}else{
		$arr = array('resultado' => false, 'contenido' => $result['error']);
		die(json_encode($arr));
	}
else:
	$columns_vals = [
	  'contenido' => $cont];
	$condition = ['id' => $id];
	$result = $objDataBase->Update(G_PREFIX.'pages_blocks', $columns_vals, $condition);
	if($result['result']){
		$arr = array('resultado' => true, 'contenido' => 'Informacion actualizada en base de datos', 'id' => $id);
		die(json_encode($arr));
	}else{
		$arr = array('resultado' => false, 'contenido' => $result['error']);
		die(json_encode($arr));
	}
endif;
?>
