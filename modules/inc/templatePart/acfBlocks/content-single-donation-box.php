<?php 
/**
 * Block Name: Single Donations Box
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
    
    <section class="single_donation_box" style="background:<?php the_field('single_background_colour'); ?>;">
        
        <?php if(get_field('single_heading_text')): ?><h2 class="<?php the_field('single_text_colour'); ?> aos-item" data-aos="fade-up"><?php the_field('single_heading_text'); ?></h2><?php endif; ?>
        
        <div class="large_box">
            <div id="product_details_box" class="aos-item" data-aos="fade-up"></div>
        </div>
    </section>
</div>

<script>

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
    <?php $products = get_field('single_project_select'); ?>
    <?php foreach( $products as $product): ?> 
    jQuery( document ).ready(function() {
        load_the_project(<?php echo $product; ?>);
    });
    <?php endforeach; ?>   
    

    // jQuery('.trigger__donation_box').click( function(event){ 
    //     var productID = jQuery(this).data('project-id');
    //     jQuery('.product__listing').addClass('active');
    //     jQuery('body').addClass('popup_active');
        
    //     event.preventDefault();
    // });

</script>