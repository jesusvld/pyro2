<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

// Variables
$id = $_POST['id'];
$des = addslashes($_POST['title']);
$album_id = $_POST['album_id'];
$url = $_POST['url'];

$tipo = $_POST['tipo'];
switch($tipo){
  case "art":
    $desurl = $_POST['articulo'];
    break;
  case "pag":
    $desurl = $_POST['pagina'];
    break;
  case "cat":
    $desurl = $_POST['categoria'];
    break;
  case "per":
    $desurl = $_POST['url'];
    break;
  case "you":
    $desurl = $_POST['youtubecode'];
    break;
  case "fac":
    $desurl = $_POST['facebookcode'];
    break;
  default:
    $desurl = "";
}

// Campos y sus valores a actualizar
$columns_vals = [
  'title' => $des,
  'url' => $desurl,
  'tipo' => $tipo
];

// Ejecución
$result = $objDataBase->Update(G_PREFIX.'files', $columns_vals, ['id' => $id]);

// Evaluando resultados
if( $result['result'] ){
  $arr = array('result' => true, 'message' => 'Datos de la imagen actualizado', 'url' => G_SERVER, 'last_id' => $id );
}else{
  $arr = array('result' => false, 'message' => $result['error']);
}

// Enviando resultados
die(json_encode($arr));
?>
