<?php 
global $product;
?>
<aside class="woo_sidebar">
<h3>Categories</h3>
<ul class="woo__parent_cat">
	<?php
	if(is_singular('product')):
		global $post;
		$theterm = get_the_terms( $post->ID, 'product_cat' );
		$current_termID = $theterm[0]->term_id;
	else:	
		$current_termID = get_queried_object()->term_id;
	endif;
	
	foreach( get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => 0 ) ) as $parent_term ) {
		if($current_termID === $parent_term->term_id){
			$itemClass = 'item_active';
		}else{
			$itemClass = '';
		}
		// display top level term name
		echo '<li class="'.$itemClass.'">';

		if(get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => $parent_term->term_id ) )):  
			echo '
			<span class="woo__label_link">'.$parent_term->name.'
				<svg class="woo__arrow_link" version="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M5.84,9.59L11.5,15.25L17.16,9.59L16.45,8.89L11.5,13.84L6.55,8.89L5.84,9.59Z"/></svg>
			</span>';

			echo '<ul class="woo__child_cat">';
			foreach( get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => $parent_term->term_id ) ) as $child_term ) {
				if($current_termID === $child_term->term_id){
					$itemClass = 'item_active';
				}else{
					$itemClass = '';
				}
				echo '<li class="'.$itemClass.'"><a href="/product-category/'.$child_term->slug.'">'.$child_term->name.'</a></li>';
			}
			echo '</ul>';
		else:
			echo '<a href="/product-category/'.$parent_term->slug.'">'.$parent_term->name.'</a>';
		endif;
		
		echo '</li>';

	}
	?>
</ul>   
</aside>

<script type="text/javascript">
jQuery('.item_active').parent('.woo__child_cat').addClass('active');

jQuery('.woo__label_link').click( function(e){
	if(jQuery(this).next('ul').hasClass('active')){
		jQuery('ul.woo__child_cat').removeClass('active');
		jQuery('.woo__arrow_link').removeClass('active');

	}else{
		jQuery('ul.woo__child_cat').removeClass('active');
		jQuery('.woo__arrow_link').removeClass('active');
		
		jQuery(this).next('ul').addClass('active');
		jQuery(this).children('.woo__arrow_link').addClass('active');
	}
	e.preventDefault();
});

</script>