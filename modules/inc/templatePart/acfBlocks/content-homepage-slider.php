<?php 
/**
 * Block Name: Homepage Carousel
 */ 
global $post;
global $location_block;
?>

<style>


	/* slider height */
	.gutenberg__wrap .homepage__slider_carousel.medium .main__carousel, .gutenberg__wrap .homepage__slider_carousel.medium, .gutenberg__wrap .homepage__slider_carousel.medium .main__carousel .item_box {
		height: auto !important;
		width: 100% !important;
		min-height: auto !important;
	}

	/* arrows */

	.gutenberg__wrap .slick-prev, .gutenberg__wrap .slick-next {
		z-index: 999;
		height: auto;
		width: auto;
		background-color: rgba(0,0,0,.35);
		border-radius:100%;
		padding:3px;
	}

	.gutenberg__wrap .slick-prev {
    	left: 25px;
	}

	.gutenberg__wrap .slick-next {
    	right: 25px;
	}
	.gutenberg__wrap .slick-prev:before {
    	content: "≪";
	}

	.gutenberg__wrap .slick-next:before {
    	content: "≫";
	}

	.gutenberg__wrap .slick-next:before, .gutenberg__wrap .slick-prev:before {
		font-family: "slick";
		font-size: 2rem;
		line-height: 1;
		color: white;
		opacity: .90;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		padding: 5px;
		border-radius: 100%;
	}

	.gutenberg__wrap .homepage__slider_carousel .main__carousel .item_box:before {
		display: none;
	}

</style>
<div class="gutenberg__wrap">
	<section class="homepage__slider_carousel content-homepage-slider medium <?php the_field('banner_style'); ?>">

		<div class="main__carousel" id="carousel__main_scroller">
		<?php while(has_sub_field('banner_items')): ?>
			<?php 
			if(isMobile()){
				if(get_sub_field('banner_image_mobile')): 
					$banner_image_id = get_sub_field('banner_image_mobile');
					$banner_image = vt_resize($banner_image_id,'' , 1000, 2000, false);
				else:
					$banner_image_id = get_sub_field('banner_image');
					$banner_image = vt_resize($banner_image_id,'' , 2000, 1500, false);
				endif;

			} else {

				if(get_sub_field('banner_image')): 
					$banner_image_id = get_sub_field('banner_image');
					$banner_image = vt_resize($banner_image_id,'' , 2000, 1500, false);
				endif;
			}

			$buttonLink = get_sub_field('button_link');
			?>
			
			<?= empty($buttonLink) ? "<a>" : "<a href=".$buttonLink.">" ?>
				<div class="item_box <?php if(get_sub_field('banner_small_heading') || get_sub_field('banner_heading') || get_sub_field('banner_text') ): echo 'has_overlay'; endif; ?>  <?php if(!get_sub_field('button_label')): echo 'no_button'; endif; ?>" style="background-size: contain !important; background-position: top center !important; background-repeat: no-repeat !important; background:url('<?php echo $banner_image['url']; ?>');">
					<div class="caption__bg <?php the_sub_field('text_position'); ?>"></div>
					<div class="large_box">
						<div class="caption <?php the_sub_field('text_position'); ?>"> 
							<?php if(get_sub_field('banner_small_heading')): ?><h4><?php the_sub_field('banner_small_heading'); ?></h4><?php endif; ?>						
							<?php if(get_sub_field('banner_heading')): ?><h1><?php the_sub_field('banner_heading'); ?></h1><?php endif; ?>
							<?php if(get_sub_field('banner_text')): ?><h3><?php the_sub_field('banner_text'); ?></h3><?php endif; ?>
							<?php if(get_sub_field('button_label')): ?><a href="<?php the_sub_field('button_link'); ?>" class="button border white"><?php the_sub_field('button_label'); ?> 
							<svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg></a><?php endif; ?>
						</div>
					</div>
				</div>
				<img src="<?php echo $banner_image['url']; ?>"/>
			</a>


		<?php endwhile; ?>
		</div><!-- end first carousel sync -->
		

	</section>


	<?php if(get_field('enable_donation_box')): ?>
	<div class="banner_quick_donation_banner_box">

		<div class="donation__box">
			
			<div class="quick_donation_banner_container">
				<?php if(get_field('homepage_donation_heading')): ?>
				<h3><?php the_field('homepage_donation_heading'); ?></h3>	
				<?php endif; ?>
				
				<?php if(get_field('mobile_text')): 
					if(isMobile()){ ?>
					<p><?php the_field('mobile_text'); ?></p>	
				<?php }
				endif; ?>
				
				<?php if(count(get_field('project_select')) != 1 ){
				//oNly one no need for select but load the first project now habiby 
					?>
				<select class="select_project_name_banner">
					<option value="">Select a fund</option>
					<?php $products_listing = get_field('project_select'); ?>
					<?php foreach( $products_listing as $project_id): ?>
						<option value="<?php echo $project_id; ?>" data-project-id="<?php echo $project_id; ?>"><?php echo get_the_title($project_id); ?></option>
					<?php endforeach; ?>        
				</select>
				<?php } ?>
				<div id="quick_donation_banner">
					<p><span><svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"></rect></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "></polygon></g></svg></span> Select a fund</p>
				</div>

			</div>
		</div>	
	
	</div>
	<?php endif; ?>

</div>
<?php $ajaxurl = get_stylesheet_directory_uri() . '/modules/inc/customajax.php'; ?>


<script type="text/javascript">

	console.log("Homepage Slider: loaded");

	jQuery( document ).ready(function() {
		console.log("Homepage Slider: ready");
		//Onload select the only item
		<?php 
		$project_select = get_field('project_select');
		if($project_select && count($project_select) == 1) {  // Added null check
			?>
			load_the_banner_project_quickdonate(<?php echo $project_select[0]; ?>);  // Added escaping
		<?php } ?>
	});


	jQuery('#carousel__main_scroller').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	infinite: true,
	autoplay: false,
	fade: true,
	dots: false,
	centerMode: true,
	centerPadding: '0',
	autoplaySpeed: 4500,
	arrows: true,
	});


	function load_the_banner_project_quickdonate(project_id){
		console.log("Homepage Slider: "+project_id);
		jQuery.ajax({
			url:  '<?= $ajaxurl ?>',
			data: 'action=loadproject&project_id='+ project_id,
			type: 'POST',
			beforeSend:function(xhr){
				// ajax_before();
			},
			success:function(data){
				// ajax_after();
				jQuery('#quick_donation_banner').addClass('active');
				jQuery('#quick_donation_banner').html(data);
			}

		});
		return false;
	}



	jQuery(function () {
		jQuery("select.select_project_name_banner").change();
	});

	jQuery('.select_project_name_banner').change( function(event){ 
		var productID = jQuery(this).val();
		console.log(productID);
		load_the_banner_project_quickdonate(productID);
		event.preventDefault();
	});



</script>