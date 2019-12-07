<?php
/**
 * Hero Content Options
 *
 * @package Christmas_Bell
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function christmasbell_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'christmasbell_hero_content_options', array(
			'title' => esc_html__( 'Hero Content Options', 'christmas-bell' ),
			'panel' => 'christmasbell_theme_options',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_hero_content_visibility',
			'default'           => 'homepage',
			'sanitize_callback' => 'christmasbell_sanitize_select',
			'choices'           => christmasbell_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'christmas-bell' ),
			'section'           => 'christmasbell_hero_content_options',
			'type'              => 'select',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'christmasbell_sanitize_post',
			'active_callback'   => 'christmasbell_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'christmas-bell' ),
			'section'           => 'christmasbell_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	christmasbell_register_option( $wp_customize, array(
			'name'              => 'christmasbell_disable_hero_content_title',
			'sanitize_callback' => 'christmasbell_sanitize_checkbox',
			'active_callback'   => 'christmasbell_is_hero_content_active',
			'label'             => esc_html__( 'Check to disable title', 'christmas-bell' ),
			'section'           => 'christmasbell_hero_content_options',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'christmasbell_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'christmasbell_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Christmas Bell 0.1
	*/
	function christmasbell_is_hero_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option( 'page_for_posts' );

		$enable = $control->manager->get_setting( 'christmasbell_hero_content_visibility' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) &&	 'homepage' == $enable )
			);
	}
endif;
