<?php

function inti_template () {
	add_theme_support( 'post-thumbnails' ); // permite que dentro de las páginas / entradas acepte una imagen destacada
	add_theme_support( 'title-tag' );	// Permite agregar titulos para las páginas.
}

/*
 hook after_setup_theme, ejecuta las opciones cuando wordpress elige un tema.
*/
add_action('after_setup_theme', 'inti_template');
