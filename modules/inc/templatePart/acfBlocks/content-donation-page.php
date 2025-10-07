<?php ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); ob_start();
/**
 * Block Name: Donation Page
 */ 
global $admin_view;
global $post;
global $location_block;
global $page_session;
$page_session = 'donate page';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<div class="gutenberg__wrap">

    <?php
    global $woocommerce; 
    ?>
	
        <div class="donation_box_page medium_box">

            <div class="continue_or_checkout_box">
                <span><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <path class="st0" d="M436.7,85.7c-50-50-131-50-181,0l-1.1,1.1c-50-50-130.6-50.5-180-1.1c-49.4,49.4-48.9,130,1.1,180l179.9,182.1
                    l181-181C486.6,216.8,486.6,135.7,436.7,85.7z M414,244.1L255.6,402.5L119.9,266.7L98.3,243c-37.4-37.4-37.9-97.8-1.1-134.7
                    C114.9,90.7,138.4,81,163.6,81c25.7,0,50,10.1,68.3,28.4l22.6,22.6l22.6-22.6c19.2-19.2,43.3-29.2,69-29.2c25.6,0,49.8,10,67.9,28.1
                    C451.4,145.8,451.4,206.7,414,244.1z"/>
                <g id="Page-1">
                    <polygon id="Path-47" points="192.7,209.7 176,227.5 247.2,294.1 389,128.9 370.5,112.9 245.2,258.8 	"/>
                </g>
                </svg>
                </span>
                <h3>Donation Added</h3>
                <div class="button_wrapper">
                    <a href="/checkout/" class="button borderStyle till woo_checkout_button">Checkout</a>
                    <a href="#" class="button till woo_continue_button">Donate More</a>
                </div>
            </div>

            <section class="donation_listing" style="width: 100%;">
                
                    <div id="product_steps_status"></div>
                    <?php $products = get_field('donation_projects'); ?>
                    <ul class="product__listing">
                    <?php foreach( $products as $product): // variable must be called $post (IMPORTANT) ?>
                        <li class="product__item_box trigger__donation_box aos-item" data-project-id="<?php echo $product; ?>" data-aos="fade-up">
                            <div class="product__wrap">
                            <?php 
                                $project_image = get_field('product_icon',$product);
                                ?>                    
                                <figure><img src="<?php echo $project_image; ?>" class="profuct__image" /></figure>
                                <div class="project__caption">
                                    <h3><?php echo get_the_title($product); ?></h3>
                                    <!--<a href="#" title="<?php get_the_title($product); ?>" class="trigger__donation_box" data-project-id="<?php echo $product; ?>">Select Package <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg></a>-->
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>        
                    </ul>
                    
                    <div id="product_details_box" class="donate_page"></div>
                    
            </section>

            <?php if(!isMobile()){ ?><aside class="cart_sidebar"><?php } ?>
            <div class="continue_shopping_popup" id="continue_shopping_popup"></div>
            <?php if(!isMobile()){ ?></aside><?php } ?>


        </div>


</div>

<script type="text/javascript">

    function load_the_steps($step,$process){
        jQuery.ajax({
            url:  $ajaxurl,
            data: 'action=loadstep&step='+$step+'&process='+$process,
            type: 'POST',
            beforeSend:function(xhr){
                //ajax_before();
            },
            success:function(data){
                jQuery('#product_steps_status').html(data);
            }

        });
        return false;
    }


    function load_the_cart($status = null){
        jQuery.ajax({
            url:  $ajaxurl,
            data: 'action=loadcart&status='+$status+'&onepagecart=onepage',
            type: 'POST',
            beforeSend:function(xhr){
                ajax_before();
            },
            success:function(data){
                ajax_after();
                jQuery('#continue_shopping_popup').html(data);
            }

        });
        return false;
    }
  

    load_the_cart();
    jQuery(document).ajaxComplete( function(){ 
        jQuery('body').removeClass('popup_active');
    });

    jQuery('.trigger__donation_box').click( function(event){ 
        console.log("test");
        jQuery('.trigger__donation_box').removeClass('activeProject');
        var productID = jQuery(this).data('project-id');
        jQuery('.product__listing').addClass('active');
        jQuery(this).addClass('activeProject');
        load_the_project(productID);
        event.preventDefault();
    });

    function continue_shopping(){
        jQuery('body').removeClass('added_to_cart');
        load_the_steps('1', '<?php if((check_recurring_cart() > 0) && (check_single_cart() > 0) ): echo 'both'; else: if(check_recurring_cart() > 0): echo 'recurring'; elseif(check_single_cart() > 0): echo 'single'; else: endif; endif; ?>');
        jQuery('.trigger__donation_box').removeClass('activeProject');
    }

    jQuery(document).on("click", '.woo_continue_button', function(event){
        continue_shopping();
        event.preventDefault();
    });

    load_the_steps('1', '<?php if((check_recurring_cart() > 0) && (check_single_cart() > 0) ): echo 'both'; else: if(check_recurring_cart() > 0): echo 'recurring'; elseif(check_single_cart() > 0): echo 'single'; else: endif; endif; ?>');



    function load_the_project($project_id){
        jQuery.ajax({
            url:  $ajaxurl,
            data: 'action=loadproject&project_id='+$project_id+'&overlay=false',
            type: 'POST',
            beforeSend:function(xhr){
                ajax_before();
            },
            success:function(data){
                ajax_after();
                load_the_steps('2', '<?php if((check_recurring_cart() > 0) && (check_single_cart() > 0) ): echo 'both'; else: if(check_recurring_cart() > 0): echo 'recurring'; elseif(check_single_cart() > 0): echo 'single'; else: endif; endif; ?>');
                jQuery('#product_details_box').addClass('active');
                jQuery('#product_details_box').html(data);
            }

        });
        return false;
    }
      
    function ajax_before(){
        jQuery('body').addClass('loading');
    }

    function ajax_after(){
        jQuery('body').removeClass('loading');
    }
</script>