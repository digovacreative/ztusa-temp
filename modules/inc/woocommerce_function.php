<?php 

//Remove WooCommerce CSS
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function random_string_generator(){
	$length = 10;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


//----------------------- SHOP & ARCHIVE PAGES
 
// remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
// remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
 
// remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
// remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
 
// remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );

// remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
// remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); 
 
// remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
 
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
// remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'ecommerce_custom_loop_product_thumbnail', 10 );
 
function ecommerce_custom_loop_product_thumbnail() {
	include(dirname(__FILE__).'/templatePart/woocommerce/loop_thumbnail.php');
}


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'ecommerce_custom_result_count', 31 );
 
function ecommerce_custom_result_count() {
	include(dirname(__FILE__).'/templatePart/woocommerce/result_count.php');
}


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'ecommerce_custom_before_content_wrapper', 10 );
function ecommerce_custom_before_content_wrapper() {
	echo '<section class="woo_wrapper">';
}



remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'ecommerce_custom_after_content_wrapper', 10 );
function ecommerce_custom_after_content_wrapper() {
	echo '</section">';

}

add_action( 'woocommerce_after_shop_loop', 'ecommerce_custom_show_boxes', 20 );
function ecommerce_custom_show_boxes() {
	echo '<div class="clear"></div>';
	echo '<div class="woo__border_box"></div>';
	include(dirname(__FILE__).'/../flexible-content/homepage-box-flexible-fields.php');

}


//----------------------- SINGLE SHOP PAGES

// add_action( 'woocommerce_before_single_product_summary', 'ecommerce_custom_box_wrap_before', 1 );
// function ecommerce_custom_box_wrap_before(){
// 	include(dirname(__FILE__).'/templatePart/woocommerce/result_count.php');
// 	echo '<div class="basheer_wrapper_iknow">';
// }

// add_action( 'woocommerce_after_single_product_summary', 'ecommerce_custom_box_wrap_after', 40 );
// function ecommerce_custom_box_wrap_after(){
// 	include(dirname(__FILE__).'/templatePart/woocommerce/product_tabs.php');
// 	include(dirname(__FILE__).'/templatePart/woocommerce/single_image_gallery.php');
// 	echo '</div>';
// 	echo '<div class="clear"></div>';
// 	include(dirname(__FILE__).'/../flexible-content/homepage-box-flexible-fields.php');
// }


//Unhook the images section and add custom
// remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
// add_action( 'woocommerce_before_single_product_summary', 'ecommerce_custom_product_images', 20 );
 
// function ecommerce_custom_product_images() {
// 	include_once(dirname(__FILE__).'/templatePart/woocommerce/single_images.php');
// }

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

add_action( 'woocommerce_single_product_summary', 'ecommerce_custom_product_title', 60 );
 
function ecommerce_custom_product_title() {
	include_once(dirname(__FILE__).'/templatePart/woocommerce/single_title.php');
}



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 42 );


// remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
// remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );



add_action( 'woocommerce_single_product_summary', 'ecommerce_custom_product_before_add_to_cart', 60 ); 
function ecommerce_custom_product_before_add_to_cart() {
	
	// For fixed add to cart
	// echo '<div class="product__add_to_cart">
	// 		<div class="large_box">';
	// 		include_once(dirname(__FILE__).'/templatePart/woocommerce/before_add_to_card.php');
	
	echo '<div class="product__add_to_cart">
			<div class="add__to_cart_wrap">';
			include_once(dirname(__FILE__).'/templatePart/woocommerce/before_add_to_card.php');
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 65 );


add_action( 'woocommerce_single_product_summary', 'ecommerce_custom_product_after_add_to_cart', 67 ); 
function ecommerce_custom_product_after_add_to_cart() {
			include_once(dirname(__FILE__).'/templatePart/woocommerce/after_add_to_card.php');
		echo '</div>';			
	echo '</div>';
}


// add_action( 'woocommerce_after_single_product_summary', 'ecommerce_custom_product_after_single_details', 41 );
// function ecommerce_custom_product_after_single_details() {
// 	include_once(dirname(__FILE__).'/templatePart/woocommerce/single_image_gallery.php');
// }




// VARIATION CALLBACK
add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo', 'bodycommerce_ajax_add_to_cart_woo_callback' );
add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo', 'bodycommerce_ajax_add_to_cart_woo_callback' );

function bodycommerce_ajax_add_to_cart_woo_callback() {

	ob_start();

	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
	// $product_quantity = $_POST['product_quantity'];
	$variation_id = $_POST['variation_id'];
	$variation  = $_POST['variation'];


  error_log("Variation Product", 0);
  $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation  );

  if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {
	do_action( 'woocommerce_ajax_added_to_cart', $product_id );
	if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
	  wc_add_to_cart_message( $product_id );
	}

	// Return fragments
	WC_AJAX::get_refreshed_fragments();
  }  else  {
	// $this->json_headers(); // REMOVED AS WAS THROWING AN ERROR

	// If there was an error adding to the cart, redirect to the product page to show any errors
	$data = array(
	  'error' => true,
	  'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id  )
	  );
	echo json_encode( $data );
  }

		die();
}

add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo_single', 'bodycommerce_ajax_add_to_cart_woo_single_callback' );
add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo_single', 'bodycommerce_ajax_add_to_cart_woo_single_callback' );
function bodycommerce_ajax_add_to_cart_woo_single_callback() {
	ob_start();
	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
	error_log("Simple Product", 0);
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity  ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
		wc_add_to_cart_message( $product_id );
		}

		// Return fragments
		WC_AJAX::get_refreshed_fragments();
	}  else  {
		$this->json_headers();

		// If there was an error adding to the cart, redirect to the product page to show any errors
		$data = array(
		'error' => true,
		'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
		);
		echo json_encode( $data );
	}

	die();
}


function variation_radio_buttons($html, $args) {
	
	$args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
	  'options'          => false,
	  'attribute'        => false,
	  'product'          => false,
	  'selected'         => false,
	  'name'             => '',
	  'id'               => '',
	  'class'            => '',
	  'show_option_none' => __('Choose an option', 'woocommerce'),
   ));
  
	if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
	  $selected_key     = 'attribute_'.sanitize_title($args['attribute']);
	  $args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
	}
  
	$options               = $args['options'];
	$product               = $args['product'];
	$attribute             = $args['attribute'];
	$name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
	$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
	$class                 = $args['class'];
	$show_option_none      = (bool)$args['show_option_none'];
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');
  
	if(empty($options) && !empty($product) && !empty($attribute)) {
	  $attributes = $product->get_variation_attributes();
	  $options    = $attributes[$attribute];
	}

	$colour_variation_field = get_field('colour_variation_field','options');

	//if($attribute === $colour_variation_field):
		$radios = '<div class="variation-radios">';
		
		if(!empty($options)) {
			
		if($product && taxonomy_exists($attribute)) {
			$terms = wc_get_product_terms($product->get_id(), $attribute, array(
			'fields' => 'all',
			));
			
			$radios .= '<span class="product__variation_wrap_select"><strong>Select</strong><span class="svg__icon"></span></span>';
			$radios .= '<div class="dropdown__variation">';

			foreach($terms as $term) {
				if(in_array($term->slug, $options, true)) {
					
					$term_id = $term->term_id;
					if(get_field('variation_colour','term_'.$term_id)):
						$variation_colour = get_field('variation_colour','term_'.$term_id);
						$variation_image_box = '<span class="variation__image" style="background-color:'.$variation_colour.'"></span>';
						$empty_image = 'false';
					else:
						$variation_image_box = '';
						$empty_image = 'true';
					endif;

					// if(get_field('variation_second_colour','term_'.$term_id)):
					// 	$second_variation_image_id = get_field('variation_second_colour','term_'.$term_id); 
					// 	$second_variation_image = vt_resize($second_variation_image_id,'' , 200, 200, true);
					// 	$second_variation_image_box = '<img src="'.$second_variation_image['url'].'" class="variation__image_second" />';
					// else:
					// 	$second_variation_image_box = '';
					// endif;

					


					//'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).' <-- THIS IS THE NAME I"VE REMOVED
					$radios .= '<span class="product__variation_wrap" data-variation-name="'.esc_attr($name).'" data-input-name="'.esc_attr($term->name).'" data-variation-value="'.esc_attr($term->slug).'">
									<label for="'.esc_attr($term->slug).'">
									<span class="product__variation_label '.$empty_image.'">'.esc_attr($term->name).'</span>
									'.$variation_image_box.' 
									</label>
								</span>';
				}
			}

			$radios .= '</div>';

		} else {
			foreach($options as $option) {

				$term_id = $term->term_id;
				if(get_field('variation_colour','term_'.$term_id)):
					$variation_colour = get_field('variation_colour','term_'.$term_id);
					$variation_image_box = '<span class="variation__image" style="background-color:'.$variation_colour.'"></span>';
					$empty_image = 'false';
				else:
					$variation_image_box = '';
					$empty_image = 'true';
				endif;
				
				// if(get_field('variation_colour','term_'.$term_id)):
				// 	$variation_image_id = get_field('variation_colour','term_'.$term_id); 
				// 	$variation_image = vt_resize($variation_image_id,'' , 200, 200, true);
				// 	$variation_image_box = '<img src="'.$variation_image['url'].'" class="variation__image" />';
				// else:
				// 	$variation_image_box = '';
				// endif;


				// if(get_field('variation_second_colour','term_'.$term_id)):
				// 	$second_variation_image_id = get_field('variation_second_colour','term_'.$term_id); 
				// 	$second_variation_image = vt_resize($second_variation_image_id,'' , 200, 200, true);
				// 	$second_variation_image_box = '<img src="'.$second_variation_image['url'].'" class="variation__image_second" />';
				// else:
				// 	$second_variation_image_box = '';
				// endif;



				//'.esc_html(apply_filters('woocommerce_variation_option_name', $option)).' <-- THIS IS THE NAME I"VE REMOVED 
				$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
				$radios    .= '<span class="product__variation_wrap" data-variation-name="'.esc_attr($name).'" id="'.sanitize_title($option).'" data-variation-value="'.esc_attr($option).'">
									<label for="'.sanitize_title($option).'">
									<span class="product__variation_label '.$empty_image.'">'.esc_attr($term->name).'</span>
									'.$variation_image_box.'
									</label>
								</span>';
				}
		}
		}
	
		$radios .= '</div>';  
		return $html.$radios;
	// else:
	// 	return $html;
	// endif;
  }
  add_filter('woocommerce_dropdown_variation_attribute_options_html', 'variation_radio_buttons', 20, 2);
  

  

//----------------------- CART PAGES

remove_action( 'woocommerce_before_cart', 'action_woocommerce_before_cart', 10, 1 ); 

add_action( 'woocommerce_before_cart', 'woocommerce_template_cart_header', 65 );
function woocommerce_template_cart_header() {
	include_once(dirname(__FILE__).'/templatePart/woocommerce/cart_header.php');	
	echo '<div class="large_box">';	
}

remove_action( 'woocommerce_after_cart', 'action_woocommerce_after_cart', 10, 1 ); 

add_action( 'woocommerce_after_cart', 'woocommerce_template_after_cart', 65 );
function woocommerce_template_after_cart() {
	echo '</div>';	
}


remove_action( 'woocommerce_before_cart_table', 'action_woocommerce_before_cart_table', 10, 1 ); 
add_action( 'woocommerce_before_cart_table', 'woocommerce_template_before_cart_table', 65 );
function woocommerce_template_before_cart_table() {
	
}


remove_action( 'woocommerce_after_cart_table', 'action_woocommerce_after_cart_table', 10, 1 ); 
add_action( 'woocommerce_after_cart_table', 'woocommerce_template_after_cart_table', 65 );
function woocommerce_template_after_cart_table() {

}




//----------------------- CHEKOUT PAGES

//Move coupon to the right hand side
// remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
// add_action( 'woocommerce_checkout_before_order_review', 'woocommerce_checkout_coupon_form' );

//Move notifications inside Left Column above title
//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_required_field_notice', 10 );
//add_action( 'woocommerce_before_checkout_billing_form', 'woocommerce_checkout_required_field_notice', 10 );

//Remove un-needed fields on checkout page 
add_filter( 'woocommerce_checkout_fields' , 'custom_checkout_fields' );
function custom_checkout_fields( $fields ) {
	//unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['order_comments']);
	return $fields;
}


remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// remove_action( 'woocommerce_before_checkout_form', 'action_woocommerce_before_checkout_form', 10, 1 ); 
// add_action( 'woocommerce_before_checkout_form', 'woocommerce_template_before_checkout', 65 );
// function woocommerce_template_before_checkout() {
// 	//echo '<div class="small_box">';	
// }

// remove_action( 'woocommerce_after_checkout_form', 'action_woocommerce_after_checkout_form', 10, 1 ); 
// add_action( 'woocommerce_after_checkout_form', 'woocommerce_template_after_checkout', 65 );
// function woocommerce_template_after_checkout() {
// 	//echo '</div>';	
// }



// define the woocommerce_checkout_billing callback 
function action_woocommerce_checkout_billing(  ) { 
	echo '<h1 class="checkout__heading">'.get_the_title().'</h1>';
}; 
         
// add the action 
add_action( 'woocommerce_checkout_billing', 'action_woocommerce_checkout_billing', 10, 0 ); 


//Group order notes section with payment options 
function action_woocommerce_checkout_after_customer_details(  ) { 
	echo '<div class="order__review_and_payment">';
};          
// add the action 
add_action( 'woocommerce_checkout_after_customer_details', 'action_woocommerce_checkout_after_customer_details', 10, 0 ); 

function action_woocommerce_checkout_after_order_review(  ) { 
	echo '</div>';
};          
// add the action 
add_action( 'woocommerce_checkout_after_order_review', 'action_woocommerce_checkout_after_order_review', 10, 0 ); 



//Add single donation heading 
function action_woocommerce_single_donation_heading(  ) { 
	// echo '<a href="/donate/" class="button till woo_continue_button">Donate More</a>';
	echo '<h2 class="checkout__donation_heading">Single Donation Checkout</h2>';
}; 
         
// add the action 
add_action( 'woocommerce_checkout_before_customer_details', 'action_woocommerce_single_donation_heading', 10, 0 ); 



//Add single donation heading 
function action_woocommerce_checkout_order_review(  ) { 
	echo '<h3>Single Donation Review</h3>';
}; 
         
// add the action 
add_action( 'woocommerce_checkout_before_order_review', 'action_woocommerce_checkout_order_review', 10, 0 ); 


// Change place ORDER button text on checkout single donation
add_filter( 'woocommerce_order_button_text', 'ztrust_custom_button_text' );
 
function ztrust_custom_button_text( $button_text ) {
   return 'Submit'; // new text is here 
}


add_action( 'woocommerce_login_form_start','ecommerce_login_form_start' );
function ecommerce_login_form_start() {
	// echo '<div class="woocommerce_login_text woocommerce_login_guest">
	// <h3>Checkout as guest</h3>
	// 	<a href="#" class="button till woo_guest_checkout">Guest checkout</a>
	// </div>
	// <div class="clear"></div>';

	echo '<div class="woocommerce_login_text">';
	echo '<h3>Have an account with us?</h3> <a href="#" class="button till" id="login__form">Login</a>';
	// echo '<p class="login_paragraph">If you have an account with us please enter your login details below. If you are a new donor, please proceed by selecting Guest Checkout below, you will have the option to register for an account using the checkout form.</p>';
	echo '</div>';
	?>
	<script>
		jQuery('#login__form').click( function(){
			jQuery('.form_login_content').toggleClass('active');
		});
	</script>
	<?php
	echo '<div class="form_login_content">';
}

add_action( 'woocommerce_login_form_end','ecommerce_login_form_end' );
function ecommerce_login_form_end() {
	echo '</div>';
}


// Remove the links on order details 
add_filter( 'woocommerce_order_item_permalink', '__return_false' );

add_shortcode( 'wc_login_form', 'woocommerce_separate_login_form' );

function woocommerce_separate_login_form() {
	if ( is_admin() ) return;
	if ( is_user_logged_in() ) return; 
	ob_start();
	woocommerce_login_form();
	return ob_get_clean();
 }

add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );

/*
add_action('woocommerce_add_order_item_meta','add_values_to_order_item_meta',1,2);
if(!function_exists('add_values_to_order_item_meta'))
{

  function random_voucher_code(){
	$length = 10;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
  }

  function add_values_to_order_item_meta($item_id, $values)
  {		

		$quantity = wc_get_order_item_meta( $item_id,'_qty', $single = true ); 
			
		global $woocommerce,$wpdb;
		
		//$values['user_custom_data_value'];
		for($i = 1; $i <= $quantity; $i++ ){
			$random_voucher = random_voucher_code();
			$user_custom_value = 'px_'.$random_voucher;
			wc_add_order_item_meta($item_id,'Voucher Code',$user_custom_value);  
		}
	
  }
}
*/


//Woocommerce minicart change cart and checkout button
add_action( 'woocommerce_widget_shopping_cart_buttons', function(){
    // Removing Buttons
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

	// Adding customized Buttons§
	add_action( 'woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_button_view_cart', 10 );
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_proceed_to_checkout', 20 );
	
}, 1 );

//Removing permalink for products in cart
add_filter('woocommerce_cart_item_permalink','__return_false');


// Custom cart button
function custom_widget_shopping_cart_button_view_cart() {
	echo '<div class="mini_cart_button_wrap">';
    echo '<a href="#" id="continue_shopping_button" class="button woo_continue_shopping">' . esc_html__( 'Donate More', 'woocommerce' ) . '</a>';
}

add_action( 'woocommerce_before_mini_cart_contents', 'custom_widget_before_mini_cart_content', 10 );

function custom_widget_before_mini_cart_content(){
	echo '<h3>Single Donations</h3>';
}





// Custom Checkout button
function custom_widget_shopping_cart_proceed_to_checkout() {
    $original_link = wc_get_checkout_url();
    $custom_link = home_url( '/checkout/' ); // HERE replacing checkout link
	echo '<a href="' . esc_url( $custom_link ) . '" class="button checkout woo_checkout_button">' . esc_html__( 'Secure Checkout', 'woocommerce' ) . '</a>';
	echo '</div>';
}


// Ajax update cart info
add_filter( 'woocommerce_add_to_cart_fragments', function($fragments)
{
    $fragments['.tm_cart_widget .tm_cart_label .cart_ajax_data .total_products'] = '' . WC()->cart->get_cart_contents_count() . '';
    $fragments['.tm_cart_widget .tm_cart_label .cart_ajax_data .subtotal'] = '' . WC()->cart->get_cart_subtotal() . '';
    return $fragments;
});


//Remove add to cart button on single page 
// remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
// remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );


add_filter('woocommerce_add_cart_item_data', 'force_separate_item_add', 10, 2);
function force_separate_item_add($cart_item_data, $product_id) {

    $unique_cart_item_key = md5(microtime().rand()."ztrustcart");
	$cart_item_data['unique_key'] = $unique_cart_item_key;
	
	// if( ! empty( $_POST['ztrust-title-field'] ) ) {
		// $cart_item_data['title_field'] = $_POST['ztrust-title-field'];
		// $_POST['ztrust-title-field'];
	// }
	
	return $cart_item_data;

}




// Ajax add to cart overlay 
add_action( 'wp_footer', 'trigger_for_ajax_add_to_cart' );
function trigger_for_ajax_add_to_cart() {
    ?>
		<script type="text/javascript">
			
			function ajax_before(){
				jQuery('body').addClass('loading');
			}

			function ajax_after(){
				jQuery('body').removeClass('loading');
			}


		 	function load_the_cart($status = null){
				jQuery.ajax({
					url:  $ajaxurl,
					data: 'action=loadcart&status='+$status,
					type: 'POST',
					beforeSend:function(xhr){
						cart_quantity();
						ajax_before();
					},
					success:function(data){
						ajax_after();
						jQuery('.continue_shopping_popup').addClass('active');
						jQuery('#continue_shopping_popup').html(data);
					}

				});
				return false;
			}
			

			//Toggle Cart overlay
			jQuery('.cart_icon').click(function(event){
				load_the_cart();
				event.preventDefault();
			});

			
            (function($){
                $('body').on( 'added_to_cart', function(){
					load_the_cart('added');
					$('body').addClass('added_to_cart');
                });
			})(jQuery);
			
		</script>
		
    <?php
}


function check_recurring_cart(){
	if(isset($_COOKIE['shopping_cart'])):
		$cookie_data = stripslashes($_COOKIE['shopping_cart']);
		$cart_data = json_decode($cookie_data, true);
		return count($cart_data);
	else:
		return 0;
	endif;
}

function check_single_cart(){
	if(WC()->cart->get_cart_contents_count() > 0){
		return WC()->cart->get_cart_contents_count();
	}else{
		return 0;
	}
}

function check_donation_page($current_page){
	$donate_page_object = get_field('donation_page','options'); 
	if($current_page === $donate_page_object->post_name){
		return TRUE;
	}else{
		return FALSE;
	}
}




add_filter( 'woocommerce_checkout_fields', 'webendev_woocommerce_checkout_fields' );
function webendev_woocommerce_checkout_fields( $fields ) {

	$fields['order']['order_comments']['placeholder'] = 'Donation notes';
	return $fields;
}


add_action( 'woocommerce_before_account_orders', 'ztrust_show_recurring_order', 20, 4 );
  
function ztrust_show_recurring_order( ) {
	$current_id = get_current_user_id();
	$userData = get_userdata($current_id);

	// args
	$recurring_args = array(
		'post_per_page'	=> -1,
		'post_type'		=> 'recurringorder',
		'meta_key'		=> 'donor_email',
		'meta_value'	=> $userData->user_email
	);

	// query
	$recurring_orders_query = new WP_Query( $recurring_args );
	?>
	<h3>Regular Donations</h3>
	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Donation Nr</span></th>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Date</span></th>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Packages</span></th>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Status</span></th>
			</tr>
		</thead>

		<tbody>
		<?php while( $recurring_orders_query->have_posts() ) : $recurring_orders_query->the_post(); ?>
			<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">
				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Order">#<?php echo get_the_id(); ?></td>
				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date"><?php echo get_the_date(); ?></td>
				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Packages">
					<?php 
					if( have_rows('donations') ):
						while ( have_rows('donations') ) : the_row();
							the_sub_field('item_title'); echo ' - '.get_woocommerce_currency_symbol(); the_sub_field('amount'); echo '<br />';
						endwhile;
					endif;
					?>
				</td>
				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date"><?php $post_status = get_post_status(); if($post_status === 'draft'): echo 'Pending'; elseif($post_status === 'publish'): echo 'Completed'; endif; ?></td>
			</tr>
		<?php endwhile; wp_reset_query(); ?>
		</tbody>
	</table>
	<br />
	<h3>Single Donations</h3>
	<?php
}


// Show all orders on my donations page
add_filter( 'woocommerce_my_account_my_orders_query', 'zt_trust_my_donations_query', 20, 1 );
function zt_trust_my_donations_query( $args ) {
    $args['limit'] = -1;
    return $args;
}



// Signup email to Mailchimp 
function signup_to_mailchimp($email,$first_name,$last_name,$phone){
	$list_id = 'fe85d3a52c';
	$authToken = '96f46dd07e758036f67a87a17cf7b0a0-us15';
	
	// First hash the email for the API endpoint
	$subscriber_hash = md5(strtolower($email));

	$postData = array(
		"email_address" => $email, 
		"status_if_new" => "subscribed", // Only applies to new subscribers
		"status" => "subscribed",
		"merge_fields" => array(
			"FNAME"=> $first_name,
			"LNAME"=> $last_name,
			"PHONE"=> $phone
		)
	);

	// Use PUT instead of POST to handle both new and existing members
	$ch = curl_init('https://us15.api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.$subscriber_hash);
	curl_setopt_array($ch, array(
		CURLOPT_CUSTOMREQUEST => "PUT",  // Changed from POST to PUT
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HTTPHEADER => array(
			'Authorization: apikey '.$authToken,
			'Content-Type: application/json'
		),
		CURLOPT_POSTFIELDS => json_encode($postData)
	));

	$response = curl_exec($ch);

	curl_close($ch);

}



// Send email recurring donations 
function send_recurring_email($donation_id){
	global $post;

	$first_name = get_field('donor_first_name',$donation_id);
	$last_name = get_field('donor_last_name',$donation_id);
	$message = '';


	$message .= '
		<table style="color:#636363;font-family:"Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left; max-width:600px;">
		<tr><td>	
		<img src="'.get_stylesheet_directory_uri().'/assets/img/logo.png" width="200" />
			<h4>You are amazing.</h4>
			<p style="margin:0 0 16px"><strong>Dear '.$first_name.' '.$last_name.',</strong></p>
			<p style="margin:0 0 16px">Peace be upon you,</p>
			<p style="margin:0 0 16px">Thank you for your kind and generous donation towards The Zahra Trust USA.  We will ensure that your contribution reaches its destination in the most efficient and effective way possible.  It is through your continued support that we are able to deliver life-changing projects to the most vulnerable people across the world.  You will find a breakdown of your donation below.</p>';
		
		$message .='<h2 style="color:#00d5b4;display:block;font-family:"Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">[Donation #'.$donation_id.']</h2>';
		
		$message .='
		<div style="margin-bottom:40px">
		<table cellspacing="0" cellpadding="6" border="1" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif">
		<thead><tr>
		<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left">Donation Item</th>
						<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left">Repeated every</th>
						<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left">Contribution Amount</th>
					</tr></thead>
			<tbody>';

		while ( have_rows('donations', $donation_id) ) : the_row();
		
			$message .= '<tr>
				<td style="color:#636363;border:1px solid #e5e5e5;padding:12px;text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word">
				'.get_sub_field('item_title').'
				</td>
				<td style="color:#636363;border:1px solid #e5e5e5;padding:12px;text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif">
				'.get_sub_field('interval_unit').'
				</td>
				<td style="color:#636363;border:1px solid #e5e5e5;padding:12px;text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif">
				<span><span>'.get_woocommerce_currency_symbol().'</span>
				'.get_sub_field('amount').'
				</span></td>
			</tr>';
		
		endwhile;

		$message .= '	
			</tbody>
		</table>
		</div>';

		$message .= '
		<p style="margin:0 0 16px">For more information and support, please email us at info@zahratrust.org</p>
		<p style="margin:0 0 16px"><strong>Thank you once again for your generous contribution.</strong></p>
		<p style="margin:0 0 16px">Kind regards,</p>
		<p style="margin:0 0 16px">The Zahra Trust USA <br /> <i>The Zahra Trust USA is project of the Zahra Foundation LTD. The Zahra Foundation LTD is as an exempt organization as described in Section 501(C)(3) of the Internal Revenue Code</i>
		</td></tr></table>';

	// Send email
	$to = get_field('donor_email',$donation_id);
	$subject = 'Thank you for your donation';
	$headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail( $to, $subject, $message, $headers);
}









//Checkout Pages 

/*
add_action( 'woocommerce_thankyou_order_received_text', 'ecommerce_view_order_and_thankyou_page', 1, 20 );

function ecommerce_view_order_and_thankyou_page($order_id){
	echo '<span class="this">';
	echo 'HELLOOOOO';
	echo '</span>';
} */


//Try and remove all SHOP Archive bits;

// remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
// remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
// remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
// remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
// remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
// remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );



/**
 * Auto Complete all WooCommerce orders.
 */
// add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_paid_order', 1, 1 );
// function custom_woocommerce_auto_complete_paid_order( $order_id ) {
//     if ( ! $order_id )
//     return;

//     $order = wc_get_order( $order_id );

//     // No updated status for orders delivered with Bank wire, Cash on delivery and Cheque payment methods.
//     if ( ( 'bacs' == get_post_meta($order_id, '_payment_method', true) ) || ( 'cod' == get_post_meta($order_id, '_payment_method', true) ) || ( 'cheque' == get_post_meta($order_id, '_payment_method', true) ) ) {
//         return;
//     } 
//     // For paid Orders with all others payment methods (with paid status "processing")
//     elseif( $order->get_status()  === 'processing' ) {
//         $order->update_status( 'completed' );
//     }
// }

add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
}




// Function to change email address from
function zt_sender_email( $original_email_address ) {
    return 'info@zahratrust.com';
}
 
// Function to change sender name
function zt_sender_name( $original_email_from ) {
    return 'The Zahra Trust';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'zt_sender_email' );
add_filter( 'wp_mail_from_name', 'zt_sender_name' );





// ------------------------
// Custom field on products for gifting donation
// ------------------------

/**
 * Display input on single product page
 */
function ztrust_custom_option(){
	if(get_field('enable_gift_donation')){
		global $post;
		$product_id = $post->ID;
		$value = isset( $_POST['_custom_option' ] ) ? sanitize_text_field( $_POST['_custom_option'] ) : '';
		echo '<div class="gifting_section"><div class="ztrust-custom-field-wrapper"><label for="ztrust-title-field">Recipient Name</label><input type="text" id="ztrust-title-field-name-'.$product_id.'" name="_custom_option" value="'.$value.'"></div>';

		$value = isset( $_POST['_custom_option_email' ] ) ? sanitize_text_field( $_POST['_custom_option_email'] ) : '';
		echo '<div class="ztrust-custom-field-wrapper"><label for="ztrust-title-field">Recipient Email</label><input type="text" id="ztrust-title-field-email-'.$product_id.'" name="_custom_option_email" value="'.$value.'"></div></div>';

		?>
		<script>
		jQuery(document).on("click", '.tabContent-<?php echo $product_id; ?> .single_add_to_cart_button', function(event) { 
			if( (jQuery('#ztrust-title-field-name-<?php echo $product_id; ?>').val() === '') || (jQuery('#ztrust-title-field-email-<?php echo $product_id ?>').val() === '')  ){
				// alert('Name and email field is compulsory');
				if( (jQuery('#ztrust-title-field-name-<?php echo $product_id; ?>').val() === '') ){
					jQuery('#ztrust-title-field-name-<?php echo $product_id; ?>').addClass('error');
				}

				if( (jQuery('#ztrust-title-field-email-<?php echo $product_id; ?>').val() === '') ){
					jQuery('#ztrust-title-field-email-<?php echo $product_id; ?>').addClass('error');
				}
				return false;
			} else {
				return true;
			}
		});
		</script>
		<?php
	}
}
add_action( 'woocommerce_before_add_to_cart_button', 'ztrust_custom_option', 9 );


/**
 * Add custom data to the cart item
 */
function ztrust_add_cart_item_data( $cart_item, $product_id ){

    if( isset( $_POST['_custom_option'] ) ) {
        $cart_item['custom_option'] = sanitize_text_field( $_POST[ '_custom_option' ] );
    }
	
	if( isset( $_POST['_custom_option_email'] ) ) {
        $cart_item['custom_option_email'] = sanitize_text_field( $_POST[ '_custom_option_email' ] );
    }
    return $cart_item;

}
add_filter( 'woocommerce_add_cart_item_data', 'ztrust_add_cart_item_data', 10, 2 );

/**
 * Load cart data from session
 */
function ztrust_get_cart_item_from_session( $cart_item, $values ) {

    if ( isset( $values['custom_option'] ) ){
        $cart_item['custom_option'] = $values['custom_option'];
    }
	
	if ( isset( $values['custom_option_email'] ) ){
        $cart_item['custom_option_email'] = $values['custom_option_email'];
    }

    return $cart_item;

}
add_filter( 'woocommerce_get_cart_item_from_session', 'ztrust_get_cart_item_from_session', 20, 2 );

/**
 * Add meta to order item
 */
function ztrust_add_order_item_meta( $item_id, $values ) {

    if ( ! empty( $values['custom_option'] ) ) {
        wc_add_order_item_meta( $item_id, 'custom_option', $values['custom_option'] );           
    }
    if ( ! empty( $values['custom_option_email'] ) ) {
        wc_add_order_item_meta( $item_id, 'custom_option_email', $values['custom_option_email'] );           
    }

}
add_action( 'woocommerce_add_order_item_meta', 'ztrust_add_order_item_meta', 10, 2 );

/**
 * Display entered value in cart
 */
function ztrust_get_item_data( $other_data, $cart_item ) {
    if ( isset( $cart_item['custom_option'] ) ){
        $other_data[] = array(
            'key' => __( 'Recipient Name', 'ztrust-plugin-textdomain' ),
            'display' => sanitize_text_field( $cart_item['custom_option'] )
        );
    }
    return $other_data;
}
add_filter( 'woocommerce_get_item_data', 'ztrust_get_item_data', 10, 2 );

function ztrust_get_item_data_email( $other_data, $cart_item ) {
    if ( isset( $cart_item['custom_option_email'] ) ){
        $other_data[] = array(
            'key' => __( 'Recipient Email', 'ztrust-plugin-textdomain' ),
            'display' => sanitize_text_field( $cart_item['custom_option_email'] )
        );
    }
    return $other_data;
}
add_filter( 'woocommerce_get_item_data', 'ztrust_get_item_data_email', 10, 2 );


/**
 * Customize the display of the meta key in order tables.
 */
function ztrust_order_item_display_meta_key( $display_key, $meta, $order_item ){

    if( $meta->key == 'custom_option' ){
        $display_key =  __( 'Recipient Name', 'ztrust-plugin-textdomain' );
	}
	if( $meta->key == 'custom_option_email' ){
        $display_key =  __( 'Recipient Email', 'ztrust-plugin-textdomain' );
	}
	
    return $display_key;

}
add_filter( 'woocommerce_order_item_display_meta_key', 'ztrust_order_item_display_meta_key', 10, 3 );


add_action( 'woocommerce_payment_complete', 'my_change_status_function' );
function my_change_status_function( $order_id ) {

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );

}



// ------------------------
// Custom field on Sayed item
// ------------------------

/**
 * Display input on single product page
 */
function ztrust_sayed_option(){
	if(get_field('enable_sayed_drop_down')){
		global $post;
		$product_id = $post->ID;
		$value = isset( $_POST['_sayed_option' ] ) ? sanitize_text_field( $_POST['_sayed_option'] ) : '';
		echo '<div class="sayed_section" class="ztrust-sayed-field-name-'.$product_id.'">
				<select name="_sayed_option" id="ztrust-sayed-field-name-'.$product_id.'">
					<option value="">Select</option>
					<option value="I am a Sayed">I am a Sayed</option>
					<option value="I am not a Sayed">I am not a Sayed</option>
				</select>	
			</div>';
		?>
		<script>
		jQuery(document).on("click", '.single_add_to_cart_button', function(event) { 
			if( (jQuery('.ztrust-sayed-field-name-<?php echo $product_id; ?>').val() === '') ){
				jQuery('.ztrust-sayed-field-name-<?php echo $product_id; ?>').addClass('error');
				return false;
			} 
		});
		</script>
		<?php
	}
}
add_action( 'woocommerce_before_add_to_cart_button', 'ztrust_sayed_option', 9 );



/**
 * Add custom data to the cart item
 */
function ztrust_add_cart_item_data_sayed( $cart_item, $product_id ){

    if( isset( $_POST['_sayed_option'] ) ) {
        $cart_item['sayed_option'] = sanitize_text_field( $_POST[ '_sayed_option' ] );
    }
	
    return $cart_item;

}
add_filter( 'woocommerce_add_cart_item_data', 'ztrust_add_cart_item_data_sayed', 10, 2 );

/**
 * Load cart data from session
 */
function ztrust_get_cart_item_from_session_sayed( $cart_item, $values ) {

    if ( isset( $values['sayed_option'] ) ){
        $cart_item['sayed_option'] = $values['sayed_option'];
    }
	return $cart_item;

}
add_filter( 'woocommerce_get_cart_item_from_session', 'ztrust_get_cart_item_from_session_sayed', 20, 2 );

/**
 * Add meta to order item
 */
function ztrust_add_order_item_meta_sayed( $item_id, $values ) {

    if ( ! empty( $values['sayed_option'] ) ) {
        wc_add_order_item_meta( $item_id, 'sayed_option', $values['sayed_option'] );           
    }

}
add_action( 'woocommerce_add_order_item_meta', 'ztrust_add_order_item_meta_sayed', 10, 2 );

/**
 * Display entered value in cart
 */
function ztrust_get_item_data_sayed( $other_data, $cart_item ) {
    if ( isset( $cart_item['sayed_option'] ) ){
        $other_data[] = array(
            'key' => __( 'Are you a Sayed?', 'ztrust-sayed-textdomain' ),
            'display' => sanitize_text_field( $cart_item['sayed_option'] )
        );
    }
    return $other_data;
}
add_filter( 'woocommerce_get_item_data', 'ztrust_get_item_data_sayed', 10, 2 );


/**
 * Customize the display of the meta key in order tables.
 */
function ztrust_order_item_display_meta_key_sayed( $display_key, $meta, $order_item ){

    if( $meta->key == 'sayed_option' ){
        $display_key =  __( 'Are you a Sayed?', 'ztrust-sayed-textdomain' );
	}
	return $display_key;

}
add_filter( 'woocommerce_order_item_display_meta_key', 'ztrust_order_item_display_meta_key_sayed', 10, 3 );






// ------------------------
// Custom field for Price Handles
// ------------------------

/**
 * Display input on single product page
 */
function ztrust_pricehandle_option(){
	global $post;
	$product_id = $post->ID;
	$value = isset( $_POST['_pricehandle_option' ] ) ? sanitize_text_field( $_POST['_pricehandle_option'] ) : '';
	echo '<input name="_pricehandle_option" type="hidden" id="ztrust-pricehandle-field-name-'.$product_id.'">';
	?>
	<script>
	
	</script>
	<?php
}
add_action( 'woocommerce_before_add_to_cart_button', 'ztrust_pricehandle_option', 9 );



/**
* Add custom data to the cart item
*/
function ztrust_add_cart_item_data_pricehandle( $cart_item, $product_id ){

if( isset( $_POST['_pricehandle_option'] ) ) {
	$cart_item['pricehandle_option'] = sanitize_text_field( $_POST[ '_pricehandle_option' ] );
}

return $cart_item;

}
add_filter( 'woocommerce_add_cart_item_data', 'ztrust_add_cart_item_data_pricehandle', 10, 2 );

/**
* Load cart data from session
*/
function ztrust_get_cart_item_from_session_pricehandle( $cart_item, $values ) {

if ( isset( $values['pricehandle_option'] ) ){
	$cart_item['pricehandle_option'] = $values['pricehandle_option'];
}
return $cart_item;

}
add_filter( 'woocommerce_get_cart_item_from_session', 'ztrust_get_cart_item_from_session_pricehandle', 20, 2 );

/**
* Add meta to order item
*/
function ztrust_add_order_item_meta_pricehandle( $item_id, $values ) {

if ( ! empty( $values['pricehandle_option'] ) ) {
	wc_add_order_item_meta( $item_id, 'pricehandle_option', $values['pricehandle_option'] );           
}

}
add_action( 'woocommerce_add_order_item_meta', 'ztrust_add_order_item_meta_pricehandle', 10, 2 );

/**
* Display entered value in cart
*/
function ztrust_get_item_data_pricehandle( $other_data, $cart_item ) {
if ( isset( $cart_item['pricehandle_option'] ) ){
	$other_data[] = array(
		'key' => __( 'Price Handle', 'ztrust-pricehandle-textdomain' ),
		'display' => sanitize_text_field( $cart_item['pricehandle_option'] )
	);
}
return $other_data;
}
add_filter( 'woocommerce_get_item_data', 'ztrust_get_item_data_pricehandle', 10, 2 );


/**
* Customize the display of the meta key in order tables.
*/
function ztrust_order_item_display_meta_key_pricehandle( $display_key, $meta, $order_item ){

if( $meta->key == 'pricehandle_option' ){
	$display_key =  __( 'Price Handle:', 'ztrust-pricehandle-textdomain' );
}
return $display_key;

}
add_filter( 'woocommerce_order_item_display_meta_key', 'ztrust_order_item_display_meta_key_pricehandle', 10, 3 );










// Apple Pay on checkout
// add_filter( 'wc_stripe_show_payment_request_on_checkout', '__return_true' );

?>