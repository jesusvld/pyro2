<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

$type = "post1";
$action = "showConfigPost1";
$block_title = "Publicaciones";
$url_img = G_SERVER."rb-script/modules/rb_blog/widget.pub.png";
if(isset($widget)){
	$widget_id = $widget['widget_id'];
}else{
	if(!isset($_GET['temp_id'])) $widget_id = 1;
	else $widget_id = $_GET['temp_id'];
}
?>
<li id="<?= $widget_id ?>" class="widget" data-id="<?= $widget_id ?>" data-type="<?= $type ?>" data-class="<?php if(isset($widget)) echo $widget['widget_class'] ?>"
	data-values='<?php if(isset($widget))echo json_encode($widget['widget_values']); else echo "{}" ?>'>
	<div class="widget-header">
		<strong><?= $block_title ?></strong>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</div>
	<div class="widget-body">
		<div class="box-edit">
			<div class="box-edit-html" id="box-edit<?= $widget_id ?>">
				<p style="text-align:center;max-width:100%"><img src="<?= $url_img ?>" alt="post" /></p>
			</div>
			<div class="box-edit-tool"><a href="#" class="<?= $action ?>" title="Clic para configurar"><span>Configurar</span></a></div>
		</div>
	</div>
</li>
