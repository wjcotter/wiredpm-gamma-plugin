<?php
/**
 * Taxonomies
 *
 * This file registers any custom taxonomies
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


/**
 * Create Location Taxonomy
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */

function be_register_location_taxonomy() {
	$labels = array(
		'name' => 'Locations',
		'singular_name' => 'Location',
		'search_items' =>  'Search Locations',
		'all_items' => 'All Locations',
		'parent_item' => 'Parent Location',
		'parent_item_colon' => 'Parent Location:',
		'edit_item' => 'Edit Location',
		'update_item' => 'Update Location',
		'add_new_item' => 'Add New Location',
		'new_item_name' => 'New Location Name',
		'menu_name' => 'Location'
	); 	

	register_taxonomy( 'rotator-location', array('rotator'), 
		array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'rotator-location' ),
		)
	);
}
add_action( 'init', 'be_register_location_taxonomy' );




// registration code for Design Tools taxonomy
function wjc_register_designtools_tax() {
        $labels = array(
                'name' => _x( 'Design Tools', 'taxonomy general name' ),
                'singular_name' => _x( 'Design Tool', 'taxonomy singular name' ),
                'add_new' => _x( 'Add New Design Tool', 'Design Tool'),
                'add_new_item' => __( 'Add New Design Tool' ),
                'edit_item' => __( 'Edit Design Tool' ),
                'new_item' => __( 'New Design Tool' ),
                'view_item' => __( 'View Design Tool' ),
                'search_items' => __( 'Search Design Tools' ),
                'not_found' => __( 'No Design Tool found' ),
                'not_found_in_trash' => __( 'No Design Tool found in Trash' ),
        );

        $pages = array( 'design-resources' );

        $args = array(
                'labels' => $labels,
                'singular_label' => __( 'Design Tool' ),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'show_tagcloud' => false,
                'show_in_nav_menus' => true,
                'rewrite' => array('slug' => 'design-tools'),
         );
        register_taxonomy( 'wps_designtools' , $pages , $args );
}
add_action( 'init' , 'wjc_register_designtools_tax' );