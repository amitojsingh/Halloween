<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Christmas_Bell
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function christmasbell_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Christmas_Bell_Note_Control',
            'label'             => sprintf( esc_html__( 'For Testimonial Options for High Responsive Theme, go %1$shere%2$s', 'christmas-bell' ),
                '<a href="javascript:wp.customize.section( \'christmasbell_testimonials\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'christmasbell_testimonials', array(
            'panel'    => 'christmasbell_theme_options',
            'title'    => esc_html__( 'Testimonials', 'christmas-bell' ),
        )
    );

    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_testimonial_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Christmas_Bell_Note_Control',
            'active_callback'   => 'christmasbell_is_ect_testimonial_inactive',
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with Testimonial Content Type Enabled', 'christmas-bell' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'christmasbell_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_testimonial_option',
            'default'           => 'disabled',
            'sanitize_callback' => 'christmasbell_sanitize_select',
            'active_callback'   => 'christmasbell_is_ect_testimonial_active',
            'choices'           => christmasbell_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'christmas-bell' ),
            'section'           => 'christmasbell_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_testimonial_slider',
            'default'           => 1,
            'sanitize_callback' => 'christmasbell_sanitize_checkbox',
            'active_callback'   => 'christmasbell_is_testimonial_active',
            'label'             => esc_html__( 'Check to Enable Slider', 'christmas-bell' ),
            'section'           => 'christmasbell_testimonials',
            'type'              => 'checkbox',
        )
    );

    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Christmas_Bell_Note_Control',
            'active_callback'   => 'christmasbell_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'christmas-bell' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'christmasbell_testimonials',
            'type'              => 'description',
        )
    );

    christmasbell_register_option( $wp_customize, array(
            'name'              => 'christmasbell_testimonial_number',
            'default'           => '3',
            'sanitize_callback' => 'christmasbell_sanitize_number_range',
            'active_callback'   => 'christmasbell_is_testimonial_active',
            'label'             => esc_html__( 'Number of items to show', 'christmas-bell' ),
            'section'           => 'christmasbell_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

   $number = get_theme_mod( 'christmasbell_testimonial_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        christmasbell_register_option( $wp_customize, array(
                'name'              => 'christmasbell_testimonial_cpt_' . $i,
                'sanitize_callback' => 'christmasbell_sanitize_post',
                'active_callback'   => 'christmasbell_is_testimonial_active',
                'label'             => esc_html__( 'Testimonial', 'christmas-bell' ) . ' ' . $i ,
                'section'           => 'christmasbell_testimonials',
                'type'              => 'select',
                'choices'           => christmasbell_generate_post_array( 'jetpack-testimonial' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'christmasbell_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'christmasbell_is_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since High Responsive 1.0
    */
    function christmasbell_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'christmasbell_testimonial_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( christmasbell_check_section( $enable ) && ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) ) );
    }
endif;

if ( ! function_exists( 'christmasbell_is_ect_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since High Responsive 1.0
    */
    function christmasbell_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;

if ( ! function_exists( 'christmasbell_is_ect_testimonial_inactive' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since High Responsive 1.0
    */
    function christmasbell_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;
