<?php
/**
* fitness-freak Customization options
**/

function fitness_freak_customize_register( $wp_customize ) {
  $wp_customize->add_panel(
    'general',
    array(
        'title' => __( 'General', 'fitness-freak' ),
        'description' => __('styling options','fitness-freak'),
        'priority' => 20, 
    )
  );
   //All our sections, settings, and controls will be added here
  $wp_customize->add_section(
    'FitnessFreakSocialLinks',
    array(
      'title' => __('Social Accounts', 'fitness-freak'),
      'priority' => 120,
      'description' => __( 'In first input box, you need to add FONT AWESOME shortcode which you can find', 'fitness-freak' ).'<a target="_blank" href="'.esc_url('https://fortawesome.github.io/Font-Awesome/icons/').'" > '.__('here','fitness-freak').' </a> '.__('and in second input box, you need to add your social media profile URL. Enter the URL of your social accounts. Leave it empty to hide the icon.' , 'fitness-freak'),
      'panel' => 'footer'
    )
  );
  $wp_customize->get_section('title_tagline')->panel = 'general';
  $wp_customize->get_section('header_image')->panel = 'general';
  $wp_customize->get_section('title_tagline')->title = __('Header & Logo','fitness-freak');
  $wp_customize->get_section('static_front_page')->panel = 'general';


$FitnessFreakSocialIcon = array();
  for($i=1;$i <= 5;$i++):  
    $FitnessFreakSocialIcon[] =  array( 'slug'=>sprintf('FitnessFreakSocialIcon%d',$i),   
      'default' => '',   
      'label' => esc_html__( 'Social Account ', 'fitness-freak' ) . $i,   
      'priority' => sprintf('%d',$i) );  
  endfor;
  foreach($FitnessFreakSocialIcon as $FitnessFreakSocialIcons){
    $wp_customize->add_setting(
      $FitnessFreakSocialIcons['slug'],
      array(
        'default' => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );
    $wp_customize->add_control(
      $FitnessFreakSocialIcons['slug'],
      array(
        'type'  => 'text',
        'section' => 'FitnessFreakSocialLinks',
        'input_attrs' => array( 'placeholder' => esc_attr__('Enter Icon','fitness-freak') ),
        'label'      =>   $FitnessFreakSocialIcons['label'],
        'priority' => $FitnessFreakSocialIcons['priority']
      )
    );
  }
  $FitnessFreakSocialIconLink = array();
  for($i=1;$i <= 5;$i++):  
    $FitnessFreakSocialIconLink[] =  array( 'slug'=>sprintf('FitnessFreakSocialIconLink%d',$i),   
      'default' => '',   
      'label' => esc_html__( 'Social Link ', 'fitness-freak' ) . $i,   
      'priority' => sprintf('%d',$i) );  
  endfor;
  foreach($FitnessFreakSocialIconLink as $FitnessFreakSocialIconLinks){
    $wp_customize->add_setting(
      $FitnessFreakSocialIconLinks['slug'],
      array(
        'default' => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
      )
    );
    $wp_customize->add_control(
      $FitnessFreakSocialIconLinks['slug'],
      array(
        'type'  => 'text',
        'section' => 'FitnessFreakSocialLinks',
        'priority' => $FitnessFreakSocialIconLinks['priority'],
        'input_attrs' => array( 'placeholder' => esc_html__('Enter URL','fitness-freak')),
      )
    );
  }

/*
*Multiple logo upload code
*/
$wp_customize->add_setting(
    'FitnessFreakDarkLogo',
    array(
        'default' => '',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'FitnessFreakDarkLogo', array(
    'section'     => 'title_tagline',
    'label'       => __( 'Upload Dark Logo' ,'fitness-freak'),
    'flex_width'  => true,
    'flex_height' => true,
    'width'       => 120,
    'height'      => 50,
    'priority'    => 48,
    'default-image' => '',
) ) );



$wp_customize->add_setting('theme_header_fix', array(
        'default' => false,  
        'sanitize_callback' => 'fitness_freak_field_sanitize_checkbox',
));
$wp_customize->add_control('theme_header_fix', array(
    'label'   => esc_html__('Header Fix','fitness-freak'),
    'section' => 'title_tagline',
    'type'    => 'checkbox',
    'priority' => 49
));

$wp_customize->add_setting(
  'theme_logo_height',
  array(
    'default' => '',
    'capability'     => 'edit_theme_options',
    'sanitize_callback' => 'absint',
    )
  );
$wp_customize->add_control(
  'theme_logo_height',
  array(
    'section' => 'title_tagline',
    'label'      => __('Enter Logo Size', 'fitness-freak'),
    'description' => __("Use if you want to increase or decrease logo size (optional) Don't include `px` in the string. e.g. 20 (default: 10px)",'fitness-freak'),
    'type'       => 'text',
    'priority'    => 50,
    )
  );

$wp_customize->add_setting(
    'preloader',
    array(
        'default' => '1',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
        'priority' => 20, 
    )
);
$wp_customize->add_section( 'preloaderSection' , array(
    'title'       => __( 'Preloader', 'fitness-freak' ),
    'priority'    => 32,
    'capability'     => 'edit_theme_options',
    'panel' => 'general'
) );
$wp_customize->add_control(
    'preloader',
    array(
        'section' => 'preloaderSection',                
        'label'   => __('Preloader','fitness-freak'),
        'type'    => 'radio',
        'choices'        => array(
            "1"   => esc_html__( "On ", 'fitness-freak' ),
            "2"   => esc_html__( "Off", 'fitness-freak' ),
        ),
    )
);

$wp_customize->add_setting( 'customPreloader', array(
    'sanitize_callback' => 'esc_url_raw',
    'capability'     => 'edit_theme_options',
    'priority' => 40,
));

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'customPreloader', array(
    'label'    => __( 'Upload Custom Preloader', 'fitness-freak' ),
    'section'  => 'preloaderSection',
    'settings' => 'customPreloader',
) ) );

$wp_customize->add_section( 'homepageSection' , array(
    'title'       => __( 'Menu Settings', 'fitness-freak' ),
    'priority'    => 40,
    'capability'     => 'edit_theme_options',
    'panel' => 'general'
) );

$wp_customize->add_setting( 'menustyle', array(
    'capability'     => 'edit_theme_options',
     'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
     'default' => '0',
    'priority' => 40,
));

$wp_customize->add_control( 'menustyle', array(
    'label'    => __( 'Menu Style', 'fitness-freak' ),
    'section'  => 'homepageSection',
    'type'       => 'select',
    
    'choices' => array(
      "0"   => esc_html__( "Transparent", 'fitness-freak' ),
      "1"   => esc_html__( "Non-Transparent", 'fitness-freak' ),
    ),
));

$wp_customize->add_setting( 'pagetitle', array(
    'capability'     => 'edit_theme_options',
    'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    'priority' => 40,
    'default' => '1',
));

$wp_customize->add_control( 'pagetitle', array(
    'label'    => __( 'Home Page Title', 'fitness-freak' ),
    'section'  => 'homepageSection',
    'type'       => 'select',
   
    'choices' => array(
      "0"   => esc_html__( "Hide", 'fitness-freak' ),
      "1"   => esc_html__( "Show", 'fitness-freak' ),
    ),
));
/* colors  section */
    
//Colors section
$wp_customize->add_setting(
    'themeColor',
    array(
        'default' => '#c14953',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'themeColor',
    array(
        'label'      => __('Theme Color ', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 10
    )
  )
);
$wp_customize->add_setting(
  'secondaryColor',
  array(
      'default' => '#4c4c47',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'secondaryColor',
    array(
        'label'      => __('Secondary Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Menu Background Color
$wp_customize->add_setting(
  'menuBackgroundColor',
  array(
      'default' => '',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'menuBackgroundColor',
    array(
        'label'      => __('Menu Background Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Menu Background Color (Scroll)
$wp_customize->add_setting(
  'menuBackgroundColorScroll',
  array(
      'default' => '#616161',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'menuBackgroundColorScroll',
    array(
        'label'      => __('Menu Background Color (after scroll)', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Menu Text Color
$wp_customize->add_setting(
  'menuTextColor',
  array(
      'default' => '#ffffff',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'menuTextColor',
    array(
        'label'      => __('Menu Text Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Menu Text Color
$wp_customize->add_setting(
  'menuTextColorScroll',
  array(
      'default' => '#ffffff',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'menuTextColorScroll',
    array(
        'label'      => __('Menu Text Color(after scroll)', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Body Background Color
$wp_customize->add_setting(
  'bodyBackgroundColor',
  array(
      'default' => '#ffffff',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'bodyBackgroundColor',
    array(
        'label'      => __('Body Background Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Body Text Color
$wp_customize->add_setting(
  'bodyTextColor',
  array(
      'default' => '#2b2b2b',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'bodyTextColor',
    array(
        'label'      => __('Body Text Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);

//Footer Background Color
$wp_customize->add_setting(
  'footerBackgroundColor',
  array(
      'default' => '#424242',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'footerBackgroundColor',
    array(
        'label'      => __('Footer Background Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Footer Text Color
$wp_customize->add_setting(
  'footerTextColor',
  array(
      'default' => '#ffffff',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'footerTextColor',
    array(
        'label'      => __('Footer Text Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Footer Link Color
$wp_customize->add_setting(
  'footerLinkColor',
  array(
      'default' => '#ffffff',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'footerLinkColor',
    array(
        'label'      => __('Footer Link Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Footer Link Hover Color
$wp_customize->add_setting(
  'footerLinkHoverColor',
  array(
      'default' => '#000000',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize,
    'footerLinkHoverColor',
    array(
        'label'      => __('Footer Link Hover Color', 'fitness-freak'),
        'section' => 'colors',
        'priority' => 11
    )
  )
);
//Copyright Background Color
/*-------------------- Page Option --------------------------*/
$wp_customize->add_section(
    'page_ThemeOption',
    array(
        'title' => __( 'Page Options', 'fitness-freak' ),
        'description' => __('Page option settings. ','fitness-freak'),
        'priority' => 44,
        'panel'=>'general',
       
    )
);
$wp_customize->add_setting(
    'pagesidebar',
    array(
        'default' => '3',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'pagesidebar',
    array(
        'section' => 'page_ThemeOption',
        'label'      => __('Select Page Sidebar Option', 'fitness-freak'),
        'type'       => 'select',
        'default'   => '1',
        'choices' => array(
          "1"   => esc_html__( "Left Sidebar", 'fitness-freak' ),
          "2"   => esc_html__( "Right Sidebar", 'fitness-freak' ),         
          "3"   => esc_html__( "Full Page", 'fitness-freak' ),
        ),
    )
);

/*-------------------- BLog (Archive) Option --------------------------*/
$wp_customize->add_section(
    'blogThemeOption',
    array(
        'title' => __( 'Blog (Archive) Options', 'fitness-freak' ),
        'description' => __('Blog (Archive) option settings. ','fitness-freak'),
        'priority' => 124,
       
    )
);
$wp_customize->add_setting(
    'blogsidebar',
    array(
        'default' => '3',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'blogsidebar',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Select Blog Sidebar Option', 'fitness-freak'),
        'type'       => 'select',
        'default'   => '1',
        'choices' => array(
          "1"   => esc_html__( "Left Sidebar", 'fitness-freak' ),
          "2"   => esc_html__( "Right Sidebar", 'fitness-freak' ),         
          "3"   => esc_html__( "Full Page", 'fitness-freak' ),
        ),
    )
);
$wp_customize->add_setting(
    'blogsinglesidebar',
    array(
        'default' => '3',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'blogsinglesidebar',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Select Single Post Sidebar Option', 'fitness-freak'),
        'type'       => 'select',
        'choices' => array(
          "1"   => esc_html__( "Left Sidebar", 'fitness-freak' ),
          "2"   => esc_html__( "Right Sidebar", 'fitness-freak' ),          
          "3"   => esc_html__( "Full Page", 'fitness-freak' ),
        ),
    )
);
$wp_customize->add_setting(
    'blogMetaTag',
    array(
        'default' => '1',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'blogMetaTag',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Select Blog Post Meta Tag Option', 'fitness-freak'),
        'type'       => 'select',
        'choices' => array(
          "1"   => esc_html__( "Show", 'fitness-freak' ),
          "2"   => esc_html__( "Hide", 'fitness-freak' ),      
        ),
    )
);
$wp_customize->add_setting(
    'blogSingleMetaTag',
    array(
        'default' => '1',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'blogSingleMetaTag',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Select Single Post Meta Tag Option', 'fitness-freak'),
        'type'       => 'select',
        'choices' => array(
          "1"   => esc_html__( "Show", 'fitness-freak' ),
          "2"   => esc_html__( "Hide", 'fitness-freak' ),      
        ),
    )
);

$wp_customize->add_setting(
    'blogPostExcerpt',
    array(
        'default' => '1',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'blogPostExcerpt',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Select Blog Post Excerpt Option', 'fitness-freak'),
        'type'       => 'select',
        'choices' => array(
          "1"   => esc_html__( "Show", 'fitness-freak' ),
          "2"   => esc_html__( "Hide", 'fitness-freak' ),      
        ),
    )
);
$wp_customize->add_setting(
    'blogPostExcerptTextLimit',
    array(
        'default' => '10',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'blogPostExcerptTextLimit',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Blog Post Excerpt String Limit Option', 'fitness-freak'),
        'type'       => 'text',        
    )
);
$wp_customize->add_setting(
    'blogPostReadMore',
    array(
        'default' => '1',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
    )
);
$wp_customize->add_control(
    'blogPostReadMore',
    array(
        'section' => 'blogThemeOption',
        'label'      => __('Select Blog Post Read More Button Option', 'fitness-freak'),
        'type'       => 'select',
        'choices' => array(
          "1"   => esc_html__( "Show", 'fitness-freak' ),
          "2"   => esc_html__( "Hide", 'fitness-freak' ),      
        ),
    )
);

/*------------------------ Blog  Page option End ----------------------------*/

//Footer Section
$wp_customize->add_panel(
    'footer',
    array(
        'title' => __( 'Footer', 'fitness-freak' ),
        'description' => __('Footer options','fitness-freak'),
        'priority' => 105, 
    )
);
$wp_customize->add_section( 'footerWidgetArea' , array(
    'title'       => __( 'Footer Widget Area', 'fitness-freak' ),
    'priority'    => 135,
    'capability'     => 'edit_theme_options',
    'panel' => 'footer'
) );

$wp_customize->add_section( 'footerSocialSection' , array(
    'title'       => __( 'Social Settings', 'fitness-freak' ),
    'description' => __( 'In first input box, you need to add FONT AWESOME shortcode which you can find', 'fitness-freak' ).'<a target="_blank" href="'.esc_url('https://fortawesome.github.io/Font-Awesome/icons/').'" > '.__('here','fitness-freak').' </a> '.__('and in second input box, you need to add your social media profile URL.' , 'fitness-freak'),
    'priority'    => 135,
    'capability'     => 'edit_theme_options',
    'panel' => 'footer'
) );
$wp_customize->add_section( 'footerCopyright' , array(
    'title'       => __( 'Footer Copyright Area', 'fitness-freak' ),
    'priority'    => 135,
    'capability'     => 'edit_theme_options',
    'panel' => 'footer'
) );
$wp_customize->add_setting(
  'hideFooterWidgetBar',
  array(
      'default' => '1',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
      'priority' => 20, 
  )
);
$wp_customize->add_control(
  'hideFooterWidgetBar',
  array(
    'section' => 'footerWidgetArea',                
    'label'   => __('Hide Widget Area','fitness-freak'),
    'type'    => 'select',
    'choices' => array(
        "1"   => esc_html__( "Show", 'fitness-freak' ),
        "2"   => esc_html__( "Hide", 'fitness-freak' ),
    ),
  )
);
$wp_customize->add_setting(
  'footerWidgetStyle',
  array(
      'default' => '2',
      'capability'     => 'edit_theme_options',
      'sanitize_callback' => 'fitness_freak_field_sanitize_input_choice',
      'priority' => 20, 
  )
);
$wp_customize->add_control(
  'footerWidgetStyle',
  array(
      'section' => 'footerWidgetArea',                
      'label'   => __('Select Widget Area','fitness-freak'),
      'type'    => 'select',
      'choices'        => array(
          "1"   => esc_html__( "2 column", 'fitness-freak' ),
          "2"   => esc_html__( "3 column", 'fitness-freak' ),
          "3"   => esc_html__( "4 column", 'fitness-freak' )
      ),
  )
);
$wp_customize->add_setting(
    'CopyrightAreaText',
    array(
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'wp_kses_post',
        'priority' => 20, 
    )
);
$wp_customize->add_control(
    'CopyrightAreaText',
    array(
        'section' => 'footerCopyright',                
        'label'   => __('Enter Copyright Text','fitness-freak'),
        'type'    => 'textarea',
    )
);
// Text Panel Starts Here 


}
add_action( 'customize_register', 'fitness_freak_customize_register' );

function fitness_freak_custom_css(){

  wp_enqueue_style( 'fitness_freak_style', get_stylesheet_uri() );
  $custom_css='';
  $custom_css.="
    p, span, li, a,.package-header h4 span,.btn-iprimary{
      font-size: ".esc_attr(get_theme_mod('NormalFontSize','14'))."px;
    }
    body{
      background: ".esc_attr(get_theme_mod('bodyBackgroundColor', '#ffffff')).";
    }
    .navbar {
      background: ".esc_attr(get_theme_mod('menuBackgroundColor', 'transparent')).";
    }
    .fitness-freak-fixed-top,.fitness-freak-fixed-top #cssmenu ul.sub-menu{
      background-color: ".esc_attr(get_theme_mod('menuBackgroundColor','transparent')).";
    }   
    
    .header-top.no-transparent{
      position:relative; 
      background-color:".esc_attr(get_theme_mod('menuBackgroundColor','transparent')).";
    }";
    

    /*Main logo height*/
    $theme_logo_height = (get_theme_mod('theme_logo_height'))?(get_theme_mod('theme_logo_height')):45;
    $custom_css.= ".header-top .logo img , #fitness_freak_navigation .main-logo img{ max-height: ".esc_attr($theme_logo_height)."px;   }";

    if(get_theme_mod('theme_header_fix',0)){
      $custom_css.= ".header-top.fixed-header { position :fixed; } ";
    }    

    $custom_css.= "     
    *::selection,.silver-package-bg,#menu-line,.menu-left li:hover:before{
      background-color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    .title-data h2 a,.btn-light:focus,.btn-light:hover,a:hover, a:focus,.package-feature h6,.menu-left h6,.sow-slide-nav a:hover .sow-sld-icon-themeDefault-left,.sow-slide-nav a:hover .sow-sld-icon-themeDefault-right, .menu-left ul li a:hover, .menu-left ul li.active a, .recentcomments:hover,.blog-carousel .blog-carousel-title h4,
    .gallery-item .ovelay .content .lightbox:hover, .gallery-item:hover .ovelay .content .imag-alt a:hover{
      color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
       
    .btn-blank{
      box-shadow: inset 0 0 0 1px ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    .btn-blank:hover:before, .btn-blank:focus:before, .btn-blank:active:before{
      box-shadow: inset 10px 0 0 0px ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    
    .btn-nav:focus, .btn-nav:hover,.menu-left li a:hover:before, .menu-left li.active:before, .services-tabs-left li:hover:before, .services-tabs-left li.active:before, ul#recentcomments li:hover:before,.btn-speechblue:before,.search-submit:hover, .search-submit:focus {
      background: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    
    .menu-left ul li,.menu-left ul li span, body,.comment-form input, .comment-form textarea,input::-webkit-input-placeholder,textarea::-webkit-input-placeholder,time,.menu-left ul li a, .services-tabs-left li a, .menu-left ul li .comment-author-link a, .menu-left ul li.recentcomments a,caption{
      color: ".esc_attr(get_theme_mod('bodyTextColor','#2b2b2b')).";
    }
    input:-moz-placeholder{
      color: ".esc_attr(get_theme_mod('bodyTextColor','#2b2b2b')).";
    }
    input::-moz-placeholder{
      color: ".esc_attr(get_theme_mod('bodyTextColor','#2b2b2b')).";
    }
    input:-ms-input-placeholder{
      color: ".esc_attr(get_theme_mod('bodyTextColor','#2b2b2b')).";
    }
    a,.comment .comment-reply-link,.services-tabs-left li a:hover, .services-tabs-left li.active a{
      color: ".esc_attr(get_theme_mod('secondaryColor','#4c4c47')).";
    }
    .menu-left li:before,.btn-blank:hover:before, .btn-blank:focus:before, .btn-blank:active:before,.package-feature h6::after,.counter-box p:before,.menu-left li:before, .services-tabs-left li:before,.btn-blank:before,.search-submit {
      background: ".esc_attr(get_theme_mod('secondaryColor','#4c4c47')).";
    }
    .comment-form p.form-submit,.btn-speechblue{
      background: ".esc_attr(get_theme_mod('secondaryColor','#4c4c47')).";
      box-shadow: inset 10px 0 0 0px ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    .comment-form .form-submit:hover::before,.btn-speechblue:hover:before, .btn-speechblue:focus:before, .btn-speechblue:active:before{
      box-shadow: inset 10px 0 0 0px ".esc_attr(get_theme_mod('secondaryColor','#4c4c47')).";
      background: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    .contact-me.darkForm input:focus, .contact-me.lightForm input:focus, .contact-me.darkForm textarea:focus, .contact-me.lightForm textarea:focus,
    blockquote,
    .comment-form input:focus, .comment-form textarea:focus{
      border-color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }    
    .footer-box{
      background:".esc_attr(get_theme_mod('footerBackgroundColor','#424242')).";
    }
    .footer-box div,.footer-box .widget-title,.footer-box p,.footer-box .textwidget p,.footer-box div,.footer-box h1,.footer-box h2,.footer-box h3,.footer-box h4,.footer-box h5,.footer-box h6 {
      color: ".esc_attr(get_theme_mod('footerTextColor','#ffffff')).";
    }
    .footer-box .footer-widget ul li a,.footer-widget .tagcloud a{
      color:".esc_attr(get_theme_mod('footerLinkColor','#ffffff')).";
    }
    .footer-box .footer-widget ul li a:hover, .footer-widget .tagcloud a:hover{
      color:".esc_attr(get_theme_mod('footerLinkHoverColor','#c14953')).";
    }
    .footer-box .tagcloud > a:hover{
      background:".esc_attr(get_theme_mod('footerLinkHoverColor','#c14953')).";
    }
    .footer-wrap .copyright p,.footer-wrap{
      color: #ffffff;
    }
    .footer-wrap a,.footer-wrap.style2 .footer-nav ul li a{
      color: #ffffff;
    }
    .footer-wrap .copyright a:hover,.footer-wrap a:hover,.footer-wrap.style2 .footer-nav ul li a:hover,.footer-wrap.style2 .copyright a:hover,.footer-wrap.style1 .copyright a:hover{
      color: ".esc_attr(get_theme_mod('copyrightLinkHoverColor', '#c14953')).";
    }      

    /* Menu Css Cutomization */
    
    /*main top menu text color*/
     #menu-style-header > ul > li > a{
      color: ".esc_attr(get_theme_mod('menuTextColor','#ffffff')).";
    }
    /*sub menu text color*/
    #menu-style-header ul ul li a{
      color: ".esc_attr(get_theme_mod('menuTextColor','#ffffff')).";
    }
    /*main top menu text Scroll color*/
    .fixed-header #menu-style-header > ul > li > a{
      color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff')).";
    }
    /*sub menu text Scroll color*/
    .fixed-header #menu-style-header ul ul li a{
      color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff')).";
    }
    /*sub menu background color*/
    #menu-style-header ul ul li a{
      background-color: ".esc_attr(get_theme_mod('secondaryColor','#4c4c47')).";
    }
    /*sub menu Scroll background color*/
    .fixed-header #menu-style-header ul ul li a{
      background-color: ".esc_attr(get_theme_mod('menuBackgroundColorScroll','#ffffff')).";
    } 
    /*sub menu background hover color*/
    #menu-style-header ul ul li a:hover{
      background-color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    /*all top menu hover effect border color*/
    #menu-style-header > ul > li:before{
         border-color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    /*all menu arrow border color*/
     #menu-style-header > ul > li.has-sub > a::after, #menu-style-header ul ul li.has-sub > a::after{
         border-color: ".esc_attr(get_theme_mod('menuTextColor','#ffffff')).";
    }
     /*all menu scroll arrow border color*/
    .fixed-header #menu-style-header > ul > li.has-sub > a::after, .fixed-header #menu-style-header ul ul li.has-sub > a::after{
         border-color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff')).";
      }

    @media only screen and (max-width: 1024px){
      
    /*all menu arrow border color*/
    #menu-style-header #menu-button::before, #menu-style-header .menu-opened::after{
         border-color: ".esc_attr(get_theme_mod('menuTextColor','#ffffff')).";
    }
    /*all menu scroll arrow border color*/
    .fixed-header #menu-style-header #menu-button::before, .fixed-header #menu-style-header .menu-opened::after{
         border-color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff'))." ;
    }
    /*all menu arrow background border color*/      
    #menu-style-header #menu-button::after{
        background-color: ".esc_attr(get_theme_mod('menuTextColor','#ffffff')).";
      }

    /*all menu scroll arrow background border color*/      
    .fixed-header #menu-style-header #menu-button::after{
        background-color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff')).";
    } 
    /*mobile menu background color*/
    #menu-style-header .mobilemenu li a{
         background-color: ".esc_attr(get_theme_mod('menuBackgroundColorScroll','#ffffff')).";
         color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff')).";
    }
    #menu-style-header .mobilemenu li a:hover{
         background-color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    #menu-style-header .mobilemenu li:hover > a{
         background-color: ".esc_attr(get_theme_mod('themeColor','#c14953')).";
    }
    #menu-style-header .submenu-button::before, #menu-style-header .submenu-button::after {
         background-color: ".esc_attr(get_theme_mod('menuTextColorScroll','#ffffff')).";
      }
    }
    /*  Menu Css Cutomization */ ";
    $custom_css .= wp_kses_post(get_theme_mod('customCss'));
  wp_add_inline_style( 'fitness_freak_style', $custom_css ); 

  $script_js = '';  
  /*header wise style*/
  if(get_theme_mod('theme_header_fix',0))
  {
    $script_js .="
      jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() > 200) {
            jQuery('.header-top').addClass('fixed-header');             
        } else {           
            jQuery('.header-top').removeClass('fixed-header');
        }
      });
    ";
  } 
  wp_add_inline_script( 'fitness-freak-custom', $script_js );
 }
// Preset Styles