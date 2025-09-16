<?php
function load_loadquickdonation_function(){  ?>
<div class="quick__donation_wrap">
    <select class="select_project_name">
    <?php $products_listing = get_field('projects'); ?>
    <?php foreach( $products_listing as $project_id): ?>
        <option value="<?php echo $project_id; ?>"><?php echo get_the_title($product); ?></option>
    <?php endforeach; ?>        
    </select>
    <div class="donation_price">
    <?php 
    if(isset($_POST['project_id'])):
        
    else:
        echo '<p>Select Project first</p>';
    endif;
    ?>
    </div>
    <a href="#" class="button till">Donate</a>
</div>
<?php  die();
}
add_action('ZTRUST_AJAX_loadquickdonation', 'load_loadquickdonation_function');
add_action('ZTRUST_AJAX_nopriv_loadquickdonation', 'load_loadquickdonation_function');
?>