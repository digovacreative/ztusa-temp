<?php
//Custom Functions, included in functions.php

//Custom Functions

function bdb_get_term($field){
  $currentTermData = get_queried_object();
  return $currentTermData->$field;
}

function bdb_get_post($field){
  /*
  ID	int	The ID of the post
  post_author	string	The post author's user ID (numeric string)
  post_name	string	The post's slug
  post_type	string	See Post Types
  post_title	string	The title of the post
  post_date	string	Format: 0000-00-00 00:00:00
  post_date_gmt	string	Format: 0000-00-00 00:00:00
  post_content	string	The full content of the post
  post_excerpt	string	User-defined post excerpt
  post_status	string	See get_post_status for values
  comment_status	string	Returns: { open, closed }
  ping_status	string	Returns: { open, closed }
  post_password	string	Returns empty string if no password
  post_parent	int	Parent Post ID (default 0)
  post_modified	string	Format: 0000-00-00 00:00:00
  post_modified_gmt	string	Format: 0000-00-00 00:00:00
  comment_count	string	Number of comments on post (numeric string)
  menu_order	string	Order value as set through page-attribute when enabled (numeric string. Defaults to 0)
  */
  global $post;
  $post_value=$post->$field;
  return $post_value;
}


//Get parent terms only
function bdb_get_parent_terms($postid=null,$taxonomy){
  if ($postid === null)
  return false;

  $terms=wp_get_post_terms($postid,$taxonomy);

  if($terms){
    foreach ( $terms as $term ) {
        if($term->parent=='0') $termr[]=$term;
    }
    return $termr;
  }
  return false;
}

//Get parent terms with children
function bdb_get_parent_terms_with_children($postid=null,$taxonomy){
  if ($postid === null)
  return false;

  $terms=wp_get_post_terms($postid,$taxonomy);

  if($terms){
    foreach ( $terms as $term ) {
       $termr[]=$term;
    }
    return $termr;
  }
  return false;
}


//Get parent terms only
function bdb_get_father_terms($postid=null,$taxonomy,$type){
  if ($postid === null)
  return false;

  $termsFather=wp_get_post_terms($postid,$taxonomy);

  if($termsFather){
    foreach ( $termsFather as $termFather ) {
        $termsFatherArr[]=$termsFather;
    }
    return $termsFatherArr[0][1]->$type;
  }
  return false;
}

//Get child terms only
function bdb_get_child_terms($postid=null,$taxonomy){
  if ($postid === null)
  return false;

  $terms=wp_get_post_terms($postid,$taxonomy);

  if($terms){
    foreach ( $terms as $term ) {
        if($term->parent!='0') $termr[]=$term;
    }
    return $termr;
  }
  return false;
}



//Remove CF7 Span wrap
add_filter('wpcf7_form_elements', function($content) {
  $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
  return $content;
});


// include custom jQuery
function my_scripts_function() {
    if (!is_admin()) {

        wp_enqueue_script(
        'custom-script', // handle
        get_stylesheet_directory_uri() . '/scripts-dist.js', // src
        array( 'jquery' ) // dependencies
        );

    }
}
add_action( 'wp_enqueue_scripts', 'my_scripts_function' );


//Darken Hex Colour
function color_luminance( $hex, $percent ) {
  
  // validate hex string
  
  $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
  $new_hex = '#';
  
  if ( strlen( $hex ) < 6 ) {
    $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
  }
  
  // convert to decimal and change luminosity
  for ($i = 0; $i < 3; $i++) {
    $dec = hexdec( substr( $hex, $i*2, 2 ) );
    $dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
    $new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
  }   
  
  return $new_hex;
}



function bdb_blog_post_link($post_link, $post, $leavename, $sample) {
  if (false !== strpos($post_link, '%category%')) {
      $projectscategory_type_term = get_the_terms($post->ID, 'category');
      if (!empty($projectscategory_type_term))
          $post_link = str_replace('%category%', array_pop($projectscategory_type_term)->
          slug, $post_link);
      else
          $post_link = str_replace('%category%', 'uncategorized', $post_link);
  }
  return $post_link;
}
add_filter( 'post_type_link', 'bdb_blog_post_link', 10, 4);


// Extend post tags for all other post types
function add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
// Get all your post types
$post_types =  array( 'news', 'video', 'podcast' );
$query->set( 'post_type', $post_types );
  return $query;
}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );


// include custom jQuery
/*
function in_include_custom_jquery() {

    global $post;
    if (!is_admin()) {
        wp_enqueue_script( 'in-scripts',  get_stylesheet_directory_uri() . '/assets/js/scripts-dist.js', array( 'jquery' ),'', 'true'  );
    }
}
add_action( 'wp_enqueue_scripts', 'in_include_custom_jquery' );
*/

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
?>
