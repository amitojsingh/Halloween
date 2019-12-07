<?php
/**
 * Theme Options
 *
 * @package Christmas_Bell
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function christmasbell_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'christmasbell_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'christmas-bell' ),
		'priority' => 130,
	) );

	// Breadcrumb Option.
	$wp_customize->add_section( 'christmasbell_breadcrumb_options', array(
		'description'   => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance.', 'christmas-bell' ),
		'panel'         => 'christmasbell_theme_options',
		'title'         => esc_html__( 'Breadcrumb', 'christmas-bell' ),
	) );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'christmasbell_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'christmas-bell' ),
			'section'           => 'christmasbell_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	// Layout Options
	$wp_customize->add_section( 'christmasbell_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'christmas-bell' ),
		'panel' => 'christmasbell_theme_options',
		)
	);

	/* Layout Type */
	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_layout_type',
			'default'           => 'fluid',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'label'             => esc_html__( 'Site Layout', 'christmas-bell' ),
			'section'           => 'christmasbell_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'fluid' => esc_html__( 'Fluid', 'christmas-bell' ),
				'boxed' => esc_html__( 'Boxed', 'christmas-bell' ),
			),
		)
	);

	/* Default Layout */
	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'christmas-bell' ),
			'section'           => 'christmasbell_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'christmas-bell' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'christmas-bell' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_homepage_archive_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'christmas-bell' ),
			'section'           => 'christmasbell_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'christmas-bell' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'christmas-bell' ),
			),
		)
	);

	/* Archive Content Layout */
	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_content_layout',
			'default'           => 'excerpt-image-top',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'label'             => esc_html__( 'Archive Content Layout', 'christmas-bell' ),
			'section'           => 'christmasbell_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'excerpt-image-top'      => esc_html__( 'Show Excerpt( Image Top)', 'christmas-bell' ),
				'full-content-image-top' => esc_html__( 'Show Full Content ( Image Top )', 'christmas-bell' ),
				'full-content'           => esc_html__( 'Show Full Content ( No Featured Image )', 'christmas-bell' ),
			),
		)
	);

	/* Single Page/Post Image Layout */
	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_single_layout',
			'default'           => 'disabled',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'label'             => esc_html__( 'Single Page/Post Image Layout', 'christmas-bell' ),
			'section'           => 'christmasbell_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'disabled'              => esc_html__( 'Disabled', 'christmas-bell' ),
				'post-thumbnail'        => esc_html__( 'Post Thumbnail', 'christmas-bell' ),
				'christmasbell-slider' => esc_html__( 'Slider Image Size (1920x1080)', 'christmas-bell' ),
				'full'                  => esc_html__( 'Original Image Size', 'christmas-bell' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'christmasbell_excerpt_options', array(
		'panel'     => 'christmasbell_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'christmas-bell' ),
	) );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_excerpt_length',
			'default'           => '40',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 40 words', 'christmas-bell' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'christmas-bell' ),
			'section'  => 'christmasbell_excerpt_options',
			'type'     => 'number',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'christmas-bell' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'christmas-bell' ),
			'section'           => 'christmasbell_excerpt_options',
			'type'              => 'text',
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'christmasbell_search_options', array(
		'panel'     => 'christmasbell_theme_options',
		'title'     => esc_html__( 'Search Options', 'christmas-bell' ),
	) );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_search_text',
			'default'           => esc_html__( 'Search', 'christmas-bell' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Search Text', 'christmas-bell' ),
			'section'           => 'christmasbell_search_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'christmasbell_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'christmas-bell' ),
		'panel'       => 'christmasbell_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'christmas-bell' ),
	) );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_front_page_category',
			'sanitize_callback' => 'christmasbell_sanitize_category_list',
			'custom_control'    => 'Christmas_Bell_Multi_Categories_Control',
			'label'             => esc_html__( 'Categories', 'christmas-bell' ),
			'section'           => 'christmasbell_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	// Pagination Options.
	$pagination_type = get_theme_mod( 'christmasbell_pagination_type', 'default' );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$nav_desc = sprintf(
		wp_kses(
			__( 'Infinite Scroll Options requires %1$sJetPack Plugin%2$s with Infinite Scroll module Enabled.', 'christmas-bell' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/jetpack/">',
		'</a>'
	);

	$nav_desc .= '&nbsp;' . sprintf(
		wp_kses(
			__( 'Once Jetpack is installed, Infinite Scroll Settings can be found %1$shere%2$s', 'christmas-bell' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="' . esc_url( admin_url( 'admin.php?page=jetpack#/settings' ) ) . '">',
		'</a>'
	);

	$wp_customize->add_section( 'christmasbell_pagination_options', array(
		'description' => $nav_desc,
		'panel'       => 'christmasbell_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'christmas-bell' ),
	) );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'choices'           => christmasbell_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'christmas-bell' ),
			'section'           => 'christmasbell_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
	$wp_customize->add_section( 'christmasbell_scrollup', array(
		'panel'    => 'christmasbell_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'christmas-bell' ),
	) );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_disable_scrollup',
			'sanitize_callback' => 'christmasbell_sanitize_checkbox',
			'label'             => esc_html__( 'Disable Scroll Up', 'christmas-bell' ),
			'section'           => 'christmasbell_scrollup',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'christmasbell_theme_options' );
