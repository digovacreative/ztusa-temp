<?php
function bdbCurrenPage($pageLink) {
    $currentURL = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  $currentURL = str_replace('/',' ',$currentURL);
    $pageURL = str_replace('/',' ', $pageLink);
    $classActive='';
    if (strpos($currentURL, $pageURL) !== false): $classActive = 'active'; endif;
    return $classActive;
}
?>
