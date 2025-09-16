<?php
function filter_product_function(){

	//print_r($_POST);

	$product_view = $_POST['displayType'];
	$page = $_POST['pageNumber'];
	$filter = $_POST['filter'];
	$ppp = 8*$page;
	$post_type = $_POST['post_type'];

	$product_cat = $_POST['product_cat'];

	$taxonomy = $_POST['taxonomy'];
	$taxonomy_id = $_POST['taxonomy_id'];
	$multiple = substr_count( $_POST['product_cat'], ",") +1;
	
	if($filter == 'all'):

		if($product_cat === 'empty'):
			$argsTotal = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => -1
			);

			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $ppp
			);

		else:
			$argsTotal = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'tax_query'     => array(
					array(
						'taxonomy'  => $taxonomy,
						'field'     => $taxonomy_id, 
						'terms'     => ($multiple == 1 ? $product_cat :  explode(",", $product_cat))
					)
				),
				'posts_per_page' => -1
			);

			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'tax_query'     => array(
					array(
						'taxonomy'  => $taxonomy,
						'field'     => $taxonomy_id, 
						'terms'     => ($multiple == 1 ? $product_cat :  explode(",", $product_cat))
					)
				),
				'posts_per_page' => $ppp
			);

		endif;

		
	endif;

	$query_product_listing = new WP_Query( $args );
	$productCount = $query_product_listing->post_count;
	$query_product_listing_total = new WP_Query( $argsTotal );
	$productTotal = $query_product_listing_total->post_count;

	//echo '<div class="productCount">'.$productCount.'</div>';
	//echo '<div class="productTotal">'.$productTotal.'</div>';

	wp_reset_query();
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.productCountView').html($('.productCount').html());
		$('.productTotalView').html($('.productTotal').html());
	});
	</script>
	
	<ul class="product__listing_items scrolling_posts <?php echo $product_view; ?>">
	<?php 
	$product_query = new WP_Query($args);
	if( $product_query->have_posts() ) : 
		while($product_query->have_posts()) : $product_query->the_post(); $post = get_post();
			
			$post_type = get_post_type();
			include('components/'.$post_type.'.php');
			
		endwhile;  wp_reset_query(); wp_reset_postdata();

		  //Get all pages and check if on last page, if on last page disable the load more button
			$current_page = $product_query->get( 'paged' );
			if (! $current_page ) {
				$current_page = 1;
			}
			if ( $current_page == $product_query->max_num_pages ) { ?>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#more__products').addClass('disabledButton');
			});
			</script>
		<?php  }else{ ?>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#more__products').removeClass('disabledButton');
			});
			</script>
		<?php } wp_reset_query();
		die();

	else: ?>
	</ul>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.productCountView').html('0');
		$('.productTotalView').html('0');
		$('#more__products').addClass('disabledButton');
	});
	</script>
	<?php die(); endif;
}
add_action('ZTRUST_AJAX_productfilter', 'filter_product_function');
add_action('ZTRUST_AJAX_nopriv_productfilter', 'filter_product_function');
?>