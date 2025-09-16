<?php
/*
	Change the author URL slug so it doesn't show the actual username but the nickname
	Source: http://wordpress.stackexchange.com/questions/5742/change-the-author-slug-from-username-to-nickname
*/
// add_filter( 'request', 'wpse5742_request' );
// function wpse5742_request( $query_vars )
// {
//     if ( array_key_exists( 'author_name', $query_vars ) ) {
//         global $wpdb;
//         $author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='nickname' AND meta_value = %s", $query_vars['author_name'] ) );
//         if ( $author_id ) {
//             $query_vars['author'] = $author_id;
//             unset( $query_vars['author_name'] );
//         }
//     }
//     return $query_vars;
// }

// add_filter( 'author_link', 'wpse5742_author_link', 10, 3 );
// function wpse5742_author_link( $link, $author_id, $author_nicename )
// {
//     $author_nickname = get_user_meta( $author_id, 'nickname', true );
//     if ( $author_nickname ) {
//         $link = str_replace( $author_nicename, $author_nickname, $link );
//     }
//     return $link;
// }

// add_action( 'user_profile_update_errors', 'wpse5742_set_user_nicename_to_nickname', 10, 3 );
// function wpse5742_set_user_nicename_to_nickname( &$errors, $update, &$user )
// {
//     if ( ! empty( $user->nickname ) ) {
//         $user->user_nicename = sanitize_title( $user->nickname, $user->display_name );
//     }
// }


function temp_function ($v, $i) {
  return __($v);
}

//Hide admin links for Contributors
// remove unnecessary menus
function remove_admin_menus () {
  global $menu;


  $adminUser = array(
        'administrator',
        '6eezie',
        'rashid@zahratrust.org'
  );

  $accountUser = array(
        'accountant'
  );

  // Get the current user
  $current_user = wp_get_current_user();


  if( !in_array( $current_user->user_login, $adminUser ) ) {
    	remove_menu_page('theme-settings');
		  remove_menu_page('update-core');
		  remove_menu_page('edit.php?post_type=acf-field-group');
	}
  
  
  if( in_array( $current_user->user_login, $accountUser ) ) {
    	//remove_menu_page('theme-settings');
		  remove_menu_page('update-core');
		  remove_menu_page('edit.php?post_type=acf-field-group');
      remove_menu_page( 'edit.php?post_type=page' );
      remove_menu_page( 'upload.php' );
      remove_menu_page( 'edit-comments.php' );
      remove_menu_page( 'themes.php' );
      remove_menu_page( 'plugins.php' );
      remove_menu_page( 'tools.php' );
      remove_menu_page( 'users.php' );
      remove_menu_page( 'options-general.php' );
      remove_menu_page( 'admin.php?page=theme-general-settings' );
      remove_menu_page( 'admin.php?page=wpseo_dashboard' );
      remove_menu_page( 'admin.php?page=wpgeoip-admin' );
      remove_menu_page( 'admin.php?page=itsec' );
	}

}

add_action('admin_menu', 'remove_admin_menus', 999);

/* Enable core updates page for allowed users

add_action( 'admin_init', 'wpse_38111' );
function wpse_38111() {
    remove_submenu_page( 'index.php', 'update-core.php' );
}
*/


// Remove woocommerce menu item
remove_menu_page('admin.php?page=wc-admin&path=%2Fmarketing');



// Create new role
function create_role($role, $roleName) {
  add_role( $role, $roleName, array(
    'read' => true, // True allows that capability
    'edit_posts' => true, // Allows user to edit their own posts
    'publish_posts'=>true, //Allows the user to publish, otherwise posts stays in draft mode
    'edit_others_posts'=>true,
    'delete_others_posts'=>true,
    'edit_published_posts'=>true,
    'upload_files'=>false,
    'delete_published_posts'=>true,
    'edit_pages'=>true,
    'edit_published_pages'=>true,
    'publish_pages'=>true,
  ));
}

create_role('accountant', 'Accountant');

function accountant_remove_menu_items() {
  if( current_user_can('accountant' ) ):
    remove_menu_page('edit.php?post_type=acf-field-group');
    remove_menu_page( 'edit.php?post_type=page' );
    remove_menu_page( 'upload.php' );
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'plugins.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'users.php' );
    remove_menu_page( 'options-general.php' );
    remove_menu_page( 'admin.php?page=theme-general-settings' );
    remove_menu_page( 'admin.php?page=wpseo_dashboard' );
    remove_menu_page( 'admin.php?page=wpgeoip-admin' );
    remove_menu_page( 'admin.php?page=itsec' );

  endif;
}
add_action( 'admin_menu', 'accountant_remove_menu_items' );
