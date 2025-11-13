<?php
/**
 * Template Name: Donation Popup Host (Minimal)
 * Description: Minimal host for the donation popup; no sliders, no listing HTML.
 */
defined('ABSPATH') || exit;

get_header();
?>
<div class="gutenberg__wrap">
	<div class="continue_shopping_popup" id="continue_shopping_popup"></div>
	</div>
	<?php //include_once('modules/flexible-content/flexible-fields.php'); ?>
	<div class="content__wrapper gutenberg__wrap">

<?php the_content(); ?>

  <section class="multiple_donation_box">
    <div class="wrap__box">
      <!-- Popup target (same id/class your AJAX expects) -->
      <div id="product_details_box" class="donate_page"></div>
    </div>
  </section>
</div>

<!-- Keep this if your add-to-cart flow shows the mini-cart popup -->
</div>
</div>
<script>
(function($){
  // Ensure $ajaxurl exists
  if (typeof window.$ajaxurl === 'undefined') {
    window.$ajaxurl = "<?php echo esc_url( admin_url('admin-ajax.php') ); ?>";
  }

  // Provide no-op loading helpers if your theme didn't define them
  if (typeof window.ajax_before !== 'function') window.ajax_before = function(){ $('body').addClass('loading'); };
  if (typeof window.ajax_after  !== 'function') window.ajax_after  = function(){ $('body').removeClass('loading'); };

  // SAME API your blocks expect
  window.load_the_project = function(project_id){
    $.ajax({
      url:  $ajaxurl,
      data: { action: 'loadproject', project_id: project_id },
      type: 'POST',
      beforeSend: ajax_before,
      success: function(html){
        ajax_after();
        $('#product_details_box').addClass('active').html(html);
        $('body').addClass('popup_active');
      }
    });
    return false;
  };

  // Legacy triggers (Multiple Donations Box)
  $(document).on('click', '.trigger__donation_box', function(e){
    e.preventDefault();
    var pid = parseInt($(this).data('project-id'), 10);
    if (pid) {
      $('body').addClass('popup_active');
      load_the_project(pid);
    }
  });

  // Project Cards Grid triggers
  $(document).on('click', '.js-donate-popup', function(e){
    e.preventDefault();
    var pid = parseInt($(this).data('project-id'), 10);
    if (pid) {
      $('body').addClass('popup_active');
      load_the_project(pid);
    }
  });

  $(document).on('click', '.project-card__link.has-popup', function(e){
    if ($(e.target).closest('.js-donate-popup').length) return;
    e.preventDefault();
    var pid = parseInt($(this).data('project-id'), 10);
    if (pid) {
      $('body').addClass('popup_active');
      load_the_project(pid);
    }
  });

  // Close button emitted inside the popup HTML
  $(document).on('click', '.close-project-popup', function(e){
    e.preventDefault();
    $('#product_details_box').removeClass('active').empty();
    $('body').removeClass('popup_active');
  });

  // Optional: open via ?donation_product=ID
  <?php if (!empty($_GET['donation_product']) && (int) $_GET['donation_product'] > 0): ?>
  $(function(){
    var pid = <?php echo (int) $_GET['donation_product']; ?>;
    $('body').addClass('popup_active');
    load_the_project(pid);
  });
  <?php endif; ?>
})(jQuery);
</script>

<?php get_footer(); ?>

		<!-- Fundraise Up: the new standard for online giving -->

  <!-- <script>(function(w,d,s,n,a){if(!w[n]){var l='call,catch,on,once,set,then,track,openCheckout'
				.split(','),i,o=function(n){return'function'==typeof n?o.l.push([arguments])&&o
				:function(){return o.l.push([n,arguments])&&o}},t=d.getElementsByTagName(s)[0],
				j=d.createElement(s);j.async=!0;j.src='https://cdn.fundraiseup.com/widget/'+a+'';
				t.parentNode.insertBefore(j,t);o.s=Date.now();o.v=5;o.h=w.location.href;o.l=[];
				for(i=0;i<8;i++)o[l[i]]=o(l[i]);w[n]=o}
				})(window,document,'script','FundraiseUp','ASFPFBAA');</script>   -->