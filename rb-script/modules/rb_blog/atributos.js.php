<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$qa = $objDataBase->Ejecutar("SELECT id, titulo, titulo_enlace FROM blog_posts ORDER BY id");
$count_attr = $qa->num_rows;
?>
$(document).ready(function () {
	var idAtributo = 100<?= $_GET['attrs'] ?>;

	$( "#newAtributo" ).click(function(event) {
		event.preventDefault();
		$('#t_atributo tr:last').after('<tr>'+
			'<td>'+
				'<input id="input_'+idAtributo+'" required type="text" name="atributo['+idAtributo+'][nombre]" />'+
			'</td>'+
			'<td>'+
				'<select data-id="'+idAtributo+'" id="select_'+idAtributo+'" class="select" name="atributo['+idAtributo+'][id]">'+
				<?php
				while($art = $qa->fetch_assoc()):
					echo "'<option value=\"".$art['id']."\">".trim($art['id'])."-".addslashes(trim($art['titulo']))."</option>'+\n";
				endwhile;
				?>
				'</select>'+
			'</td>'+
			'<td><a title="Borrar" class="deleteAtributo" href="#"><img src="img/del-red-16.png" alt="delete" /></a></td>'+
			'</tr>');
		idAtributo++;
	});

	$("#t_atributo").on("click", ".deleteAtributo", function (event) {
		event.preventDefault();
		$(this).closest("tr").remove();
	});

	$(document).on('change', '.select', function() {
		var select_id = $(this).attr("data-id");
	  	var option = $(this).find('option:selected').text();
	  	$('#input_'+select_id).val(option);
	  	console.log( option );
	});
});
