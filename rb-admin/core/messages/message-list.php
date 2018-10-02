<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."rb-script/class/rb-database.class.php");

if(isset($_GET['opc'])){
  // ENVIADOS
  if($_GET['opc'] == "send"){
    $result = $objDataBase->Ejecutar("SELECT id, asunto, fecha_envio, inactivo FROM mensajes WHERE remitente_id = ".G_USERID." AND inactivo = 0 ORDER BY fecha_envio DESC LIMIT 10");
  }
}else{
  // RECIBIDOS
	//$retenido_string_col = "";
	//if(G_USERTYPE=="admin") $retenido_string_col = " AND mu.retenido=0";
	$q = "SELECT m.id, m.remitente_id, m.asunto, mu.leido, m.fecha_envio, mu.usuario_id, mu.inactivo, mu.retenido FROM mensajes m, mensajes_usuarios mu
		WHERE m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND mu.inactivo=0 AND mu.retenido=0 ORDER BY fecha_envio DESC";
	$result = $objDataBase->Ejecutar( $q );

	//echo G_USERTYPE;
}
while ($row = $result->fetch_assoc()){
  $style = "";
  $mod = "";
  // si estamos en la opcion de enviados
  if(isset($_GET['opc']) && $_GET['opc'] == "send"){
    $style = "";
    $mod = "sd"; //send
  }else{
  // si estamos en la opcion de recibidos
    $style = "";
    if($row['leido']==0){
      $style = 'style="font-weight:bold"';
    }
    $mod = "rd"; //received
  }?>
  <tr <?= $style ?>>
		<td>
      <input id="message-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" data-mode="<?= $mod ?>" data-uid="<?= G_USERID ?>" />
    </td>
		<td>
			<?php
			/*$aprobado = "";
			if(isset($row['retenido']) && $row['retenido']==0 && $row['remitente_id']==0){
				$aprobado = " [Aprobado]";
			}*/
			?>
			<a href="?pag=men&opc=view&mod=<?= $mod ?>&id=<?= $row['id'] ?>"><?= $row['asunto'] ?></a>
		</td>
		<?php
	  if(isset($_GET['opc']) && $_GET['opc'] == "send"){
			?>
	    <td>
			<?php
	    $coma = "";
	    $q = $objUsuario->destinatarios_del_mensaje($row['id']);
	    while($r = $q->fetch_assoc()){
	      echo $coma.$r['nombres'];
	      $coma=", ";
	    }
	    ?>
			</td>
			<?php
	  }else{
			?>
	    <td>
				<?php
				if($row['remitente_id']==0){
					echo "Gestor de Contenido ";
				}else{
					$Usuario = rb_get_user_info($row['remitente_id']);
					if($Usuario) echo $Usuario['nombrecompleto'];
					else echo 'Este usuario ya no existe';
				}
				?>
			</td>
			<?php
	  }
		?>
	  <td><?= $row['fecha_envio'] ?></td>
	  <td width='40px;'>
			<span>
				<a href="#" style="color:red" title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>" data-mode="<?= $mod ?>" data-uid="<?= G_USERID ?>">
					<img src="img/del-black-16.png" alt="Eliminar" />
				</a>
			</span>
	  </td>
	<tr>
<?php
}
?>
