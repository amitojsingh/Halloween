<?php
/**
 * Customizer functionality
 *
 * @package Christmas_Bell
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Christmas Bell 0.1
 *
 * @see christmasbell_header_style()
 */
function christmasbell_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support.
	 *
	 * @since Christmas Bell 0.1
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'christmasbell_custom_background_args', array(
		'default-color' => '#1a1a1a',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support.
	 *
	 * @since Christmas Bell 0.1
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'christmasbell_custom_header_args', array(
		'default-image'      	 => get_parent_theme_file_uri( '/assets/images/header-image.jpg' ),
		'default-text-color'     => '#ffffff',
		'width'                  => 1920,
		'height'                 => 1080,
		'flex-height'            => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'christmasbell_header_style',
		'video'                  => true,
	) ) );

	register_default_headers( array(
	'default-image' => array(
		'url'           => '%s/assets/images/header-image.jpg',
		'thumbnail_url' => '%s/assets/images/header-image-275x155.jpg',
		'description'   => esc_html__( 'Default Header Image', 'christmas-bell' ),
		),
	) );
}
add_action( 'after_setup_theme', 'christmasbell_custom_header_and_background' );

if ( ! function_exists( 'christmasbell_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own christmasbell_header_style() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 *
 * @see christmasbell_custom_header_and_background().
 */
function christmasbell_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="christmasbell-header-css">
		<?php
			// Has the text been hidden?
		if ( 'blank' === $header_text_color ) :
		?>
			.site-identity {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
	</style>
	<?php
}
endif; // christmasbell_header_style

/**
 * Customize video play/pause button in the custom header.
 *
 * @param array $settings header video settings.
 */
function christmasbell_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . esc_html__( 'Play background video', 'christmas-bell' ) . '</span>' . christmasbell_get_svg( array(
		'icon' => 'play',
	) );
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . esc_html__( 'Pause background video', 'christmas-bell' ) . '</span>' . christmasbell_get_svg( array(
		'icon' => 'pause',
	) );
	return $settings;
}
add_filter( 'header_video_settings', 'christmasbell_video_controls' );
