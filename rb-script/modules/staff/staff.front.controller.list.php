<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

require_once ABSPATH.'rb-admin/hook.php';
$modules_prev = rb_get_values_options('modules_load');
$array_modules = json_decode($modules_prev, true);
require_once ABSPATH.'rb-admin/modules.list.php';

// VARIABLES CON DATOS DE CABECERA GENERALES
define('rm_titlesite', G_TITULO);
define('rm_subtitle', G_SUBTITULO);
define('rm_longtitle' , G_TITULO . ( G_SUBTITULO=="" ? "" :  " - ".G_SUBTITULO ));
define('rm_url', G_SERVER."/" );
define('rm_urltheme', G_URLTHEME."/");
define('rm_datetoday', date("Y-m-d"));

$qs = $objDataBase->Ejecutar("SELECT * FROM staff ORDER BY num_order ASC, id");
$CountPosts = $qs->num_rows;

//$staff = $qs->fetch_assoc();

define('rm_title', "Staff | ".G_TITULO);
define('rm_title_page', "Staff");
define('rm_metakeywords', "");
define('rm_metadescription', "Relación del staff");
define('rm_metaauthor', G_METAAUTHOR);

$file = ABSPATH.'rb-script/modules/staff/staff.front.view.list.php';
require_once( $file );
?>