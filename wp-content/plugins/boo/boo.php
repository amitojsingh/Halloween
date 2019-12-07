<?php
/*
   Plugin Name: Boo admin
  a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Amitoj Singh
   License: GPL2
   */
function boo_admin(){
    add_menu_page('boo Widget','Boo','manage_options','boo_admin',200);
}
add_action('admin_menu','boo_admin');
?>