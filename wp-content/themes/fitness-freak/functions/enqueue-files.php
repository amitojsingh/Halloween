<?php
/*
 * fitness-freak Enqueue css and js files
 */
function fitness_freak_enqueue() {   
    wp_enqueue_style('fitness-freak-font-raleway', '//fonts.googleapis.com/css?family=Raleway:400,300,600,700', array(),null);

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(),null);
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(),null);       
    wp_enqueue_style('fitness_freak_main_style', get_template_directory_uri() . '/assets/css/default.css', array(),null);
    wp_enqueue_style('fitness_freak_header', get_template_directory_uri() . '/assets/css/fitness-freak-header.css', array(),null);
    
    wp_enqueue_script("comment-reply");   
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js',array('jquery'), false, true );
    wp_enqueue_script('fitness-freak-custom', get_template_directory_uri() . '/assets/js/fitness-freak-custom.js',array('jquery'), false, true);      

    fitness_freak_custom_css();
}
add_action('wp_enqueue_scripts', 'fitness_freak_enqueue');