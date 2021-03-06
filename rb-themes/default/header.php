<!DOCTYPE html>
<html lang="es">
	<head>
    	<meta charset="utf-8">
		<title><?= rm_title ?></title>
		<meta name="theme-color" content="#fff" /> <!-- mobil bg color -->
		<meta name="description" content="<?= rm_metadescription ?>">
		<meta name="author" content="<?= rm_metaauthor ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
		<meta property="og:title" content="<?= rm_title ?>"/>
		<meta property="og:image" content="<?= rm_page_image ?>"/>
		<meta property="og:image:width" content="476" />
		<meta property="og:image:height" content="249" />
		<meta property="og:site_name" content="<?= rm_titlesite ?>"/>
		<meta property="og:description" content="<?= rm_metadescription ?>" />
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/styles.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/cols.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/styles-add.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/responsive.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/animations.css">
		<link rel="stylesheet" href="<?= rm_url?>rb-admin/css/frontend-bar.css">
		<link rel="stylesheet" href="<?= rm_url?>rb-script/modules/rb-userpanel/paneluser.css">
		<link rel="stylesheet" href="<?= rm_url?>rb-script/modules/pages.view3/styles-page.css">
		<link rel="stylesheet" href="<?= rm_url?>rb-script/modules/pages.view3/styles-page-responsive.css">
		<link rel="shortcut icon" href="<?= rb_favicon(G_FAVICON) ?>">
		<link rel="apple-touch-icon" href="<?= rb_favicon(G_FAVICON) ?>">
		<!-- jquery -->
		<script src="<?= rm_urltheme ?>js/jquery-1.11.2.min.js"></script>
		<script src="<?= rm_urltheme ?>js/jquery-migrate-1.2.1.js"></script>
		<!-- parallax -->
		<script src="<?= rm_urltheme ?>js/parallax.js"></script>
		<!-- fancy box -->
		<link rel="stylesheet" href="<?= rm_urltheme ?>res/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
		<script src="<?= rm_urltheme ?>res/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="<?= rm_urltheme ?>res/fancybox/source/jquery.fancybox.pack.js"></script>
		<script src="<?= rm_urltheme ?>res/fancybox/source/helpers/jquery.fancybox-media.js"></script>
		<!-- camera plugin -->
		<link rel="stylesheet" href="<?= rm_urltheme ?>res/camera/css/camera.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/slide.css">
		<script src="<?= rm_urltheme ?>res/camera/scripts/jquery.easing.1.3.js"></script>
		<script src="<?= rm_urltheme ?>res/camera/scripts/camera.min.js"></script>
		<!-- functions js additional -->
		<script src="<?= rm_urltheme ?>js/add.js"></script>
		<!-- start modulos adicionales -->
		<?= do_action('theme_header') ?>
		<!-- end modulos adicionales -->
		<script src="<?= rm_urltheme ?>js/funcs.js"></script>
	</head>
	<body>
		<div class="bg"></div>
		<?php //rb_show_bar_admin() ?>
