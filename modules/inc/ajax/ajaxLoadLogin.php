<?php
function load_login_function(){ ?>

<?php
 die();
}
add_action('ZTRUST_AJAX_loadlogin', 'load_login_function');
add_action('ZTRUST_AJAX_nopriv_loadlogin', 'load_login_function');
?>