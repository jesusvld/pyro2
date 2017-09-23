<?php
// VALORES INICIALES - DEBE IR EN TODOS FILES
require('../global.php');
include 'islogged.php';

// redirect
$url_to_redirect = G_SERVER.$_SERVER['REQUEST_URI'];

$menu_panel = array();
require_once ABSPATH."rb-script/funciones.php";
require_once ABSPATH."rb-script/class/rb-usuarios.class.php";

//$menu_panel = rb_menu_panel(); // funcion
$menu_panel = json_decode(rb_get_values_options('menu_panel'), true); // from base datos

// CREA ESTRUCTURA DE CARPETA PARA GUARDAR MEDIOS AL PRIMER INICIO
define('RAIZ', dirname(dirname(__FILE__)) . '/');
$dir_raiz = RAIZ."rb-media";

if(is_dir($dir_raiz)==false){
	mkdir("$dir_raiz", 0775); // Crea directorio si no existe
}

$dir_raiz2 = RAIZ."rb-media/gallery";
if(is_dir($dir_raiz2)==false){
	mkdir("$dir_raiz2", 0775); // Crea directorio si no existe
}

$dir_raiz4 = RAIZ."rb-media/gallery/tn";
if(is_dir($dir_raiz4)==false){
	mkdir("$dir_raiz4", 0775); // Crea directorio si no existe
}

/* CREAR CATEGORIA SI NO HAY NINGUNA */
$q = $objDataBase->Ejecutar("SELECT * FROM categorias");
$num_categories = $q->num_rows;
if( $num_categories == 0 ) $objDataBase->Ejecutar("INSERT INTO categorias (nombre_enlace, nombre ) VALUES ('pordefecto', 'Por defecto' )");

// CONSULTAR COOKIE QUE CONTIENE AYUDAS OCULTAS
if (isset($_COOKIE['help_close'])) $array_help_close = unserialize($_COOKIE['help_close']);
else $array_help_close = array();

// USUARIO LOGUEADO CON EXITO
if(G_ACCESOUSUARIO==0){
	header('Location: '.G_SERVER.'/login.php?redirect='.urlencode($url_to_redirect));
}else{
	if(isset($_SESSION['type'])){
		if($_SESSION['type']=="user-front"){
			die("Usted no cuenta con acceso a esta seccion. <a href='".G_SERVER."'>Sacame de aqui</a>");
		}
	}
	$userType = $_SESSION['type'];

	// DATOS DEL USUARIO A VARIABLES GLOBALES
	$q = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE id=".G_USERID);
	$root = $q->fetch_assoc();
	//$root = mysql_fetch_array($q);
	define("G_USERNAME",$_SESSION['usr']);

	// PRINCIPALES COOKIES

	// CANTIDAD POR DEFECTO EN LAS LISTAS - POR CADA SECCION
	if(!isset($_COOKIE['art_show_items'])):
		setcookie("art_show_items", rb_get_values_options('show_items') );
	endif;

	if(!isset($_COOKIE['user_show_items'])):
		setcookie("user_show_items", rb_get_values_options('show_items') );
	endif;

	if(!isset($_COOKIE['page_show_items'])):
		setcookie("page_show_items", rb_get_values_options('show_items') );
	endif;

	if(!isset($_COOKIE['com_show_items'])):
		setcookie("com_show_items", rb_get_values_options('show_items') );
	endif;
	$titulo =  G_TITULO;
}
?>