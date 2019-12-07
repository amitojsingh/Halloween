<?php

/**
 * Function to register control and setting
 */
function christmasbell_register_option( $wp_customize, $option ) {

	// Initialize Setting.
	$wp_customize->add_setting( $option['name'], array(
		'sanitize_callback'    => $option['sanitize_callback'],
		'default'              => isset( $option['default'] ) ? $option['default'] : '',
		'transport'            => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
		'theme_supports'       => isset( $option['theme_supports'] ) ? $option['theme_supports'] : '',
	) );

	$control = array(
		'label'    => $option['label'],
		'section'  => $option['section'],
		'settings' => $option['name'],
	);

	if ( isset( $option['active_callback'] ) ) {
		$control['active_callback'] = $option['active_callback'];
	}

	if ( isset( $option['priority'] ) ) {
		$control['priority'] = $option['priority'];
	}

	if ( isset( $option['choices'] ) ) {
		$control['choices'] = $option['choices'];
	}

	if ( isset( $option['type'] ) ) {
		$control['type'] = $option['type'];
	}

	if ( isset( $option['input_attrs'] ) ) {
		$control['input_attrs'] = $option['input_attrs'];
	}

	if ( isset( $option['description'] ) ) {
		$control['description'] = $option['description'];
	}

	if ( isset( $option['custom_control'] ) ) {
		$wp_customize->add_control( new $option['custom_control']( $wp_customize, $option['name'], $control ) );
	} else {
		$wp_customize->add_control( $option['name'], $control );
	}
}

/**
 * Function to reset date with respect to condition
 */
function christmasbell_reset_data() {
	if ( get_theme_mod( 'christmasbell_reset_all_settings' ) ) {
		remove_theme_mods();

		return;
	}
}
add_action( 'customize_save_after', 'christmasbell_reset_data' );

/**
 * Alphabetically sort theme options sections
 *
 * @param  wp_customize object $wp_customize wp_customize object.
 */
function christmasbell_sort_sections_list( $wp_customize ) {
	foreach ( $wp_customize->sections() as $section_key => $section_object ) {
		if ( false !== strpos( $section_key, 'christmasbell_' ) && 'christmasbell_reset_all' !== $section_key && 'christmasbell_important_links' !== $section_key ) {
			$options[] = $section_key;
		}
	}

	sort( $options );

	$priority = 1;
	foreach ( $options as  $option ) {
		$wp_customize->get_section( $option )->priority = $priority++;
	}
}
add_action( 'customize_register', 'christmasbell_sort_sections_list' );

/**
 * Returns an array of visibility options for featured sections
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_section_visibility_options() {
	$options = array(
		'homepage'    => esc_html__( 'Homepage / Frontpage', 'christmas-bell' ),
		'entire-site' => esc_html__( 'Entire Site', 'christmas-bell' ),
		'disabled'    => esc_html__( 'Disabled', 'christmas-bell' ),
	);

	return apply_filters( 'christmasbell_section_visibility_options', $options );
}

/**
 * Returns an array of featured content options
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_sections_layout_options() {
	$options = array(
		'layout-one'   => esc_html__( '1 column', 'christmas-bell' ),
		'layout-two'   => esc_html__( '2 columns', 'christmas-bell' ),
		'layout-three' => esc_html__( '3 columns', 'christmas-bell' ),
		'layout-four'  => esc_html__( '4 columns', 'christmas-bell' ),
	);

	return apply_filters( 'christmasbell_sections_layout_options', $options );
}

/**
 * Returns an array of section types
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_section_type_options() {
	$options = array(
		'demo'     => esc_html__( 'Demo', 'christmas-bell' ),
		'post'     => esc_html__( 'Post', 'christmas-bell' ),
		'page'     => esc_html__( 'Page', 'christmas-bell' ),
		'category' => esc_html__( 'Category', 'christmas-bell' ),
		'image'    => esc_html__( 'Image', 'christmas-bell' ),
	);

	return apply_filters( 'christmasbell_section_type_options', $options );
}

/**
 * Returns an array of color schemes registered.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_get_pagination_types() {
	$pagination_types = array(
		'default'         => esc_html__( 'Default(Older Posts/Newer Posts)', 'christmas-bell' ),
		'numeric'         => esc_html__( 'Numeric', 'christmas-bell' ),
		'infinite-scroll' => esc_html__( 'Infinite Scroll', 'christmas-bell' ),
	);

	return apply_filters( 'christmasbell_get_pagination_types', $pagination_types );
}

/**
 * Generate a list of all available post array
 *
 * @param  string $post_type post type.
 * @return post_array
 */
function christmasbell_generate_post_array( $post_type = 'post' ) {
	$output = array();
	$posts = get_posts( array(
		'post_type'        => $post_type,
		'post_status'      => 'publish',
		'suppress_filters' => false,
		'posts_per_page'   => -1,
		)
	);

	$output['0']= esc_html__( '-- Select --', 'christmas-bell' );

	foreach ( $posts as $post ) {
		/* translators: 1: post id. */
		$output[ $post->ID ] = ! empty( $post->post_title ) ? $post->post_title : sprintf( __( '#%d (no title)', 'christmas-bell' ), $post->ID );
	}

	return $output;
}
