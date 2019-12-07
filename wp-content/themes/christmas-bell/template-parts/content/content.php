<?php
/**
 * The template part for displaying content
 *
 * @package Christmas_Bell
 */
?>

<?php
$show_meta 	  = get_theme_mod( 'christmasbell_featured_meta_show', 'show-meta' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<?php
		$content_layout = get_theme_mod( 'christmasbell_content_layout', 'excerpt-image-top' ); ?>

		<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="sticky-post"><?php _e( 'Featured', 'christmas-bell' ); ?></span>
			<?php endif; ?>

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'show-meta' === $show_meta ) {
				echo christmasbell_entry_header();
			} ?>

		</header><!-- .entry-header -->

		<?php christmasbell_post_thumbnail(); ?>

		<?php if ( 'excerpt-image-top' === $content_layout ) : ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php else : ?>
			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'christmas-bell' ),
						get_the_title()
					) );

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'christmas-bell' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'christmas-bell' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				?>
			</div><!-- .entry-content -->

		<?php endif; ?>
	</div><!-- .hentry-inner -->
</article><!-- #post-## -->
