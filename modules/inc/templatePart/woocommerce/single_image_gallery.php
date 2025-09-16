<?php global $product; ?>
<?php if(get_field('products_gallery')): ?>
<section class="product__gallery">
    <div class="owl-carousel owl-theme" id="single_image_gallery">
    <?php while(has_sub_field('products_gallery')): ?>
        <div class="product__gallery_item">
        <?php $gallery_image_id = get_sub_field('image'); $gallery_image = vt_resize($gallery_image_id,'' , 1500, 800, true); ?>
            <img src="<?php echo $gallery_image['url']; ?>" />
            <?php if(get_sub_field('enable_caption')): ?>
            <div class="banner__caption_box <?php the_sub_field('caption_position'); ?>">
                <?php the_sub_field('caption_text'); ?>
            </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
    </div>
</section>
<?php endif; ?>

<?php if(get_field('enable_contact_bar')): ?>
<section class="product__contact_bar">
    <h3><?php the_field('product_request_title','options'); ?></h3>
    <a href="<?php the_field('request_contact_link','options'); ?>" title="<?php the_field('request_contact_label','options'); ?>"><?php the_field('request_contact_label','options'); ?></a>
</section>
<?php endif; ?>

<script type="text/javascript">
    
    jQuery('#single_image_gallery').owlCarousel({
        loop:true,
        margin:0,
        //nav:true,
        dots: true,
        autoHeight:false,
        autoplay: true,
        //navText: ["",""],
        autoplayHoverPause: true,
        autoplayTimeout: 4000,
        autoplaySpeed: 900,
        items: 1,
        animateOut: 'fadeOut',
        stagePadding: 0,
    });

</script>