<div class="latest__articles">
    <h3>Latest Articles</h3>

    <?php 
    $news_carousel_args_continued = array(
		'post_type' => 'post', // required
		'orderby' => 'date', 
		'order' => 'DESC', 
		'posts_per_page' => 3
	);
    ?>
    <div class="secondary__scroller">
        <?php
        $news_carousel_query = new WP_Query( $news_carousel_args_continued );
        if ( $news_carousel_query->have_posts() ) {
            while($news_carousel_query->have_posts()) {
            $news_carousel_query->the_post();
            global $post;
            ?>
            <div class="item_box owl-item">
                
                
                    <figure class="post__left_details">
                    <?php if(get_post_thumbnail_id($post->ID)):
                    $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                    $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                    ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                    </a>
                    <?php else: ?>
                            <?php if(get_post_type() === 'video'): ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img src="https://img.youtube.com/vi/<?php echo get_field('youtube_id',$post->ID); ?>/0.jpg" class="youtube__video_thumb" alt="<?php the_title(); ?>">
                                </a>
                            <?php endif; ?>
                    <?php endif; ?>  
                    </figure>
                    <div class="post__right_details">
                        <h3 class="post__title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <span class="post__date"><?php echo get_the_time("d M Y"); ?></span>
                    </div>

                

            </div>
            <?php 
            }
        } wp_reset_query(); ?>
        </div><!-- end first carousel sync -->



</div>

<?php /* ?>
<div class="author__box">
    <h3>About the Author</h3>
    <?php single_author_details($post->ID, 'dark', TRUE, TRUE); ?>
    <a href="<?php echo  get_author_posts_url(get_the_author_meta('ID')); ?>">Read more</a>
</div>

<div class="author__box">
    <h3>Signup</h3>
    <h2>To our Newsletter</h2>

    <div id="mc_embed_signup">
        <form action="https://urbanmuslimz.us4.list-manage.com/subscribe/post?u=d3fc2d6224702956bb07b2182&amp;id=176e672bb5" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <div id="mc_embed_signup_scroll">
                <div class="mc-field-group">
                    <input type="email" value="" placeholder="Email Address *" name="EMAIL" class="required email" id="mce-EMAIL">
                </div>
                <div class="mc-field-group">
                    <input type="text" value="" placeholder="First Name" name="FNAME" class="" id="mce-FNAME">
                </div>
                <div class="mc-field-group">
                    <input type="text" value="" placeholder="Surname" name="LNAME" class="" id="mce-LNAME">
                </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_d3fc2d6224702956bb07b2182_176e672bb5" tabindex="-1" value=""></div>
                    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
            </div>
            <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
        </form>
    </div>


</div>
*/ ?>

<div class="share__box">
    <h3>Share Article</h3>
    <div class="addthis_inline_share_toolbox"></div>
</div>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5de8f78404c94624"></script>
