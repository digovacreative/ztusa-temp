
<?php if(get_field('product_details')): ?>
<div class="product__tabs">
	<ul class="product__tabs_heading">
	<?php $tab_counter=0; while ( have_rows('product_details') ) : the_row(); $tab_counter++; ?>
		<li <?php if($tab_counter===1): ?>class="active"<?php endif; ?> data-tabheading="product_tabs_<?php echo $tab_counter; ?>"><?php the_sub_field('tab_heading'); ?></li>
	<?php endwhile; ?>
	</ul>
	<div class="product__tabs_content">
	<?php $tab_counter=0; while ( have_rows('product_details') ) : the_row(); $tab_counter++; ?>
		<div class="tab_content <?php if($tab_counter===1): ?>active<?php endif; ?>" id="product_tabs_<?php echo $tab_counter; ?>"><?php the_sub_field('tab_content'); ?></div>
	<?php endwhile; ?>
	</div>	
</div>
<?php endif; ?>
