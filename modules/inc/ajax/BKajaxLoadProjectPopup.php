<?php
function load_project_function(){ 
    
    ?>
    <div class="pop-up-product <?php if(empty($_POST['project_id'])): echo 'no_id'; endif; ?>">
        
        <div id="recurring_project_add"></div>
        <?php 
            if(empty($_POST['project_id'])):
                echo '<div class="disabled_overlay"></div>';
            endif;

                $product_id = $_POST['project_id'];
                if(isset($_POST['overlay'])):
                    $overlay_option = $_POST['overlay'];
                else:
                    $overlay_option = TRUE;
                endif;

                $random_string = random_string_generator();

                $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'p' => $product_id );
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <div class="quickproduct">

                            <h3><?php the_title(); ?></h3>
                            <?php if(get_the_content()): ?>
                            <div class="product__description">
                                <?php the_content(); ?>
                            </div>
                            <?php endif; ?>

                            <?php if($overlay_option === TRUE): ?>
                            <a href="#" class="close-project-popup">
                                <svg enable-background="new 0 0 40 40" version="1.1" viewBox="0 0 40 40" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Controls"><g id="D71_4_"/><g id="D61_4_"/><g id="D51_4_"/><g id="Dolby"/><g id="Stereo_4_"/><g id="CC_4_"/><g id="HD_4_"/><g id="SD_4_"/><g id="Pause_02"/><g id="Play_02"/><g id="Left_02"/><g id="Right_02"/><g id="Down_02"/><g id="Up_02"/><g id="Urgent_02"/><g id="Info_02"/><g id="Help_02"/><g id="OK_02"/><g id="Remove__02"/><g id="Minus_02"/><g id="Plus_02"/><g id="Pause_01"/><g id="Play_01"/><g id="Left_01"/><g id="Right_01"/><g id="Down_01"/><g id="Up_01"/><g id="Urgent_01"/><g id="Info_01"/><g id="Help_01"/><g id="OK_01"/><g id="Remove_01"><g><g id="Remove_Stroke"><g><path clip-rule="evenodd" d="M20,8C13.4,8,8,13.4,8,20c0,6.6,5.4,12,12,12       c6.6,0,12-5.4,12-12C32,13.4,26.6,8,20,8z M20,30c-5.5,0-10-4.5-10-10c0-5.5,4.5-10,10-10c5.5,0,10,4.5,10,10       C30,25.5,25.5,30,20,30z" fill="#ECF0F1" fill-rule="evenodd"/></g></g><g id="Remove_Stroke_1_"><g><polygon clip-rule="evenodd" fill="#1ABC9C" fill-rule="evenodd" points="24.9,16.5 23.5,15.1 20,18.6 16.5,15.1 15.1,16.5        18.6,20 15.1,23.5 16.5,24.9 20,21.4 23.5,24.9 24.9,23.5 21.4,20      "/></g></g></g></g><g id="Minus_01"/><g id="Plus_01"/><g id="Chevron_Light_Down_2_"/><g id="Chevron_Light_Up_2_"/><g id="Chevron_Heavy_Down_1_"/><g id="Chevron_Heavy_Up_3_"/><g id="Chevron_Light_Right_2_"/><g id="Chevron_Light_Left_2_"/><g id="Chevron_Heavy_Right_2_"/><g id="Chevron_Heavy_Left_2_"/><g id="Random_2_"/><g id="Rotation_Lock_4_"/><g id="Replay_1_"/><g id="Rotation_3_"/><g id="Refresh_2_"/><g id="Power_3_"/><g id="Transfer_4_"/><g id="Retweet_2_"/><g id="Loop_2_"/><g id="Delete_3_"/><g id="Brighten_3_"/><g id="Dim_3_"/><g id="Screen_Fit_4_"/><g id="Screen_Fill_3_"/><g id="Down_03"/><g id="Up_03"/><g id="Right_03"/><g id="Left_03"/><g id="Bell_3_"/><g id="Bell_Mute_4_"/><g id="Playlist_3_"/><g id="Octave_2_"/><g id="Quaver_2_"/><g id="Earbuds_4_"/><g id="Mute_Mic_1_"/><g id="Mic_4_"/><g id="Volume_Up"/><g id="Volume_Down"/><g id="Volume_Mute_4_"/><g id="Volume_3_"/><g id="Maximize"/><g id="Fullscreen_Enter_2_"/><g id="Fullscreen_Exit_2_"/><g id="Eject_2_"/><g id="Step_Forward_2_"/><g id="Fast-forward_1_"/><g id="Forward_2_"/><g id="Stop_2_"/><g id="Pause_2_"/><g id="Play_2_"/><g id="Rewind_2_"/><g id="Fast-backward"/><g id="Step_Backward_2_"/><g id="Record_2_"/></g><g id="Lockup"/></svg>
                            </a>
                            <?php endif; ?>
                            <script type="text/javascript" language="javascript">
                                jQuery(document).ready(function($) {
                                    console.log('<?php echo $random_string; ?>');
                                    jQuery(".tabContent-<?php echo($random_string); ?>").hide(); //Hide all content
                                    jQuery("ul.tabs-<?php echo($random_string); ?> li:first").addClass("active").show(); //Activate first tab
                                    jQuery(".tabContent-<?php echo($random_string); ?>:first").show(); //Show first tab content

                                    // Tab links
                                    jQuery("ul.tabs-<?php echo($random_string); ?> li").click(function() {
                                        jQuery("ul.tabs-<?php echo($random_string); ?> li").removeClass("active"); //Remove any "active" class
                                        jQuery(this).addClass("active"); //Add "active" class to selected tab
                                        jQuery(".tabContent-<?php echo($random_string); ?>").hide(); //Hide all tab content
                                        var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
                                        jQuery(activeTab).fadeIn(); //Fade in the active content
                                        return false;
                                    });

                                 });
                            </script>


                            <div class="productWrapper tab <?php /*if(get_field('enable_multiple_donations')): echo 'has_quantity'; endif; */ ?>">
                                
                                <?php if(!get_field('product_type') || get_field('product_type') === 'both'): ?>
                                <ul class="tabs-<?php echo($random_string); ?>" id="tabsnav">
                                   
                                    <li>
                                        <a href="#2-<?php echo($random_string); ?>" title="SINGLE DONATION">
                                        <svg version="1.1" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="" id="Core" transform="translate(-44.000000, -86.000000)"><g id="check-circle" transform="translate(44.000000, 86.000000)"><path d="M10,0 C4.5,0 0,4.5 0,10 C0,15.5 4.5,20 10,20 C15.5,20 20,15.5 20,10 C20,4.5 15.5,0 10,0 L10,0 Z M8,15 L3,10 L4.4,8.6 L8,12.2 L15.6,4.6 L17,6 L8,15 L8,15 Z" id="Shape"/></g></g></g></svg>
                                        Single Donation</a>
                                    </li>
                                    <li>
                                        <a href="#1-<?php echo($random_string); ?>" title="MONTHLY DONATION">
                                        <svg version="1.1" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="" id="Core" transform="translate(-44.000000, -86.000000)"><g id="check-circle" transform="translate(44.000000, 86.000000)"><path d="M10,0 C4.5,0 0,4.5 0,10 C0,15.5 4.5,20 10,20 C15.5,20 20,15.5 20,10 C20,4.5 15.5,0 10,0 L10,0 Z M8,15 L3,10 L4.4,8.6 L8,12.2 L15.6,4.6 L17,6 L8,15 L8,15 Z" id="Shape"/></g></g></g></svg>
                                        Regular Donation</a>
                                    </li>

                                </ul>
                                <?php endif; ?>

                                <div class="tab-content">

                                    <?php if(get_field('enable_split_donation_calculator')): ?>
                                        <div class="split_donation_wrapper">
                                            <div class="amount__wrapper">
                                                <span>Total amount: <?= get_woocommerce_currency_symbol() ?></span>
                                                <input type="number" value="10" class="split_amount" />
                                            </div>
                                            <div class="split_causes">
                                                <?php
                                                $numberTotal = get_field('number_of_days'); 
                                                $textBefore = get_field('text_before_number');
                                                for($i=1; $i <= $numberTotal; $i++ ){ ?>
                                                <div class="cause__row">
                                                    <label><?php echo $textBefore; ?> <?php echo $i; ?></label>
                                                    <select name="causes_dropdown" class="causes_dropdown">
                                                        <?php while(has_sub_field('calculation_split_options')): ?>
                                                        <option value="<?php the_sub_field('cause_name'); ?>"><?php the_sub_field('cause_name'); ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                    <input class="cause_amount" type="number" name="cause-amount-<?php echo $i; ?>" />
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <script>
                                            jQuery(document).ready(function() {
                                                var totalDonation = jQuery('.split_amount').val();
                                                calculateAndDivide(totalDonation);
                                            });

                                            jQuery(".split_amount").on('keyup', function (e) {
                                                var totalDonation = jQuery(this).val();
                                                calculateAndDivide(totalDonation);
                                                e.preventDefault();
                                            });

                                            jQuery(".cause_amount").on('keyup', function (e) {
                                                var totalAmount = 0;
                                                jQuery('.cause_amount').each(function(i, obj) {
                                                    var currentValue = parseFloat(jQuery(this).val());
                                                    console.log(currentValue);
                                                    totalAmount = totalAmount+currentValue;
                                                });                                            
                                                // console.log(totalAmount);
                                                jQuery('.split_amount').val(totalAmount);
                                                jQuery('.payyourprice_contribution').val(totalAmount);
                                                e.preventDefault();
                                            });

                                            function calculateAndDivide(calculateAndDivide){
                                                var equalAmount = calculateAndDivide/<?php the_field('number_of_days'); ?>;
                                                console.log(equalAmount);
                                                jQuery('.payyourprice_contribution').val(calculateAndDivide);
                                                // jQuery('.payyourprice_contribution').val(calculateAndDivide);
                                                
                                                jQuery('.cause_amount').val(equalAmount);
                                            }
                                            
                                        </script>
                                    <?php endif; ?>

                                    <?php if(!get_field('product_type') || get_field('product_type') === 'both' || get_field('product_type') === 'single'  ): ?>
                                        <div class="donation singleDonationTab tabContent-<?php echo($random_string); ?>" style="<?php if(get_field('single')): echo 'display:block;'; endif;?>" id="2-<?php echo($random_string); ?>">
                                            <div class="summary entry-summary  <?php if(get_field('enable_split_donation_calculator')): echo 'has_split_donation'; endif; ?>">
                                                
                                                <div class="package__options">
                                                    <ul class="<?php $option_count = count(get_field('product_options')); ?>package__listing">
                                                    <?php while(has_sub_field('product_options')): ?>
                                                        <?php if(get_sub_field('amount')): ?>
                                                        <li class="package__listing_item item_<?php echo $option_count; ?>" data-project-id="<?php echo($product_id); ?>" data-value="<?php the_sub_field('amount'); ?>">
                                                        <span class="inactive"></span> 
                                                        <strong>
                                                            <em><?= get_woocommerce_currency_symbol() ?><?php the_sub_field('amount'); ?></em>
                                                            <small><?php the_sub_field('text'); ?></small>
                                                        </strong>
                                                        </li>
                                                        <?php endif; ?>
                                                    <?php endwhile; ?>
                                                    </ul>
                                                </div>
                                                <?php
                                                    /**
                                                     * woocommerce_single_product_summary hook.
                                                     *
                                                     * @hooked woocommerce_template_single_title - 5
                                                     * @hooked woocommerce_template_single_rating - 10
                                                     * @hooked woocommerce_template_single_price - 10
                                                     * @hooked woocommerce_template_single_excerpt - 20
                                                     * @hooked woocommerce_template_single_add_to_cart - 30
                                                     * @hooked woocommerce_template_single_meta - 40
                                                     * @hooked woocommerce_template_single_sharing - 50
                                                     */
                                                    do_action( 'woocommerce_single_product_summary' );
                                                ?>

                                            </div><!-- .summary -->
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!get_field('product_type') || get_field('product_type') === 'both' || get_field('product_type') === 'recurring'  ): ?>
                                    <div class="donation reucrringDonationTab tabContent-<?php echo($random_string); ?>" style="<?php if(get_field('recurring')): echo 'display:block;'; endif;?>" id="1-<?php echo($random_string); ?>">
                                        <div class="summary entry-summary">
                                            
                                            <div class="package__options">
                                               

                                                <form class="recurring_form recurring_form_<?php echo($random_string); ?>">

                                                <?php /*if(get_field('enable_sayed_drop_down')): ?>
                                                    <div class="sayed_section" class="ztrust-sayed-field-name-<?php echo($product_id); ?>">
                                                        <select name="sayed_option" id="ztrust-sayed-field-name-<?php echo($product_id); ?>" data-product-id="<?php echo($product_id); ?>" class="ztrust-sayed-field-name">
                                                            <option value="">Select</option>
                                                            <option value="I am a Sayed">I am a Sayed</option>
                                                            <option value="I am not a Sayed">I am not a Sayed</option>
                                                        </select>	
                                                    </div>
                                                <?php endif; ?>
                                                <input name="sayed_option_field" id="input_sayed_option_field_<?php echo($product_id); ?>" type="hidden" value="" />*/?>
                                                <ul class="package__listing">
                                                <?php /*
                                                <input type="text" name="quantity" value="1" class="form-control" />
                                                <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
                                                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
                                                <input type="hidden" name="hidden_id" value="<?php echo $row["id"]; ?>" /> */ ?>
                                                <?php while(has_sub_field('product_options')): ?>
                                                    <?php if(get_sub_field('recurring_amount')): ?>
                                                    <li class="package__listing_item_recurring" data-project-id="<?php echo($product_id); ?>" data-value="<?php the_sub_field('recurring_amount'); ?>">
                                                    <span class="inactive"></span> 
                                                    <strong>
                                                        <em><?= get_woocommerce_currency_symbol() ?><?php the_sub_field('recurring_amount'); ?></em>
                                                        <small><?php the_sub_field('text'); ?></small>
                                                    </strong>
                                                    </li>
                                                    <?php endif; ?>
                                                <?php endwhile; ?>
                                                    
                                                <li class="package__listing_item_recurring you_pay" 
                                                        data-project-id="<?php echo esc_attr($product_id); ?>">
                                                    <span class="inactive"></span> 
                                                    <strong>
                                                        <small>You Decide</small>    
                                                        <li class="package__listing_item_recurring you_pay"
                                                            data-project-id="<?php echo esc_attr($product_id); ?>"
                                                            data-value="<?php the_sub_field('recurring_amount'); ?>">
                                                        <span class="inactive"></span>
                                                        <strong>
                                                            <small>You Decide</small>
                                                            <input
                                                            required
                                                            type="number"
                                                            min="1"
                                                            step="1"                            
                                                            class="recurring_donation your_price_recurring_<?php echo esc_attr($product_id); ?>"
                                                            value=""                                
                                                            placeholder="Enter 1 or more"
                                                            />
                                              
                                                    </strong>
                                                    </li>


                                                </ul>
                                                
                                                <?php /*if(get_field('enable_multiple_donations')): ?>
                                                    <div class="quantity">
                                                        <select name="multiple_donations" id="multiple_heading" class="multiple_donations" data-project-id="<?php echo($product_id); ?>">
                                                            <option value="1"><?php the_field('multiple_heading'); ?></option>
                                                        <?php for($i=1;$i<=10;$i++){ ?>
                                                            <option value="<?php echo $i; ?>" data-project-id="<?php echo($product_id); ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                <?php endif;*/ ?>
                                                
                                                <div class="button_wrapper">
                                                    <button type="submit" class="recurring_add_to_cart_button button alt" data-title="<?php the_title(); ?>" data-button-id="<?php echo $product_id; ?>">Donate Now</button>
                                                </div>
                                                </form>
                                               

                                            </div>
                                            

                                        </div><!-- .summary -->
                                    </div>
                                    <?php endif; ?>

                                    

                                    
                                </div><!-- tab-content -->

                            </div><!-- product wrapper -->

                        </div>

                <?php endwhile; ?>
                <?php wp_reset_query(); 
            
            ?>

            

    </div>
    <script type="text/javascript">
        //Single functions
        <?php if($overlay_option === FALSE): ?>
        jQuery('body').removeClass('popup_active');
        <?php endif; ?>
        
        // function validateForm(){
        //     alert('yes');
        // }
        
        // jQuery(document).on('submit','.recurring_form', function(){
        //     alert('yes');
        // });

        // jQuery(document).on("click", '.recurring_add_to_cart_button', function(e){
        //     $project_id = jQuery(this).data('button-id');
        //     if(!jQuery('.your_price_recurring_'+$project_id).val()){
        //         e.preventDefault();
        //         return false;
        //     }
           
        // });

        jQuery(document).on("click", '.close-project-popup', function(event){
            jQuery('#product_details_box').removeClass('active');
            jQuery('.product__listing').removeClass('active');
            jQuery('body').removeClass('popup_active');

            //jQuery('body').removeClass('popup_active');
            event.preventDefault();
        });

        function update_price_field($product_id,$amount){
            jQuery('.pyppledgeamount'+$product_id).val($amount);
        }

        jQuery(document).on("click", '.package__listing_item', function(event){
            jQuery('.package__listing_item').removeClass('active');
            jQuery('.payyourprice_customize_class').removeClass('active');

            jQuery(this).addClass('active');
            $projectID = jQuery(this).data('project-id');
            $projectAmount = jQuery(this).data('value');
            
            update_hidden_pricehandle_field(<?php echo $product_id; ?>);

            
            //Pass values to function
            update_price_field($projectID,$projectAmount);
            event.preventDefault();
        });


        function update_hidden_pricehandle_field($product_id){
            $pricehandledescription = jQuery('.singleDonationTab.tabContent-<?php echo($random_string); ?> .package__listing li.active strong small').text();
            console.log($pricehandledescription);
            jQuery('#ztrust-pricehandle-field-name-'+$product_id).val($pricehandledescription);
        }
        
        // jQuery(document).on("change", '.multiple_donations', function(event){
        //     $projectID = <?php echo $product_id; ?>;
        //     $currentValue = jQuery('.your_price_recurring_'+$projectID).val();
        //     $projectAmount = jQuery(this).val()*$currentValue;
        //     console.log($projectID);
        //     console.log($currentValue);
        //     console.log($projectAmount);
            
        //     jQuery('.your_price_recurring_'+$projectID).val($projectAmount);
        //     //Pass values to function
        //     // update_price_field($projectID,$projectAmount);
        //     event.preventDefault();
        // });

        jQuery(document).on("click", '.payyourprice_customize_class', function(event){
            jQuery('.package__listing_item').removeClass('active');
            jQuery(this).addClass('active');
        });

        jQuery(document).on("click", '.payyourprice_contribution', function(event){
            jQuery('.package__listing_item').removeClass('active');
            jQuery('.add__to_cart_wrap').find('.payyourprice_customize_class').addClass('active');
            //jQuery(this).addClass('active');
        });

        jQuery('.payyourprice_customize_class').addClass('active'); 
        jQuery('.you_pay').addClass('active'); 
        
        
        //Recurring Functions
        function update_price_field_recurring($product_id,$amount){
            jQuery('.your_price_recurring_'+$product_id).val($amount);
        }

        jQuery(document).on("click", '.package__listing_item_recurring', function(event){
            // If the click originated on the <input> (or its spinner), skip this handler.
            if ( jQuery(event.target).is("input") ) {
                return;
            }

            jQuery('.package__listing_item_recurring').removeClass('active');
            jQuery(this).addClass('active');

            var projectID     = jQuery(this).data('project-id');
            var projectAmount = jQuery(this).data('value');
            update_price_field_recurring(projectID, projectAmount);

            event.preventDefault();
        });


        jQuery('.ztrust-sayed-field-name').on('change', function() {
            $project_id = jQuery(this).data('product-id');
            $selected_sayed_value = jQuery(this).val();
            // alert($selected_sayed_value);
            jQuery('#input_sayed_option_field_'+$project_id).val($selected_sayed_value);
        });



        jQuery('.recurring_add_to_cart_button').click(function(event){
            $project_id = jQuery(this).data('button-id');
            $amount = jQuery('.your_price_recurring_'+$project_id).val();
            $title = jQuery(this).data('title');
            $sayed_option = jQuery('#input_sayed_option_field_'+$project_id).val();

            load_the_project_add_to_cart_recurring($project_id,$amount,$title,$sayed_option);
            <?php if(isMobile()): ?>
                lockBody('remove');
                jQuery('.quick__donate').addClass('hide');
                jQuery('.donate_trigger_search').removeClass('inactive');
                jQuery('.donate_trigger_cart').removeClass('inactive');
                jQuery('.header').removeClass('inactive');
                jQuery('.donate_trigger_mobile').removeClass('active');
            <?php endif; ?>
            event.preventDefault();
        });

        <?php if(isMobile()): ?>
        jQuery('.single_add_to_cart_button').click(function(event){
            lockBody('remove');
            jQuery('.quick__donate').addClass('hide');
            jQuery('.donate_trigger_search').removeClass('inactive');
            jQuery('.donate_trigger_cart').removeClass('inactive');
            jQuery('.header').removeClass('inactive');
            jQuery('.donate_trigger_mobile').removeClass('active');
        });
        <?php endif; ?>
        

        function load_the_project_add_to_cart_recurring($project_id, $donation_amount, $title, $sayed_option){
            jQuery.ajax({
                url:  '<?php echo get_stylesheet_directory_uri(); ?>/modules/inc/ajax/ajaxRecurringCartAdd.php',
                data: 'action=add_recurring_to_cart&project_id='+$project_id+'&amount='+$donation_amount+'&title='+$title+'&sayed_option='+$sayed_option,
                type: 'POST',
                beforeSend:function(xhr){
                    //ajax_before();
                },
                success:function(data){
                    //ajax_after();
                    jQuery('#recurring_project_add').addClass('active');
                    jQuery('#recurring_project_add').html(data);
                },
                error : function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
            return false;
        }


    </script>
<?php  die();
}
add_action('ZTRUST_AJAX_loadproject', 'load_project_function');
add_action('ZTRUST_AJAX_nopriv_loadproject', 'load_project_function');
?>