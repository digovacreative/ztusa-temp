<?php 
/**
 * Block Name: Image Image Overlap Box
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
    <?php 
    $content_image_id = get_field('background_image');
    $content_image = vt_resize($content_image_id,'' , 2000, 1500, false);
    ?>
    <section class="overlay__wrapper">

        <section class="overlap_image_box" style="background:url('<?php echo $content_image['url']; ?>');">
            <article class="<?php the_field('box_position'); ?> <?php the_field('text_position'); ?> desktopVisible aos-item" data-aos="fade-up" style="background:<?php the_field('background_colour'); ?>;">
                <?php the_field('content_box'); ?>

                <?php if(get_field('buttons')): ?>
                    <div class="button_wrap">
                    <?php while(has_sub_field('buttons')): ?>	
                        <a href="<?php the_sub_field('button_link'); ?>" class="button <?php the_sub_field('button_style'); ?>  aos-item" data-aos="fade-up">
                            <?php the_sub_field('button_label'); ?>
                            <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg>
                        </a>
                    <?php endwhile; ?>
                    </div>
                <?php endif; ?>

            </article>
        </section>

        <article class="<?php the_field('box_position'); ?> <?php the_field('text_position'); ?> mobileVisible  aos-item" data-aos="fade-up" style="background:<?php the_field('background_colour'); ?>;">
            <?php the_field('content_box'); ?>

            <?php if(get_field('buttons')): ?>
                <div class="button_wrap">
                <?php while(has_sub_field('buttons')): ?>	
                    <a href="<?php the_sub_field('button_link'); ?>" class="button <?php the_sub_field('button_style'); ?> aos-item" data-aos="fade-up">
                        <?php the_sub_field('button_label'); ?>
                        <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg>
                    </a>
                <?php endwhile; ?>
                </div>
            <?php endif; ?>

        </article>

    </section>
</div>