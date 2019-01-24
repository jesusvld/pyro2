<?php
/* Parametros iniciales para CRUD basico */
$title_section = "Platos";
$file_prefix = "plato";
$table_name = "rest_plato";
$module_dir = "restaurant";
$key = "rest_plato";

$newedit_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".newedit.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag='.$key;

$columns_title_coltable = [
  'Nombre' => 'nombre',
  'Categoria' => 'categoria',
  'Precio' => 'precio',
  'Salidas' => 'salidas'
];

/* start */
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM $table_name ORDER BY id DESC");
?>
<section class="seccion">
  <div class="seccion-header">
    <h2><?= $title_section ?></h2>
    <ul class="buttons">
      <li>
        <a class="btn-primary fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>">Nuevo</a>
      </li>
    </ul>
  </div>
  <div class="seccion-body">
    <script>
      $(document).ready(function() {
        $('#table').DataTable({
          "language": {
            "url": "resource/datatables/Spanish.json"
          }
        });
      } );
    </script>
    <table id="table" class="tables table-striped">
      <thead>
        <tr>
          <th>Imagen</th>
          <?php
          foreach ($columns_title_coltable as $key => $value) {
            ?>
            <th><?= $key ?></th>
            <?php
          }
          ?>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php include_once $file_prefix.'.list.php' ?>
      </tbody>
    </table>
  </div>
</section>
<script>
// Eliminar item
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("¿Continuar con la eliminacion de este elemento?");
  if ( eliminar ) {
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_DIR_MODULES_URL.$module_dir."/".$file_prefix ?>.del.php?id="+id
    })
    .done(function( data ) {
      if(data.resultado){
        notify(data.contenido);
        setTimeout(function(){
          window.location.href = '<?= $urlreload ?>';
        }, 1000);
      }else{
        notify(data.contenido);
      }
    });
  }
});
</script>
