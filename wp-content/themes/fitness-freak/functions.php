<?php
/*
* Set up the content width value based on the theme's design.
*/ 
if (!function_exists('fitness_freak_setup')) :
    function fitness_freak_setup() {   
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 870;
        }    
        // Make fitness-freak theme available for translation.
        load_theme_textdomain('fitness-freak', get_template_directory() . '/languages');

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support('automatic-feed-links');

        // register menu 
        register_nav_menus(array(
            'primary' => __('Top Header Menu', 'fitness-freak'),
        ));
        // Featured image support
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo', array(
            'height' => 120,
            'width' => 120,
            'flex-height' => true,
            'flex-width' => true,
            'priority' => 11,
            'header-text' => array('img-responsive', 'site-description'),
        ));
        add_image_size('fitness_freak_ThumbnailImage', 840, 560, true);

        add_theme_support('custom-header');
        // Switch default core markup for search form, comment form, and commen, to output valid HTML5.
        add_theme_support('html5', array(  'comment-form', 'comment-list',
        ));
        // Add support for featured content.
        add_theme_support('featured-content', array(
            'featured_content_filter' => 'fitness_freak_get_featured_posts',
            'max_posts' => 6,
        ));
        // This theme uses its own gallery styles.
        add_filter('use_default_gallery_style', '__return_false');
        /* slug setup */
        add_theme_support('title-tag');      
        
        function fitness_freak_active_widgets($active) {          

            //Bundled Widgets
            $active['video'] = true;
            $active['testimonial'] = true;
            $active['taxonomy'] = true;
            $active['social-media-buttons'] = true;
            $active['simple-masonry'] = true;
            $active['slider'] = true;
            $active['cta'] = true;
            $active['contact'] = true;
            $active['features'] = true;
            $active['headline'] = true;
            $active['hero'] = true;
            $active['icon'] = true;
            $active['image-grid'] = true;
            $active['price-table'] = true;
            $active['layout-slider'] = true;

            return $active;
        }
        $user = wp_get_current_user();
        update_user_option($user->ID, 'managenav-menuscolumnshidden',
            array( 0 => 'link-target',  1 => 'xfn', 2 => 'description', 3 => 'title-attribute', ),
            true);

        add_filter('siteorigin_widgets_active_widgets', 'fitness_freak_active_widgets');
    }

endif; // fitness_freak_setup
add_action('after_setup_theme', 'fitness_freak_setup');
add_filter('nav_menu_css_class', 'fitness_freak_special_navclass', 10, 2);

function fitness_freak_special_navclass($classes, $item) {
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    return $classes;
}

add_filter( 'nav_menu_css_class', 'fitness_freak_nav_menu_css_class' );
add_filter( 'walker_nav_menu_start_el', 'fitness_freak_walker_nav_menu_start_el', 10, 4 );

function fitness_freak_nav_menu_css_class( $classes ){
        if( is_array( $classes ) ){
            $tmp_classes = preg_grep( '/^(fa)(-\S+)?$/i', $classes );
            if( !empty( $tmp_classes ) ){
                $classes = array_values( array_diff( $classes, $tmp_classes ) );
            }
        }
        return $classes;
}
function fitness_freak_walker_nav_menu_start_el( $item_output, $item, $depth, $args ){
        if( is_array( $item->classes ) ){
            $classes = preg_grep( '/^(fa)(-\S+)?$/i', $item->classes );
            if( !empty( $classes ) ){
                $item_output = fitness_freak_replace_item( $item_output, $classes );
            }
        }
        return $item_output;
}
function fitness_freak_replace_item( $item_output, $classes ){
        //$settings = get_option( 'n9m-font-awesome-4-menus', FontAwesomeFour::$defaults );
       $spacer = ' ';

        if( !in_array( 'fa', $classes ) ){
            array_unshift( $classes, 'fa' );
        }

        $before = true;
        if( in_array( 'fa-after', $classes ) ){
            $classes = array_values( array_diff( $classes, array( 'fa-after' ) ) );
            $before = false;
        }

        $icon = '<i class="' . implode( ' ', $classes ) . '"></i>';

        preg_match( '/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches );
        if( 4 === count( $matches ) ){
            $item_output = $matches[1];
            if( $before ){
                $item_output .= $icon . '<span class="fontawesome-text">' . $spacer . $matches[2] . '</span>';
            } else {
                $item_output .= '<span class="fontawesome-text">' . $matches[2] . $spacer . '</span>' . $icon;
            }
            $item_output .= $matches[3];
        }
        return $item_output;
 }

add_action( 'admin_menu', 'fitness_freak_admin_menu');
function fitness_freak_admin_menu( ) {
    add_theme_page( __('Pro Feature','fitness-freak'), __('Fitness Freak Pro','fitness-freak'), 'manage_options', 'fitness-freak-pro-buynow', 'fitness_freak_pro_buy_now', 300 );   
}
function fitness_freak_pro_buy_now(){ ?>
<div class="fitness_freak_pro_version">
  <a href="<?php echo esc_url('https://hippothemes.com/wordpress-themes/fitness-freak-pro/'); ?>" target="_blank">
    <img src ="<?php echo esc_url('https://d3u593pl7xwbqj.cloudfront.net/featured-images/fitness-freak-pro-features.png') ?>" width="100%" height="auto" />
  </a>
</div>
<?php
}

require get_template_directory() . '/functions/theme-default-setup.php';
require get_template_directory() . '/functions/enqueue-files.php';
require get_template_directory() . '/functions/theme-customization.php';
require get_template_directory() . '/functions/class-tgm-plugin-activation.php';