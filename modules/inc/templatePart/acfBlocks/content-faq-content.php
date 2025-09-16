<?php 
/**
 * Block Name: FAQ Content Box
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
    <section class="faq_content_box <?php the_field('content_size'); ?> <?php the_field('content_colour'); ?>" style="background:<?php the_field('background_colour'); ?>;">

        <?php $accordionCount=0; while ( have_rows('faq_items') ) : the_row(); $accordionCount++; ?>
        <article class="aos-item" data-aos="fade-up">
            <div class="accordion-toggle">
               <?php the_sub_field('question'); ?> <svg class="icon" viewBox="0 0 22 30"><path d="M9.469 21.738l-9.25-9.175c-0.294-0.294-0.294-0.769 0-1.063l1.238-1.238c0.294-0.294 0.769-0.294 1.062 0l7.481 7.406 7.481-7.406c0.294-0.294 0.769-0.294 1.063 0l1.238 1.238c0.294 0.294 0.294 0.769 0 1.063l-9.25 9.175c-0.294 0.294-0.769 0.294-1.063 0z"></path></svg>
            </div>
            <div class="accordion-content">
                <?php the_sub_field('answer'); ?>
              </div>
        </article>
        <?php endwhile; ?>
   
    </section>
</div>

<script>
    jQuery('.faq_content_box').find('.accordion-toggle').click(function(){

        jQuery(this).toggleClass('active');
        jQuery(this).next().slideToggle('fast');
        jQuery(".accordion-content").not(jQuery(this).next()).slideUp('fast');
        jQuery(".accordion-toggle").not(jQuery(this)).removeClass('active');

        if (jQuery('.accordion-toggle').hasClass('active')){
            jQuery(this).closest('.accordionBox').addClass('clickedAccordion');
        }else {
            jQuery(this).closest('.accordionBox').removeClass('clickedAccordion');
        }

    });
</script>