<?php
add_action('acf/init', 'my_acf_init');
function my_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
        
        acf_register_block_type(
            array(
                'name'				=> 'section',
                'title'				=> __('Section Block'),
                'description'		=> __('Section Block'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'icon'				=> 'admin-comments',
                'mode'				=> 'preview',
                'supports'			=> array(
                    'align' => true,
                    'mode' => false,
                    'jsx' => true
                ),
                'keywords'			=> array( 'section' ),
            )
        );

        acf_register_block_type(
            array(
                'name'				=> 'editors',
                'title'				=> __('Content Editors'),
                'description'		=> __('Content Editors'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'mode'				=> 'edit',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'editors' ),
            )
        );

	
        acf_register_block_type(
            array(
                'name'				=> 'homepage-slider',
                'title'				=> __('Homepage Slider'),
                'description'		=> __('Full Width Homepage Slider'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'image-overlap' ),
            )
        );


        acf_register_block_type(array(
            'name'            => 'project-cards-grid',
            'title'           => __('Project Cards Grid'),
            'description'     => __('Cards sourced from WooCommerce products or manual links, each with image and custom icon.'),
            'render_callback'	=> 'my_acf_block_render_callback',
            'category'        => 'widgets',
            'icon'            => 'grid-view',
            'mode'            => 'preview',
            'keywords'        => array('woocommerce','cards','grid','packages','donation'),
          ));
          

          acf_register_block_type(array(
            'name'            => 'two-up-hero',
            'title'           => __('Two-Up Hero'),
            'description'     => __('2-in-1 hero: single circular/square image or 4-image collage, with two-colour heading and optional button.'),
            'render_callback'	=> 'my_acf_block_render_callback',
            'category'        => 'layout',
            'icon'            => 'align-wide',
            'mode'            => 'preview',
            'keywords'        => array('hero','callout','donation','legacy','collage')
          ));
          
          acf_register_block_type(array(
            'name'            => 'impact-stats',
            'title'           => __('Impact Stats'),
            'description'     => __('Gradient headline with animated statistics grid.'),
            'render_callback'	=> 'my_acf_block_render_callback',
            'category'        => 'layout',
            'icon'            => 'chart-bar',
            'mode'            => 'preview',
            'keywords'        => array('stats','numbers','impact','donation')
          ));
          

        acf_register_block_type(
            array(
                'name'            => 'project-pills',
                'title'           => __('Project Product Pills'),
                'description'     => __('Left title with selectable WooCommerce product pills (buttons).'),
                'render_callback' => 'my_acf_block_render_callback',
                'category'        => 'widgets',
                'mode'            => 'edit',
                'icon'            => 'tag',
                'keywords'        => array('woocommerce','products','pills','buttons','projects'),
            )
        );

 
            acf_register_block_type([
                'name'            => 'landing-hero', // <— slug
                'title'           => __('Landing Hero', 'the-zahra-trust'),
                'description'     => __('Single hero (no slider) using the first banner row + optional quick-donate box.', 'the-zahra-trust'),
                'category'        => 'layout',
                'icon'            => 'slides',
                'keywords'        => ['hero','landing','donation','banner'],
                'mode'            => 'edit',
                'supports'        => [
                  'align'  => ['wide','full'],
                  'anchor' => true,
                  'html'   => false,
                ],
                'render_callback' => 'my_acf_block_render_callback',
            ]);
    
          
          

        
         acf_register_block_type([
            'name'            => 'legacy-callout',
            'title'           => __('Legacy Callout', 'the-zahra-trust'),
            'description'     => __('Gradient callout with optional button', 'the-zahra-trust'),
            'render_callback' => 'my_acf_block_render_callback',
            'category'        => 'formatting',
            'mode'            => 'edit',
            'icon'            => 'megaphone',
            'keywords'        => ['callout','cta','donation','legacy'],
            'supports'        => [
                'align' => ['wide','full'],
                'mode'  => false,        // hides the mode switcher UI; keep if you like
            ],
        ]);

        acf_register_block_type([
            'name'            => 'donation-hero',
            'title'           => __('Donation Hero Banner','the-zahra-trust'),
            'description'     => __('Full-width hero with headline and Fundraise Up donation widget.','the-zahra-trust'),
            'category'        => 'layout',
            'icon'            => 'heart',
            'keywords'        => ['fundraise','donation','fundraise up','hero'],
            'mode'            => 'preview',
            'supports'        => ['align' => ['full','wide'], 'anchor' => true, 'html' => false],
            'render_callback'	=> 'my_acf_block_render_callback',
          ]);

          acf_register_block_type(array(
            'name'            => 'fu-top-supporters',
            'title'           => __('Top Supporters (Fundraise Up)'),
            'description'     => __('Heading + Fundraise Up Top Supporters embed trigger.'),
            'render_callback' => 'my_acf_block_render_callback',
            'category'        => 'widgets',
            'icon'            => 'groups',
            'mode'            => 'preview',
            'keywords'        => array('fundraise','fundraiseup','supporters','donors'),
          ));

         acf_register_block_type([
            'name'            => 'impact-map-cta',
            'title'           => __('Impact Map + CTA'),
            'description'     => __('Left embed (e.g., Fundraise Up map) + right CTA content and buttons.'),
            'render_callback' => 'my_acf_block_render_callback',
            'category'        => 'widgets',
            'icon'            => 'location-alt',
            'mode'            => 'preview',
            'keywords'        => ['map','fundraise up','cta','donate','embed'],
        ]);
        
          
        
        acf_register_block_type(
            array(
                'name'				=> 'faq-content',
                'title'				=> __('FAQ Content'),
                'description'		=> __('FAQ Content'),
                'render_callback'	=> 'my_acf_block_render_callback',
                'category'			=> 'formatting',
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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
                'mode'				=> 'edit',
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