<?php
//Dashboard Functions, included in functions.php


//Remove Admin Menu Items
function remove_menus(){
  //remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  //remove_menu_page( 'tools.php' );                  //Tools
}
add_action( 'admin_menu', 'remove_menus' );


//Remove WP Version
function wpb_remove_version() {
return '';
}
add_filter('the_generator', 'wpb_remove_version');

//Hide WP Errors
function no_wordpress_errors(){
  return 'Something is wrong!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );

//Remove intro panel
remove_action('welcome_panel', 'wp_welcome_panel');

//Disable XML PRC
add_filter('xmlrpc_enabled', '__return_false');


//Enque Admin Fontawesome CSS
// Admin CSS (Font Awesome + dashboard.css)
add_action('admin_enqueue_scripts', function () {
  // If these files live in the CHILD theme. If they’re in the parent, use get_template_directory_* instead.
  $dir = get_stylesheet_directory();
  $uri = get_stylesheet_directory_uri();

  // Font Awesome
  $fa_rel = '/assets/fonts/fontawesome/fontawesome-all.min.css'; // check exact path + case (css vs CSS)
  if (file_exists($dir . $fa_rel)) {
      wp_enqueue_style(
          'zt-admin-fa',
          $uri . $fa_rel,
          [],
          filemtime($dir . $fa_rel) // cache-bust on change
      );
  }

  // Dashboard styles
  $dash_rel = '/assets/style/css/dashboard.css'; // verify this path exists
  if (file_exists($dir . $dash_rel)) {
      wp_enqueue_style(
          'zt-admin-dashboard',
          $uri . $dash_rel,
          ['zt-admin-fa'],           // optional dependency
          filemtime($dir . $dash_rel)
      );
  }
});

//add_action('wp_head', 'FontAwesome_icons');


//Enque Admin ACF CSS
/*
function ACF_icons() {
    $acfStyleCSS = get_stylesheet_directory_uri() . '/assets/style/css/acf-style.css');
    echo '<link href="'.$acfStyleCSS.'"  rel="stylesheet">';
}
add_action('admin_head', 'ACF_icons');
*/



//Enque login css
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/style/css/admin.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

// function admin_style() {
//   wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri()."/style-base.css" );
// }
// add_action('admin_enqueue_scripts', 'admin_style');


//Add thumbnail support for posts
add_theme_support('post-thumbnails');

//Register ACF Options page
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Desktop Navigation Settings',
		'menu_title'	=> 'Desktop Navigation',
		'parent_slug'	=> 'theme-general-settings',
	));

  acf_add_options_sub_page(array(
		'page_title' 	=> 'Mobile Navigation Settings',
		'menu_title'	=> 'Mobile Navigation',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

}

function wpb_custom_new_menu() {
  register_nav_menu('main-menu',__( 'Main Menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );


add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
    $post_type = array('nav_menu_item','blog','news','event','insights','people','post');
    $query->set('post_type',$post_type);
	  return $query;
    }
}


/*
add_action( 'init', 'bdb_add_editor_styles' );
function bdb_add_editor_styles() {
  $editorStylesheet = get_stylesheet_directory_uri() . '/assets/style/css/editor.css';
  add_editor_style( $editorStylesheet );
}
*/

remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
?>
