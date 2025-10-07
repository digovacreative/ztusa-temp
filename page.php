<?php get_header(); ?>
<div class="gutenberg__wrap">
	<div class="continue_shopping_popup" id="continue_shopping_popup"></div>
	</div>
	<?php //include_once('modules/flexible-content/flexible-fields.php'); ?>
	<div class="content__wrapper gutenberg__wrap">
	<?php while(have_posts()) : the_post(); ?>
		<?php the_content(); ?>
		<?php 
		$thank_you_slug = str_replace("/","",get_option('thankyou_url'));

		if(is_page($thank_you_slug)): 
			$order_id = $_GET['order'];	
			
			$donation_option = $_GET['v'];

			if($donation_option === 's') {

				$order = wc_get_order( $order_id );
				$order_data = $order->get_data(); 

				$first_name = $order_data['billing']['first_name'];
				$last_name = $order_data['billing']['last_name'];
				$phone = $order_data['billing']['phone'];
				$email = $order_data['billing']['email'];

				$items = [];
				foreach ($order->get_items() as $item) {
					$product = $item->get_product();
					$items[] = [
						'item_name' => $item->get_name(),
						'item_id'   => $product ? strval($product->get_id()) : '',
						'price'     => floatval($order->get_item_total($item)),
						'quantity'  => intval($item->get_quantity())
					];
				}

				?>

				<!-- BEGIN: Purchase Event DataLayer Push -->
				<script>

					// Prepare the data that will be pushed to the Data Layer
					var purchaseData = {
						event: "purchase",
						ecommerce: {
							transaction_id: "<?php echo esc_js($order->get_order_number()); ?>",
							value: <?php echo floatval($order->get_total()); ?>,
							currency: "<?php echo esc_js($order->get_currency()); ?>",
							items: <?php echo json_encode($items); ?>
						}
					};

					// Log the data to the console to verify what is being sent to DataLayer
					console.log('Data to be pushed to DataLayer:', purchaseData);

					// Push the data to the DataLayer
					window.dataLayer = window.dataLayer || [];
					dataLayer.push(purchaseData);

					console.log('✅ GA4 purchase push fired from Page');


				</script>
		
				<?php

			} else {
				$post_type = 'recurringorder'; 
				$first_name = get_field('donor_first_name',$order_id);
				$last_name = get_field('donor_last_name',$order_id);
				$phone = get_field('donor_phone_number',$order_id);
				$email = get_field('donor_email',$order_id);
			}

			

			//$newsletter_signup = get_field('newsletter_signup',$order_id);

			echo signup_to_mailchimp($email, $first_name, $last_name, $phone);
			
			if($donation_option != 's') {
				$post_type = 'recurringorder'; 

				//Now lets send the email shall we?
				echo send_recurring_email($order_id);

				// And let's delete the cookie for recurring order mate
				// $cookie_name = 'shopping_cart';
				// unset($_COOKIE[$cookie_name]);
				// // empty value and expiration one hour before
				// $res = setcookie($cookie_name, '', time() - 3600);

				$recurring_total = 0;
				while ( have_rows('donations',$order_id) ) : the_row();
					$recurring_total = $recurring_total+get_sub_field('amount');
				endwhile;
			}
		?>
		
		<div class="thank_you_wrap">
			<ul class="share_donation become_monthly_donor" style="padding-top: 15px !important;">
				<li style="padding-top: 0px !important;">
					<h3 style="font-size: 19px !important; color:#04A7A8; line-height: 20px;"><strong>Thank you <?php echo $first_name; ?>!</strong><br /></h3>
					<p style="font-size: 15px !important; line-height: 16px;">Thank you for your donation, you will be sent a confirmation email shortly, your donation reference number is: <strong>#<?php echo $order_id; ?></strong></p>
					<br />
					<p><strong>Become a Monthly Supporter!</strong></p>
					<p style="font-size: 15px !important; line-height: 16px;">Monthly donations ensure continous support for our work. Would you like to become a monthly donor <strong>starting next month?</strong></p>
					<a class="monthly-donate-button" rel="nofollow noreferrer noopener" href="/monthly-supporter">Yes, I'll give monthly</a>
				</li>
			</ul>
		</div>

		<?php endif; ?>
	<?php endwhile; ?>
	</div>

<script type="text/javascript">
	jQuery(".wp-block-gallery .blocks-gallery-item a").fancybox().attr('data-fancybox', 'gallery');
</script>

		<!-- <script>(function(w,d,s,n,a){if(!w[n]){var l='call,catch,on,once,set,then,track,openCheckout'
				.split(','),i,o=function(n){return'function'==typeof n?o.l.push([arguments])&&o
				:function(){return o.l.push([n,arguments])&&o}},t=d.getElementsByTagName(s)[0],
				j=d.createElement(s);j.async=!0;j.src='https://cdn.fundraiseup.com/widget/'+a+'';
				t.parentNode.insertBefore(j,t);o.s=Date.now();o.v=5;o.h=w.location.href;o.l=[];
				for(i=0;i<8;i++)o[l[i]]=o(l[i]);w[n]=o}
				})(window,document,'script','FundraiseUp','ASFPFBAA');</script> -->
<?php get_footer(); ?>
