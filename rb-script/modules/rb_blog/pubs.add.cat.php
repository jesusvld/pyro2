<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';


$nomVis=$_POST['categoria_nombre'];
$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['categoria_nombre']));
$des="";
$catpadre = 0;
$nivel = 0;

//$campos = array(,,$des,$catpadre,$nivel,0);
$data = [
	'nombre_enlace' => $nomOcul,
	'nombre' => $nomVis,
	'descripcion' => $des,
	'categoria_id' => $catpadre,
	'nivel' => $nivel,
	'photo_id' => 0,
	'acceso' => 'public'
];
//$q = "INSERT INTO blog_categories (nombre_enlace, nombre, descripcion, categoria_id, nivel, photo_id, acceso) VALUES ('".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",".$campos[4].", ".$campos[5]." ,'public' )";
$result = $objDataBase->Insert('blog_categories', $data);
if($result){
	$ultimo_id= $result['insert_id'];
	echo "<label class=\"label_checkbox\">";
	echo "<input type=\"checkbox\" value=\"$ultimo_id\" name=\"categoria[]\" /> $nomVis \n";
	echo "</label>";
}else{
	die("error");
}
