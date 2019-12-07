<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Christmas_Bell
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the single post content template.
			get_template_part( 'template-parts/content/content', 'single' );

			// Comments Templates
			get_template_part( 'template-parts/content/content', 'comment' );

			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'christmas-bell' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'christmas-bell' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'christmas-bell' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . christmasbell_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'christmas-bell' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'christmas-bell' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . christmasbell_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
				) );
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
