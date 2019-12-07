<?php
/**
 * Custom Christmas Bell template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Christmas_Bell
 */

if ( ! function_exists( 'christmasbell_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own christmasbell_entry_meta() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_entry_meta() {
	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		christmasbell_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'christmas-bell' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		christmasbell_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'christmas-bell' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'christmasbell_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own christmasbell_entry_date() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="date-label">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'christmas-bell' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'christmasbell_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own christmasbell_entry_taxonomies() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'christmas-bell' ) );
	if ( $categories_list && christmasbell_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="cat-label">%1$s </span>%2$s</span>',
			_x( 'Categories ', 'Used before category names.', 'christmas-bell' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'christmas-bell' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Tags: ', 'Used before tag names.', 'christmas-bell' ),
			$tags_list
		);
	}
}
endif;


if ( ! function_exists( 'christmasbell_entry_category_date' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own christmasbell_entry_category_date() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_entry_category_date() {
	$meta = '<div class="entry-meta">';

	$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'christmas-bell' ), '</span>' );

	if ( 'jetpack-portfolio' === get_post_type() ) {
		$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
			sprintf( _x( '<span class="cat-label">Categories </span>', 'Used before category names.', 'christmas-bell' ) ),
			$portfolio_categories_list
		);

		$meta .= '<span class="sep">' . _x( ' &ndash; ', 'Post meta separator', 'christmas-bell' ) . '</span>';
	}

	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'christmas-bell' ) );
	if ( $categories_list && christmasbell_categorized_blog() ) {
		$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
			sprintf( _x( '<span class="cat-label">Categories </span>', 'Used before category names.', 'christmas-bell' ) ),
			$categories_list
		);

		$meta .= '<span class="sep">' . _x( ' &ndash; ', 'Post meta separator', 'christmas-bell' ) . '</span>';
	}

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$meta .= sprintf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
		sprintf( __( '<span class="date-label">Posted on </span>', 'christmas-bell' ) ),
		esc_url( get_permalink() ),
		$time_string
	);

	$meta .= '</div><!-- .entry-meta -->';

	return $meta;

}
endif;

if ( ! function_exists( 'christmasbell_portfolio_meta' ) ) :
/**
 * Portfolio Meta
 *
 * Create your own christmasbell_portfolio_meta() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_portfolio_meta() {
	$meta = '<p class="entry-meta">';

	$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'christmas-bell' ), '</span>' );

	if ( 'jetpack-portfolio' === get_post_type() ) {
		$meta .= sprintf( '<span class="cat-links jetpack-portfolio">%1$s%2$s</span>',
			sprintf( _x( '<span class="cat-label screen-reader-text">Categories </span>', 'Used before category names.', 'christmas-bell' ) ),
			$portfolio_categories_list
		);
	} else {
		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'christmas-bell' ) );

		if ( $categories_list && christmasbell_categorized_blog() ) {
			$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
				sprintf( _x( '<span class="cat-label screen-reader-text">Categories </span>', 'Used before category names.', 'christmas-bell' ) ),
				$categories_list
			);
		}
	}

	$meta .= '</p><!-- .entry-meta -->';

	return $meta;
}
endif;


if ( ! function_exists( 'christmasbell_entry_header' ) ) :
/**
 * Prints HTML with meta information for the date and author
 *
 * Create your own christmasbell_entry_header() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_entry_header() {
	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '<span class="author-label">By </span>%s', 'christmas-bell' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	echo '<div class="entry-meta">';

		echo '<span class="byline"> ' . $byline . '</span>';

		echo '<span class="sep">' . _x( ' &ndash; ', 'Post meta separator', 'christmas-bell' ) . '</span>';

		christmasbell_entry_date();

	echo '</div><!-- .entry-meta -->';
}
endif;


if ( ! function_exists( 'christmasbell_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function christmasbell_entry_footer() {

	$show_meta 	  = get_theme_mod( 'christmasbell_featured_meta_show', 'show-meta' );

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'christmas-bell' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( christmasbell_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}

			echo '<div class="entry-meta">';
				if ( 'post' === get_post_type() && 'show-meta' === $show_meta ) {
					if ( ( $categories_list && christmasbell_categorized_blog() ) || $tags_list ) {
						echo '<span class="cat-tags-links">';

							// Make sure there's more than one category before displaying.
							if ( $categories_list && christmasbell_categorized_blog() ) {
								echo '<span class="cat-links">' . christmasbell_get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Categories', 'christmas-bell' ) . '</span>' . $categories_list . '</span>';
							}

							if ( $tags_list ) {
								echo '<span class="tags-links">' . christmasbell_get_svg( array( 'icon' => 'hashtag' ) ) . '<span class="screen-reader-text">' . __( 'Tags', 'christmas-bell' ) . '</span>' . $tags_list . '</span>';
							}

						echo '</span>';
					}
				}

				christmasbell_edit_link();
			echo '</div><!-- .entry-meta -->';

		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;


if ( ! function_exists( 'christmasbell_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function christmasbell_edit_link() {
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'christmas-bell' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;


if ( ! function_exists( 'christmasbell_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * Create your own christmasbell_post_thumbnail() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_post_thumbnail( $size = 'post-thumbnail' ) {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail( $size ); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( $size, array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'christmasbell_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own christmasbell_excerpt() function to override in a child theme.
	 *
	 * @since Christmas Bell 0.1
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function christmasbell_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
		<?php endif;
	}
endif;

if ( ! function_exists( 'christmasbell_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options.
		$length	= get_theme_mod( 'christmasbell_excerpt_length', 40 );

		return absint( $length );
	}
endif; //christmasbell_excerpt_length
add_filter( 'excerpt_length', 'christmasbell_excerpt_length' );

if ( ! function_exists( 'christmasbell_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer.
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function christmasbell_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text = get_theme_mod( 'christmasbell_excerpt_more_text',  esc_html__( 'Continue reading', 'christmas-bell' ) );

		$link = sprintf( '<span class="more-link"><a href="%1$s" class="readmore">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
		);

		return ' &hellip; ' . $link;
	}
endif;
add_filter( 'excerpt_more', 'christmasbell_excerpt_more' );

if ( ! function_exists( 'christmasbell_custom_excerpt' ) ) :
	/**
	 * Adds Continue reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_custom_excerpt( $output ) {

		if ( has_excerpt() && ! is_attachment() ) {
			$more_tag_text = get_theme_mod( 'christmasbell_excerpt_more_text', esc_html__( 'Continue reading', 'christmas-bell' ) );

			$link = sprintf( '<span class="more-link"><a href="%1$s" class="readmore">%2$s</a></span>',
				esc_url( get_permalink( get_the_ID() ) ),
				/* translators: %s: Name of current post */
				wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

			$output .= ' &hellip; ' . $link;
		}

		return $output;
	}
endif; // christmasbell_custom_excerpt.
add_filter( 'get_the_excerpt', 'christmasbell_custom_excerpt' );

if ( ! function_exists( 'christmasbell_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'christmasbell_excerpt_more_text', esc_html__( 'Continue reading', 'christmas-bell' ) );

		return str_replace( $more_link_text, wp_kses_post( $more_tag_text ), $more_link );
	}
endif; // christmasbell_more_link.
add_filter( 'the_content_more_link', 'christmasbell_more_link', 10, 2 );

if ( ! function_exists( 'christmasbell_categorized_blog' ) ) :
/**
 * Determines whether blog/site has more than one category.
 *
 * Create your own christmasbell_categorized_blog() function to override in a child theme.
 *
 * @since Christmas Bell 0.1
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function christmasbell_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'christmasbell_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'christmasbell_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so christmasbell_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so christmasbell_categorized_blog should return false.
		return false;
	}
}
endif;

/**
 * Flushes out the transients used in christmasbell_categorized_blog().
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'christmasbell_categories' );
}
add_action( 'edit_category', 'christmasbell_category_transient_flusher' );
add_action( 'save_post',     'christmasbell_category_transient_flusher' );

if ( ! function_exists( 'christmasbell_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action christmasbell_footer
 *
 * @since Christmas Bell 0.1
 */
function christmasbell_footer_content() {
	$theme_data = wp_get_theme();

	$def_footer_text = sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'christmas-bell' ), esc_attr( date_i18n( __( 'Y', 'christmas-bell' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', get_the_privacy_policy_link() ) . ' &#124; ' . esc_html( $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'christmas-bell' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>';

	echo '
	<div class="site-info">
		<div class="wrapper">
			<div id="footer-left-content" class="copyright">' . $def_footer_text . '</div>
		</div><!-- .wrapper -->
	</div><!-- .site-info -->';
}
add_action( 'christmasbell_credits', 'christmasbell_footer_content', 10 );
