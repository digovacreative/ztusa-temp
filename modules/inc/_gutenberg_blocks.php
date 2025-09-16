<?php
add_action('acf/init', 'my_acf_init');
function my_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
	
        acf_register_block_type(
            array(
                'name'				=> 'homepage-slider',
                'title'				=> __('Homepage Slider'),
                'description'		=> __('Full Width Homepage Slider'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'homepage-slider' ),
            )
        );

        acf_register_block_type(
            array(
                'name'				=> 'stats-carousel',
                'title'				=> __('Stats Carousel'),
                'description'		=> __('Stats Carousel Slider'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'stats-carousel' ),
            )
        );
        

        acf_register_block_type(
            array(
                'name'				=> 'image-content-box',
                'title'				=> __('Image Content Box'),
                'description'		=> __('Image Content Box Row'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'image-content' ),
            )
        );

        acf_register_block_type(
            array(
                'name'				=> 'project-carousel',
                'title'				=> __('Project Carousel'),
                'description'		=> __('Featured Project Carousel'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'project-carousel' ),
            )
        );


        acf_register_block_type(
            array(
                'name'				=> 'image-overlap',
                'title'				=> __('Image Overlap Box'),
                'description'		=> __('Image Overlap Content Box'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'image-overlap' ),
            )
        );
        
        acf_register_block_type(
            array(
                'name'				=> 'faq-content',
                'title'				=> __('FAQ Content'),
                'description'		=> __('FAQ Content'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'faq-content' ),
            )
        );


        acf_register_block_type(
            array(
                'name'				=> 'image-background',
                'title'				=> __('Image Background'),
                'description'		=> __('Image Background Content'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'image-background' ),
            )
        );
        
        acf_register_block_type(
            array(
                'name'				=> 'khums-calculator',
                'title'				=> __('Khums Calculator Form'),
                'description'		=> __('Khums Calculator Form'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'khums-calculator' ),
            )
        );

        acf_register_block_type(
            array(
                'name'				=> 'multiple-donation-box',
                'title'				=> __('Multiple Donation Box'),
                'description'		=> __('Multiple Donation Selection Box'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'multiple-donation-box' ),
            )
        );


        acf_register_block_type(
            array(
                'name'				=> 'single-donation-box',
                'title'				=> __('Single Donation Box'),
                'description'		=> __('Single Donation Selection Box'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'single-donation-box' ),
            )
        );


        acf_register_block_type(
            array(
                'name'				=> 'donation-page',
                'title'				=> __('Donation Page Box'),
                'description'		=> __('Donation Page Box Full Layout'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'donation-page-box' ),
            )
        );

        

        // acf_register_block_type(
        //     array(
        //         'name'				=> 'featured-singleitem-carousel',
        //         'title'				=> __('Single Item Carousel Feed'),
        //         'description'		=> __('Single Item Carousel Feed'),
        //         'render_callback'	=> 'my_acf_block_render_callback',
        //         'category'			=> 'formatting',
        //         'icon'				=> 'admin-comments',
        //         'keywords'			=> array( 'featured-singleitem-carousel' ),
        //     )
        // );

        // acf_register_block_type(
        //     array(
        //         'name'				=> 'posttype-feed',
        //         'title'				=> __('Post Type Feed'),
        //         'description'		=> __('Post Type Feed'),
        //         'render_callback'	=> 'my_acf_block_render_callback',
        //         'category'			=> 'formatting',
        //         'icon'				=> 'admin-comments',
        //         'keywords'			=> array( 'posttype-feed' ),
        //     )
        // );

       


	}

}

function my_acf_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
    //echo $slug;
    $path = plugin_dir_path(__FILE__).'/templatePart/acfBlocks/content-'.$slug.'.php';
    //echo $path;
    if( file_exists( $path ) ) {
        include( $path );
	} 
}

//Include admin CSS stylesheet
function gutenberg_admin_style() {
    wp_enqueue_style( 'gutenberg-editor-stylesheet', get_stylesheet_directory_uri()."/style-base.css" );
    wp_enqueue_script( 'pf-scripts',  get_stylesheet_directory_uri() .'/assets/js/lib/_slick.js', array( 'jquery' ),'', 'true'  );
  }
  add_action('admin_enqueue_scripts', 'gutenberg_admin_style');