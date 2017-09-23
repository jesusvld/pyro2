<?php
require_once('global.php');
require_once('rb-script/funciones.php');
require_once('rb-script/class/rb-database.class.php');
require_once('rb-script/class/rb-usuarios.class.php');

//$Page=1;
// VARIABLES CON DATOS DE CABECERA GENERALES
$rm_titlesite = G_TITULO;
$rm_title = G_TITULO;
$rm_subtitle = G_SUBTITULO;
$rm_longtitle = G_TITULO . ( G_SUBTITULO=="" ? "" :  " - ".G_SUBTITULO );
$rm_metakeywords = G_METAKEYWORDS;
$rm_metadescription = G_METADESCRIPTION;
$rm_metaauthor = G_METAAUTHOR;
$rm_url = G_SERVER."/";
$rm_urltheme = G_URLTHEME."/";
$rm_datetoday = date("Y-m-d");
$rm_mainmenu = G_MAINMENU;
$rm_usernick = "";
$rm_usernames = "";
$rm_userlastnames = "";
$rm_userimgid = "";
$rm_userid = G_USERID;
$rm_url_page = $rm_url;
$rm_url_page_img = $rm_url."blackpyro-logo.png";

function message_error($file){
	header( 'Location: '.G_SERVER.'/login.php');
}
// SI NO ACCESÓ
if(G_ACCESOUSUARIO==0){
	if(G_ESTILO=="0"){ // Si no hay estilo seleccionado, que se logueo para conseguirlo
		header('Location: '.G_SERVER.'/login.php');
	}
}
// Si sitio inicial es Privado y no se logueo, manda a loguearse
if(G_ALCANCE==1 && G_ACCESOUSUARIO==0) header('Location: '.G_SERVER.'/login.php');

// VALORES SI INICIA SESION USUARIO
if(G_ACCESOUSUARIO==1):
	$user = rb_get_user_info($rm_userid);
	$rm_usernick = $user['nickname'];
	$rm_usernames = $user['nombres'];
	$rm_userlastnames = $user['apellidos'];
	$rm_userimgid = $user['photo_id'];
endif;

// VALIDAMOS SI TRABAJAMOS CON ENLACES AMIGABLES
if(G_ENL_AMIG):
	// -- Si opcion enlaces amigables e ingresa de manera tradicional, direccionarlo a enlaces amigables.
	//Direccionar en caso de publicacion
	if ( isset($_GET['art']) ):
		$Post = rb_show_post( $_GET['art'] );
		header( 'Location: '.$Post['url'] );
		exit();
	endif;

	// Direccionamientos pendientes
	/*if ( isset($_GET['p']) ) $PageId = $_GET['p'];
	if ( isset($_GET['cat']) ):
		$CategoryId = $_GET['cat'];
		if ( isset($_GET['page']) ) $Page = $_GET['page'];
	endif;
	//if ( isset($_GET['s']) ) $SearchTerm = $_GET['s'];
	if ( isset($_GET['panel']) ) $Panel = $_GET['panel'];*/

	//Direccionar en caso de busqueda
	if ( isset($_GET['s']) ):
		header( 'Location: '.G_SERVER.'/'.G_BASESEAR.'/'.rb_cambiar_nombre(trim($_GET['s'])).'/' );
		exit();
	endif;
  //$requestURI  = str_replace("/prueba", "", $_SERVER['REQUEST_URI']);
	$requestURI = str_replace("", "", $_SERVER['REQUEST_URI']);
  $requestURI = explode("/", $requestURI);
	//$requestURI = explode( '/', $_SERVER['REQUEST_URI'] );

	// Eliminamos los espacios del principio y final y recalculamos los índices del vector.
	$requestURI = array_values( array_filter( $requestURI ) );
	$numsItemArray = count($requestURI);

	if( $numsItemArray > 0 ):
		// Si es Post - Articulos - Publicacion
		if( $requestURI[0] == G_BASEPUB ):
			$PostId = $requestURI[1];
		endif;
		// Si es Categoria
		if( $requestURI[0] == G_BASECAT ):
			$num_parts = count($requestURI);
			if( $num_parts == 4):
				$CategoryId = $requestURI[1];
				$Page = $requestURI[3];
			else:
				$CategoryId = $requestURI[1];
			endif;
		endif;
		// Si es Usuario ??? Revisar
		if( $requestURI[0] == G_BASEUSER ):
			echo "Usuario"; // En Desarrollo
		endif;
		// Si es Busqueda
		if( $requestURI[0] == G_BASESEAR ):
			$SearchTerm = $requestURI[1];
		endif;
		// Si es Panel ??? Revisar
		if( $requestURI[0] == G_BASESEAR ):
			$SearchTerm = $requestURI[1];
		endif;
		// Si es Pagina simple
		if( $numsItemArray == 1 ):
			if( $requestURI[0] == "index.php" ):
				header( 'Location: '.G_SERVER );
				exit();
			endif;
			$PageId = $requestURI[0];
			// Buscamos si existe en la base de datos
		endif;
	endif;
else: // SI ENLACES NO AMIGABLES
	if ( isset($_GET['art']) ) $PostId = $_GET['art'];
	if ( isset($_GET['p']) ) $PageId = $_GET['p'];
	if ( isset($_GET['cat']) ):
	 	$CategoryId = $_GET['cat'];
		if ( isset($_GET['page']) ) $Page = $_GET['page'];
	endif;
	if ( isset($_GET['s']) ) $SearchTerm = $_GET['s'];
	if ( isset($_GET['panel']) ) $Panel = $_GET['panel'];
endif;

// ARCHIVOS DIRECTOS
if(isset($_GET['pa'])){
	// Si accede a panel y no esta logueado, manda al index
	if($_GET['pa']=="panel" && G_ACCESOUSUARIO==0):
		header('Location: '.$objOpcion->obtener_valor(1,'direccion_url'));

	// Si accede a panel y esta logueado, lleva al modulo externo para el panel
	elseif($_GET['pa']=="panel" && G_ACCESOUSUARIO==1):
		$rm_menu_name = "";
		require ABSPATH.'rb-script/modules/rb-userpanel/panel.php';
	// Si es cualquier pagina, la carga respectivamente
	else:
		$file = ABSPATH.'rb-temas/'.G_ESTILO.'/'.$_GET['pa'].'.php';
		if(file_exists( $file )) require_once( $file );
	endif;
// PUBLICACIONES
}elseif(isset( $PostId )){
	$Post = rb_show_post( $PostId );
	if(!$Post) header('Location: '.G_SERVER.'/404.php');

	// VALORES DE CABECERA DEL POST
	$rm_title = $Post['titulo']." | ".G_TITULO;
	$rm_metadescription = rb_fragment_text($Post['contenido'],30, false);
	$rm_metaauthor = $Post['autor_id']; //--> capturar codigo de usuario
	$rm_url_page = $Post['url'];
	$rm_menu_name = "";
	$rm_url_page_img = $Post['url_img_por_max'];

	// CATEGORIA
	$qc = rb_get_category_by_post_id($Post['id']);
	$Cat = $qc->fetch_assoc();
	$Categoria_id = $Cat['id'];

	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/post.php';
	if(file_exists( $file )): require_once( $file );rb_set_read_post($Post['id']);
	else: die( message_error($file));
	endif;

// PAGINAS
}elseif( isset( $PageId ) ){
	$Page = rb_show_specific_page( $PageId );
	if($Page==false){ // Sino es una pagina del sistema sino una pagina externa independiente html/php
		if($PageId=="panel" && G_ACCESOUSUARIO==0):
			header('Location: '.$objOpcion->obtener_valor(1,'direccion_url'));

		// Si accede a panel y esta logueado, lleva al modulo externo para el panel
		elseif($PageId=="panel" && G_ACCESOUSUARIO==1):
			$rm_menu_name = "";
			require ABSPATH.'rb-script/modules/rb-userpanel/panel.php';
		// Si es cualquier pagina, la carga respectivamente
		else:
			$file = ABSPATH.'rb-temas/'.G_ESTILO.'/'.$PageId.'.php';
			if(file_exists( $file )) require_once( $file );
		endif;
	}else{ // Asignando valores a la pagina del sistema
		//if(!$Page) header('Location: '.G_SERVER.'/404.php');
	  $rm_title = $Page['titulo']." | ".G_TITULO;
	  $rm_metakeywords = $Page['tags'];
	  $rm_metadescription = rb_fragment_text($Page['contenido'],30, false);
	  $rm_metaauthor = $Page['autor_id']; //--> capturar codigo de usuario

	  $allow_sidebar = $Page['sidebar'];
		$rm_menu_name = $Page['addon'];
		$rm_url_page = rb_url_link('pag', $Page['id']);

		$file = ABSPATH.'rb-temas/'.G_ESTILO.'/page.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
	}
	// Asingar la pagina 404 en ambos casos. Arreglar bug
// CATEGORIAS
}elseif( isset($CategoryId) ){
	// Verificar si pagina esta definida
	if( isset( $Page ) ):
		$CurrentPage = $Page;
		$RegStart = ($CurrentPage-1)*G_POSTPAGE;
		$NextPage = $CurrentPage+1;
		$PrevPage = $CurrentPage-1;
	else:
		$CurrentPage = 1;
		$RegStart = 0;
		$NextPage = 2;
		$PrevPage = 0;
	endif;
	$Categoria = rb_get_category_info($CategoryId);
	$categoria_id = $Categoria['id'];
	$rm_menu_name = $Categoria['nombre_enlace'];

	//$Posts = rb_get_post_by_category($CategoryId, G_POSTPAGE, $RegStart);
	$CountPostAll = rb_nums_post_by_category( $categoria_id );

	$TotalPage = floor($CountPostAll / G_POSTPAGE);

	if($CountPostAll % G_POSTPAGE) $TotalPage++;
	$LastPage = $TotalPage;

	if($NextPage > $TotalPage) $NextPage = 0;
	if($CurrentPage == $TotalPage) $LastPage = 0;

	$rm_title = $Categoria['nombre']." | ".G_TITULO;
	$rm_metakeywords =  $Categoria['nombre'];
	$rm_metadescription =  $Categoria['descripcion'];
	$rm_metaauthor = G_METAAUTHOR;
	$rm_url_page = rb_url_link('cat', $categoria_id);

	$Photo = rb_get_photo_from_id( $Categoria['photo_id'] );
	if($Photo) $rm_url_page_img = $rm_url."rb-media/gallery/".$Photo['src'];

	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/category.php';
	if(file_exists( $file )) require_once( $file );
	else die( message_error($file));

// BUSQUEDA
}elseif( isset( $SearchTerm ) ){
	//if( !isset($_GET['search']) ) die('No hay termino a buscar');
	$data_to_search = $SearchTerm;

	/*search articulos*/
	$qa = $objArticulo->Search($data_to_search, false);
	$CountPosts = mysql_num_rows($qa);

	/*search paginas*/
	$qp = $objPagina->Search($data_to_search, false);
	$CountPages = mysql_num_rows($qp);

	$CountTotal = $CountPosts + $CountPages;

	$rm_title = "Buscando ".$data_to_search." | ".G_TITULO;
	$rm_metakeywords =  "";
	$rm_metadescription =  "Resultados de busqueda";
	$rm_metaauthor = G_METAAUTHOR;

	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/search.php';
	if(file_exists( $file )) require_once( $file );
	else die( message_error($file));

// AL MODULO : PANEL DE USUARIO
}elseif( isset( $Panel ) ){
	if(G_ACCESOUSUARIO==1){
		require ABSPATH.'rb-script/modules/rb-userpanel/panel.php';
	}else{
		header('Location: '.$objOpcion->obtener_valor(1,'direccion_url').'/login.php');
	}
}else{
	// ** PAGINA INDEX **
	if(G_INITIAL==0){
		// todas las publicaciones
		$qAll = $objDataBase->Ejecutar("SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_corta FROM articulos WHERE activo='A' ORDER BY fecha_creacion DESC LIMIT 12");

		// post destacados
		$qStarred = $objDataBase->Ejecutar("SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_corta FROM articulos WHERE activo='A' and portada=1 ORDER BY fecha_creacion DESC LIMIT 3");

		$rm_title = $rm_longtitle;
		$rm_menu_name = "m-inicio";

		$file = ABSPATH.'rb-temas/'.G_ESTILO.'/index.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
	}else{
	  $Page = rb_show_specific_page(G_INITIAL);
	  $rm_metakeywords = $Page['tags'];
	  $rm_metadescription = rb_fragment_text($Page['contenido'],30, false);
	  $rm_metaauthor = $Page['autor_id']; //--> capturar codigo de usuario
	  $rm_menu_name = $Page['addon'];

	  $file = ABSPATH.'rb-temas/'.G_ESTILO.'/page.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
	}
}
?>