<?php 
/**
 * Block Name: Multiple Donations Box
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
    
    <section class="multiple_donation_box <?php if(get_field('enable_carousel')): echo 'carousel_style_box'; endif; ?>" style="background:<?php the_field('background_colour'); ?>;">
        
        <?php if(get_field('heading_text')): ?><h2 class="<?php the_field('text_colour'); ?> aos-item" data-aos="fade-up"><?php the_field('heading_text'); ?><span><?php the_field('heading_text'); ?></span></h2><?php endif; ?>
        
        <div class="wrap__box <?php if(get_field('enable_carousel')): echo 'carousel_style'; endif; ?>">
            <div id="product_details_box"></div>
            <?php $products = get_field('project_selects'); ?>
                <ul class="product__listing">
                <?php $boxCounter = 150; foreach( $products as $product): $boxCounter=$boxCounter+50; // variable must be called $post (IMPORTANT) ?>
                    <li class="product__item_box aos-item" data-aos="fade-up" data-aos-delay="<?php echo $boxCounter; ?>">
                        <div class="product__wrap">
                            <?php 
                            $project_image_id = get_post_thumbnail_id( $product);
                            $project_image = vt_resize($project_image_id,'' , 500, 500, true); 
                            ?>                    
                            <figure class="trigger__donation_box" data-project-id="<?php echo $product; ?>"><img src="<?php echo $project_image['url']; ?>" class="profuct__image" /></figure>
                            <div class="project__caption">
                                <h3><?php echo get_the_title($product); ?></h3>
                                <a href="#" title="<?php get_the_title($product); ?>" class="trigger__donation_box" data-project-id="<?php echo $product; ?>">Select Package <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg></a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>        
                </ul>
        </div>
    </section>
</div>

<script>

    <?php if(get_field('enable_carousel')): ?>
    jQuery('.product__listing').slick({
        slidesToShow: 5.5,
        slidesToScroll: 1,
        dots: true,
        centerMode: true,
        centerPadding: '0',
        arrows: false,
        responsive: [
            {
            breakpoint: 1800,
            settings: {
                slidesToShow: 4.5,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 1500,
            settings: {
                slidesToShow: 3.5,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 768,
            settings: {
                slidesToShow: 2.5,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 400,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            },
            
        ]
    });
    <?php endif; ?>

    function load_the_project($project_id){
        jQuery.ajax({
            url:  $ajaxurl,
            data: 'action=loadproject&project_id='+$project_id,
            type: 'POST',
            beforeSend:function(xhr){
                ajax_before();
            },
            success:function(data){
                ajax_after();
                jQuery('#product_details_box').addClass('active');
                jQuery('#product_details_box').html(data);
            }

        });
        return false;
    }
    
    jQuery('.trigger__donation_box').click( function(event){ 
        var productID = jQuery(this).data('project-id');
        jQuery('.product__listing').addClass('active');
        jQuery('body').addClass('popup_active');
        load_the_project(productID);
        event.preventDefault();
    });

</script>