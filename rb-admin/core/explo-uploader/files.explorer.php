<?php
/*
 * Usando dirname para retroceder
 * 4 niveles arriba y ubicarse
 * en la raiz del sitio
 *
 * Alternativamente se puede usar $_SERVER['DOCUMENT_ROOT']
 * Ver el archivo files.explorer.refresh.php
 *
 * */

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname( dirname( dirname( dirname(__FILE__) ) ) ). '/' );

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

$controlShowId = $_GET['controlShowId'];
$controlHideId = $_GET['controlHideId'];
?>
<script>
	$( "#close" ).click(function( event ) {
		event.preventDefault();
		$('#img_loading').hide();
		$(".bg_files").hide();
		$(".explorer").hide();
   	$(".explorer").empty();
	});

	$("#imgsingallery").on("click", ".explorer-file", function (event) { // on(). Para contenido generado dinamicamente
		event.preventDefault();
		$( "#<?= $controlShowId ?>" ).val( $(this).attr("datafld") );
		$( "#<?= $controlHideId ?>" ).val( $(this).attr("datasrc") );
		$( "#close" ).click();
	});

	// Mostrar Uploader de archivos
	$( '#btnShowUploader' ).click(function( event ) {
		event.preventDefault();
		$( ".explorer-body-inner" ).show();
		$( ".gallery-list" ).hide();

		$("#btnShowImages").removeClass('selected');
		$(this).addClass('selected');
	});

	// Refresca la lista de archivos
	$( '#btnShowImages' ).click(function( event ) {
		event.preventDefault();
		$( ".explorer-body-inner" ).hide();
		$( ".gallery-list" ).show();

		$("#btnShowUploader").removeClass('selected');
		$(this).addClass('selected');

		/*$.ajax({
			method: "GET",
			url: "<?= G_SERVER ?>rb-admin/core/explo-uploader/files.explorer.refresh.php?album_id=0"
		}).done(function( html_response ) {
		    $('#imgsingallery').html(html_response);
		});*/
	});

	// Filter files
	$('#search_box').keyup(function(){
		var valThis = $(this).val();
    $('.gallery>li').each(function(){
			var text = $(this).find('span').text().toLowerCase();
			(text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
   	});
	});
</script>
<div class="explorer-header">
	<h3>Explorar archivos</h3>
	<a id="close" href="#">×</a>
</div>
<div class="explorer-toolbar">
	<a href="#" id="btnShowImages" class="selected">Seleccionar</a>
	<a href="#" id="btnShowUploader">Subir archivo</a>
</div>
<div class="explorer-body">
	<!-- L I S T A D O   I M A G E N E S  -->
	<div class="gallery-list">
		<div class="search-bar">
			<input type="text" id="search_box" placeholder="Archivo a buscar" />
		</div>
		<div id="imgsingallery" class="flibrary">
			<ul class="gallery" style="overflow:hidden;margin-bottom:20px;">
				<?php require_once 'files.explorer.refresh.php' ?>
			</ul>
			<div style="clear:both"></div>
		</div>
	</div>
	<!-- S U B I R   I M A G E N E S  -->
	<div class="explorer-body-inner" id="examiner-photos" style="display: none">
		<div id="mulitplefileuploader"></div> <!-- aqui aparecen el form -->
		<div id="status"></div>
		<link href="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
		<script src="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			var settings = {
				url: "<?= G_SERVER ?>rb-admin/uploader.php",
			  dragDrop:true,
			  fileName: "myfile",
			  formData: {"albumid":"0" , "user_id" : "<?= G_USERID ?>"},
				allowedTypes:"<?= rb_get_values_options('files_allowed') ?>",
			  returnType:"json", //json
				showStatusAfterSuccess: false,
				onSuccess:function(files,data,xhr){
					msg = '<li><a class="explorer-file" title="ID: '+data.last_id+'" datafld="'+data.filename+'" datasrc="'+data.last_id+'" href="#"><img class="thumb" width="100" src="../rb-media/gallery/tn/'+data.filename+'"><span>'+data.filename+'</span></a></li>';
					$('.gallery').prepend( msg );
			  },
			  //showDelete:true,
			  deleteCallback: function(data,pd){
			    for(var i=0;i<data.length;i++){
						$.post("delete.php",{op:"delete",name:data[i]},
						function(resp, textStatus, jqXHR){
							$("#status").append("<div>Archivo borrado</div>");
			      });
			    }
			    pd.statusbar.hide(); //You choice to hide/not.
				}
			}

			var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
		});
		</script>
	</div>
</div>
