<?php
/**
 * Metaboxes
 *
 * This file registers any custom metaboxes
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

 /**
 * Initialize Metabox Class
 * @since 1.0.0
 * see /lib/metabox/example-functions.php for more information
 *
 */
  
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( BE_DIR . '/lib/metabox/init.php' );
	}
}
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );


/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wjc_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	
	$meta_boxes[] = array(
		'id'         => 'book-review',
		'title'      => 'Book Review Metabox',
		'pages'      => array( 'page', 'book_review' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Title:',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'wjc_book_title',
				'type' => 'text',
			),
			array(
				'name' => 'Author:',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'wjc_book_author',
				'type' => 'text',
			
			),
			array(
				'name' => 'Website:',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'wjc_book_website',
				'type' => 'text',
			),
			
			// IMAGE UPLOAD
            array(
                'name'    => 'Book Image',
                'desc'    => 'Image of Book Jacket.',
                'id'      => $prefix . 'wjc_book_image',
                'type'    => 'file',
                'save_id' => false, // save ID using true
                'allow'   => array('url', 'attachment') // limit to just attachments with array( 'attachment' )
            ),
             //Summary - TEXTAREA
            array(
                'name' => __( 'Summary', 'book_reviews' ),
                'desc' => __( 'A Brief Summary of Review', 'book_reviews' ),
                'id'   => $prefix . 'wjc_book_summary',
                'type' => 'textarea',
            ),
			
		),
	);
	
	
	return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'wjc_sample_metaboxes' );

