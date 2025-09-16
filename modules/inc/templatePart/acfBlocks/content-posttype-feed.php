<?php 
/**
 * Block Name: Post Type Feed
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
    <section class="content__wrapper gutenberg__wrap">
        <section class="featured__fixed_listing category_listing_box">
            <div class="fixed__wrapper">

                <div class="featured__fixed_heading">
                    <h4 class="watermark__heading"><?php the_field('posttype_second_heading'); ?></h4>
                    <div class="caption__wrap">
                        <h3><?php the_field('posttype_first_heading'); ?></h3>
                        <h2><?php the_field('posttype_second_heading'); ?></h2>
                    </div>
                </div>
                

                <div class="fixed__top_newsbox large_box">
                
                    <div class="col_1_2 main__carousel featured__fixed_top">
                        <?php 
                            $post_types = get_field('posttype_post_type');
                            $args = array(
                                'post_type' => $post_types,
                                'post_status' => 'publish',
                                'order' => 'DESC',
                                'orderby' => 'date',
                                'offset' => 0,
                                'posts_per_page' => 1
                            ); ?>
                        <?php $query_listing = new WP_Query( $args ); 
                        while($query_listing->have_posts()) : $query_listing->the_post(); 
                        $post = get_post(); ?>

                            <div class="item_box col_1_1">
                                    
                                <figure>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php if(get_post_thumbnail_id($post->ID)):
                                        $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                                        $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                                        ?>
                                        <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                                        <?php else: ?>
                                            <?php if(get_post_type() === 'video'): 
                                                $post_image_url = 'https://img.youtube.com/vi/'.get_field('youtube_id',$post->ID).'/maxresdefault.jpg';
                                                $post_bg_image_id = get_field('blank_image','options');
                                                $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true); ?>
                                                <div class="video__image" style="background:url('<?php echo $post_image_url; ?>') center center;"></div>
                                                <!--<img src="<?php echo $post_image_url; ?>" class="youtube__video_thumb" alt="<?php the_title(); ?>">-->
                                            <?php endif; ?>
                                        <?php endif; ?>  
                                    </a>
                                    <span class="cta__icon">
                                    <?php if(get_post_type() === 'video'): ?>
                                        <svg enable-background="new 0 0 512 512" height="512px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M256,512C114.625,512,0,397.375,0,256C0,114.609,114.625,0,256,0s256,114.609,256,256C512,397.375,397.375,512,256,512z   M256,64C149.969,64,64,149.969,64,256s85.969,192,192,192c106.03,0,192-85.969,192-192S362.031,64,256,64z M192,160l160,96l-160,96  V160z"/></svg>
                                    <?php elseif(get_post_type() === 'podcast'): ?>
                                        <svg enable-background="new 0 0 512 512" height="512px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M408.207,150.644c-12.984,12.954-33.993,12.954-46.979,0c-12.955-12.955-12.955-33.995,0-46.981l93.931-93.931  c12.986-12.955,33.995-12.955,46.981,0c12.954,12.955,12.954,33.995,0,46.98L408.207,150.644z M255.871,511.727L128.008,383.863  H32.11c-17.669,0-31.966-14.299-31.966-31.967V160.102c0-17.668,14.297-31.966,31.966-31.966h95.897L255.871,0.272  c0,0,31.966-3.996,31.966,31.966c0,191.233,0,478.926,0,447.522C287.837,515.722,255.871,511.727,255.871,511.727z M223.905,128.136  l-63.932,63.932H64.076v127.864h95.896l63.932,63.933V128.136z M383.734,287.965c-17.669,0-31.966-14.297-31.966-31.966  c0-17.668,14.297-31.966,31.966-31.966h95.897c17.669,0,31.966,14.298,31.966,31.966c0,17.669-14.297,31.966-31.966,31.966H383.734z   M408.207,361.355l93.933,93.931c12.954,12.986,12.954,34.026,0,46.98c-12.986,12.955-33.995,12.955-46.981,0l-93.931-93.931  c-12.955-12.986-12.955-34.025,0-46.98C374.214,348.4,395.223,348.4,408.207,361.355z"/></svg>
                                    <?php else: ?>
                                        <svg version="1.1" id="Layer_1" class="arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <path d="M3.8,256c0,19.9,16.2,36.1,36.1,36.1h346.6l-83.4,83.4c-7.1,7.1-10.5,15.6-10.5,24.9c0,17.8,14.7,36.1,36.1,36.1
                                            c9.6,0,17.9-3.5,24.9-10.5l143.9-143.9c6.6-6.6,11.7-13,11.7-26.1s-6-20.5-11.9-26.4L353.6,85.9c-7-7-15.3-10.5-24.9-10.5
                                            c-21.4,0-36.1,18.3-36.1,36.1c0,9.3,3.4,17.8,10.5,24.9l83.4,83.4H39.9C20,219.9,3.8,236,3.8,256z"/>
                                        </svg>
                                    <?php endif; ?>
                                    </span>
                                    

                                </figure>
                                <div class="post__excerpt">
                                    <span class="post__date"><?php echo get_the_time("d M Y"); ?></span>
                                    <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <?php //single_author_details($post->ID,'dark'); ?>
                                </div>

                            </div>

                        <?php  endwhile; wp_reset_query(); ?>
                    </div>

                    <div class="col_1_2 featured__fixed_bottom no_spacing_border">
                        <?php $args_second = array(
                                'post_type' => $post_types,
                                'post_status' => 'publish',
                                'order' => 'DESC',
                                'orderby' => 'date',
                                'offset' => 1,
                                'posts_per_page' => 3
                            ); ?>
                        <?php $query_listing_second = new WP_Query( $args_second ); 
                        while($query_listing_second->have_posts()) : $query_listing_second->the_post(); 
                        $post = get_post(); ?>

                            <div class="item_box listing_box">
                                    
                                <figure>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php if(get_post_thumbnail_id($post->ID)):
                                        $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                                        $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                                        ?>
                                        <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                                        <?php else: ?>
                                            <?php if(get_post_type() === 'video'): 
                                                $post_image_url = 'https://img.youtube.com/vi/'.get_field('youtube_id',$post->ID).'/maxresdefault.jpg';
                                                $post_bg_image_id = get_field('blank_image','options');
                                                $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true); ?>
                                                <div class="video__image" style="background:url('<?php echo $post_image_url; ?>') center center;"></div>
                                                <!--<img src="<?php echo $post_bg_image['url']; ?>" class="youtube__video_thumb" alt="<?php the_title(); ?>">-->
                                            <?php endif; ?>
                                        <?php endif; ?>  
                                    </a>
                                    <span class="cta__icon">
                                    <?php if(get_post_type() === 'video'): ?>
                                        <svg enable-background="new 0 0 512 512" height="512px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M256,512C114.625,512,0,397.375,0,256C0,114.609,114.625,0,256,0s256,114.609,256,256C512,397.375,397.375,512,256,512z   M256,64C149.969,64,64,149.969,64,256s85.969,192,192,192c106.03,0,192-85.969,192-192S362.031,64,256,64z M192,160l160,96l-160,96  V160z"/></svg>
                                    <?php elseif(get_post_type() === 'podcast'): ?>
                                        <svg enable-background="new 0 0 512 512" height="512px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M408.207,150.644c-12.984,12.954-33.993,12.954-46.979,0c-12.955-12.955-12.955-33.995,0-46.981l93.931-93.931  c12.986-12.955,33.995-12.955,46.981,0c12.954,12.955,12.954,33.995,0,46.98L408.207,150.644z M255.871,511.727L128.008,383.863  H32.11c-17.669,0-31.966-14.299-31.966-31.967V160.102c0-17.668,14.297-31.966,31.966-31.966h95.897L255.871,0.272  c0,0,31.966-3.996,31.966,31.966c0,191.233,0,478.926,0,447.522C287.837,515.722,255.871,511.727,255.871,511.727z M223.905,128.136  l-63.932,63.932H64.076v127.864h95.896l63.932,63.933V128.136z M383.734,287.965c-17.669,0-31.966-14.297-31.966-31.966  c0-17.668,14.297-31.966,31.966-31.966h95.897c17.669,0,31.966,14.298,31.966,31.966c0,17.669-14.297,31.966-31.966,31.966H383.734z   M408.207,361.355l93.933,93.931c12.954,12.986,12.954,34.026,0,46.98c-12.986,12.955-33.995,12.955-46.981,0l-93.931-93.931  c-12.955-12.986-12.955-34.025,0-46.98C374.214,348.4,395.223,348.4,408.207,361.355z"/></svg>
                                    <?php else: ?>
                                        <svg version="1.1" id="Layer_1" class="arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <path d="M3.8,256c0,19.9,16.2,36.1,36.1,36.1h346.6l-83.4,83.4c-7.1,7.1-10.5,15.6-10.5,24.9c0,17.8,14.7,36.1,36.1,36.1
                                            c9.6,0,17.9-3.5,24.9-10.5l143.9-143.9c6.6-6.6,11.7-13,11.7-26.1s-6-20.5-11.9-26.4L353.6,85.9c-7-7-15.3-10.5-24.9-10.5
                                            c-21.4,0-36.1,18.3-36.1,36.1c0,9.3,3.4,17.8,10.5,24.9l83.4,83.4H39.9C20,219.9,3.8,236,3.8,256z"/>
                                        </svg>
                                    <?php endif; ?>
                                    </span>
                                    

                                </figure>
                                <div class="post__excerpt">
                                    <span class="post__date"><?php echo get_the_time("d M Y"); ?></span>
                                    <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <?php //single_author_details($post->ID,'dark'); ?>
                                </div>

                            </div>
                            
                        <?php  endwhile; wp_reset_query(); ?>
                    </div>
        
                </div>

        
                <div class="resultAjax featured__fixed_top large_box" id="ajaxLoadPosts">
                    <div class="loadingBox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/loader.gif" alt=""></div>
                </div>

                <div class="centerContent paddingVertical load__more_button">
                        <a href="#" id="more_articles" class="button till wave borderStyle">
                            <span class="text">Load More</span>
                            <span class="loadericon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/loader.gif" alt=""></span>
                        </a>
                </div>
                
                
            </div>
        </section>
    </section>
</div>

<?php 
$ajax_posttypes = implode(', ',$post_types);
?>
<script>
jQuery(document).ready(function($) {
	$ppp = 8;
	$pageNumber = 1;
	$tum_tax = '';
	$tum_post_type = '<?php echo $ajax_posttypes; ?>';
	$tum_offset = 4;
	$filter = 'all';
	$action = 'postfilter';
	$dataUrl = 'tum_post_type='+ $tum_post_type +'&action='+ $action +'&ppp='+ $ppp +'&pageNumber=' + $pageNumber + '&tum_offset=' + $tum_offset +'&tum_tax=' + $tum_tax;
	load_the_posts();
});
</script>

<script type="text/javascript">
function load_the_posts(){
jQuery.ajax({
	url:  '<?php echo site_url() ?>/wp-admin/admin-ajax.php?',
	data: $dataUrl+'&pageNumber=' + $pageNumber,
	type: 'POST',
	beforeSend:function(xhr){
		ajax_before();
	},
	success:function(data){
		jQuery('#ajaxLoadPosts').html(data);
		ajax_after();
	}
});
return false;
}

jQuery("#more_articles").on("click",function(e){
	jQuery("#more_articles").attr("disabled",true);
	$pageNumber++;
	load_the_posts();
	e.preventDefault();
});

function ajax_before() {
	jQuery(".loadingBox").show();
	jQuery("input:checkbox").attr("disabled",true);
	jQuery('.resultAjax').addClass('loadingScreen');
	jQuery('#more_articles .text').hide();
	jQuery('#more_articles .loadericon').show();
}

function ajax_after() {
	jQuery('.resultAjax').removeClass('loadingScreen');
	jQuery('#more_articles .loadericon').hide();
	jQuery('#more_articles .text').show();
	jQuery("input:checkbox").removeAttr("disabled");
	jQuery(".loadingBox").hide();
}
</script>
