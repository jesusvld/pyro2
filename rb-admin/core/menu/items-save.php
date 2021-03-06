<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

if(!isset($_POST['mainmenu_id'])) die ("Error: Id Main Menu no especificado");

$objDataBase->Ejecutar("DELETE FROM ".G_PREFIX."menus_items WHERE mainmenu_id=".$_POST['mainmenu_id']);

$directions = json_decode($_POST['json'],true);
travel_json($directions);
echo "1";

function travel_json($matriz, $padre_id = 0, $nivel = 0){  // De array a base de datos
	global $objDataBase;
	require_once(ABSPATH."rb-script/funcs.php");

	foreach($matriz as $row=>$value):
		$menu_nombre = htmlentities(strip_tags( trim($value['title']), "<i>" ));
		$menu_nombre_enlace = rb_cambiar_nombre(addslashes(strip_tags( trim($value['title']) )));
		$menu_url = $value['url'];
		$menu_menuid = $value['menumain'];
		$menu_nivel = $nivel+1;
		$menu_tipo = $value['type'];
		$menu_estilo = $value['style'];
		$menu_img = $value['img'];

		$data = [
			'nombre_enlace' => $menu_nombre_enlace,
			'nombre' => $menu_nombre,
			'url' => $menu_url,
			'menu_id' => $padre_id,
			'nivel' => $nivel,
			'mainmenu_id' => $menu_menuid,
			'tipo' => $menu_tipo,
			'style' => $menu_estilo,
			'img' => $menu_img
		];

		/*$response = $objDataBase->Insertar("INSERT INTO ".G_PREFIX."menus_items (nombre_enlace, nombre, url, menu_id, nivel, mainmenu_id, tipo, style, img)
		VALUES ('$menu_nombre_enlace', '$menu_nombre', '$menu_url', $padre_id, $nivel, $menu_menuid, '$menu_tipo', '$menu_estilo', '$menu_img')");*/
		$response = $objDataBase->Insert(G_PREFIX."menus_items", $data);

		if($response['result']) $nuevo_padre = $response['insert_id'];
		else die("Ocurrio error");

		if(isset($matriz[$row]['children']) ):
			travel_json($matriz[$row]['children'], $nuevo_padre, $menu_nivel);
		endif;
	endforeach;
}
?>
