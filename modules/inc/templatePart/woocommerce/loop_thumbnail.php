<?php global $product; ?>
<div class="product__image_wrap">
<?php if(get_field('new_product')): ?>
<span class="new__sticker">NEW</span>
<?php endif; ?>    
<?php if(has_post_thumbnail()): $woo_thumb_id = get_post_thumbnail_id(); $woo_thumb = vt_resize($woo_thumb_id,'' , 500, 400, true);?><img src="<?php echo $woo_thumb['url']; ?>" /><?php endif; ?></div>