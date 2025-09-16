<?php 
global $product; 

?>
<script>

jQuery(function($){

	// Ajax add to cart on the product page
    var $warp_fragment_refresh = {
        url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
        type: 'POST',
        success: function( data ) {
            if ( data && data.fragments ) {

                $.each( data.fragments, function( key, value ) {
                    $( key ).replaceWith( value );
                });

                $( document.body ).trigger( 'wc_fragments_refreshed' );
            }
        }
    };

    $('.entry-summary form.cart').on('submit', function (e)
    {   
        $('.entry-summary').addClass('loading');
        var product_url = window.location,
            form = $(this);
        $.post(product_url, form.serialize() + '&_wp_http_referer=' + product_url, function (result)
        {
            var cart_dropdown = $('.widget_shopping_cart', result)
            // update dropdown cart
            $('.widget_shopping_cart').replaceWith(cart_dropdown);

            // update fragments
            $.ajax($warp_fragment_refresh);
            $('.entry-summary').removeClass('loading');
            jQuery('#product_details_box').removeClass('active');
            jQuery('.product__listing').removeClass('active');
            $status = 'added';
            load_the_cart($status);
            $('body').addClass('added_to_cart');
        });
        e.preventDefault();
    });
});
</script>