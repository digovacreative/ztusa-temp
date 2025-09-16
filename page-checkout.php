<?php get_header(); 
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

?>
	<?php //include_once('modules/flexible-content/flexible-fields.php'); ?>
	<div class="content__wrapper gutenberg__wrap">
    
        <?php
        global $woocommerce; 

        if (sizeof(WC()->cart->get_cart()) != 0) {
            if(isset($_COOKIE['shopping_cart'])){
                $display = 'both';
            }else{
                $display = 'single';
            }
        }else{
        
            if(isset($_COOKIE['shopping_cart'])){
                $display = 'recurring';
            }
            $display = '';
        }
        ?>

        <?php if(is_order_received_page()): 
            global $wp;

            $order_id  = absint( $wp->query_vars['order-received'] );
            $order = wc_get_order( $order_id );
            $order->update_status( 'completed' );

            $order_data = $order->get_data(); 

            $gift_aid = get_post_meta($order_id, '_gift_aid', true );

            $newsletter_signup = get_post_meta($order_id, '_signup_newsletter', true );
            if($newsletter_signup == 1){
                //Signup to Mailchimp
                echo signup_to_mailchimp($order_data['billing']['email'], $order_data['billing']['first_name'], $order_data['billing']['last_name'], $order_data['billing']['phone']);
            } ?>    
            <div class="donation_box_page medium_box">
                
                <section class="donation_listing">
                    
                        <div id="product_steps_status"></div>
                            <div id="checkout_page">

                                <h2 class="donation_sucessful">Thank you for your Single Donation</h2>
                                <?php if(check_recurring_cart() > 0): 
                                    
                                    //echo '<div id="recurringcheckout"></div>'; ?>
                                    <?php
                                        if (is_user_logged_in() ): 
                                            global $current_user,$fname,$lname,$address_1,$city,$country,$postcode,$phone,$email; 
                                            $current_user = wp_get_current_user();
                                            $fname = get_user_meta( $current_user->ID, 'first_name', true );
                                            $lname = get_user_meta( $current_user->ID, 'last_name', true );
                                            $address_1 = get_user_meta( $current_user->ID, 'billing_address_1', true ); 
                                            $city = get_user_meta( $current_user->ID, 'billing_city', true );
                                            $country = get_user_meta( $current_user->ID, 'billing_country', true );
                                            $postcode = get_user_meta( $current_user->ID, 'billing_postcode', true );
                                            $phone = get_user_meta( $current_user->ID, 'billing_phone', true );
                                            $email = $current_user->user_email;
                                        else:
                                            
                                            $order_id = wc_get_order_id_by_order_key( $_GET['key'] );
                                            $order_meta = get_post_meta($order_id);
                                            
                                            $fname = $order_meta['_billing_first_name']['0'];
                                            $lname = $order_meta['_billing_last_name']['0'];
                                            $address_1 = $order_meta['_billing_address_1']['0'];
                                            $city = $order_meta['_billing_city']['0'];
                                            $country = $order_meta['_billing_country']['0'];
                                            $postcode = $order_meta['_billing_postcode']['0'];
                                            $phone = $order_meta['_billing_phone']['0'];
                                            $email = $order_meta['_billing_email']['0'];
                                        endif;
                                        ?>
                                        <div class="woocommerce">

                                            <div id="recurring_submit_data"></div>
                                            <?php 
                                            if(isset($_POST['form_submit'])):
                                                if(isset($_POST['createaccount'])):
                                                //Create account checked, check if email exists in DB as User:
                                                    if(email_exists($_POST['billing_email'])):
                                                        //Email already exists throw error and don't continue
                                                        ?>

                                                        <div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">
                                                            <ul class="woocommerce-error" role="alert">
                                                                <li>An account is already registered with your email address. Please log in.</li>
                                                            </ul>
                                                        </div>

                                                    <?php
                                                    else:
                                                        //Create user
                                                        // wp_create_user($_POST['billing_email'],'',$_POST['billing_email']);
                                                        $username = $_POST['billing_email'];
                                                        $email = $_POST['billing_email'];
                                                        $first_name = $_POST['billing_first_name'];
                                                        $last_name = $_POST['billing_last_name'];
                                                        $country = $_POST['billing_country'];
                                                        $street = $_POST['billing_address_1'];
                                                        $town = $_POST['billing_city'];
                                                        $postcode = $_POST['billing_postcode'];
                                                        $phone = $_POST['billing_phone'];

                                                        $userdata = array(
                                                            'user_login'    =>  $username,
                                                            'user_email'    =>  $email,
                                                            'user_pass'     =>  wp_generate_password ( 12, false ),
                                                            'user_url'      =>  '',
                                                            'first_name'    =>  $first_name,
                                                            'last_name'     =>  $last_name,
                                                            'nickname'      =>  '',
                                                            'description'   =>  '',
                                                            'role' => 'customer'
                                                        );
                                                        
                                                        $user = wp_insert_user( $userdata );
                                                        update_user_meta( $user, 'billing_first_name', $first_name );
                                                        update_user_meta( $user, 'billing_last_name', $last_name );
                                                        update_user_meta( $user, 'billing_address_1', $street );
                                                        update_user_meta( $user, 'billing_country', $country );
                                                        update_user_meta( $user, 'billing_city', $town );
                                                        update_user_meta( $user, 'billing_postcode', $postcode );
                                                        update_user_meta( $user, 'billing_phone', $phone );
                                                        update_user_meta( $user, 'billing_email', $email );

                                                        // //Login user
                                                        // $current_user = get_user_by( 'id', $user );

                                                        // // set the WP login cookiekeysk
                                                        // $secure_cookie = is_ssl() ? true : false;
                                                        // wp_set_auth_cookie( $user, true, $secure_cookie );

                                                        echo do_shortcode('[stripe_redirect]');
                                                    endif;
                                                else:
                                                    echo do_shortcode('[stripe_redirect]');
                                                endif;
                                            endif;
                                            
                                            echo do_shortcode('[stripe_form]');
                                            ?>
                                        </div>
                                        <script type="text/javascript">
                                            // Track recurring cart 
                                            jQuery('form.checkout').hide();

                                            jQuery(document).ready(function() {
                                                load_the_steps('4', 'both');
                                                // load_recurring_checkout();
                                            });

                                            // Track single donation Details 
                                                {
                                                    value: <?php echo $order->get_total(); ?>,
                                                    currency: 'GBP',
                                                    contents: [
                                                    <?php foreach ( $order->get_items() as $item_id => $item ) { ?>
                                                        {
                                                            id: '<?php echo $item->get_product_id(); ?>',
                                                            quantity: 1
                                                        },
                                                    <?php } ?>
                                                    ],
                                                    content_type: 'single_donations'
                                                }
                                            );

                                        </script>

                                    <?php
                                else:
                                    $thankyou_url = get_option('thankyou_url');
                                    global $post;
                                    echo $order_id;
                                    header('Location: '.$thankyou_url.'?order='.$order_id.'&v=s');
                                    ?>
                                       
                                    <script type="text/javascript">
                                    jQuery('form.checkout').hide();

                                    jQuery(document).ready(function() {
                                        jQuery('.woocommerce-checkout').removeClass('login_active');
                                        load_the_steps('4', 'both');
                                        // load_recurring_checkout();
                                    });
                                    </script>
                                    
                                <?php endif; ?>
                                
                        
                        </div>
                    
                </section>

                <?php if(!isMobile()){ ?><aside class="cart_sidebar"><?php } ?>
                    <div class="continue_shopping_popup" id="continue_shopping_popup"></div>
                <?php if(!isMobile()){ ?></aside><?php } ?>

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
                </script>
            </div>
            

        <?php else: ?>
            <div class="donation_box_page medium_box">

           
                <section class="donation_listing">
                    
                    <div id="product_steps_status"></div>
                    

                        <div id="checkout_page">
                            <?php     //add_filter('woocommerce_is_checkout', '__return_true');
                            
                            if ( WC()->cart->get_cart_contents_count() == 0 ) {
                                
                                if(check_recurring_cart() > 0): 
                                    
                                    echo do_shortcode('[woocommerce_checkout]');
                                    //echo '<div id="recurringcheckout"></div>'; ?>
                                    <?php
                                    if (is_user_logged_in() ): 
                                            global $current_user,$fname,$lname,$address_1,$city,$country,$postcode,$phone,$email; 
                                            $current_user = wp_get_current_user();
                                            $fname = get_user_meta( $current_user->ID, 'first_name', true );
                                            $lname = get_user_meta( $current_user->ID, 'last_name', true );
                                            $address_1 = get_user_meta( $current_user->ID, 'billing_address_1', true ); 
                                            $city = get_user_meta( $current_user->ID, 'billing_city', true );
                                            $country = get_user_meta( $current_user->ID, 'billing_country', true );
                                            $postcode = get_user_meta( $current_user->ID, 'billing_postcode', true );
                                            $phone = get_user_meta( $current_user->ID, 'billing_phone', true );
                                            $email = $current_user->user_email;
                                        else:
                                            $fname = '';
                                            $lname = '';
                                            $address_1 = '';
                                            $city = '';
                                            $country = '';
                                            $postcode = '';
                                            $phone = '';
                                            $email = '';
                                        endif;
                                        ?>
                                        <div class="woocommerce">

                                            <div id="recurring_submit_data"></div>
                                            <?php 
                                            if(isset($_POST['form_submit'])):
                                                if(isset($_POST['createaccount'])):
                                                //Create account checked, check if email exists in DB as User:
                                                    if(email_exists($_POST['billing_email'])):
                                                        //Email already exists throw error and don't continue
                                                        ?>

                                                        <div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">
                                                            <ul class="woocommerce-error" role="alert">
                                                                <li>An account is already registered with your email address. Please log in.</li>
                                                            </ul>
                                                        </div>

                                                    <?php
                                                    else:
                                                        //Create user
                                                        // wp_create_user($_POST['billing_email'],'',$_POST['billing_email']);
                                                        $username = $_POST['billing_email'];
                                                        $email = $_POST['billing_email'];
                                                        $first_name = $_POST['billing_first_name'];
                                                        $last_name = $_POST['billing_last_name'];
                                                        $country = $_POST['billing_country'];
                                                        $street = $_POST['billing_address_1'];
                                                        $town = $_POST['billing_city'];
                                                        $postcode = $_POST['billing_postcode'];
                                                        $phone = $_POST['billing_phone'];

                                                        $userdata = array(
                                                            'user_login'    =>  $username,
                                                            'user_email'    =>  $email,
                                                            'user_pass'     =>  wp_generate_password ( 12, false ),
                                                            'user_url'      =>  '',
                                                            'first_name'    =>  $first_name,
                                                            'last_name'     =>  $last_name,
                                                            'nickname'      =>  '',
                                                            'description'   =>  '',
                                                            'role' => 'customer'
                                                        );
                                                        
                                                        $user = wp_insert_user( $userdata );
                                                        update_user_meta( $user, 'billing_first_name', $first_name );
                                                        update_user_meta( $user, 'billing_last_name', $last_name );
                                                        update_user_meta( $user, 'billing_address_1', $street );
                                                        update_user_meta( $user, 'billing_country', $country );
                                                        update_user_meta( $user, 'billing_city', $town );
                                                        update_user_meta( $user, 'billing_postcode', $postcode );
                                                        update_user_meta( $user, 'billing_phone', $phone );
                                                        update_user_meta( $user, 'billing_email', $email );

                                                        // //Login user
                                                        // $current_user = get_user_by( 'id', $user );

                                                        // // set the WP login cookie
                                                        // $secure_cookie = is_ssl() ? true : false;
                                                        // wp_set_auth_cookie( $user, true, $secure_cookie );

                                                        echo do_shortcode('[stripe_redirect]');
                                                    endif;
                                                else:
                                                    echo do_shortcode('[stripe_redirect]');
                                                endif;
                                            endif;
                                            
                                            echo do_shortcode('[stripe_form]');
                                            ?>
                                        </div>
                                        
                                    <?php
                                else:
                                    echo '<h2>No donations in your cart</h2>';
                                endif;
                                ?>
                                <script type="text/javascript">
                                    jQuery('form.checkout').hide();
                                    jQuery(document).ready(function() {
                                        // load_recurring_checkout();
                                    });
                                </script>
                                <?php
                            }else{
                                echo do_shortcode('[woocommerce_checkout]');
                            }
                            ?>
                        
                        </div>
                        <!-- <div><?php // echo do_shortcode('[woocommerce_checkout]'); ?></div> -->

                </section>

                <?php if(!isMobile()){ ?><aside class="cart_sidebar"><?php } ?>
                    <div class="continue_shopping_popup" id="continue_shopping_popup"></div>
                <?php if(!isMobile()){ ?></aside><?php } ?>


            </div>
            <script>


                jQuery(document).ready(function() {
                    load_the_steps('3', '<?php if((check_recurring_cart() > 0) && (check_single_cart() > 0) ): echo 'both'; else: if(check_recurring_cart() > 0): echo 'recurring'; elseif(check_single_cart() > 0): echo 'single'; else: endif; endif; ?>');
                });

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
                <?php if (!is_user_logged_in() ): ?>
                jQuery('.woocommerce-form-login' ).show();
                jQuery('.woocommerce-checkout').addClass('login_active');
                <?php endif; ?>
            </script>
        <?php endif; ?>
        

    </div>

    <script type="text/javascript">

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
                    jQuery('body').removeClass('popup_active');

                }

            });
            return false;
        }

        function load_recurring_checkout(){
            jQuery.ajax({
                url:  $ajaxurl,
                data: 'action=loadrecurring_checkout',
                type: 'POST',
                beforeSend:function(xhr){
                    //ajax_before();
                },
                success:function(data){
                    jQuery('#recurringcheckout').html(data);
                }

            });
            return false;
        }

        function load_checkout_box(){
            jQuery('.cart_sidebar').addClass('disabled');
            jQuery('#checkout_page').addClass('active'); 
            jQuery(document).on("click", '.woo_guest_checkout', function(event){
                jQuery('.woocommerce-form-login' ).hide();
                jQuery('.woocommerce-checkout').removeClass('login_active');
            });
        }
        
        function ajax_before(){
            jQuery('body').addClass('loading');
        }

        function ajax_after(){
            jQuery('body').removeClass('loading');
        }

        load_the_cart();
        load_checkout_box();
       

    </script>

    </div>
<?php get_footer(); ?>
