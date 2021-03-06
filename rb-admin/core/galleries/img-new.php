<?php
$album_id=$_GET["album_id"];
$qg = $objDataBase->Ejecutar("SELECT nombre FROM ".G_PREFIX."galleries WHERE id=$album_id");
$rg= $qg->fetch_assoc();
?>
<?php if (!in_array("imgnew", $array_help_close)): ?>
<div class="help" data-name="imgnew">
  <p>Puedes agregar nuevos elementos a tu Galería:</p>
  <ul>
    <li>Subir directamente tu imagen</li>
    <li>Seleccionar imágenes desde las que ya tienes subidas</li>
  </ul>
</div>
<?php endif ?>
<div class="inside_contenedor_frm">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/?pag=gal">Galerias</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <span><?= $row['nombre'] ?></span>
        <?php else: ?>
          <span>Nueva galería</span>
        <?php endif ?>
      </div>
      <a class="button" href="<?= G_SERVER ?>rb-admin/index.php?pag=gal&album_id=<?= $album_id ?>">Volver</a>
    </div>
  </div>
    <section class="seccion">
      <div class="seccion-header">
        <h3>Subir imágenes nuevas</h3>
      </div>
      <div class="seccion-body">
      <div id="mulitplefileuploader"></div>
      <span class="info">Archivos permitidos: jpg, png, gif, doc. Tamaño máximo: <strong><?php echo ini_get("upload_max_filesize"); ?></strong></span>
      <div id="status"></div>
      <!-- Load multiples imagenes -->
      <link href="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
      <script src="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

      <script type="text/javascript">
      $(document).ready(function(){
        var settings = {
            url: "<?= G_SERVER ?>rb-admin/uploader.php",
            dragDrop:true,
            fileName: "myfile",
            formData: {"albumid":"<?= $album_id ?>" , "user_id" : "<?= G_USERID ?>"},
            urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=gal&opc=edt&album_id=".$album_id."&id=" ?>',
            allowedTypes:"jpeg,jpg,png,gif",
            returnType:"html", //json
          onSuccess:function(files,data,xhr)
            {
               //$("#status").append("Subido con exito");
            },
            //showDelete:true,
            deleteCallback: function(data,pd)
          {
            for(var i=0;i<data.length;i++)
            {
                $.post("delete.php",{op:"delete",name:data[i]},
                function(resp, textStatus, jqXHR)
                {
                    $("#status").append("<div>Archivo borrado</div>");
                });
             }
            pd.statusbar.hide(); //You choice to hide/not.

          }
        }

        var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

        // Filter files
        $('#search_box').keyup(function(){
          var valThis = $(this).val();
          $('.gallery>li').each(function(){
            var text = $(this).find('span').text().trim().toLowerCase();
            (text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
          });
        });
      });
      </script>
      </div>
    </section>

    <?php
    if($userType == "user-panel"):
      $q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id = ".G_USERID);
    else:
      $q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg')");
    endif;
    if($q->num_rows):
    ?>
    <section class="seccion">
      <div class="seccion-header">
        <h3>Seleccionar imágenes ya subidas</h3>
      </div>
      <div class="seccion-body">
        <div class="search-bar">
  				<input type="text" id="search_box" placeholder="Filtrar por nombre de archivo" />
  			</div>
        <div class="flibrary">
          <form action="core/galleries/img-add.php" method="POST" name="library">
            <input type="hidden" name="album_id" value="<?= $album_id ?>" />
            <input type="hidden" name="section" value="imgnew" />
            <ul class="gallery wrap-grid">
            <?php
            while($r= $q->fetch_assoc()):
            ?>
            <li class="grid-1">
            <label>
              <div class="cover-img" style="background-image:url('<?= G_SERVER ?>rb-media/gallery/tn/<?= $r['src'] ?>')" title="<?= $r['src'] ?>">
              <input class="checkbox" type="checkbox" name="items[]" value="<?= $r['id']?>" />
              <span class="filename truncate"><a class="fancybox" href="<?= G_SERVER ?>rb-media/gallery/<?= $r['src'] ?>"><?= $r['src'] ?></a></span>
              </div>
            </label>
            </li>
            <?php
            endwhile;
            ?>
            </ul>

            <p style="text-align: center;"><input class="btn-primary" type="submit" value="Guardar seleccion" /></p>
          </form>
        </div>
      </div>
    </section>
    <?php
    endif;
    ?>
</div>
