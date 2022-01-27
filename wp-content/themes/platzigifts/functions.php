<?php

function inti_template () {
	add_theme_support( 'post-thumbnails' ); // permite que dentro de las páginas / entradas acepte una imagen destacada
	add_theme_support( 'title-tag' );	// Permite agregar titulos para las páginas.

	// agregar menu
	register_nav_menus(
		array(
			'top_menu'	=> 'Menú Principal',
			'second_menu' => 'Menú Secundario'
		)
	);
}

/*
 hook after_setup_theme, ejecuta las opciones cuando wordpress elige un tema.
*/
add_action('after_setup_theme', 'inti_template');

/*
* ==============================================================================
* Agregar assets, css y js
* ==============================================================================
*/
function assets(){
	wp_register_style('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', '', '4.4.1','all');
	wp_register_style('montserrat', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap','','1.0', 'all');
	wp_enqueue_style('estilos', get_stylesheet_uri(), array('bootstrap','montserrat'),'1.0', 'all');

	wp_register_script('popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js','','1.16.0', true);
	wp_enqueue_script('boostraps', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','popper'),'4.4.1', true);
	wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', '1.0', true);

	// Agregar un dato a una variable de js. En este caso para la url de ajax
	// Agregar al variable js, la url de api.
	wp_localize_script('custom', '_PG', [
		'ajaxurl' => admin_url('admin-ajax.php'),
		'apiurl'  => home_url('wp-json/pg/v1') // wp-json + datos del namespaces
	]);

}

/*
 hook wp_enqueue_scripts, agrega en el html los assets registrados.
*/
add_action('wp_enqueue_scripts','assets');

/*
* ==============================================================================
* Agregar witget
* ==============================================================================
*/
function sidebar () {
	register_sidebar(
		array(
			'name' => 'Pie de pagina',
			'id' => 'footer',
			'description' => 'Zona de Widgets para pie de pagina',
			'before_title' => '<p>',
			'after_title' => '</p>',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget'  => '</div>',
		)
	);
}
/*
 hook widgets_init, agrega el html de widget registrados.
*/
add_action('widgets_init', 'sidebar');


/*
* ==============================================================================
* Agregar custum post type
* ==============================================================================
*/
function productos_type(){
	$labels = array(
		'name' => 'Productos',
		'singular_name' => 'Producto',
		'manu_name' => 'Productos',
	);

	$args = array(
		'label'              => 'Productos',
		'description'        => 'Productos de Platzi',
		'labels'             => $labels,
		'supports'           => array('title','editor','thumbnail', 'revisions'),
		'public'             => true,
		'show_in_menu'       => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-cart', // https://developer.wordpress.org/resource/dashicons//#cart
		'can_export'         => true,
		'publicly_queryable' => true,
		'rewrite'            => true,  // necesario para editor gutenberg
		'show_in_rest'       => true   // necesario para editor gutenberg

	);
	register_post_type('producto', $args);
}

add_action('init', 'productos_type');

/*
* ==============================================================================
* Registrar taxonomia personalizada
* ==============================================================================
*/

function registrarTaxonimiaCP () {
	$args = [
		'hierarchical' => true,   // permitir orden girárquico o no. ejpl: categoria y sub categoria
		'labels'       => [
			'name'          => 'Categorias de Productos',
			'singular_name' => 'Categoria de Productos'
		],
		'show_in_menu'      => true,   // mostrar en el menu de administración
		'show_admin_column' => true,
		'rewrite'           => [
			// Permite especificar como será la ruta de categoria de productos
			'slug' => 'categoria-productos',
		]
	];

	register_taxonomy(
		'categoria-productos',
		[
			// asignar a que posts type's pertenecerá esta taxonomia
			'producto'
		],
		$args
	);
}

add_action('init', 'registrarTaxonimiaCP');

/*
* ==============================================================================
* Registrar funcion a hoock de ajax
* ==============================================================================
*/

function pgFiltroProductosCategoria () {
	$return = [];

	$args = array(
		'post_type'      => 'producto',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'        => 'title'
	);

	if($_POST['categoria']) {
		$args['tax_query'] = [
			// indica que el query es para una taxonomia en particular
			[
				'taxonomy' => 'categoria-productos',
				'field' => 'slug',
				'terms' => $_POST['categoria']
			]
		];
	};

	$productos = new WP_Query($args);

	if($productos->have_posts()) {
		while($productos->have_posts()) {
			$productos->the_post();
			$return[] = [
				'image_con_elemento' => get_the_post_thumbnail( get_the_ID(), 'large' ),
				'image' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
				'link' => get_the_permalink(),
				'title' => get_the_title()
			];
		}
	}

	wp_send_json( $return );
}

/* Agregar con login y sin login para acceso total a la acción */
add_action( "wp_ajax_nopriv_pgFiltroProductosCategoria", "pgFiltroProductosCategoria" ); // para acceso con login
add_action( "wp_ajax_pgFiltroProductosCategoria", "pgFiltroProductosCategoria" ); // para acceso sin login

/*
* ==============================================================================
* Registrar API en wp
* ==============================================================================
*/

function novedadesAPI () {
	register_rest_route(
		'pg/v1',	// namespaces
		'/novedades/(?P<cantidad>\d+)', // d+ es expresión regular de solo números
		[
			'methods' => 'GET',
			'callback' => 'pedidoNovedades'
		]
	);
}

add_action('rest_api_init', 'novedadesAPI');

function pedidoNovedades ( $data ) {
	$return = [];

	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $data['cantidad'],
		'order'          => 'ASC',
		'orderby'        => 'title'
	);

	$novedades = new WP_Query($args);

	if($novedades->have_posts()) {
		while($novedades->have_posts()) {
			$novedades->the_post();
			$return[] = [
				'image_con_elemento' => get_the_post_thumbnail( get_the_ID(), 'large' ),
				'image' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
				'link' => get_the_permalink(),
				'title' => get_the_title()
			];
		}
	}

	return $return;
}

/*
* ==============================================================================
* Registrar bloque
* ==============================================================================
*/

function pgRegisterBlock () {
	$assets = include_once get_template_directory().'/blocks/build/index.asset.php';

	wp_register_script( 'pg-block', get_template_directory_uri().'/blocks/build/index.js', $assets['dependencies'], $assets['version'] );

	// pg/basic tiene que ser igual al js
	register_block_type( 'pg/basic', [ 'editor_script' => 'pg-block' ] );
}

add_action( 'init', 'pgRegisterBlock' );