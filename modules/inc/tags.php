<?php $postTag = bdb_get_parent_terms( $post->ID, 'post_tag' );
if ( !empty( $postTag ) ) { ?>
<div class="in__tags">
    <?php foreach ( $postTag as $postTags ) { ?>
    <a href="/tag/<?php echo $postTags->slug; ?>" class="tagLink" data-value="<?php echo $postTags->slug; ?>" title="<?php echo $postTags->name; ?>">#<?php echo $postTags->name; ?></a>
    <?php } ?>
</div>
<?php } ?>
