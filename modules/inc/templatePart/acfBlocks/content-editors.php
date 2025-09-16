<?php 
/**
 * Block Name: Editors
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">

    <section role="region" aria-label="content" class="contentEditorContainer">
        
        <?php if(get_field('background_colour')): ?>
        <div class="content_background" 
        style="background:<?php the_field('background_colour'); ?>; 
        <?php if(get_field('background_color_opacity')):?>
            -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php the_field('background_color_opacity'); ?>)';
            -moz-opacity:0.<?php the_field('background_color_opacity'); ?>;
            -khtml-opacity: 0.<?php the_field('background_color_opacity'); ?>;
            opacity: 0.<?php the_field('background_color_opacity'); ?>;
        <?php endif; ?>"
        ></div>
        <?php endif; ?>
        
        <?php if(get_field('background_image')): 
        $content_image_id = get_field('background_image');
        $content_image = vt_resize($content_image_id,'' , 1000, 1000, false);    
        ?>
        <div class="content_image"style="background:url('<?php echo $content_image['url']; ?>') center center;"></div>
        <?php endif; ?>
        
        <div class="content__wrapper_box">

            <div class="editor__box <?php the_field('content_size'); ?> <?php the_field('content_position'); $position = get_field('content_position'); ?> <?php the_field('row_spacing'); ?> 
                <?php  
                if(!isMobile()):
                    the_field('content_colour');  $caption_colour = get_field('content_colour'); 
                else:
                    the_field('mobile_content_colours');  $caption_colour = get_field('mobile_content_colours'); 
                endif; ?>">

                <?php $gridStyle = get_field('style'); ?>
                <?php if ($gridStyle=='full_width'): ?>

                    <?php $delay=100; if( have_rows('full_content_editor') ): while( have_rows('full_content_editor') ): the_row(); $delay+=100; ?>
                    <div class="col_1_1 content__box" data-aos="fade-top" data-aos-delay="<?php echo $delay; ?>"><?php the_sub_field('editor'); ?></div>
                    <?php endwhile; endif; ?>

                <?php elseif ($gridStyle=='half_width'): ?>

                    <?php $delay=100; if( have_rows('half_content_editor') ): while( have_rows('half_content_editor') ): the_row(); $delay+=100; ?>
                    <div class="col_1_2 content__box" data-aos="fade-top" data-aos-delay="200"><?php the_sub_field('editor_left'); ?></div>
                    <div class="col_1_2 content__box" data-aos="fade-top" data-aos-delay="300"><?php the_sub_field('editor_right'); ?></div>
                    <?php endwhile; endif; ?>

                <?php elseif ($gridStyle=='one_third_width'): ?>

                    <?php $delay=100; if( have_rows('one_third_content_editor') ): while( have_rows('one_third_content_editor') ): the_row(); $delay+=100; ?>
                    <div class="col_1_3 content__box" data-aos="fade-top" data-aos-delay="200"><?php the_sub_field('editor_first'); ?></div>
                    <div class="col_1_3 content__box" data-aos="fade-top" data-aos-delay="300"><?php the_sub_field('editor_second'); ?></div>
                    <div class="col_1_3 content__box" data-aos="fade-top" data-aos-delay="400"><?php the_sub_field('editor_third'); ?></div>
                    <?php endwhile; endif; ?>

                <?php elseif ($gridStyle=='one_fourth_width'): ?>

                    <?php $delay=100; if( have_rows('one_fourth_content_editor') ): while( have_rows('one_fourth_content_editor') ): the_row(); $delay+=100; ?>
                    <div class="col_1_4 content__box" data-aos="fade-top" data-aos-delay="200"><?php the_sub_field('editor_first'); ?></div>
                    <div class="col_1_4 content__box" data-aos="fade-top" data-aos-delay="300"><?php the_sub_field('editor_second'); ?></div>
                    <div class="col_1_4 content__box" data-aos="fade-top" data-aos-delay="400"><?php the_sub_field('editor_third'); ?></div>
                    <div class="col_1_4 content__box" data-aos="fade-top" data-aos-delay="500"><?php the_sub_field('editor_fourth'); ?></div>
                    <?php endwhile; endif; ?>

                <?php elseif ($gridStyle=='one_third_right_width'): ?>
                    
                    <?php $delay=100; if( have_rows('one_third_left_editor') ): while( have_rows('one_third_left_editor') ): the_row(); $delay+=100; ?>
                    <div class="col_2_3 content__box" data-aos="fade-top" data-aos-delay="200"><?php the_sub_field('editor_two_third'); ?></div>
                    <div class="col_1_3 content__box" data-aos="fade-top" data-aos-delay="300"><?php the_sub_field('editor_one_third'); ?></div>
                    <?php endwhile; endif; ?>

                <?php elseif ($gridStyle=='one_third_left_width'): ?>
                    
                    <?php $delay=100; if( have_rows('one_third_right_editor') ): while( have_rows('one_third_right_editor') ): the_row(); $delay+=100; ?>
                    <div class="col_1_3 content__box" data-aos="fade-top" data-aos-delay="200"><?php the_sub_field('editor_one_third'); ?></div>
                    <div class="col_2_3 content__box" data-aos="fade-top" data-aos-delay="300"><?php the_sub_field('editor_two_third'); ?></div>
                    <?php endwhile; endif; ?>

                <?php endif; ?>
              
                <?php if( have_rows('call_to_action_buttons') ):?>
                    <div class="buttons  <?php echo  $position; ?>">
                    <?php while ( have_rows('call_to_action_buttons') ) : the_row(); ?>
                        <a href="<?php the_sub_field('cta_link'); ?>" class="button <?php the_sub_field('cta_style'); ?>" title="<?php the_sub_field('cta_label'); ?>" target="<?php the_sub_field('cta_target'); ?>"><?php the_sub_field('cta_label'); ?></a>
                    <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                
            </div>
       
        </div>

    </section>


</div>


<script type="text/javascript">
    jQuery('iframe[src*="youtube"]').parent('p').addClass('videoWrap');
    // jQuery(".wp-block-gallery .blocks-gallery-item a").fancybox().attr('data-fancybox', 'gallery');
</script>