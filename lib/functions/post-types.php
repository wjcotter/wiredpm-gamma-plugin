<?php
/**
 * Post Types
 *
 * This file registers any custom post types
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

 /* Book Review post-type 
---------------------------------------------------------------------------- */


add_action( 'init', 'register_wjc_book_review' );

function register_wjc_book_review() {

    $labels = array( 
        'name' => _x( 'Book Reviews', 'book review' ),
        'singular_name' => _x( 'Book Review', 'book review' ),
        'add_new' => _x( 'Add New', 'book review' ),
        'add_new_item' => _x( 'Add New Book Review', 'book review' ),
        'edit_item' => _x( 'Edit Book Review', 'book review' ),
        'new_item' => _x( 'New Book Review', 'book review' ),
        'view_item' => _x( 'View Book Review', 'book review' ),
        'search_items' => _x( 'Search Book Review', 'book review' ),
        'not_found' => _x( 'No Book Reviews found', 'book review' ),
        'not_found_in_trash' => _x( 'No Book Reviews found in Trash', 'book review' ),
        'parent_item_colon' => _x( 'Parent Book Review:', 'book review' ),
        'menu_name' => _x( 'Book Reviews', 'book review' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Book Reviews.',
        'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
        //'taxonomies' => array( 'category', 'book-reviews' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
	
    );

    register_post_type( 'book_review', $args );
}


/* Process Resources post-type 
----------------------------------------------------------------------------*/
function wjc_process_resources_post_type() {
	$labels = array(
		'name' => 'Process Resources',
		'singular_name' => 'Process Resource',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Process Resource',
		'edit_item' => 'Edit Process Resource Item',
		'new_item' => 'New Process Resource Item',
		'view_item' => 'View Process Resource Item',
		'search_items' => 'Search Process Resource Items',
		'not_found' =>  'No Process Resource items found',
		'not_found_in_trash' => 'No Process Resource items found in trash',
		'parent_item_colon' => '',
		'menu_name' => 'Process Resource'
	);
	
		
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => 'process-resources' ),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'genesis-seo' )
	); 

	register_post_type( 'process-resources', $args );
}
add_action( 'init', 'wjc_process_resources_post_type' );	


/* Content Resources post-type 
----------------------------------------------------------------------------*/
function wjc_content_resources_post_type() {
	$labels = array(
		'name' => 'Content Resources',
		'singular_name' => 'Content Resource',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Content Resource',
		'edit_item' => 'Edit Content Resource Item',
		'new_item' => 'New Content Resource Item',
		'view_item' => 'View Content Resource Item',
		'search_items' => 'Search Content Resource Items',
		'not_found' =>  'No Content Resource items found',
		'not_found_in_trash' => 'No Content Resource items found in trash',
		'parent_item_colon' => '',
		'menu_name' => 'Content Resources'
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => 'content-resources' ),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'genesis-seo' )
	); 

	register_post_type( 'content-resources', $args );
}
add_action( 'init', 'wjc_content_resources_post_type' );	



/* Design Resources post-type 
----------------------------------------------------------------------------*/
function wjc_design_resources_post_type() {
	$labels = array(
		'name' => 'Design Resources',
		'singular_name' => 'Design Resource',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Design Resource',
		'edit_item' => 'Edit Design Resource Item',
		'new_item' => 'New Design Resource Item',
		'view_item' => 'View Design Resource Item',
		'search_items' => 'Search Design Resource Items',
		'not_found' =>  'No Design Resource items found',
		'not_found_in_trash' => 'No Design Resource items found in trash',
		'parent_item_colon' => '',
		'menu_name' => 'Design Resources'
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => 'design-resources' ),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'taxonomies' => array( 'wjc_designtools' ),
		'supports' => array( 'title', 'editor', 'genesis-seo' )
	); 

	register_post_type( 'design-resources', $args );
}
add_action( 'init', 'wjc_design_resources_post_type' );	

/* Code Resources post-type 
----------------------------------------------------------------------------*/
 
add_action( 'init', 'register_wjc_code_resources' );
   
function register_wjc_code_resources() {
    $labels = array(
        'name'               => _x( 'Code Resources', 'code_resources' ),
        'singular_name'      => _x( 'Code Resource', 'code_resources' ),
        'add_new'            => _x( 'Add New', 'code_resources' ),
        'add_new_item'       => _x( 'Add New Code Resource', 'code_resources' ),
        'edit_item'          => _x( 'Edit Code Resource', 'code_resources' ),
        'new_item'           => _x( 'New Code Resource', 'code_resources' ),
        'view_item'          => _x( 'View Code Resource', 'code_resources' ),
        'search_items'       => _x( 'Search Code Resource', 'code_resources' ),
        'not_found'          => _x( 'No Code Resources found', 'code_resources' ),
        'not_found_in_trash' => _x( 'No Code Resources found in Trash', 'code_resources' ),
        'parent_item_colon'  => '',
        'menu_name'          => _x( 'Code Resources', 'code_resources' )
    );
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'exclude_from_search' => false,
        'hierarchical'        => false,
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'design-tools')
    );
    register_post_type( 'wjc_code_resources', $args );  
}
