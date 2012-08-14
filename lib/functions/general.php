<?php
/**
 * General
 *
 * This file contains any general functions
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
 
/**
 * Don't Update Plugin
 * @since 1.0.0
 * 
 * This prevents you being prompted to update if there's a public plugin
 * with the same name.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */
function be_core_functionality_hidden( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
		return $r; // Not a plugin update request. Bail immediately.
	$plugins = unserialize( $r['body']['plugins'] );
	unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
	unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
	$r['body']['plugins'] = serialize( $plugins );
	return $r;
}
add_filter( 'http_request_args', 'be_core_functionality_hidden', 5, 2 );


/**
 * Remove Menu Items
 * @since 1.0.0
 *
 * Remove unused menu items by adding them to the array.
 * See the commented list of menu items for reference.
 *
 */
function be_remove_menus () {
	global $menu;
	$restricted = array(__('Links'));
	// Example:
	//$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action( 'admin_menu', 'be_remove_menus' );

/**
 * Customize Admin Bar Items
 * @since 1.0.0
 * @link http://wp-snippets.com/addremove-wp-admin-bar-links/
 */
function be_admin_bar_items() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'new-link', 'new-content' );
}
add_action( 'wp_before_admin_bar_render', 'be_admin_bar_items' );


/**
 * Customize Menu Order
 * @since 1.0.0
 *
 * @param array $menu_ord. Current order.
 * @return array $menu_ord. New order.
 *
 */
function be_custom_menu_order( $menu_ord ) {
	if ( !$menu_ord ) return true;
	return array(
		'index.php', // this represents the dashboard link
		'edit.php?post_type=page', //the page tab
		'edit.php', //the posts tab
		'edit-comments.php', // the comments tab
		'upload.php', // the media manager
    );
}
//add_filter( 'custom_menu_order', 'be_custom_menu_order' );
//add_filter( 'menu_order', 'be_custom_menu_order' );


/**
 * Default Facebook Image 
 * @since 1.0.0
 *
 * See /lib/functions/facebook.php
 * Should be at least 200x200
 * @link https://developers.facebook.com/tools/debug
 *
 * @param array $meta
 * @return array 
 *
 */
function be_default_facebook_image( $meta ) {
	if( isset( $meta['image'] ) && empty( $meta['image'] ) )
		$meta['image'] = get_stylesheet_directory_uri() . '/images/facebook.jpg';
	
	return $meta;
}
//add_filter( 'mfields_open_graph_meta_tags', 'be_default_facebook_image' );

/*
add_action( 'pre_get_posts', 'child_change_home_query' );
/** Changes the query on the home page
function child_change_home_query( $query ) {

if( $query->is_main_query() && $query->is_home() ) {
$query->set( 'posts_per_page', '5' );
}

}  
*/

/**
 * Create Recipe CPT Functionality
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
 
function mcr_display_recipe($content) {
 
    global $post;
    $recipe = '';
 
    if ( is_singular( 'my_culinary_recipe' ) ) {
        $recipe .= '<div class="recipe">';
            $recipe .= '<div itemscope itemtype="http://schema.org/Recipe" >';
                $recipe .= '<h2 itemprop="name">'. get_post_meta($post->ID,'mcr_name',true) .'</h2>';
                $recipe .= '<img class="alignright" itemprop="image" src="'. get_post_meta($post->ID,'mcr_image',true) .'" />';
                $recipe .= '<span class="mcr_meta"><b>Recipe type:</b> <time itemprop="recipeCategory">'. get_post_meta($post->ID,'mcr_type',true) .'</time></span>';
                $recipe .= '<span class="mcr_meta"><b>Yield:</b> <span itemprop="recipeYield">'. get_post_meta($post->ID,'mcr_yield',true) .'</span></span>';
                $recipe .= '<span class="mcr_meta"><b>Prep time:</b> <time content="'. mcr_time('prep','iso') .'" itemprop="prepTime">'. mcr_time('prep') .'</time></span>';
                $recipe .= '<span class="mcr_meta"><b>Cook time:</b> <time content="'. mcr_time('cook','iso') .'" itemprop="cookTime">'. mcr_time('cook') .'</time></span>';
                $recipe .= '<span class="mcr_meta"><b>Total time:</b> <time content="'. mcr_total_time('iso') .'" itemprop="totalTime">'. mcr_total_time() .'</time></span>';
                $recipe .= '</br>';
                $recipe .= '<hr />';
                $recipe .= '<span itemprop="description">'. get_post_meta($post->ID,'mcr_summary',true) .'</span><br />';
                $recipe .= '<h3>Ingredients:</h3> '. mcr_list_items('ingredients');
                $recipe .= '<h3>Directions:</h3> '. mcr_list_items('instructions');
                $recipe .= '<span class="mcr_meta">Published on <time itemprop="datePublished" content="'. get_the_date('Y-m-d') .'">'. get_the_date('F j, Y') .'</time></span>';
                $recipe .= '<span class="mcr_meta">by <span itemprop="author">'. get_the_author() .'</span></span>';
            $recipe .= '</div>';
        $recipe .= '</div>';
    }
 
    return $content . $recipe;
}
add_filter('the_content', 'mcr_display_recipe', 1);




function mcr_time($type = 'prep', $format = null) {
 
    global $post;
 
    $hours = get_post_meta($post->ID,'mcr_'.$type.'_time_hours',true);
    $minutes = get_post_meta($post->ID,'mcr_'.$type.'_time_minutes',true);
    $time = '';
    if ($format == 'iso') {
        if ($hours > 0) {
            $time = 'PT'.$hours.'H';
            if($minutes > 0) {
                $time .= $minutes.'M';
            }
        }
        else {
            $time = 'PT'.$minutes.'M';
        }
    }
    else {
        if ($hours > 0) {
            if ($hours == 1) {
                $time = $hours.' hour ';
            }
            else {
                $time = $hours.' hrs ';
            }
            if ($minutes > 0) {
                $time .= $minutes.' mins';
            }
        }
        else {
            $time = $minutes.' mins';
        }
    }
    return $time;
}

add_action( 'cmb_render_number', 'rrh_cmb_render_number', 10, 2 );
function rrh_cmb_render_number( $field, $meta ) {
    echo '<input type="number" min="0" max="60" class="cmb_text_inline" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" />','<p class="cmb_metabox_description">', $field['desc'], '</p>';
}
add_filter( 'cmb_validate_number', 'rrh_cmb_validate_number' );
 
function rrh_cmb_validate_number( $new ) {
    return (int)$new;
}

function mcr_total_time($format = null) {
 
    global $post;
    $prep_hours = get_post_meta($post->ID,'mcr_prep_time_hours',true);
    $prep_minutes = get_post_meta($post->ID,'mcr_prep_time_minutes',true);
    $cook_hours = get_post_meta($post->ID,'mcr_cook_time_hours',true);
    $cook_minutes = get_post_meta($post->ID,'mcr_cook_time_minutes',true);
    $total_minutes = ($prep_hours + $cook_hours)*60 + $prep_minutes + $cook_minutes;
    $hours = 0;
    $minutes = 0;
 
    if ($total_minutes >= 60) {
        $hours = floor($total_minutes / 60);
        $minutes = $total_minutes - ($hours * 60);
    }
    else {
        $minutes = $total_minutes;
    }
    $total_time = '';
    if ($format == 'iso') {
        if ($hours > 0 ) {
            $total_time = 'PT'.$hours.'H';
            if ($minutes > 0) {
                $total_time .= $minutes.'M';
            }
        }
        else {
            $total_time = 'PT'.$minutes.'M';
        }
    }
    else {
        if ($hours > 0 ) {
            if ($hours == 1) {
                $total_time = $hours.' hour ';
            }
            else {
                $total_time = $hours.' hrs ';
            }
            if ($minutes > 0) {
                $total_time .= $minutes.' mins';
            }
        }
        else {
            $total_time = $minutes.' mins';
        }
    }
    return $total_time;
}


function mcr_list_items($type = 'ingredients') {
 
    global $post;
 
    if (get_post_meta($post->ID, 'mcr_'. $type, true)) {
        $get_items = get_post_meta($post->ID, 'mcr_'. $type, true);
        $items = explode("\r", $get_items);
        $list = '';
    }
    else {
        return;
    }
    if ($type=='ingredients') {
        $list .= '<ul>';
        foreach ($items as $item) {
            $list .= '<li><span itemprop="ingredients">' . trim($item) . '</span></li>';
        }
        $list .= '</ul>';
    }
    elseif ($type=='instructions') {
        $list .= '<ol itemprop="recipeInstructions">';
        foreach ($items as $item) {
            $list .= '<li>' . trim($item) . '</li>';
        }
        $list .= '</ol>';
    }
    else {
        $list .= 'Invalid list type.';
    }
    return $list;
}















/**
 * Create Book Review CPT Functionality
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_post_type


function wjc_display_book($content) {
 
    global $post;
    $book = '';
 
    if ( is_singular( 'wjc_book_reviews' ) ) {
        $book .= '<div class="book">';
            $book .= '<div itemscope itemtype="http://schema.org/Book" >';
                $book .= '<h2 itemprop="name">'. genesis_get_custom_field($post->ID,'wjc_title',true) .'</h2>';
                $book .= '<img class="alignright" itemprop="image" src="'. genesis_get_custom_field($post->ID,'wjc_image',true) .'" />';
                $book .= '</br>';
                $book .= '<hr />';
                $book .= '<span itemprop="author">'. genesis_get_custom_field($post->ID,'wjc_author',true) .'</span><br />';
				$book .= '<span itemprop="publisher">'. genesis_get_custom_field($post->ID,'wjc_publisher',true) .'</span><br />';
				$book .= '<span itemprop="link">'. genesis_get_custom_field($post->ID,'wjc_link',true) .'</span><br />';
                
            $book .= '</div>';
        $book .= '</div>';
    }
 
    return $content . $book;
}
add_filter('the_content', 'wjc_display_book', 1);


*/












/** Customize search form input box text */
add_filter( 'genesis_search_text', 'custom_search_text' );
function custom_search_text($text) {
    return esc_attr('Enter key words, hit enter;');
}

/** Customize the post info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if (is_single()) {
    $post_info = '[post_date] by [post_author_posts_link] &middot; [tweetbutton]';
	}
	else {
	$post_info = '[post_date] by [post_author_posts_link]';
	}
    return $post_info;

}

/** Customize the post meta function */ 
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if(!is_front_page()) {
    $post_meta = '[post_categories] [post_tags]';
	}
	else {
	remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
	}
	return $post_meta;
}

/** Customize Read More Link */
add_filter( 'excerpt_more', 'be_more_link' );
add_filter( 'get_the_content_more_link', 'be_more_link' );
add_filter( 'the_content_more_link', 'be_more_link' );
function be_more_link($more_link) {
    return sprintf('... <p><a href="%s" class="btn-more more-link">%s</a>', get_permalink(), 'Read More');
}


/* fixes Grid loop Paignation ***/
add_action( 'pre_get_posts', 'child_change_home_query' );
/** Changes the query on the home page*/
function child_change_home_query( $query ) {

if( $query->is_main_query() && $query->is_home() ) {
$query->set( 'posts_per_page', '1' );
}

}  
