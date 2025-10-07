(function ($) {
  'use strict';

  var mq = window.matchMedia('(max-width: 767.98px)');

  function initOrDestroy($list) {
    if (!$.fn || !$.fn.slick) return; // Slick not ready
    if (mq.matches) {
      if (!$list.hasClass('slick-initialized')) {
        $list.slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: true,
          adaptiveHeight: true,
          infinite: false,
          mobileFirst: true
        });
      }
    } else if ($list.hasClass('slick-initialized')) {
      $list.slick('unslick');
    }
  }

  function sweepAll() {
    $('.project-cards-grid__list').each(function () {
      initOrDestroy($(this));
    });
  }

  // Try until Slick is actually available, then run once
  function whenSlickReady(cb) {
    if ($.fn && $.fn.slick) return cb();
    var tries = 0, maxTries = 40; // ~4s
    var t = setInterval(function () {
      tries++;
      if ($.fn && $.fn.slick) { clearInterval(t); cb(); }
      if (tries >= maxTries) { clearInterval(t); }
    }, 100);
  }

  // Debounce resize/mq changes
  var raf, onChange = function () {
    cancelAnimationFrame(raf);
    raf = requestAnimationFrame(sweepAll);
  };

  // Kick off
  $(function () { whenSlickReady(sweepAll); });
  $(window).on('load', function () { whenSlickReady(sweepAll); });

  if (typeof mq.addEventListener === 'function') {
    mq.addEventListener('change', onChange);
  } else if (typeof mq.addListener === 'function') {
    mq.addListener(onChange);
  }
  $(window).on('resize orientationchange', onChange);

})(jQuery);
