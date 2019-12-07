<?php
/**
* The template for adding Service Settings in Customizer
*
 * @package Christmas_Bell
*/

function christmasbell_service_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_jetpack_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Christmas_Bell_Note_Control',
            'label'             => sprintf( esc_html__( 'For Service Options for High Responsive Theme, go %1$shere%2$s', 'christmas-bell' ),
                 '<a href="javascript:wp.customize.section( \'christmasbell_service\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'ect_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'christmasbell_service', array(
			'panel'    => 'christmasbell_theme_options',
			'title'    => esc_html__( 'Service', 'christmas-bell' ),
		)
	);

	christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_service_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Christmas_Bell_Note_Control',
			'active_callback'   => 'christmasbell_is_ect_service_inactive',
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Content Type Enabled', 'christmas-bell' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'christmasbell_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_service_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'active_callback'   => 'christmasbell_is_ect_service_active',
			'choices'           => christmasbell_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'christmas-bell' ),
			'section'           => 'christmasbell_service',
			'type'              => 'select',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_service_main_image',
			'sanitize_callback' => 'absint',
			'custom_control'    => 'WP_Customize_Media_Control',
			'active_callback'   => 'christmasbell_is_service_active',
			'label'             => esc_html__( 'Main Image', 'christmas-bell' ),
			'section'           => 'christmasbell_service',
			'mime_type'         => 'image',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_service_main_image_link',
			'sanitize_callback' => 'esc_url_raw',
			'active_callback'   => 'christmasbell_is_service_active',
			'label'             => esc_html__( 'Main Image Link', 'christmas-bell' ),
			'section'           => 'christmasbell_service',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_service_main_image_target',
			'sanitize_callback' => 'christmasbell_sanitize_checkbox',
			'active_callback'   => 'christmasbell_is_service_active',
			'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'christmas-bell' ),
			'section'           => 'christmasbell_service',
			'type'              => 'checkbox',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_service_headline',
			'default'           => esc_html__( 'Services', 'christmas-bell' ),
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'christmasbell_is_service_active',
			'label'             => esc_html__( 'Service Archive Title', 'christmas-bell' ),
			'section'           => 'christmasbell_service',
			'type'              => 'text',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_service_subheadline',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'christmasbell_is_service_active',
			'label'             => esc_html__( 'Service Archive Content', 'christmas-bell' ),
			'section'           => 'christmasbell_service',
			'type'              => 'textarea',
		)
	);

	christmasbell_register_option( $wp_customize, array(
				'name'              => 'christmasbell_service_number',
				'default'           => 3,
				'sanitize_callback' => 'christmasbell_sanitize_number_range',
				'active_callback'   => 'christmasbell_is_service_active',
				'description'       => esc_html__( 'Save and refresh the page if No. of Service is changed', 'christmas-bell' ),
				'input_attrs'       => array(
					'style' => 'width: 45px;',
					'min'   => 0,
				),
				'label'             => esc_html__( 'No of Service', 'christmas-bell' ),
				'section'           => 'christmasbell_service',
				'type'              => 'number',
		)
	);

	$number = get_theme_mod( 'christmasbell_service_number', 3 );

	for ( $i = 1; $i <= $number ; $i++ ) {
		christmasbell_register_option( $wp_customize, array(
				'name'              => 'christmasbell_service_cpt_' . $i,
				'sanitize_callback' => 'christmasbell_sanitize_post',
				'default'           => 0,
				'active_callback'   => 'christmasbell_is_service_active',
				'label'             => esc_html__( 'Service ', 'christmas-bell' ) . ' ' . $i ,
				'section'           => 'christmasbell_service',
				'type'              => 'select',
				'choices'           => christmasbell_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'christmasbell_service_options' );

if ( ! function_exists( 'christmasbell_is_service_active' ) ) :
	/**
	* Return true if service is active
	*
	* @since High Responsive 1.0
	*/
	function christmasbell_is_service_active( $control ) {
		$enable = $control->manager->get_setting( 'christmasbell_service_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( christmasbell_check_section( $enable ) && ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) ) );
	}
endif;

if ( ! function_exists( 'christmasbell_is_ect_service_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since High Responsive 1.0
    */
    function christmasbell_is_ect_service_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'christmasbell_is_ect_service_inactive' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since High Responsive 1.0
    */
    function christmasbell_is_ect_service_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
