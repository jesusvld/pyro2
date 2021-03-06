<?php rb_header(['header-allpages.php'], false) ?>
<?php
	$allow_view = true; // Permitir ver por defecto: true
	if( $Content['acceso_permitir']==1){
		// Si no inicio sesion
	    if(G_ACCESOUSUARIO==0){
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
		        $url = "https://";   
		    else  
		        $url = "http://";   
		    // Append the host(domain name, ip) to the URL.   
		    $url.= $_SERVER['HTTP_HOST'];   
		    
		    // Append the requested resource location to the URL   
		    $url.= $_SERVER['REQUEST_URI'];

		    print '<p style="text-align:center;padding:30px 10px">Necesita <a href="'.G_SERVER.'/login.php?redirect='.$url.'">iniciar sesion</a> para ver este contenido</p>';
		    $allow_view=false;
		}

	    // Si inicio sesion
	    if(G_ACCESOUSUARIO==1){
			// Usuarios permitidos
		    $users_ids = explode(",", $Content['allow_users_ids']);
		    if(!in_array (G_USERID, $users_ids)) {
		    	print '<p style="text-align:center;padding:30px 10px">No tiene permiso para ver este contenido.</p>';
		    	$allow_view=false;
			}else{
				$allow_view=true;
			}
		}
	}

	if($allow_view){
		?>
		<div class="wrap-content">
			<div class="inner-content">
				<div class="aula_cover_content">
					<div class="aula_content_header_info">
						<div class="aula_content_path">
							Navegación: <?= $path ?>
						</div>
						<h2><?= $Content['titulo'] ?></h2>
						<?php
						if( isset($Links) ){
							print '<ul class="secciones">';
							
							foreach ($Links as $key => $value) {
								switch ($value['tipo']) {
									case '2':
										$Section = 'sesion';
										break;
									case '3':
										$Section = 'categoria';
										break;
								}
								print '<li>';
								print '<a href="'.G_SERVER.$Section.'/'.$value['id'].'">'.$value['titulo'].'</a>';
								print '</li>';
							}
							print '</ul>';
						}
						?>
						
					</div>
					<div class="aula_content">
						<?= $Content['contenido'] ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
?>
<?php rb_footer(['footer-allpages.php'], false) ?>
