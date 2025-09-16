<footer class="section footer_section" id="footer_slide">
	<section class="footer__bottom checkout__footer_bottom <?php the_field('background_style','options'); ?>">
		<div class="medium_box">

			<div class="col_1_2 floatLeft footer__copyright">
				<?php if(get_field('footer_menu','options')): 
					$footer_menu = get_field('footer_menu','options');
					wp_nav_menu(array('menu' => $footer_menu, 'items_wrap' => '<ul class="footer_menu">%3$s</ul>', 'container' => false));
				endif; ?>
				<h4>&copy; <?php //site_title(); ?> <?php echo date('Y'); ?><?php if(get_field('footer_security_text','options')): the_field('footer_security_text','options'); endif; ?></h4>
			</div>

			<div class="col_1_2 floatRight">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fr-logo.svg" class="frlogo" />
			</div>
			
		</div>	
	</section>
</footer>