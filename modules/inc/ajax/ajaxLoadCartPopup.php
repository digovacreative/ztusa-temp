<?php
function load_cart_function(){  ?>
    
    <div class="pop-up-window">

        <a href="#" class="close_popup" id="continue_shopping_button">
            <svg enable-background="new 0 0 40 40" version="1.1" viewBox="0 0 40 40" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Web"><g id="Tabs_3_"/><g id="Male_2_"/><g id="Female_1_"/><g id="Unshare_2_"/><g id="Share_2_"/><g id="More_4_"/><g id="New_Window_3_"/><g id="Edit_5_"/><g id="Checked_3_"/><g id="Unchecked_2_"/><g id="Menu_Alt_1_"/><g id="Menu_6_"/><g id="Hand_Cursor_2_"/><g id="Type_Cursor_2_"/><g id="Tag_Minus_4_"/><g id="Tag_Plus_4_"/><g id="Tag_2_"/><g id="Options_2_"/><g id="List_Alt_2_"/><g id="List_2_"/><g id="Grid_Small"/><g id="Grid_Big"/><g id="Log_Out_3_"/><g id="Log_In_3_"/><g id="Upload_8_"/><g id="Download_8_"/><g id="Export_1_"/><g id="Import_1_"/><g id="Userlist"/><g id="User_Star"/><g id="User_Down"/><g id="User_Up"/><g id="User_Minus"/><g id="User_Plus"/><g id="Like_3_"/><g id="Dislike_3_"/><g id="Unlock"/><g id="Lock"/><g id="More_Windows_9_"/><g id="External_Link_9_"/><g id="Grid_System"/><g id="Image_5_"/><g id="Table_3_"/><g id="Embed_Close_2_"/><g id="Embed_2_"/><g id="QR_2_"/><g id="Translate_6_"/><g id="Global_7_"/><g id="Trash_4_"/><g id="Nut_3_"/><g id="Gauge"/><g id="Sliders_3_"/><g id="Tools"/><g id="Gears_3_"/><g id="Gear_2_"/><g id="Arrow_Keys"/><g id="Ban_2_"/><g id="Warning"/><g id="Remove_2_"><g id="Remove"><g><polygon clip-rule="evenodd" fill-rule="evenodd" points="30,12.8 27.2,10 20,17.2 12.9,10.1 10.1,12.9 17.2,20       10,27.2 12.8,30 20,22.8 27.1,29.9 29.9,27.1 22.8,20     "/></g></g></g><g id="OK_2_"/><g id="Search_4_"/><g id="Zoom_In_5_"/><g id="Zoom_Out_5_"/><g id="Social_Network_5_"/><g id="Anchor_2_"/><g id="Link_4_"/><g id="Cloud_Camera_6_"/><g id="Cloud_Up_4_"/><g id="Cloud_Down_4_"/><g id="Cloud_Tunes"/><g id="Broadcast_4_"/><g id="Filter_3_"/><g id="Paper_Plane_3_"/><g id="Star_Fill_2_"/><g id="Star_Stroke_3_"/><g id="Heart_Fill_2_"/><g id="Heart_Stroke_1_"/><g id="Chat_Convo_Alt"/><g id="Chat_Type_Alt"/><g id="Chat_Alert_Alt"/><g id="Chat_Alt"/><g id="Chat_Convo"/><g id="Chat_Type"/><g id="Chat_Alert"/><g id="Chat"/><g id="Home_3_"/></g><g id="Lockup"/></svg>
        </a>
        
        <div class="cart_wrap">
            <div class="widget_shopping_cart_content">
                <?php if(isset($_POST['status']) && ($_POST['status'] === 'added')): ?>
                <h4>
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
                    Donation Added
                </h4>

                <?php endif; ?>
                <?php woocommerce_mini_cart(); ?>
                <?php //include('ajaxMiniCart.php'); ?>
                
            </div>
            <?php //include('ajaxRecurringCart.php'); 
            ?>
            <div class="recurring_cart_content" id="recurring_cart_content"></div>
            <div class="checkout_button_wrap">
                <a href="#" id="continue_shopping_button" class="button green checkout">Donate More</a>
                <a href="/checkout/" class="button green checkout woo_checkout_button">Secure Checkout</a>
            </div>


        </div>
    </div>
    <script type="text/javascript">

        <?php if(isset($_POST['onepagecart']) && $_POST['onepagecart'] === 'onepage' ): ?>
            jQuery('#continue_shopping_button').hide();
        <?php endif; ?>

        jQuery(document).on("click", '#continue_shopping_button', function(event){
            console.log('closed');
            cart_quantity();
            jQuery('.continue_shopping_popup').removeClass('active');
            jQuery('body').removeClass('popup_active');
            jQuery('body').removeClass('added_to_cart');
            console.log('closed');
            event.preventDefault();
        });
        jQuery('body').addClass('popup_active');
        //jQuery('.product__item_box').removeClass('activeProject');

        $method = 'load';
        load_the_recurring_cart_data($method,$id=false);

        function load_the_recurring_cart_data($method = false, $id = false){
            jQuery.ajax({
                // url:  $ajaxurl,
                url:  '<?php echo get_stylesheet_directory_uri(); ?>/modules/inc/ajax/ajaxRecurringCart.php',
                data: 'action=load_recurring_cart&method='+$method+'&id='+$id+'&url=<?php  echo get_stylesheet_directory_uri(); ?>',
                type: 'POST',
                beforeSend:function(xhr){
                    jQuery('.recurring_cart').addClass('loading');
                    
                    //ajax_before();
                },
                success:function(data){
                    //ajax_after();
                    jQuery('.recurring_cart').removeClass('loading');
                    jQuery('#recurring_cart_content').html(data);
                },
                error:function(xhr){
                    console.log(xhr);
                }

            });
            return false;
        }

        function load_login_box(){
            
            jQuery.ajax({
                url:  $ajaxurl,
                data: 'action=loadlogin',
                type: 'POST',
                beforeSend:function(xhr){
                    ajax_before();
                },
                success:function(data){
                    ajax_after();
                    //jQuery('.continue_shopping_popup').addClass('active');
                    jQuery('#login_register').html(data);
                }

            });
            return false;
        }

        // function load_checkout_box(){
        //     jQuery('body').removeClass('added_to_cart');
        //     jQuery('.trigger__donation_box').removeClass('activeProject');
        //     jQuery(this).closest('#product_details_box').removeClass('active');
            
        //     // loadCheckoutPage();
        //     load_the_steps('3', '<?php if(isset($_COOKIE['shopping_cart'])): echo 'recurring'; endif; ?>');
        //     jQuery('body' ).trigger('update_checkout');
        //     jQuery('#checkout_page').addClass('active');
        //     jQuery('.pop-up-window').addClass('disabled');
        // }
        
    </script>

<?php  die();
}
add_action('ZTRUST_AJAX_loadcart', 'load_cart_function');
add_action('ZTRUST_AJAX_nopriv_loadcart', 'load_cart_function');
?>