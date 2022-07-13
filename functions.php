<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/dist/app.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);

   wp_enqueue_script( 'my-app', get_stylesheet_directory_uri() . '/dist/app.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

/* Custom Post Type Start */
function create_posttype_event()
{
	register_post_type(
		'Evenement',
		// CPT Options
		array(
			'labels' => array(
				'name' => __('Évenements', 'hello-elementor'),
				'singular_name' => __('Évenement', 'hello-elementor')
			),
			'public' => true,
			'has_archive' => false,
			'taxonomies' => array('category'),
			'show_in_nav_menus' => true,
			'supports' => array('title'),
			'menu_icon' => 'dashicons-calendar-alt',
			'rewrite' => array('slug' => 'evenements'),
			'capability_type' => array('evenement', 'evenements'),
			'map_meta_cap'    => true,
		)
	);
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype_event');

add_action('elementor/query/my_custom_filter_head', function ($query) {

	$tomorrow = date("Y-m-d", strtotime('tomorrow'));

	$query->set('meta_query', array(
		array(
			'key'     => 'date_de_debut',
			'compare' => '>=',
			'value'   => $tomorrow,
			'type'	  => 'DATE'
		),
	));
	$query->set('meta_key', 'date_de_debut');
	$query->set('orderby', 'meta_value_num');
	$query->set('order', 'ASC');
});


add_action('elementor/query/my_custom_filter_past', function ($query) {
	$tomorrow = date("Y-m-d", strtotime('tomorrow'));

	$query->set('meta_query', array(
		array(
			'key'     => 'date_de_debut',
			'compare' => '<=',
			'value'   => $tomorrow,
			'type'	  => 'DATE'
		),
	));
	$query->set('meta_key', 'date_de_debut');
	$query->set('orderby', 'meta_value_num');
	$query->set('order', 'DESC');
});