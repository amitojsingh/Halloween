<?php
/*
 * The Header template for our theme
 */ ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class();?>> 
    <?php if(get_theme_mod('preloader') != 2) :
        if(get_theme_mod('customPreloader') == '') { ?>
            <div class="preloader">
                <?php  get_template_part('template-parts/svg-loader/default'); ?>
            </div>
        <?php } else{ ?>
            <div class="preloader"><span class="preloader-gif" style="background: url(<?php echo esc_url(get_theme_mod('customPreloader')); ?>) no-repeat;background-size: contain;animation: none;"></span></div>
    <?php } endif;
        get_template_part('template-parts/header-style/fitness-freak-template');
     ?>