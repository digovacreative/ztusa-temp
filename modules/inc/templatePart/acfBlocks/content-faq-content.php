<?php
/**
 * Block Name: FAQ Content Box
 */
defined('ABSPATH') || exit;

$block_id           = 'faq-box-' . wp_unique_id();
$size               = (string) get_field('content_size');
$colour             = (string) get_field('content_colour');
$bg                 = (string) get_field('background_colour');
$block_heading      = (string) get_field('block_heading');
?>
<div id="<?php echo esc_attr($block_id); ?>">
  <section
    class="faq_content_box <?php echo esc_attr(trim("$size $colour")); ?>"
    <?php echo $bg ? 'style="background:' . esc_attr($bg) . ';"' : ''; ?>
  >
    <h2><?php echo esc_html( $block_heading); ?></h2>
    <?php if ( have_rows('faq_items') ) : ?>
      <?php while ( have_rows('faq_items') ) : the_row();
        $q = get_sub_field('question');
        $a = get_sub_field('answer');
      ?>
        <article>
          <button type="button" class="accordion-toggle" aria-expanded="false">
            <span class="accordion-title"><?php echo $q ? wp_kses_post($q) : ''; ?></span>
            <svg class="icon" viewBox="0 0 22 30" aria-hidden="true" focusable="false">
              <path d="M9.469 21.738l-9.25-9.175c-0.294-0.294-0.294-0.769 0-1.063l1.238-1.238c0.294-0.294 0.769-0.294 1.062 0l7.481 7.406 7.481-7.406c0.294-0.294 0.769-0.294 1.063 0l1.238 1.238c0.294 0.294 0.294 0.769 0 1.063l-9.25 9.175c-0.294 0.294-0.769 0.294-1.063 0z"></path>
            </svg>
          </button>
          <div class="accordion-content" hidden>
            <?php echo $a ? wp_kses_post($a) : ''; ?>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <?php if ( is_admin() ) : ?>
        <p><em>No FAQs found. Add rows in <strong>faq_items</strong>.</em></p>
      <?php endif; ?>
    <?php endif; ?>
  </section>
</div>

<?php if ( ! is_admin() ) : ?>
<script>
(function($){
  var $root = $('#<?php echo esc_js($block_id); ?>');
  if (!$root.length || !window.jQuery) return;

  $root.on('click', '.accordion-toggle', function(){
    var $btn     = $(this);
    var $content = $btn.closest('article').find('.accordion-content').first();
    var expanded = $btn.attr('aria-expanded') === 'true';

    // Toggle ONLY this item
    $btn.attr('aria-expanded', expanded ? 'false' : 'true');
    if (expanded) {
      $content.attr('hidden', true).slideUp('fast');
    } else {
      $content.removeAttr('hidden').slideDown('fast');
    }
  });
})(jQuery);
</script>
<?php endif; ?>
