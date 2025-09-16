<?php global $product; ?>
<div class="product__heading">
	<h1><?php the_title(); ?></h1>
	

	<div class="product_add_to_cart_price">
		<?php if($price_html = $product->get_price_html()): ?><?php echo $price_html; ?><?php endif; ?>
	</div>

</div>



<div class="product__labels">
	<ul class="product__labels_listing">
	<?php while ( have_rows('labels') ) : the_row(); ?>
		<li>
			<strong><?php the_sub_field('heading'); ?></strong>
			<span><?php the_sub_field('content'); ?></span>
		</li>
	<?php endwhile; ?>
	</ul>
</div>

<div class="product__description">
	<?php the_content(); ?>
</div>