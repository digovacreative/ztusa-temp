(function ($) {
    function renderDonation(productId) {
      var $ui = $('#lh__donation-ui');
      var ajax = $ui.data('ajax');
      if (!productId) {
        $ui.html('<div class="lh__placeholder">Please select a fund</div>');
        return;
      }
      $.ajax({
        url: ajax,
        type: 'POST',
        data: {
          action: 'loadproject',
          project_id: productId,
          skin: 'hero' // <- tells PHP to add the hero skin class
        },
        success: function (html) { $ui.addClass('is-ready').html(html); }
      });
    }
  
    // Initial load (for single pre-selected fund)
    $(function () {
      var pid = parseInt($('#lh__donation-ui').data('product-id'), 10);
      if (pid) renderDonation(pid);
    });
  
    // Fund change
    $(document).on('change', '#lh__fund', function () {
      var pid = parseInt($(this).val(), 10) || 0;
      renderDonation(pid);
    });
  
    // ---- Safety: delegated tab switching after HTML injection (works with your random suffix) ----
    $(document).off('click.lhTabs').on('click.lhTabs', '.landing-hero .quickproduct ul[id="tabsnav"] li a', function (e) {
      e.preventDefault();
      var $a = $(this), href = $a.attr('href');            // e.g. #2-<rand>
      var $ul = $a.closest('ul');                          // tab list
      var $wrap = $ul.closest('.productWrapper');          // content wrapper
      $ul.find('li').removeClass('active');
      $a.closest('li').addClass('active');
      // Hide all panels that share the suffix for this instance:
      var suffix = href.split('-').pop();                  // the random string
      $wrap.find('.tabContent-' + suffix).hide();
      $(href).fadeIn();
    });
  })(jQuery);
  