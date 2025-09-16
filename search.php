<?php
/*
Template Name: Search Result
*/
get_header(); ?>


<section class="gutenberg__wrap">
    <section class="large_box">
        <div class="fixed__wrapper">

            <div class="featured__fixed_heading">
                <div class="caption__wrap">
					<h2>SEARCH</h2>
                    <h3 class="center">You Searched For '<?php echo $_GET['search']; ?>'</h3>
                </div>
            </div>

			<div class="results_wrapper">
				<div class="resultAjax featured__fixed_bottom large_box" id="ajaxLoadPosts">
				</div>

				<div class="centerContent paddingVertical load__more_button">
						<a href="#" id="more_articles" class="button till wave borderStyle">
							<span class="text">Load More</span>
							<span class="loadericon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/loader.gif" alt=""></span>
						</a>
				</div>
			</div>
            
            
        </div>
    </section>
</section>

<script>
jQuery(document).ready(function($) {
	$ppp = 8;
	$pageNumber = 1;
	$tum_post_type = 'post,page,product';
    $filter = 'all';
    $searchQuery = '<?php echo $_GET['search']; ?>';
	$action = 'postsearch';
	$dataUrl = 'tum_post_type='+ $tum_post_type +'&action='+ $action +'&ppp='+ $ppp +'&pageNumber=' + $pageNumber + '&s=' + $searchQuery;
	load_the_posts();
});
</script>

<script type="text/javascript">
function load_the_posts(){
jQuery.ajax({
	url:  $ajaxurl,
	data: $dataUrl+'&pageNumber=' + $pageNumber,
	type: 'POST',
	beforeSend:function(xhr){
		ajax_before_search();
	},
	success:function(data){
		jQuery('#ajaxLoadPosts').html(data);
		ajax_after_search();
    },
    error: function(jqxhr, data, exception) {
        alert('Exception:', exception);
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

function ajax_before_search() {
	jQuery(".loadingBox").show();
	jQuery("input:checkbox").attr("disabled",true);
	jQuery('.resultAjax').addClass('loadingScreen');
	jQuery('#more_articles .text').hide();
	jQuery('#more_articles .loadericon').show();
}

function ajax_after_search() {
	jQuery('.resultAjax').removeClass('loadingScreen');
	jQuery('#more_articles .loadericon').hide();
	jQuery('#more_articles .text').show();
	jQuery("input:checkbox").removeAttr("disabled");
	jQuery(".loadingBox").hide();
}
</script>


<?php get_footer(); ?>
