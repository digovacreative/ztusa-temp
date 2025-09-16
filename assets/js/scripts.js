//Main.js
//Author: Ali Moshen

//@prepros-append lib/_loader.js
//@prepros-append lib/_mark.js
//@prepros-append lib/fancybox/_jquery.fancybox.min.js
//@prepros-append lib/_macy.js
//@prepros-append lib/_jquery.countdownTimer.min.js
//@prepros-append lib/_slick.js
//@prepros-append lib/jqueryvalidate/_jquery.validate.js
//@prepros-append lib/_datepicker.js
//@prepros-append lib/_cookies.js
//@prepros-append lib/_aos.js

function tilt_cards(){
    jQuery('.card_tilt').tilt({
        scale: 1.05,
        maxTilt: 3,
        glare: false,
    });
}


function tabs(){
  
  jQuery('ul.product__tabs_heading li').click(function(){
    var tab_id = jQuery(this).attr('data-tabheading');

    jQuery('ul.product__tabs_heading li').removeClass('active');
    jQuery('.tab_content').removeClass('active');

    jQuery(this).addClass('active');
    jQuery("#"+tab_id).addClass('active');
  });

}


function search_overlay(){
  jQuery( "#searchWebsite" ).click(function(event) {
    jQuery(this).toggleClass('active');
    jQuery( ".searchOverlay" ).toggleClass('active');
    event.preventDefault();
  });
  jQuery( "#closeSearch" ).click(function(event) {
    jQuery(this).toggleClass('active');
    jQuery( ".searchOverlay" ).toggleClass('active');
    event.preventDefault();
  });
}

//Make element not sticky when it reaches it's original position (used at checkout page for make payment button)
//DOESN"T WORK NEED TO DEBUG AND FIX (For now it's fixed all the time)

/*
function sticktothetop() {
    var window_top = jQuery(window).scrollTop();
    var top = jQuery('#woocommerce-process-checkout-nonce').offset().top;
    if (window_top > top) {
        jQuery('#place_order').removeClass('stick');
        jQuery('#woocommerce-process-checkout-nonce').height(0);
    } else {
        jQuery('#place_order').addClass('stick');
        jQuery('#woocommerce-process-checkout-nonce').height(jQuery('#place_order').outerHeight());
    }
}*/

function cart_quantity(){
	jQuery.ajax({
		url:  $ajaxurl,
		data: 'action=loadcarttotal',
		type: 'POST',
		beforeSend:function(xhr){
			// ajax_before();
		},
		success:function(data){
			// ajax_after();
			jQuery('#cart_quantity').html(data);
		}

	});
	return false;
}

function mobile_addclass(){
  var $window = jQuery(window),
      $header = jQuery('.header');
  if ($window.width() < 959) {
      return $header.addClass('fixed__header');
  }
}  

function aosanimate(){
  AOS.init({
    easing: 'ease-in-out-sine',
    disable: 'mobile'
  });
}

function lockBody($value){
  if($value==='remove'){
    jQuery('body').removeClass('popup_active');
  }else{
    jQuery('body').addClass('popup_active');
  }
}

function quick_donate(){

  jQuery('.close_donation').click( function(event){
    jQuery('.quick__donate').addClass('hide');
    jQuery('.donateTrigger').addClass('active');
    event.preventDefault();
  });
  

  jQuery('.donateTrigger').click( function(event){

    jQuery('.quick__donate').removeClass('hide');
    jQuery(this).removeClass('active');
    event.preventDefault();
  });


  jQuery('.donate_trigger_mobile').click( function(event){
    if(jQuery(this).hasClass('active')){
      lockBody('remove');
      jQuery('.quick__donate').addClass('hide');
      jQuery('.donate_trigger_search').removeClass('inactive');
      jQuery('.donate_trigger_cart').removeClass('inactive');
      jQuery('.header').removeClass('inactive');
      jQuery(this).removeClass('active');

    }else{
      lockBody('add');
      jQuery('.quick__donate').removeClass('hide');
      jQuery('.donate_trigger_search').addClass('inactive');
      jQuery('.donate_trigger_cart').addClass('inactive');
      jQuery('.header').addClass('inactive');
      jQuery(this).addClass('active');
      
    }
    
    // jQuery(this).removeClass('active');
    event.preventDefault();
  });


  jQuery('.close_donation_mobile').click( function(event){
    lockBody('remove');
    jQuery('.quick__donate').addClass('hide');
    jQuery('.donate_trigger_search').removeClass('inactive');
    jQuery('.donate_trigger_cart').removeClass('inactive');
    jQuery('.header').removeClass('inactive');
    jQuery('.donate_trigger_mobile').removeClass('active');
    event.preventDefault();
  });

  
}

//On window resize calculate height again
jQuery(document).ready(function($){
  tabs();
  mobile_addclass();
  quick_donate();
  //in_init_owlcarousel();
  search_overlay();
  aosanimate();
  //toggle_woo_filter();
  //tilt_cards();
  //sticktothetop();
  //jQuery(window).scroll(sticktothetop);

});

