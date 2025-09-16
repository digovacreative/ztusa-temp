<?php /* Template Name: 404 Error */ get_header(); ?>
<section class="error-page medium_box" aria-label="404 Error Page" role="general" style="background:url('<?php the_field('error_page_background','options'); ?>') no-repeat bottom;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
  <div class="darkText  textContent">
    <h1 align="center" class="error_heading">Sorry</h1>
    <h3 align="center">Page not found</h3>
    <p align="center">The page you are looking for might have been removed, had it's name changed or is temporarily unavailable.<br /><a href="/">Back to homepage</a></p>
  </div>
</section>
<?php get_footer(); ?>
