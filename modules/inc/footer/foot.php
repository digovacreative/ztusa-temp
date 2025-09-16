		

	
	<section class="footer__top <?php the_field('background_style','options'); ?>">
		<div class="large_box">

			<div class="col_1_2 footer__top_container">
				
				<div class="col_1_3">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-footer.svg" class="footer__logo">
					<?php 
					
						if(have_rows('social_media_links','options')){
						echo '<ul class="footer__social_media">';
							while ( have_rows('social_media_links','options') ) : the_row();
								echo '<li><a href="'.get_sub_field('social_media_link').'" target="_blank" title="'.get_sub_field('social_media_title').'" class="'.get_sub_field('social_media_bg').'"><i class="'.get_sub_field('social_media_icon').' '.get_sub_field('social_media_style').'"></i></a></li>';
							endwhile;
						echo '</ul>';
						}
					?>
				</div>
				
				<div class="col_1_3">
					<h4>CURRENT APPEALS</h4>
				<?php if(get_field('footer_project_menu','options')): 
					$footer_menu_project = get_field('footer_project_menu','options');
					wp_nav_menu(array('menu' => $footer_menu_project, 'items_wrap' => '<ul class="footer_menu_normal">%3$s</ul>', 'container' => false));
				endif; ?>
				</div>
				
				<div class="col_1_3">
				<h4>USEFUL LINKS</h4>
				<?php if(get_field('footer_normal_menu','options')): 
					$footer_menu_project = get_field('footer_normal_menu','options');
					wp_nav_menu(array('menu' => $footer_menu_project, 'items_wrap' => '<ul class="footer_menu_normal">%3$s</ul>', 'container' => false));
				endif; ?>
				</div>

				
			</div>
			
			<div class="col_1_2 footer__top_container_donate">
				<div class="contact_details">
					<h4>Call us or email us for information<span>+ 44 (0) 208 452 7565</span><a href="mailto:info@zahratrust.com">info@zahratrust.com</a></h4>
					<a href="/donate/" class="button red">Donate</a>
					<h5>The Zahra Trust, 131 Walm Lane London, NW2 3AU, United Kingdom</h5>
				</div>
				
				<div class="newsletter_signup">
					<h5>Get your monthly charity newsletter and updates straight into your mailbox, signup below and receive updates on how your donations are being spent</h5>

					<div id="mc_embed_signup">
						<form action="https://justgiving.us3.list-manage.com/subscribe/post?u=b019bd39febd090c9f6774cc0&amp;id=c210925626" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							<div id="mc_embed_signup_scroll">
								<div class="mc-field-group">
									<input type="email" value="" placeholder="Email Address" name="EMAIL" class="required email" id="mce-EMAIL">
									<div class="response" id="mce-error-response" style="display:none"></div>
									<div class="response" id="mce-success-response" style="display:none"></div>
									<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_b019bd39febd090c9f6774cc0_c210925626" tabindex="-1" value=""></div>
									<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button till">
							</div>
						</form>
					</div>
					
				</div>
			</div>


		</div>	
	</section>
	
	<section class="footer__bottom <?php the_field('background_style','options'); ?>">
		<div class="large_box">

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
