<?php
/**
 * Display Header Media Text
 *
 * @package Christmas_Bell
 */
?>

<?php
$header_media_title = get_theme_mod( 'christmasbell_header_media_title', esc_html__( 'Merry Christmas', 'christmas-bell' ) );

$header_media_text = get_theme_mod( 'christmasbell_header_media_text', esc_html__( 'Get inspired this Christmas.', 'christmas-bell' ) );

if ( '' !== $header_media_title || '' !== $header_media_text ) : ?>
	<div class="custom-header-content sections header-media-section">
		<?php if ( '' !== $header_media_title ) : ?>
		<h2 class="entry-title section-title"><?php echo wp_kses_post( $header_media_title ); ?></h2>
		<?php endif; ?>

		<p class="site-header-text"><?php echo wp_kses_post( $header_media_text ); ?>
		<span class="more-link"><a href="<?php echo esc_url( get_theme_mod( 'christmasbell_header_media_url', '#' ) ); ?>" target="<?php echo get_theme_mod( 'christmasbell_header_url_target' ) ? '_blank' : '_self'; ?>" class="readmore"><?php echo esc_html( get_theme_mod( 'christmasbell_header_media_url_text', esc_html__( 'Continue reading', 'christmas-bell' ) ) ); ?><span class="screen-reader-text"><?php echo wp_kses_post( $header_media_title ); ?></span></a></span></p>
	</div>
<?php endif; ?>
