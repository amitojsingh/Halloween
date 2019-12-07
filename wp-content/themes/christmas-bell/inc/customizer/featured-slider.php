<?php
/**
 * Featured Slider Options
 *
 * @package Christmas_Bell
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function christmasbell_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'christmasbell_featured_slider', array(
			'panel' => 'christmasbell_theme_options',
			'title' => esc_html__( 'Featured Slider', 'christmas-bell' ),
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'choices'           => christmasbell_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'christmas-bell' ),
			'section'           => 'christmasbell_featured_slider',
			'type'              => 'select',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_slider_transition_effect',
			'default'           => 'fade',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'active_callback'   => 'christmasbell_is_slider_active',
			'choices'           => christmasbell_slider_transition_effects(),
			'label'             => esc_html__( 'Transition Effect', 'christmas-bell' ),
			'section'           => 'christmasbell_featured_slider',
			'type'              => 'select',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_slider_transition_delay',
			'default'           => '4',
			'sanitize_callback' => 'absint',
			'active_callback'   => 'christmasbell_is_slider_active',
			'description'       => esc_html__( 'seconds(s)', 'christmas-bell' ),
			'input_attrs'       => array(
				'style' => 'width: 40px;',
			),
			'label'             => esc_html__( 'Transition Delay', 'christmas-bell' ),
			'section'           => 'christmasbell_featured_slider',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_slider_transition_length',
			'default'           => '1',
			'sanitize_callback' => 'absint',

			'active_callback'   => 'christmasbell_is_slider_active',
			'description'       => esc_html__( 'seconds(s)', 'christmas-bell' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
			),
			'label'             => esc_html__( 'Transition Length', 'christmas-bell' ),
			'section'           => 'christmasbell_featured_slider',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_slider_image_loader',
			'default'           => 'false',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'active_callback'   => 'christmasbell_is_slider_active',
			'choices'           => christmasbell_slider_image_loader(),
			'label'             => esc_html__( 'Image Loader', 'christmas-bell' ),
			'section'           => 'christmasbell_featured_slider',
			'type'              => 'select',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'christmasbell_sanitize_number_range',

			'active_callback'   => 'christmasbell_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'christmas-bell' ),
			'input_attrs'       => array(
				'style' => 'width: 45px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'christmas-bell' ),
			'section'           => 'christmasbell_featured_slider',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$slider_number = get_theme_mod( 'christmasbell_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		christmasbell_register_option( $wp_customize, array(
				'name'              =>'christmasbell_slider_page_' . $i,
				'sanitize_callback' => 'christmasbell_sanitize_post',
				'active_callback'   => 'christmasbell_is_slider_active',
				'label'             => esc_html__( 'Page', 'christmas-bell' ) . ' # ' . $i,
				'section'           => 'christmasbell_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'christmasbell_slider_options' );


/**
 * Returns an array of feature slider transition effects
 *
 * @since High Responsive 1.0
 */
function christmasbell_slider_transition_effects() {
	$options = array(
		'fade'       => esc_html__( 'Fade', 'christmas-bell' ),
		'fadeout'    => esc_html__( 'Fade Out', 'christmas-bell' ),
		'none'       => esc_html__( 'None', 'christmas-bell' ),
		'scrollHorz' => esc_html__( 'Scroll Horizontal', 'christmas-bell' ),
		'scrollVert' => esc_html__( 'Scroll Vertical', 'christmas-bell' ),
		'flipHorz'   => esc_html__( 'Flip Horizontal', 'christmas-bell' ),
		'flipVert'   => esc_html__( 'Flip Vertical', 'christmas-bell' ),
		'tileSlide'  => esc_html__( 'Tile Slide', 'christmas-bell' ),
		'tileBlind'  => esc_html__( 'Tile Blind', 'christmas-bell' ),
		'shuffle'    => esc_html__( 'Shuffle', 'christmas-bell' ),
	);

	return apply_filters( 'christmasbell_slider_transition_effects', $options );
}


/**
 * Returns an array of featured slider image loader options
 *
 * @since High Responsive 1.0
 */
function christmasbell_slider_image_loader() {
	$options = array(
		'true'  => esc_html__( 'True', 'christmas-bell' ),
		'wait'  => esc_html__( 'Wait', 'christmas-bell' ),
		'false' => esc_html__( 'False', 'christmas-bell' ),
	);

	return apply_filters( 'christmasbell_slider_image_loader', $options );
}

/** Active Callback Functions */

if( ! function_exists( 'christmasbell_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since High Responsive 1.0
	*/
	function christmasbell_is_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'christmasbell_slider_option' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable )
			);
	}
endif;
