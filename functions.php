<?php



    add_action('wp_head','zahratrust_custom_css');
    
    /**
     * Remove related products output
     */
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    

    function zahratrust_custom_css(){
        echo "<style>
        .site-container {
            margin: 0 auto !important;
            font-size: 2rem;
            line-height: 3rem;
            color: #434343;
            font-weight: 400;
        }
    
        </style>
        ";
    }
    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', time() );
    function my_theme_enqueue_styles() {
        wp_enqueue_style( 'child-style', get_stylesheet_uri() );
    }

    // Include header scripts

    function w3plus_ajax_scripts() {


        ?>

            <script type="text/javascript">
                var $ajaxurl = '<?php echo get_stylesheet_directory_uri(); ?>/modules/inc/customajax.php';
                console.log($ajaxurl);
            </script>

            <!-- Meta Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1255659082168997');
            fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1255659082168997&ev=PageView&noscript=1"
            /></noscript>
            <!-- End Meta Pixel Code -->

            <?php
        if ( ! is_page(8) && ! is_page(7) && ! is_page(428) ) {

            //include_once('modules/inc/header/head.php');
            ?>


    <?php if(!get_field('hide_quick_donation_completely')) {
         ?>
         <div class="gutenberg__wrap">
    <div class="quick__donate <?php if( get_field('quick_donation_visibility') && !ismobile() ): else: ?>hide<?php endif; ?>">

        <a href="#" class="<?php if(isMobile()){ echo 'close_donation_mobile'; }else{ echo 'close_donation'; } ?>" id="close_donation">
            <svg enable-background="new 0 0 40 40" version="1.1" viewBox="0 0 40 40" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Web"><g id="Tabs_3_"></g><g id="Male_2_"></g><g id="Female_1_"></g><g id="Unshare_2_"></g><g id="Share_2_"></g><g id="More_4_"></g><g id="New_Window_3_"></g><g id="Edit_5_"></g><g id="Checked_3_"></g><g id="Unchecked_2_"></g><g id="Menu_Alt_1_"></g><g id="Menu_6_"></g><g id="Hand_Cursor_2_"></g><g id="Type_Cursor_2_"></g><g id="Tag_Minus_4_"></g><g id="Tag_Plus_4_"></g><g id="Tag_2_"></g><g id="Options_2_"></g><g id="List_Alt_2_"></g><g id="List_2_"></g><g id="Grid_Small"></g><g id="Grid_Big"></g><g id="Log_Out_3_"></g><g id="Log_In_3_"></g><g id="Upload_8_"></g><g id="Download_8_"></g><g id="Export_1_"></g><g id="Import_1_"></g><g id="Userlist"></g><g id="User_Star"></g><g id="User_Down"></g><g id="User_Up"></g><g id="User_Minus"></g><g id="User_Plus"></g><g id="Like_3_"></g><g id="Dislike_3_"></g><g id="Unlock"></g><g id="Lock"></g><g id="More_Windows_9_"></g><g id="External_Link_9_"></g><g id="Grid_System"></g><g id="Image_5_"></g><g id="Table_3_"></g><g id="Embed_Close_2_"></g><g id="Embed_2_"></g><g id="QR_2_"></g><g id="Translate_6_"></g><g id="Global_7_"></g><g id="Trash_4_"></g><g id="Nut_3_"></g><g id="Gauge"></g><g id="Sliders_3_"></g><g id="Tools"></g><g id="Gears_3_"></g><g id="Gear_2_"></g><g id="Arrow_Keys"></g><g id="Ban_2_"></g><g id="Warning"></g><g id="Remove_2_"><g id="Remove"><g><polygon clip-rule="evenodd" fill-rule="evenodd" points="30,12.8 27.2,10 20,17.2 12.9,10.1 10.1,12.9 17.2,20       10,27.2 12.8,30 20,22.8 27.1,29.9 29.9,27.1 22.8,20     "></polygon></g></g></g><g id="OK_2_"></g><g id="Search_4_"></g><g id="Zoom_In_5_"></g><g id="Zoom_Out_5_"></g><g id="Social_Network_5_"></g><g id="Anchor_2_"></g><g id="Link_4_"></g><g id="Cloud_Camera_6_"></g><g id="Cloud_Up_4_"></g><g id="Cloud_Down_4_"></g><g id="Cloud_Tunes"></g><g id="Broadcast_4_"></g><g id="Filter_3_"></g><g id="Paper_Plane_3_"></g><g id="Star_Fill_2_"></g><g id="Star_Stroke_3_"></g><g id="Heart_Fill_2_"></g><g id="Heart_Stroke_1_"></g><g id="Chat_Convo_Alt"></g><g id="Chat_Type_Alt"></g><g id="Chat_Alert_Alt"></g><g id="Chat_Alt"></g><g id="Chat_Convo"></g><g id="Chat_Type"></g><g id="Chat_Alert"></g><g id="Chat"></g><g id="Home_3_"></g></g><g id="Lockup"></g></svg>
        </a>
        
        <div class="donation__box">
            <span class="quick_donation_label">
                <?php the_field('quick_donation_label','option'); ?>
            </span>
            <div class="quick_donation_container">
                <select class="select_project_name">
                    <option value="">Select a fund</option>
                    <?php $products_listing = get_field('projects','option'); ?>
                    <?php foreach( $products_listing as $project_id): ?>
                        <option value="<?php echo $project_id; ?>" data-project-id="<?php echo $project_id; ?>"><?php echo get_the_title($project_id); ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="quick_donation">
                    <p><span><svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"></rect></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "></polygon></g></svg></span> Select a fund</p>
                </div>

            </div>
        </div>
        
        <script>

        function load_the_project_quickdonate($project_id){
            console.log($project_id);
            jQuery.ajax({
                url:  $ajaxurl,
                data: 'action=loadproject&project_id='+$project_id,
                type: 'POST',
                beforeSend:function(xhr){
                    // ajax_before();
                },
                success:function(data){
                    // ajax_after();
                    jQuery('#quick_donation').addClass('active');
                    jQuery('#quick_donation').html(data);
                }

            });
            return false;
        }

        jQuery(function () {
            jQuery("select.select_project_name").change();
        });

        jQuery('.select_project_name').change( function(event){
            var productID = jQuery(this).val();
            console.log(productID);
            load_the_project_quickdonate(productID);
            event.preventDefault();
        });

        </script>
    </div>
    

    <a href="#" class="donateTrigger button till quick__donate_button <?php if( get_field('quick_donation_visibility') && !ismobile() ): else: ?>active<?php endif; ?>">
        <svg id="Layer_1" style="enable-background:new 0 0 1024 1024;" version="1.1" viewBox="0 0 1024 1024" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="XMLID_264_"><path d="M667.8,601.8c0.6,1,1.2,2.1,1.8,3.1c1.7,2.6-0.9,1.3-0.3-1.2c-0.3,1.1,1.5,4.7,1.8,5.9c0.2,0.9,1,4.7,0.3,1   c-0.7-3.4-0.1-0.7-0.1,0.1c0,1.1,0,2.3,0,3.4c0.2,5.2,1-3.6,0.3-0.8c-0.5,1.9-0.9,3.8-1.4,5.7c-1.1,4.2,0.1-0.8,0.7-1.2   c-0.5,0.3-1.2,2.4-1.6,3.1c-0.7,1.2-1.4,2.3-2.2,3.5c-0.4,0.7-2.1,2.8,0.2-0.1c2.5-3.3-0.3,0.2-0.9,0.8c-1.8,1.9-6.1,4.1-0.4,0.9   c-1.5,0.8-2.8,1.9-4.3,2.8c-0.8,0.5-1.7,0.9-2.6,1.4c-2.2,1.3,2.7-1.1,2.6-1.1c-2,0.3-4.3,1.4-6.3,1.9c-5.9,1.3,4.4-0.1,0.1,0   c-1.6,0-3.1,0.1-4.7,0.1c-3.1,0-6.1,0.1-9.2,0.1c-29.1,0.3-58.1,0.2-87.2,0.1c-13.6-0.1-27.2-0.1-40.8-0.3   c-13.1-0.1-25.6,11.6-25,25c0.6,13.6,11,24.9,25,25c29.6,0.2,59.1,0.4,88.7,0.4c15.1,0,30.1-0.1,45.2-0.3   c9.5-0.1,19.2-0.6,28.2-4.1c10.8-4.2,20.9-10.2,28.4-19.3c19-23,23-55,6.9-81c-6.9-11.1-22.6-16.4-34.2-9   C665.7,574.8,660.5,589.9,667.8,601.8L667.8,601.8z" id="XMLID_7_"/><path d="M267.2,635.5c17.9-18,35.8-36,53.8-54c2.3-2.3,4.5-4.6,6.8-6.9c0.5-0.5,1-0.9,1.5-1.4   c0.7-0.6,4.7-3.8,1.7-1.5c-3.1,2.4,2.3-1.6,2.9-2c1.7-1.2,3.5-2.3,5.2-3.3c3-1.8,6-3.5,9.1-5c1.5-0.8,3-1.5,4.6-2.2   c0.7-0.3,1.6-0.6,2.3-1c-1.2,0.7-4.4,1.7-1.3,0.6c6.8-2.5,13.7-4.7,20.8-6.2c1.6-0.3,3.3-0.7,4.9-1c0.8-0.1,1.7-0.2,2.5-0.4   c2.8-0.5-2.6,0.3-2.5,0.3c3.6-0.2,7.2-0.8,10.8-0.9c7.2-0.3,14.5-0.1,21.7,0.7c0.8,0.1,1.7,0.2,2.5,0.3c0,0-5.3-0.9-2.5-0.3   c1.6,0.3,3.3,0.6,5,0.9c3.6,0.7,7.1,1.5,10.7,2.5c11.6,3.2,22.8,8,33.9,12.3c14.8,5.7,29.6,11.4,44.4,17c4,1.5,7.9,3.2,11.9,4.6   c12.5,4.3,26.7,5.8,39.8,6.1c10,0.3,20,0.1,30,0.1c16.1,0,32.1,0,48.2,0c5.1,0,10.2,0,15.3,0c0.8,0,1.6,0,2.4,0   c1.2,0,2.5,0.2,3.7,0.2c2.7,0-3.1-0.4-3-0.4c0.6,0.3,1.5,0.3,2.2,0.4c1.4,0.3,2.8,0.7,4.2,1.2c5.2,1.8-3.4-2,0,0   c1.4,0.8,2.9,1.8,4.3,2.6c2.2,1.2-2.1-1.7-2.1-1.7c0.4,0.5,1.1,1,1.7,1.4c1.1,1,2.1,2,3.1,3.1c3.7,4.1-2.2-3.3,0.1,0.2   c7.6,11.3,21.8,16,34.2,9c21.1-12,42.2-24,63.2-36.2c10.3-5.9,17.6-14.5,25.6-23c10.3-10.9,20.5-21.9,30.8-32.8   c4.3-4.6,8.8-9.2,13.4-13.6c2.2-2.1,4.4-4.2,6.7-6.1c0.6-0.5,1.2-0.9,1.7-1.4c2-1.8-2.3,1.7-2.1,1.6c1.5-0.8,2.8-2,4.2-2.9   c1.5-0.9,2.9-1.8,4.5-2.6c0.7-0.3,1.4-0.6,2-1c2.3-1.2-2.5,1-2.5,1c3.2-0.3,6.9-2,10.1-2.8c2.7-0.6-2.3,0.4-2.4,0.3   c0.5,0.2,2-0.1,2.6-0.2c1.6-0.1,3.2-0.1,4.8,0c1.1,0,6.2,0.6,1.6,0c-4.6-0.6,1.4,0.5,2.4,0.8c0.3,0.1,1.6,0.3,1.8,0.6   c0.3,0.4-5.4-2.7-3.1-1.3c1.1,0.6,2.2,1.1,3.3,1.7c0.9,0.5,4.5,3.2,1.2,0.6c-3.4-2.8,0.8,0.8,1.6,1.5c1.8,1.7,4.2,5.5,6.4,6.5   c-0.3-0.1-2.6-4-1.5-1.8c0.3,0.7,0.8,1.4,1.2,2c2.2,3.4-0.4-0.9-0.5-1.7c0.1,0.9,0.7,2,1,3c0.2,0.7,0.3,1.5,0.5,2.3   c0.8,2.4-0.3-2.7-0.3-2.8c-0.3,1.3,0.1,3.2,0.1,4.6c0,4.4,1.3-4.8,0.1-0.6c-0.3,1-2.1,6.6-0.7,2.8c1.4-3.7-0.9,0.9-1.3,1.8   c-1,2.1,3.4-3.9,0.5-0.6c-0.1,0.1-0.2,0.3-0.3,0.4c-0.7,0.8-1.3,1.6-2,2.4c-2.9,3.5-5.9,6.9-8.8,10.4   c-9.8,11.6-19.7,23.2-29.5,34.8c-15.4,18.2-30.4,37-46.4,54.7c-5.5,6.1-11.9,11.4-17.8,17c-11.8,11.2-23.7,22.3-35.5,33.5   c-6.8,6.4-13.5,12.9-20.4,19.2c-2.4,2.2-4.8,4.4-7.4,6.5c-0.6,0.5-1.4,1-1.9,1.5c0,0,4.1-3,1.8-1.4c-1.5,1.1-3,2.2-4.6,3.3   c-5.7,4-11.7,7.6-18,10.8c-2.8,1.5-6,2.6-8.7,4.1c-0.1,0,4.9-1.9,2.3-1c-0.8,0.3-1.5,0.6-2.2,0.9c-1.7,0.7-3.5,1.3-5.3,1.9   c-6.6,2.3-13.3,4.1-20.2,5.4c-1.6,0.3-3.2,0.6-4.8,0.9c-0.8,0.1-1.6,0.2-2.4,0.4c-0.1,0,5.5-0.6,2.6-0.4c-3.5,0.4-7,0.7-10.5,0.9   c-4.4,0.2-8.9,0.3-13.3,0.1c-2.9-0.1-5.7-0.2-8.6-0.3c-13.8-0.4-27.7-0.9-41.5-1.3c-24.4-0.8-48.7-1.8-73.1-2.3   c-16.2-0.3-32.8,3.9-46.7,12.2c-6.3,3.8-11.9,8.7-17.6,13.3c-11.8,9.6-23.6,19.3-35.4,28.9c-2.8,2.3-5.6,4.6-8.4,6.8   c-10.2,8.3-9.3,26.8,0,35.4c10.8,9.9,24.5,8.9,35.4,0c9.3-7.6,18.6-15.2,27.9-22.8c5.7-4.6,11.4-9.3,17-13.9c1.2-1,2.5-2,3.7-3   c0.1-0.1,0.1-0.1,0.2-0.2c0,0-2.4,1.9-2.4,1.9c0.6-0.2,1.5-1.1,2-1.4c1.4-0.9,2.8-1.8,4.2-2.6c1-0.5,1.9-1.1,2.9-1.5   c0.7-0.3,4.2-2,0.8-0.4c-3.5,1.5,1.5-0.4,2.4-0.7c1.6-0.5,3.2-0.9,4.8-1.3c0.8-0.2,1.6-0.3,2.4-0.5c2.4-0.5,2.4,0.8-1.7,0.2   c1.8,0.2,4-0.3,5.8-0.3c1.3,0,2.6,0,3.9,0.1c3.9,0.1,7.8,0.2,11.7,0.4c15.1,0.5,30.2,0.9,45.2,1.4c15.9,0.5,31.9,1,47.8,1.5   c10.1,0.3,20.4,0.9,30.5,0.4c31.2-1.7,62.1-11,88.4-28.1c13.4-8.7,25.1-19.4,36.7-30.4c20.2-19.1,40.5-38.1,60.6-57.3   c4.4-4.2,8.1-9.2,12.1-13.8c9.7-11.5,19.4-22.9,29.1-34.4c16.1-19,32.2-38,48.2-57c10.5-12.4,17.7-27.6,16-44.3   c-1-10.1-3.6-20.1-9.6-28.5c-5.3-7.4-11.3-13.4-18.5-18.9c-12.9-10-29.4-14.4-45.7-12.7c-19.4,2-35.3,9.7-50.1,22.2   c-11,9.4-20.8,20.5-30.7,31c-10.1,10.8-20.3,21.6-30.4,32.4c-0.7,0.7-1.4,1.4-2.1,2.2c-0.6,0.7-2.6,1.8,0.1,0.2   c3.1-1.9,0,0-0.8,0.4c-0.3,0.2-0.5,0.3-0.8,0.5c-0.4,0.2-0.7,0.4-1.1,0.6c-4.7,2.7-9.4,5.3-14,8c-13.8,7.9-27.5,15.7-41.3,23.6   c-2.8,1.6-5.6,3.2-8.4,4.8c11.4,3,22.8,6,34.2,9c-9.8-14.6-24.4-26.3-41.9-30c-6.8-1.4-13.5-1.8-20.4-1.8c-14.5,0-29.1,0-43.6,0   c-13.5,0-27.1,0-40.6,0c-1,0-2,0-3,0c-2.8,0-5.5-0.1-8.3-0.3c-1.8-0.1-3.7-0.3-5.5-0.5c-0.9-0.1-4.9-0.5-1.2-0.1   c3.6,0.3-0.5-0.1-1.2-0.3c-6.2-1.1-12.1-2.6-18-4.8c-24.4-9.4-48.8-18.9-73.3-28.1c-29.4-11.1-61.9-12.9-92.6-6.3   c-25.3,5.4-51.7,17.8-70.2,36.1c-19.3,19.2-38.4,38.6-57.6,57.9c-0.6,0.6-1.1,1.2-1.7,1.7c-9.2,9.3-10,26.2,0,35.4   C241.8,644.6,257.4,645.4,267.2,635.5L267.2,635.5z" id="XMLID_6_"/><path d="M419.6,828.4c-23.2,21.6-46.4,43.3-69.6,64.9c-1.8,1.7-3.6,3.4-5.4,5.1c-0.5,0.4-1,0.8-1.4,1.3   c-1.6,1.8,4.2-2.4,1.8-1.4c-1,0.4-3.5,2.4-0.1,0.2c3.8-2.4-2.3-0.1,2.4-0.7c4.2-0.5,1-0.3,0-0.2c-2.5,0.3,3.5,0.5,3.3,0.5   c-3.6-0.6,1.6,0.8,2.1,1.2c0,0-2.2-1.4-2.4-1.4c2.5-0.1,3.9,3.6,1.8,1.1c-0.3-0.4-0.6-0.7-1-1c-5.5-5.8-10.9-11.7-16.4-17.6   c-24.3-26-48.6-52.1-72.9-78.1c-27.3-29.3-54.6-58.5-81.9-87.8c-9.3-10-18.7-20-28-30c-3.4-3.7-6.8-8.7-10.9-11.7   c0.2,0.2,3.7,5,1.4,1.7c-0.9-1.4-1.3-4.2,0.9,2.2c-1.4-4.1,0.5,6,0.1,0.7c-0.2-3.1-1.2,5.7-0.3,2.7c0.9-3-2.7,4.8-1.1,2.2   c3.1-4.8-3.4,2.8-0.1,0c0.9-0.7,1.6-1.5,2.5-2.3c5-4.7,10.1-9.4,15.1-14.1c14.6-13.6,29.2-27.2,43.8-40.9   c4.6-4.3,9.2-8.6,13.9-12.9c0.4-0.4,1-0.7,1.3-1.2c0.9-1.3-5.3,3.8-0.7,0.8c2.6-1.7-5.1,1.8-2.2,1c2.4-0.6-3.3,0.5-3.3,0.3   c0-0.3,2.4,0.1,2.7,0c-3.3,1.2-5.4-1.1-2.7-0.2c-6.3-2.2-3.7-1.8-2.2-0.9c2.5,1.5-0.5,0.8-1.7-1.4c0.3,0.5,0.9,0.9,1.3,1.4   c7.4,8.5,15.4,16.5,23.1,24.7c19.1,20.5,38.2,41,57.4,61.5c26.9,28.8,53.7,57.6,80.6,86.4c14.9,16,29.9,32,44.8,48.1   c1.5,1.6,3,3.9,4.8,5.2c0.1,0.1-2.1-2.8-2.1-2.8c0,0,1.2,2.3,1.4,2.4c-0.6-0.4-1.8-5.8-1.2-2.1c0-0.2-0.6-6.7-0.4-2.6   c0.1,2.1-1.1,3.4,0.5-2.6c-0.3,1.1-1.1,2.7,0.4-0.4c1.9-3.7,0.2-0.8-0.2,0.1C417.5,832.5,423.1,824.9,419.6,828.4   c-9.2,9.3-10,26.2,0,35.4c10,9.1,25.5,9.9,35.4,0c10.7-10.7,15.1-25.6,12.1-40.5c-1.7-8.4-6.2-15.4-11.9-21.7   c-6.2-6.7-12.5-13.4-18.7-20c-4.8-5.1-9.6-10.3-14.4-15.4c-24.7-26.5-49.4-53-74.2-79.5c-24.4-26.2-48.8-52.4-73.3-78.6   c-5.1-5.4-10.1-10.9-15.2-16.3c-6.9-7.4-13.4-15.4-21.6-21.3c-17.2-12.3-40.1-7.9-54.9,5.6c-24.8,22.7-49.2,45.9-73.8,68.8   c-11.1,10.3-16.9,24.1-14.9,39.3c1.4,10.1,6.2,18.4,13,25.7c6.3,6.7,12.5,13.4,18.8,20.2c25.8,27.7,51.6,55.4,77.4,83   c27.5,29.5,55,59,82.5,88.5c8.4,9,16.8,18,25.2,27c1.7,1.9,3.5,3.8,5.2,5.6c12.2,12.8,31.4,17.2,47.8,10.3   c7.8-3.3,13.6-8.6,19.7-14.2c6.2-5.8,12.5-11.6,18.7-17.5c14.7-13.7,29.5-27.5,44.2-41.2c2.7-2.5,5.5-5.1,8.2-7.6   c9.6-8.9,9.7-26.4,0-35.4C444.7,818.9,429.8,818.8,419.6,828.4z" id="XMLID_5_"/><path d="M722.7,317.2c0,3.3-0.1,6.5-0.3,9.8c-0.1,1.6-0.3,3.2-0.4,4.8c-0.1,0.7-0.2,1.4-0.2,2.1   c-0.5,5,0.8-4.8,0.2-1.9c-1.2,6.5-2.4,12.8-4.3,19.1c-0.9,3-1.9,5.9-3,8.9c-0.4,1.1-2.4,6-0.7,1.9c1.7-4.1-0.6,1.3-1.2,2.5   c-2.7,5.8-5.8,11.3-9.3,16.7c-1.7,2.6-3.5,5-5.2,7.5c-2.5,3.4,3.7-4.4,0.3-0.4c-1.1,1.3-2.2,2.7-3.4,4c-4.2,4.7-8.7,9.2-13.4,13.4   c-1.2,1-2.3,2-3.5,2.9c-4,3.4,3.8-2.7,0.4-0.3c-2.7,1.9-5.3,3.8-8.1,5.6c-5.4,3.4-10.9,6.5-16.7,9.2c-1,0.5-5.9,2.6-1.9,0.9   c4.1-1.7-0.9,0.3-2,0.7c-3.1,1.2-6.3,2.2-9.5,3.2c-6.3,1.9-12.8,2.6-19.2,4.2c-0.4,0.1,6-0.7,3.2-0.4c-0.9,0.1-1.8,0.2-2.7,0.3   c-1.6,0.2-3.2,0.3-4.8,0.4c-3.5,0.2-7,0.3-10.5,0.3c-3.3,0-6.5-0.1-9.8-0.4c-1.6-0.1-3.2-0.3-4.8-0.4c-0.7-0.1-1.4-0.2-2.1-0.2   c-3.2-0.3,6.2,1,1.9,0.2c-6.5-1.1-12.8-2.5-19.1-4.4c-3-0.9-5.9-1.9-8.8-3c-1.9-0.7-6.4-3.2,0.4,0.3c-1.6-0.8-3.2-1.4-4.8-2.2   c-5.7-2.7-11.3-5.9-16.6-9.4c-2.6-1.7-5-3.5-7.5-5.3c-2.2-1.5,2.7,2.2,2.5,1.9c-0.6-0.6-1.4-1.1-2-1.6c-1.3-1.1-2.7-2.2-4-3.4   c-4.7-4.2-9.2-8.7-13.3-13.5c-1-1.2-2-2.3-2.9-3.5c-2.7-3.2,3.7,5,0.3,0.4c-1.9-2.7-3.8-5.3-5.6-8.1c-3.4-5.4-6.5-11-9.1-16.8   c-0.9-1.9-2.1-6.7,0.1,0.5c-0.5-1.5-1.2-2.9-1.7-4.3c-1.2-3.1-2.2-6.3-3.1-9.5c-0.9-3-1.7-6.1-2.3-9.1c-0.3-1.3-0.6-2.7-0.8-4   c-0.2-1.1-1.2-8.2-0.6-3.4c0.6,4.7-0.1-1.2-0.2-2.1c-0.1-1.4-0.3-2.8-0.3-4.1c-0.3-3.7-0.4-7.4-0.3-11.1c0-6.3,0.7-12.5,1.2-18.7   c0.3-2.8-0.5,4-0.5,3.5c0-0.8,0.3-1.8,0.4-2.5c0.2-1.3,0.4-2.5,0.6-3.8c0.6-3.3,1.3-6.7,2.1-10c1.4-5.7,3-11.4,4.9-17   c0.9-2.8,2-5.5,3-8.3c0.5-1.4,1.1-2.7,1.6-4.1c1.1-2.8-2.3,5.3-1.1,2.5c0.4-0.9,0.8-1.9,1.3-2.9c4.9-11,10.7-21.5,17.1-31.7   c3-4.8,6.2-9.6,9.5-14.2c1.6-2.3,3.3-4.6,5-6.8c0.6-0.8,3.8-5,0.9-1.3c-2.9,3.8,1-1.3,1.7-2.1c6.8-8.4,13.9-16.5,21.3-24.4   c12.5-13.2,25.8-25.5,39.9-37c2.6-2.1,5.2-4.2,7.9-6.3c1-0.8,3.5-2.7-0.6,0.4c-4.1,3.2-1.6,1.3-0.7,0.5c1.1-0.8,2.1-1.6,3.2-2.4   c2.6-2,5.4-3.8,8-5.8c0.4-0.3,0.7-0.5,1.1-0.7c-8.4,0-16.8,0-25.2,0c1.2,0.9,2.5,1.8,3.7,2.7c0.6,0.4,1.2,0.9,1.8,1.3   c3,2.2-6.3-4.9-2.2-1.7c1.9,1.5,3.8,3,5.7,4.5c11.5,9.3,22.6,19.2,33.2,29.5c14.3,13.9,27.1,28.8,39.8,44.1c0.3,0.4-3.6-4.8-2-2.6   c0.4,0.5,0.7,1,1.1,1.5c0.7,1,1.5,2,2.2,2.9c1.7,2.3,3.4,4.7,5.1,7c3.1,4.4,6.1,8.9,9,13.5c5.9,9.4,11.4,19.2,16.1,29.3   c0.6,1.3,1.2,2.7,1.8,4c0.3,0.8,0.6,1.6,1,2.3c-0.2-0.5-2.3-5.6-1.1-2.5c1.2,2.9,2.3,5.9,3.4,8.8c2.1,5.7,3.9,11.6,5.3,17.5   c0.8,3,1.5,6.1,2.1,9.2c0.3,1.4,0.5,2.9,0.8,4.3c0.4,2.1,0.8,8.1,0-0.4C722.1,304.6,722.7,310.9,722.7,317.2   c0.1,13.1,11.5,25.6,25,25c13.5-0.6,25.1-11,25-25c-0.2-49.5-21.7-96.5-50.6-135.8c-23-31.3-49.9-59.6-79.9-84.3   c-7.3-6-14.6-11.9-22.3-17.4c-6.8-4.8-18.4-4.6-25.2,0c-22,14.7-42.4,32.5-61.1,51.1c-36.7,36.7-68.8,80.8-83.6,131.1   c-8.6,29.2-10.5,60.2-4.4,90.1c6,29.6,21.3,57.5,42,79.4c42.9,45.3,111.3,63,170.7,43.2c57.8-19.3,103.5-70.3,112.2-131.3   c1.2-8.7,2.2-17.3,2.2-26c0.1-13.1-11.5-25.6-25-25C734.1,292.8,722.8,303.2,722.7,317.2z" id="XMLID_4_"/></g></svg>
        Quick Donate
    </a>
    </div>

            <?php
            } else {

            include_once('modules/inc/header/head_checkout.php');

            }
        }
    }

    add_action('wp_head', 'w3plus_ajax_scripts', time());

    function enqueue_wc_cart_fragments() {
        wp_enqueue_script( 'wc-cart-fragments' );
    }

    add_action( 'wp_enqueue_scripts', 'enqueue_wc_cart_fragments', time() );


    //Include Gutenberg Custom Blocks
    require_once('modules/inc/gutenberg_blocks.php');

    //Include custom functions
    require_once('modules/admin/custom-functions.php');

    //Include duplicate post functions
    require_once('modules/admin/duplicate_post.php');

    //Include Ajax Template Feeder
    //require_once('modules/inc/ajax/ajaxLoadItems.php');

    //Include Clean up file
    require_once('modules/admin/clean-up.php');

    //Hide Admin user
    //require_once('modules/admin/hide_admin.php');

    //Include WP Dashboard

    require_once('modules/admin/dashboard.php');

    //Include Image Resize
    require_once('modules/admin/image_resize.php');

    //Include Browser Detect
    require_once('modules/admin/browser-detect.php');

    //Include ACF local file
    require_once('modules/admin/acf.json.php');

    //Include Ajax Search feed
    //include('modules/inc/ajax/search.php');

    //Include Ajax Project Load
    include('modules/inc/ajax/ajaxLoadProjectPopup.php');

    //Include Ajax Cart Pop-up
    include('modules/inc/ajax/ajaxLoadCartPopup.php');

    //Include Ajax Cart Total
    include('modules/inc/ajax/ajaxLoadCartTotal.php');

    //Include Ajax login register functions file
    include('modules/inc/ajax/ajaxLoginRegister.php');

    //Include Ajax search file
    include('modules/inc/ajax/search.php');

    //Include Ajax Login loading
    //include('modules/inc/ajax/ajaxLoadLogin.php');

    //Include Checkout recurring page
    // include('modules/inc/ajax/ajaxrecurringCheckout.php');

    //Include Checkout recurring Submit page
    // include('modules/inc/ajax/ajaxrecurringCheckoutSubmit.php');

    //Include Ajax Checkout Steps
    include('modules/inc/ajax/ajaxLoadCheckoutSteps.php');

    //Include Woocommerce Functions
    include('modules/inc/woocommerce_function.php');

//add_action('wp_footer', 'push_purchase_event_to_datalayer');

function push_purchase_event_to_datalayer() {
    if (!is_order_received_page()) return;
    if (!function_exists('wc_get_order')) return;

    $order_id = absint(get_query_var('order-received'));
    if (!$order_id) return;

    $order = wc_get_order($order_id);
    if (!$order) return;

    $items = [];
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        $items[] = [
            'item_name' => $item->get_name(),
            'item_id'   => $product ? $product->get_id() : '',
            'price'     => floatval($order->get_item_total($item)),
            'quantity'  => intval($item->get_quantity())
        ];
    }

    ?>
    <!-- BEGIN: Purchase Event DataLayer Push -->
    <script>
        console.log('✅ GA4 purchase push fired from wp_footer');

        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            event: "purchase",
            ecommerce: {
                transaction_id: "<?php echo esc_js($order->get_order_number()); ?>",
                value: <?php echo floatval($order->get_total()); ?>,
                currency: "<?php echo esc_js($order->get_currency()); ?>",
                items: <?php echo json_encode($items); ?>
            }
        });
    </script>
    <!-- END -->
    <?php
}
//add_action('wp_footer', 'push_purchase_event_to_datalayer');
 
   
?>
