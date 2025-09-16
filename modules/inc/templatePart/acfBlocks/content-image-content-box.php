<?php 
/**
 * Block Name: Image Content Box
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
    <section class="image__content_box <?php the_field('content_size'); ?> <?php the_field('image_position'); ?> <?php the_field('content_colour'); ?>" style="background:<?php the_field('background_colour'); ?>;">
        <?php if(get_field('image_position') === 'left_image'): 
            $content_image_id = get_field('left_image');
            $content_image = vt_resize($content_image_id,'' , 1500, 1500, false);
        else:
            $content_image_id = get_field('right_image');
            $content_image = vt_resize($content_image_id,'' , 1500, 1500, false);
        endif; ?>
        <figure class="<?php the_field('image_position'); ?> aos-item" data-aos="fade-up" style="background:url('<?php echo $content_image['url']; ?>');"></figure>
        <article class="<?php the_field('image_position'); ?>">
            <div class="article__wrap aos-item" data-aos="fade-up">
                <?php if(get_field('image_position') === 'left_image'): the_field('left_image_content'); else: the_field('right_image_content'); endif; ?>
            </div>
        </article>
    </section>
</div>