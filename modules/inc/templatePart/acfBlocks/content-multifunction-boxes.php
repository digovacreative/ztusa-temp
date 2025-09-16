<?php 
/**
 * Block Name: Multifunction Boxes
 */ 
global $post;
global $location_block;
?>
<section class="multi_function_boxes <?php the_field('box_size'); ?>">
    <?php 
    $counter_multi_boxes = count(get_field('multi_function_boxes'));
    while ( have_rows('multi_function_boxes') ) : the_row(); ?>
    
        <?php 
            // $bg_image_box = get_sub_field('box_image');
            // $bg_image_box_url = vt_resize($bg_image_box,'' , 800, 800, false);
        ?>
        <div class="card_tilt multi__box image__box col_1_<?php echo $counter_multi_boxes; ?> <?php the_sub_field('background_colour'); ?>" >
            
            <div class="image__box_content aos-item" data-aos="fade-up">
                <?php if(get_sub_field('first_title')): ?>
                    <h2><?php the_sub_field('first_title'); ?></h2>
                <?php endif; ?>
                <?php if(get_sub_field('second_title')): ?>
                    <h3><?php the_sub_field('second_title'); ?></h3>
                <?php endif; ?>

                <?php if(get_sub_field('box_content')): ?>
                <div class="image__box_description">
                    <?php the_sub_field('box_content'); ?>
                </div>
                <?php endif; ?>

            </div>
            <?php if(get_sub_field('link')): ?>
                <a href="<?php the_sub_field('link'); ?>" class="button" title="<?php the_sub_field('link_label'); ?>">
                    <?php the_sub_field('link_label'); ?> <svg class="arrow" contentScriptType="text/ecmascript" contentStyleType="text/css" height="60.000000px" preserveAspectRatio="xMidYMid meet" version="1.0" viewBox="0 0 60.000000 60.000000" width="60.000000px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" zoomAndPan="magnify"><g><polyline fill="none" points="47.0,17.0 59.0,29.0 47.0,41.0" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="59.0" x2="1.0" y1="29.0" y2="29.0"/></g></svg>
                </a>
            <?php endif; ?>

            <?php if(get_sub_field('custom_link')): ?>
                <?php the_sub_field('custom_link'); ?>
            <?php endif; ?>
            
        </div>

    
    <?php endwhile; ?>
</section>
