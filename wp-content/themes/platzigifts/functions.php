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
