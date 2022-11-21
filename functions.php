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
function hello_elementor_child_enqueue_scripts()
{
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/dist/app.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);

	wp_enqueue_script('my-app', get_stylesheet_directory_uri() . '/dist/app.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);

/* Custom Post Type Start */
function create_posttype_event()
{
	register_post_type(
		'Agenda',
		// CPT Options
		array(
			'labels' => array(
				'name' => __('Agenda', 'hello-elementor'),
				'singular_name' => __('Agenda', 'hello-elementor')
			),
			'public' => true,
			'has_archive' => false,
			'taxonomies' => array('category'),
			'show_in_nav_menus' => true,
			'supports' => array('title', 'thumbnail'),
			'menu_icon' => 'dashicons-calendar-alt',
			'rewrite' => array('slug' => 'agenda'),
			'map_meta_cap'    => true,
			'rewrite' => array('slug' => 'agenda'),
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
	$query->set('orderby', 'meta_value');
	$query->set('order', 'ASC');
});


add_action('elementor/query/my_custom_filter_past', function ($query) {
	$tomorrow = date("Y-m-d", strtotime('tomorrow'));

	$query->set('meta_query', array(
		array(
			'key'     => 'date_de_debut',
			'compare' => '<',
			'value'   => $tomorrow,
			'type'	  => 'DATE'
		),
	));
	$query->set('meta_key', 'date_de_debut');
	$query->set('orderby', 'meta_value');
	$query->set('order', 'DESC');
});


remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
function woocommerce_custom_single_add_to_cart_text()
{
}

// To change add to cart text on product archives(Collection) page
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text');
function woocommerce_custom_product_add_to_cart_text()
{
	return __('Order CD', 'woocommerce');
}
