<script src="<?= G_SERVER ?>rb-script/modules/sapiens/sapiens.orders.js"></script>
<section class="seccion">
  <div class="seccion-header">
    <h2>Pedidos</h2>
    <ul class="buttons">
      <li><a class="button btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>sapiens/sapiens.orders.form.php">Nuevo</a></li>
    </ul>
  </div>
  <div class="seccion-body">
    <div id="content-list">
      <table id="table" class="tables table-striped">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Producto</th>
            <th>Atendido</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'sapiens.orders.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>