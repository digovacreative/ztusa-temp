<?php get_header(); 
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

?>
	<?php //include_once('modules/flexible-content/flexible-fields.php'); ?>
	<div class="content__wrapper gutenberg__wrap">
    <?php echo do_shortcode('[gocardless_success]'); ?>
    </div>
<?php get_footer(); ?>