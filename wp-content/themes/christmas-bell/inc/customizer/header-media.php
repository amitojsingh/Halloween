<?php
/**
 * Header Media Options
 *
 * @package Christmas_Bell
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function christmasbell_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'christmas-bell' );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'christmas-bell' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'christmas-bell' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'christmas-bell' ),
				'entire-site'            => esc_html__( 'Entire Site', 'christmas-bell' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'christmas-bell' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'christmas-bell' ),
				'disable'                => esc_html__( 'Disabled', 'christmas-bell' ),
			),
			'label'             => esc_html__( 'Enable on ', 'christmas-bell' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_media_position',
			'default'           => 'after-menu',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'choices'           => array(
				'after-menu'    => esc_html__( 'After Primary Menu', 'christmas-bell' ),
				'before-menu'   => esc_html__( 'Before Primary Menu', 'christmas-bell' ),
				'before-header' => esc_html__( 'Before Header', 'christmas-bell' ),
			),
			'label'             => esc_html__( 'Position', 'christmas-bell' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 2,
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_media_title',
			'default'           => esc_html__( 'Merry Christmas', 'christmas-bell' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'christmas-bell' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_media_text',
			'default'           => esc_html__( 'Get inspired this Christmas.', 'christmas-bell' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Text', 'christmas-bell' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'christmas-bell' ),
			'section'           => 'header_image',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_media_url_text',
			'default'           => esc_html__( 'Continue Reading', 'christmas-bell' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'christmas-bell' ),
			'section'           => 'header_image',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_header_url_target',
			'sanitize_callback' => 'christmasbell_sanitize_checkbox',
			'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'christmas-bell' ),
			'section'           => 'header_image',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'christmasbell_header_media_options' );
