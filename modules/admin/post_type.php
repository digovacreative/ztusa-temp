<?php
/*------------------------------------*\
 Custom Post Types
\*------------------------------------*/

// Post type 'Themes'
/* OLD METHOD!
add_action( 'init', 'create_theme_post_type', 4 );
function create_event_post_type()
{
  	$labels = array(
		'name' => __( 'Themes' ),
		'singular_name' => __( 'Theme' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Create New' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit' ),
		'new_item' => __( 'New' ),
		'view' => __( 'View' ),
		'view_item' => __( 'View' ),
		'search_items' => __( 'Search' ),
		'not_found' => __( 'Not found' ),
		'not_found_in_trash' => __( 'Nothing found in trash' ),
		'parent' => __( 'Parent' ),
	  );

	$args = array(
		'labels' => $labels,
		'description' => __( 'This is where you can create a new Item.' ),
		'public' => true,
		'show_ui' => true,
    	'menu_icon' => 'dashicons-calendar',
		'capability_type' => 'post',
		'publicly_queryable' => true,
    	'has_archive' => true,
		'exclude_from_search' => false,
		'menu_position' => 4,
		'hierarchical' => true,
		'_builtin' => false, // It's a custom post type, not built in!
		'rewrite' => true,
		'rewrite' => array( 'slug' => 'theme', 'with_front' => true ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies' => array('post_tag','occassion','gender','product_type'),
	  );

	register_post_type('theme',$args);
}



// Extend post tags for all other post types
function add_custom_types_to_tax( $query ) {
	if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
	// Get all your post types
	$post_types =  array( 'blog', 'news', 'event', 'insights', 'people' );
	$query->set( 'post_type', $post_types );
		return $query;
	}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );
*/

//Include Composer files


// include( 'composer/vendor/gizburdt/cuztom/cuztom.php' );
// define( 'CUZTOM_URL', 'composer/vendor/gizburdt/cuztom' );

// function register_content_types()
// {

//   //Register Post Types
//   $theme = register_cuztom_post_type( 'Theme', array(
//       'has_archive'         => true,
//       'supports'            => array( 'title', 'editor', 'thumbnail' ),
//       'exclude_from_search' => true
//   ) );

//   $offer = register_cuztom_post_type( 'Offer', array(
// 		'has_archive'         => true,
// 		'supports'            => array( 'title', 'editor', 'thumbnail' ),
// 		'exclude_from_search' => true
//   ) );


//   //Register Taxonomies
//   $event = register_cuztom_taxonomy(
//       'event',
//       array('theme'),
//       array(
//           'show_admin_column'     => true,
//           'admin_column_sortable' => true,
//           'admin_column_filter'   => true
//       )
//   );

//   $gender = register_cuztom_taxonomy(
//       'gender',
//       array('theme'),
//       array(
//           'show_admin_column'     => true,
//           'admin_column_sortable' => true,
//           'admin_column_filter'   => true
//       )
//   );

//   $number_photos = register_cuztom_taxonomy(
//       'number_photos',
//       array('theme'),
//       array(
//           'show_admin_column'     => true,
//           'admin_column_sortable' => true,
//           'admin_column_filter'   => true
//       )
//   );

//   	$product_theme = register_cuztom_taxonomy(
// 		'product_theme',
// 		array('product'),
// 		array(
// 			'show_admin_column'     => true,
// 			'admin_column_sortable' => true,
// 			'admin_column_filter'   => true
// 		)
// 	);


// }
// add_action( 'init', 'register_content_types' );


// //Extend post type to include product_cat tax
// add_action( 'init', 'add_product_cat_to_theme' );
// function add_product_cat_to_theme() {
//     register_taxonomy_for_object_type( 'product_cat', 'theme' );
// }
?>
