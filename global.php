<?php
// ESTE ARCHIVO CONTIENE DATOS QUE SON USADOS EN LA MAYORIA DE LAS PAGINAS DEL APP

//definicion de variables globales que se usaran en todo el gestor
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

//llamar a clase con las opciones basica del sitio
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$objDataBase = new DataBase;

// Prefijo para las tablas del sistema
define('G_PREFIX', 'py_');

require_once(ABSPATH.'rb-script/funcs.php');

// verifica datos en tabla, sino inicial el instalador
$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."configuration");
if($q->num_rows==0){
	// Fragmentamos la url
	$url_parts = explode("/",$_SERVER['SCRIPT_NAME']);
	// Obtenermos el ultimo elemento del array
	$last_part_url = $url_parts[count($url_parts)-1];

	// Obtener el directorio donde estara instalado el cms
	// Reemplazamos el ultimo elemento con un dato campo vacio para obtener este valor
	$directory = str_replace('/'.$last_part_url, '', $_SERVER['SCRIPT_NAME']);
	header('Location: '.$directory.'/rb-install/index.php');
}

// Inicia arrays para contener los bb_codes y su correspondiente en html
$widgets=[];
$bb_codes = [];
$bb_htmls = [];
$menu_user_panel=[];
$menu_user_panel_start=[ // iniciar array del menu del panel de usuario
	[
		'key' => 'data',
		'title' => 'Mis datos',
	],
	[
		'key' => 'notifications',
		'title' => 'Mis notificaciones',
	]
];

array_push($menu_user_panel, $menu_user_panel_start);

//enlaces amigables
define('G_ENL_AMIG', rb_get_values_options('enlaceamigable'));

// version del gestor
define('G_VERSION', rb_get_values_options('version'));

//nombre del servidor http
define('G_SERVER', rb_get_values_options('direccion_url')."/");

//url del panel
define('G_URLPANEL', rb_get_values_options('direccion_url')."/rb-admin/");

//nombre del servidor http
define('G_DIR_MODULES_URL', G_SERVER."rb-script/modules/");

//si el sitio esta en un directorio
define('G_DIRECTORY', rb_get_values_options('directorio_url'));

// nombre pagina con extension. Ej. De "http://emocion.pe" a "emocion.pe"
$s = parse_url(G_SERVER);
define('G_HOSTNAME', $s['host']);

//numero registros
//define('G_NUMREGS', rb_get_values_options('num_registers'));

//tema usado o guardado en cookies
//define('G_CSS', rb_get_values_options('css_style'));
if(isset($_COOKIE['_ribosoma_style'])){
	define('G_ESTILO', $_COOKIE['_ribosoma_style']);
}else{
	define('G_ESTILO', rb_get_values_options('tema'));
}
//valores titulo y descripcion
define('G_TITULO', rb_get_values_options('nombresitio'));
define('G_SUBTITULO', rb_get_values_options('descripcion'));

//informacion sobre meta tags
define('G_METAKEYWORDS', rb_get_values_options('meta_keywords'));
define('G_METADESCRIPTION', rb_get_values_options('meta_description'));
define('G_METAAUTHOR', rb_get_values_options('meta_author'));

// mails destination
define('G_MAILS', rb_get_values_options('mail_destination'));

// mail sender
define('G_MAILSENDER', rb_get_values_options('mail_sender'));

//cuando mostrar en categoria, index, u otras listas
define('G_POSTPAGE', rb_get_values_options('post_by_category'));

//define directorio del la url del tema
define('G_URLTHEME',rb_get_values_options('direccion_url')."/rb-themes/".rb_get_values_options('tema')."/");

// codigo pagina inicial
define('G_INITIAL', rb_get_values_options('initial'));

// muestra o no, link para registro de usuario
define('G_LINKREGISTER', rb_get_values_options('linkregister'));

// formulario de contacto
//define('G_FORM', rb_get_values_options('form_code'));

// ancho y alto thumbnails por defecto
define('G_TWIDTH', rb_get_values_options('t_width'));
define('G_THEIGHT', rb_get_values_options('t_height'));

// menu principal a mostrar - obsoleto
// define('G_MAINMENU', rb_get_values_options('mainmenu_id'));

// moneda
define('G_COIN', rb_get_values_options('moneda'));

// slide principal
//define('G_SLIDEMAIN', rb_get_values_options('slide_main'));

// logo
define('G_LOGO', rb_get_values_options('logo'));

// favicon
define('G_FAVICON', rb_get_values_options('favicon'));

// background-image login
define('G_BGLOGIN', rb_get_values_options('background-image'));

// mail libreria externa
//define('G_LIBMAILNATIVE', rb_get_values_options('lib_mail_native'));

// base url links amigables
//define('G_BASEPUB', rb_get_values_options('base_publication'));
//define('G_BASECAT', rb_get_values_options('base_category'));
define('G_BASEUSER', rb_get_values_options('base_user'));
define('G_BASESEAR', rb_get_values_options('base_search'));
define('G_BASEPAGE', rb_get_values_options('base_page'));

define('G_USERACTIVE', rb_get_values_options('user_active_admin'));
define('G_ALCANCE', rb_get_values_options('alcance'));

define('G_BLOCK_HEADER', rb_get_values_options('block_header_ids'));
define('G_BLOCK_FOOTER', rb_get_values_options('block_footer_ids'));

define('G_KEYWEB', rb_get_values_options('key_web'));

// Zona horaria por defecto
date_default_timezone_set('America/Lima'); // Versiones futuras sera modificable

//variable global para sesion activa
session_start();

if(isset($_SESSION['usr']) and isset($_SESSION['pwd'])){
	define('G_ACCESOUSUARIO',1);
	define('G_USERID', $_SESSION['usr_id']);
	define('G_USERTYPE', $_SESSION['type']);
	define('G_USERNIVELID', $_SESSION['nivel_id']);
}else{
	define('G_ACCESOUSUARIO',0);
	define('G_USERID', 0);
	define('G_USERTYPE', 0);
	define('G_USERNIVELID', 0);
}
?>
