<?php
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
    <?php
    foreach ($columns_title_coltable as $key => $value) {
      ?>
      <td><?= $row[$value] ?></td>
      <?php
    }
    ?>
		<td class="row-actions">
      <a href="<?= G_SERVER ?>rb-admin/module.php?pag=carrusel_list&id=<?= $row['id'] ?>">Elementos</a>
      <a title="Editar" class="edit fancyboxForm fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= $newedit_path ?>?id=<?= $row['id'] ?>">
        <i class="fa fa-edit"></i>
      </a>
      <a title="Eliminar" class="del" data-item="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>
    </td>
	</tr>
  <?php
endwhile;
?>