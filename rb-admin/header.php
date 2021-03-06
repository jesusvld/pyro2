<?php
include 'islogged.php';
?>
<!DOCTYPE HTML>
<html class="bg-main" lang="es">
<head>
	<link rel="shortcut icon" href="<?= rb_favicon(G_FAVICON) ?>">
	<link rel="apple-touch-icon" href="<?= rb_favicon(G_FAVICON) ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta content="True" name="HandheldFriendly">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<title><?= $rb_title ?></title>
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/styles2.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/cols.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/table.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/menu.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/fonts.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/resource/nestable/nestable.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/core/pages3/pages3.css" />
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/core/forms/forms.edit.css" />
	<!-- modulos css -->
	<?= do_action('panel_header_css') ?>
	<script src="<?= G_SERVER ?>rb-admin/js/jquery-1.11.2.min.js"></script>
	<script src="<?= G_SERVER ?>rb-admin/js/func.js"></script>
	<!--<script src="<?= G_SERVER ?>rb-admin/js/jquery.easing.1.3.js"></script>-->
	<!-- modulos js -->
	<?= do_action('panel_header_js') ?>
	<!-- Add fancyBox -->
	<link rel="stylesheet" href="<?= G_SERVER ?>rb-admin/resource/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script src="<?= G_SERVER ?>rb-admin/resource/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script src="<?= G_SERVER ?>rb-admin/resource/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<!-- jquery ui -->
	<link rel="stylesheet" href="<?= G_SERVER ?>rb-admin/resource/ui/jquery-ui.css">
	<!-- Funciones nuevas -->
	<script src="<?= G_SERVER ?>rb-admin/core/explo-uploader/file.explorer.js"></script>
	<script>
		$(document).ready(function() {
			// FancyBox simple
			$(".fancybox").fancybox();

			// Fancybox advanced Form
			$('.fancyboxForm').fancybox({
				//closeBtn    : false, // hide close button
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : {
					// prevents closing when clicking OUTSIDE fancybox
					overlay : {closeClick: false}
				},
				keys : {
					// prevents closing when press ESC button
					close  : null
				}
			});

			// Fancybox advanced Form + Tinymce
			$(".fancyboxFormEditor").fancybox({
				//closeBtn    : false, // hide close button
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : {
					// prevents closing when clicking OUTSIDE fancybox
					overlay : {closeClick: false}
				},
				keys : {
					// prevents closing when press ESC button
					close  : null
				},
				beforeShow: function () { tinymce.execCommand('mceToggleEditor', false, 'editor1'); },
				beforeClose: function () { tinyMCE.remove(); }
			});

			// scroll then menu top fixed
			var num = 50; //number of pixels before modifying styles
			$(window).bind('scroll', function () {
				if ($(window).scrollTop() > num) {
					$('#toolbar').addClass('fixed');
				} else {
					$('#toolbar').removeClass('fixed');
				}
			});

			// Btn Menu - Open
			$('.btnMenuOpen').click( function (event){
				event.preventDefault();
				$('.items').show();
				//$('.items').show("slide", { direction: "left" }, 300);
				$(".bg-opacity").fadeIn();

				$('html, body').css({
				    'overflow': 'hidden',
				    'height': '100%'
				});
			});

			// Btn Menu - Close
			$('.btnMenuClose').click( function (event){
				event.preventDefault();
				$('.items').hide();
				//$('.items').hide("slide", { direction: "left" }, 200);
				$(".bg-opacity").fadeOut();

				$('html, body').css({
				    'overflow': 'auto',
				    'height': 'auto'
				});
			});

			// Add BtnClose to Help Box
			$('.help').append('<a id="help-close" class="help-close" href="#">X</a>');
			$('.help').on("click", "#help-close", function(event){
				var $NameHelpBox = $('.help').attr("data-name");
				//alert($NameHelpBox);
				$.ajax({
					type: 'GET',
					url: 'hide.help.php',
					data: {
						nameHelpBox: $NameHelpBox
					}
				})
				.done( function (data){
					console.log(data);
					$('.help').slideUp();
				});
			});

			// Mostrar ocultar menu
			$('.btnShowMenu').click(function(event){
				event.preventDefault();
				console.log('menu mostrar');
				$('.items').toggleClass('items_expande', 500);
				$('#contenedor').toggleClass('contenedor_collapse', 500);
			});
		});

		var validateInputText = function(thisObj, msj){
			if( (thisObj.val()).trim() == ""){
				thisObj.addClass('input_red');
				thisObj.focus();
				thisObj.nextAll().remove();
				thisObj.after('<span style="color:red;font-size:.8em;">'+msj+'</span>');
				event.preventDefault();
			}else{
				thisObj.removeClass('input_red');
				thisObj.nextAll().remove();
			}
		}

		var pointInputText = function(thisObj, msj){
			thisObj.addClass('input_red');
			thisObj.focus();
			thisObj.nextAll().remove();
			thisObj.after('<span style="color:red;font-size:.8em;">'+msj+'</span>');
			event.preventDefault();
		}
	</script>
	<!-- tablas con datos -->
	<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/resource/datatables/datatables.min.css"/>
	<script type="text/javascript" src="<?= G_SERVER ?>rb-admin/resource/datatables/datatables.min.js"></script>
</head>
<body>
<?php
function msgOk($text){
	?>
	<script>
	notify('<?= $text ?>');
	</script>
	<?php
}
if(isset($_GET['m']) && $_GET['m']=="1")msgOk("Se envio un correo al usuario");
?>
<img id="img_loading" src="<?= G_SERVER ?>rb-script/images/loading.gif" alt="loading" style="display:none" />
<div id="message"></div>
<div class="bg-opacity"></div>
<div class="explorer"></div>
<header id="wrap-menu">
    <div class="logo">
		<a class="btnShowMenu" href="#"><i class="fas fa-bars"></i></a>
   	</div>
    <div class="bar">
    	<h1 class="title-web"><a href="<?= G_SERVER ?>rb-admin/" title="Página Inicial"><?= $titulo ?></a></h1>
			<div class="menu2">
				<?php if(G_ESTILO!="0"): ?>
	    	<a title="Ver Sitio Web" class="btn-goto-web" target="_blank" href="<?= G_SERVER ?>">
					<img src="<?= G_SERVER ?>rb-admin/img/website-icon.png" alt="Ver Sitio Web">
				</a>
				<?php endif ?>
				<?php if($userType == "admin"): ?>
	    	<a id="modules" title="Añadir funciones extras" href="<?= G_SERVER ?>rb-admin/modules.php">
	    		<img src="<?= G_SERVER ?>rb-admin/img/plugin-icon.png" alt="Modulos">
	    	</a>
				<?php endif ?>
	    	<?php if($userType == "admin"): ?>
	    	<a id="config" title="Opciones" href="<?= G_SERVER ?>rb-admin/index.php?pag=opc">
	    		<img src="<?= G_SERVER ?>rb-admin/img/options-icon.png" alt="Configuración general">
	    	</a>
	    	<?php endif ?>
	    	<a id="out" title="Cerrar sesion" href="<?= G_SERVER ?>login.php?out">
	    		<img src="<?= G_SERVER ?>rb-admin/img/out-icon.png" alt="Cerrar">
	    	</a>
			</div>
    </div>
</header>
