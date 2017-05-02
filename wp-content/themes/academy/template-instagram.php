<?php
/*
Template Name: Instagram
*/

$code = !empty($_GET['code']) ? $_GET['code'] : false;
if(!$code){
    wp_redirect(get_bloginfo('home'));
    exit;
}

wp_redirect(get_bloginfo('home').'/wp-admin/options-general.php?page=instagram&inst=1&code='.$code);
exit;