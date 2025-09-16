<?php 
/**
 * Block Name: Section Row
 */ 
global $post;
global $block;
global $location_block;
global $is_preview;

$classes = '';
if( !empty($block['className']) ) {
    $classes .= sprintf( ' %s', $block['className'] );
}
if( !empty($block['align']) ) {
    $classes .= sprintf( ' align%s', $block['align'] );
}

if(get_field('section_height') === 'custom' ):
	$section_height = get_field('custom_height').'vh';
elseif(get_field('section_height') === 'none'):
	$section_height = '';
else:
	$section_height = get_field('section_height').'vh';
endif;

?>

<?php 
if( have_rows('margin') ): 
	while( have_rows('margin') ) : the_row();
		$margin_top = get_sub_field('margin_top');
		$margin_right = get_sub_field('margin_right');
		$margin_bottom = get_sub_field('margin_bottom');
		$margin_left = get_sub_field('margin_left');
	endwhile;
endif; 

if( have_rows('padding') ): 
	while( have_rows('padding') ) : the_row();
		$padding_top = get_sub_field('padding_top');
		$padding_right = get_sub_field('padding_right');
		$padding_bottom = get_sub_field('padding_bottom');
		$padding_left = get_sub_field('padding_left');
	endwhile;
endif; 
?>

<div class="lw_section  <?php the_field('content_size'); ?> <?php the_field('text_colour'); ?> <?php the_field('visibile_in'); ?> <?php if( !$is_preview ) { echo 'admin_preview'; } ?>
<?php if(get_field('margin_settings') !== 'custom_margin'): echo ' '; the_field('margin_settings'); endif; ?>
"
style="
<?php if(get_field('margin_settings') === 'custom_margin'): ?>
margin-top:<?php echo $margin_top; ?>px;
margin-right:<?php echo $margin_right; ?>px;
margin-bottom:<?php echo $margin_bottom; ?>px;
margin-left:<?php echo $margin_left; ?>px;
<?php endif; ?> 
height:<?php echo $section_height; ?>;
">
	<section class="lw__section_item  <?php the_field('section_width'); ?> <?php the_field('background_position'); ?> <?php echo esc_attr($classes); ?>"
	style="height:<?php echo $section_height; ?>;
	<?php if(get_field('background_type') === 'image'): 
		$content_image_id = get_field('background_image');
		$content_image = vt_resize($content_image_id,'' , 2000, 700, false);
		?>
		background:url('<?php echo $content_image['url']; ?>') center center no-repeat;
	<?php endif; ?>">

		<?php if(get_field('overlay_colour')): ?>
		<div class="content_background" 
		style="height:<?php echo $section_height; ?>; background:<?php the_field('overlay_colour'); ?>; 
			<?php if(get_field('opacity_overlay')):?>
				-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php the_field('opacity_overlay'); ?>)';
				-moz-opacity:0.<?php the_field('opacity_overlay'); ?>;
				-khtml-opacity: 0.<?php the_field('opacity_overlay'); ?>;
				opacity: 0.<?php the_field('opacity_overlay'); ?>;
			<?php endif; ?>">
		</div>
		<?php endif; ?>
		
		<?php if(get_field('background_type') === 'video'): ?>
		<div class="video_container">
			<video class="video" width="1800" muted="" autoplay="" loop="" preload="auto">
				<source src="<?php the_field('video_file'); ?>" type="video/mp4"></source>
			</video>
		</div>
		<?php endif; ?>

		<?php if(get_field('background_type') === 'youtube'): ?>
		<section class="youtube_banner loading">
			<div class="image video-slide">
				<div class="video-background">
					<div class="video-foreground" id="player">
					</div>
				</div>
			</div>
		</section>
		

		<script async src="https://www.youtube.com/iframe_api"></script>
		<script async >
			// 2. This code loads the IFrame Player API code asynchronously.
			// var tag = document.createElement('script');

			// tag.src = "https://www.youtube.com/iframe_api";
			// var firstScriptTag = document.getElementsByTagName('script')[0];
			// firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			// 3. This function creates an <iframe> (and YouTube player)
			//    after the API code downloads.
			var player;
			function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
					videoId: '<?php the_field('youtube_id'); ?>', // YouTube Video ID
					width: 1280,               // Player width (in px)
					height: 720,              // Player height (in px)
					playerVars: {
					playlist: '<?php the_field('youtube_id'); ?>',
						autoplay: 1,        // Auto-play the video on load
						autohide: 1,
						disablekb: 1, 
						controls: 0,        // Hide pause/play buttons in player
						showinfo: 0,        // Hide the video title
						modestbranding: 1,  // Hide the Youtube Logo
						loop: 1,            // Run the video in a loop
						fs: 0,              // Hide the full screen button
						autohide: 0,         // Hide video controls when playing
						rel: 0,
						enablejsapi: 1
					},
					events: {
						onReady: function(e) {
							e.target.mute();
							e.target.setPlaybackQuality('hd1080');
						},
						onStateChange: function(e) {
							if(e && e.data === 1){
								var videoHolder = document.getElementById('player');
								if(videoHolder && videoHolder.id){
								videoHolder.classList.remove('loading');
								}
							}else if(e && e.data === 0){
							e.target.playVideo()
							}
						}
					}
				
				});
			}

			// 4. The API will call this function when the video player is ready.
			function onPlayerReady(event) {
				event.target.playVideo();
			}

			// 5. The API calls this function when the player's state changes.
			//    The function indicates that when playing a video (state=1),
			//    the player should play for six seconds and then stop.
			var done = false;
			function onPlayerStateChange(event) {
				if (event.data == YT.PlayerState.PLAYING && !done) {
				setTimeout(stopVideo, 6000);
				done = true;
				}
			}
			function stopVideo() {
				player.stopVideo();
			}

		</script>
	
		<?php ?>
		<?php endif; ?>
		
		<div class="innerBlockSection 
		<?php if(get_field('section_height')): 
			if( get_field('section_height') !== 'none'): 
				echo 'position_absolute ';
				echo 'position_'.get_field('inner_block_position').' ';
			endif; 
		endif; ?>

		<?php if(get_field('padding_settings') !== 'custom_padding'): echo ' '; the_field('padding_settings'); endif; ?>"
		
			style="
			<?php if(get_field('padding_settings') === 'custom_padding'): ?>
				padding-top:<?php echo $padding_top; ?>px;
				padding-right:<?php echo $padding_right; ?>px;
				padding-bottom:<?php echo $padding_bottom; ?>px;
				padding-left:<?php echo $padding_left; ?>px;
			<?php endif; ?>
			">
			<InnerBlocks />
		</div>

	</section>
</div>
