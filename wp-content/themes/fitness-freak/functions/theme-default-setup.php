<?php
/*
 * fitness-freak Main Sidebar
 */
function fitness_freak_widgets_init() {
    register_sidebar(array(
        'name' => __('Main Sidebar', 'fitness-freak'),
        'id' => 'sidebar-1',
        'description' => __('Main sidebar that appears on the right.', 'fitness-freak'),
        'before_widget' => '<aside id="%1$s" class="menu-left widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h6>',
        'after_title' => '</h6>',
    ));
    register_sidebar(array(
        'name' => __('Footer 1', 'fitness-freak'),
        'id' => 'footer-1',
        'description' => __('Footer that appears on the down.', 'fitness-freak'),
        'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer 2', 'fitness-freak'),
        'id' => 'footer-2',
        'description' => __('Footer that appears on the down.', 'fitness-freak'),
        'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer 3', 'fitness-freak'),
        'id' => 'footer-3',
        'description' => __('Footer that appears on the down.', 'fitness-freak'),
        'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer 4', 'fitness-freak'),
        'id' => 'footer-4',
        'description' => __('Footer that appears on the down.', 'fitness-freak'),
        'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'fitness_freak_widgets_init');
/**
 * Set up post entry meta.    
 * Meta information for current post: categories, tags, permalink, author, and date.    
 * */
function fitness_freak_entry_meta() {
  	$FitnessFreakDate = sprintf('<time datetime="%1$s">%2$s</time>', esc_attr(get_the_date('c')), esc_html(get_the_date('F d , Y'))); ?>	      
      <?php if(get_the_tag_list()) { ?>
        <p><?php the_tags();?></p>
      <?php }
}
/*
 * Function For Tag Meta List
 */

function fitness_freak_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
} 

function fitness_freak_font_families_filter($font_families) {
    $font_families['Raleway'] = 'Raleway';
    return $font_families;
}
add_filter('siteorigin_widgets_font_families', 'fitness_freak_font_families_filter');

add_action( 'tgmpa_register', 'fitness_freak_action_tgm_plugin_active_register_required_plugins' );
function fitness_freak_action_tgm_plugin_active_register_required_plugins() {
    if(class_exists('TGM_Plugin_Activation')){
      $plugins = array(
        array(
           'name'      => __('Page Builder by SiteOrigin','fitness-freak'),
           'slug'      => 'siteorigin-panels',
           'required'  => false,
        ),
        array(
           'name'      => __('SiteOrigin Widgets Bundle','fitness-freak'),
           'slug'      => 'so-widgets-bundle',
           'required'  => false,
        ),
        array(
           'name'      => __('Contact Form 7','fitness-freak'),
           'slug'      => 'contact-form-7',
           'required'  => false,
        ),
      );
      $config = array(
        'default_path' => '',
        'menu'         => 'fitness-freak-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
           'page_title'                      => __( 'Install Recommended Plugins', 'fitness-freak' ),
           'menu_title'                      => __( 'Install Plugins', 'fitness-freak' ),
           
        )
      );
      tgmpa( $plugins, $config );
    }
}

if ( ! function_exists( 'fitness_freak_field_sanitize_checkbox' ) ) :
  function fitness_freak_field_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}
endif;

if ( ! function_exists( 'fitness_freak_field_sanitize_input_choice' ) ) :
function fitness_freak_field_sanitize_input_choice( $input, $setting ) {

  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;