<?php
$mainmenu_id = $_GET['id'];
?>
<nav class="menu-edition">
	<ul id="subitems" class="main column">
	<?php rb_menus_edition($mainmenu_id,0,0); ?>
	</ul>
</nav>

<?php
function rb_menus_edition($mainmenu_id, $parent, $level) {
	global $objDataBase;

	$result = $objDataBase->Ejecutar("SELECT mi.nivel, mi.id, mi.mainmenu_id, mi.nombre, mi.url, mi.tipo, mi.style, Items.Count FROM menus_items mi  LEFT OUTER JOIN (SELECT menu_id, COUNT(*) AS Count FROM menus_items GROUP BY menu_id) Items ON mi.id = Items.menu_id WHERE mi.menu_id=". $parent." AND mi.mainmenu_id=".$mainmenu_id. " ORDER BY id");
    while ($row = $result->fetch_assoc()):
    	$class_nivel = "margen_". $row['nivel'];
    	$tipo = trim($row['tipo']);
        if ($row['Count'] > 0):
            ?>
            <li class="item" data-id="item<?= $row['id'] ?>" data-title="<?= $row['nombre'] ?>" data-url="<?= $row['url'] ?>" data-menumain="<?= $row['mainmenu_id'] ?>" data-type="<?= $row['tipo'] ?>" data-style="<?= $row['style'] ?>">
            	<div class="header">
            		<span class="item-title"><?= $row['nombre'] ?></span>
            	</div>
            	<a class="more" href="#"><span class="arrow-up" style="display: none;">&#9650;</span><span class="arrow-down">&#9660;</span></a>
            	<div class="item-body" style="display: none">
            		<label title="Titulo del Item" for="nombre">Titulo del Item:
            			<input id="item-menu-name-<?= $row['id'] ?>" required autocomplete="off"  name="nombre" class="menu_title" type="text" value="<?= $row['nombre'] ?>" required />
            		</label>
            		<?php
            		if($row['tipo']=="per"):
            		?>
            			<label title="URL" for="nombre">URL (incluir http://):
            				<input id="item-menu-url-<?= $row['id'] ?>" required autocomplete="off"  name="url" class="menu_url" type="text" value="<?= $row['url'] ?>" required />
            			</label>
            		<?php
					endif;
            		?>
            		<label>Estilos CSS (id):
            			<input id="item-menu-css-<?= $row['id'] ?>" name="estilo" class="menu_style" type="text" value="<?= $row['style'] ?>" />
            		</label>
            		<button class="delete">Eliminar</button>
            	</div>
            	<ul class="column item sortable">
            		<?php rb_menus_edition($mainmenu_id, $row['id'], $level + 1) ?>
            	</ul>
            </li>
            <?php
        elseif ($row['Count']==0):
			?>
			<li class="item" data-id="item<?= $row['id'] ?>" data-title="<?= $row['nombre'] ?>" data-url="<?= $row['url'] ?>" data-menumain="<?= $row['mainmenu_id'] ?>" data-type="<?= $row['tipo'] ?>" data-style="<?= $row['style'] ?>">
            	<div class="header">
            		<span class="item-title"><?= $row['nombre'] ?></span>
            	</div>
            	<a class="more" href="#"><span class="arrow-up" style="display: none;">&#9650;</span><span class="arrow-down">&#9660;</span></a>
            	<div class="item-body" style="display: none">
            		<label title="Titulo del Item" for="nombre">Titulo del Item:
            			<input id="item-menu-name-<?= $row['id'] ?>" required autocomplete="off"  name="nombre" class="menu_title" type="text" value="<?= $row['nombre'] ?>" required />
            		</label>
            		<?php
            		if($row['tipo']=="per"):
            		?>
            			<label title="URL" for="nombre">URL (incluir http://):
            				<input id="item-menu-url-<?= $row['id'] ?>" required autocomplete="off"  name="url" class="menu_url" type="text" value="<?= $row['url'] ?>" required />
            			</label>
            		<?php
					endif;
            		?>
            		<label>Estilos CSS (id):
            			<input id="item-menu-css-<?= $row['id'] ?>" name="estilo" class="menu_style" type="text" value="<?= $row['style'] ?>" />
            		</label>
            		<button class="delete">Eliminar</button>
            	</div>
            	<ul class="column item sortable">
            		<?php rb_menus_edition($mainmenu_id, $row['id'], $level + 1) ?>
            	</ul>
            </li>
            <?php
		endif;
	endwhile;
}
?>