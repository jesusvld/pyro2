<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

/* parametros inciales */
$file_prefix = "category";
$table_name = "plm_category";
$key = "plm_category";
$module_dir = "plm";
$save_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".save.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag='.$key;

/* start */
if( isset($_GET['id']) ){
  $id=$_GET['id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM $table_name WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}

if( isset($_GET['parent_id']) ){
	$parent_id = $_GET['parent_id'];
}else{
	$parent_id = 0;
}
?>
<form id="frmNewEdit" class="form" style="max-width:400px">
	<input type="hidden" name="id" value="<?= $id ?>" required />
	<!-- campos inicio -->
  <label>
    Nombre
    <input type="text" name="nombre" required value="<?php if(isset($row)) echo $row['nombre'] ?>" />
  </label>
  <label>
    Descripcion
    <textarea name="descripcion"><?php if(isset($row)) echo $row['descripcion'] ?></textarea>
  </label>
	<label>
		<input type="checkbox" name="link" <?php if(isset($row) && $row['islink']==0) echo "checked" ?>> Link vacio
		<span class="info">No llevar a ningun lado</span>
	</label>
  <label>
    Foto
		<script>
			$(document).ready(function() {
				$(".foto_id").filexplorer({
					inputHideValue: "<?php if(isset($row)) echo $row['foto_id']; else echo "0"; ?>"
				});
			});
		</script>
    <?php
              $photo_category = "";
              if( isset($row) ){
                $Photo = rb_get_photo_details_from_id( $row['foto_id'] );
                $photo_category = $Photo['file_name'];
              }
              ?>
		<input type="text" readonly name="foto_id" class="foto_id" value="<?= $photo_category ?>" />
  </label>
	<label>
    Categoria padre
		<select name="parent_id">
			<option value="0">Ninguna</option>
			<?php
			$qc = $objDataBase->Ejecutar("SELECT * FROM plm_category ORDER BY nombre");
			while($category = $qc->fetch_assoc()){
				?>
				<option value="<?= $category['id'] ?>" <?php if(isset($row) && $row['parent_id']==$category['id']){ echo "selected"; }elseif($category['id']==$parent_id){ echo "selected"; } ?>><?= $category['nombre'] ?></option>
				<?php
			}
			?>
		</select>
  </label>
	<!-- campos final -->
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button class="button btn-primary" type="submit">Guardar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
	$(document).ready(function() {
    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

    // Boton Guardar
    $('#frmNewEdit').submit(function(event){
      event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: "<?= $save_path ?>",
  			data: $( this ).serialize()
  		})
  		.done(function( data ) {
  			if(data.resultado){
					$.fancybox.close();
  				notify(data.contenido);
					setTimeout(function(){
	          window.location.href = '<?= $urlreload ?>';
	        }, 1000);
  	  	}else{
  				notify(data.contenido);
  	  	}
  		});
    });
  });
</script>
