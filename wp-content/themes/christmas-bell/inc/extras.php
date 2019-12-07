<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Christmas_Bell
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Christmas Bell 0.1
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function christmasbell_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	// Adds a class of (full-width|box) to blogs.
	if ( 'boxed' === get_theme_mod( 'christmasbell_layout_type' ) ) {
		$classes[] = 'boxed-layout';
	} else {
		$classes[] = 'fluid-layout';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class with respect to layout selected.
	$layout  = christmasbell_get_theme_layout();
	$sidebar = christmasbell_get_sidebar_id();

	if ( 'no-sidebar' === $layout ) {
		$classes[] = 'no-sidebar content-width-layout';
	} elseif ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns-layout content-left';
		}
	}

	$classes[] = get_theme_mod( 'christmasbell_content_layout', 'excerpt-image-top' );

	$classes[] = 'primary-menu-left';

	$footer_left_content = get_theme_mod( 'christmasbell_footer_content_left' );
	$footer_right_content = get_theme_mod( 'christmasbell_footer_content_right' );

	if ( !( '' == $footer_left_content && '' == $footer_right_content ) ) {
		$classes[] = 'site-generator-two';
	}

	return $classes;
}
add_filter( 'body_class', 'christmasbell_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function christmasbell_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'christmasbell_pingback_header' );

/**
 * Function to add Scroll Up icon
 */
function christmasbell_scrollup() {
	$disable_scrollup = get_theme_mod( 'christmasbell_disable_scrollup' );

	if ( $disable_scrollup ) {
		return;
	}

	echo '<a href="#masthead" id="scrollup" class="backtotop">' .christmasbell_get_svg( array( 'icon' => 'angle-down' ) ) . '<span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'christmas-bell' ) . '</span></a>' ;

}
add_action( 'wp_footer', 'christmasbell_scrollup', 1 );

if ( ! function_exists( 'christmasbell_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'christmasbell_pagination_type', 'default' );

		/**
		 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
		 * if it's active then disable pagination
		 */
		if ( ( 'infinite-scroll' === $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return false;
		}

		if ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous page', 'christmas-bell' ),
				'next_text'          => esc_html__( 'Next page', 'christmas-bell' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'christmas-bell' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // christmasbell_content_nav

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function christmasbell_check_section( $value ) {
	global $wp_query;

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	return ( 'entire-site' == $value  || ( ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) && 'homepage' == $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Christmas Bell 0.1
 */

function christmasbell_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. esc_url( $first_img ) .'">';
	}

	return false;
}

function christmasbell_get_theme_layout() {
	$layout = get_theme_mod( 'christmasbell_default_layout', 'right-sidebar' );

	if ( is_home() || is_archive() ) {
		$layout = get_theme_mod( 'christmasbell_homepage_archive_layout', 'right-sidebar' );
	}

	return $layout;
}

function christmasbell_get_sidebar_id() {
	$sidebar = '';

	$layout = christmasbell_get_theme_layout();

	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

/**
 * Display social Menu
 */
function christmasbell_social_menu() {
	if ( has_nav_menu( 'social-menu' ) ) :
		?>
		<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'christmas-bell' ); ?>">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'social-menu',
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
					'depth'          => 1,
				) );
			?>
		</nav><!-- .social-navigation -->
	<?php endif;
}

if ( ! function_exists( 'christmasbell_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since Christmas Bell 0.1
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function christmasbell_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //christmasbell_truncate_phrase

if ( ! function_exists( 'christmasbell_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since Christmas Bell 0.1
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function christmasbell_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		// Strip tags and shortcodes so the content truncation count is done correctly.
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		// Remove inline styles / .
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		// Truncate $content to $max_char
		$content = christmasbell_truncate_phrase( $content, $max_characters );

		// More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="more-link"><a href="%s" class="readmore">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'christmasbell_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //christmasbell_get_the_content_limit

if ( ! function_exists( 'christmasbell_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply fabulous-fluid your own christmasbell_content_image(), and that function will be used instead.
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_content_image() {
		if ( has_post_thumbnail() && christmasbell_jetpack_featured_image_display() && is_singular() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
		 		if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'christmasbell-single-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'christmasbell-single-image', true );
				}
			}

			if ( empty( $individual_featured_image ) ) {
				$individual_featured_image = 'default';
			}

			if ( 'disable' === $individual_featured_image ) {
				echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
				return false;
			} else {
				$class = array();

				$image_size = 'post-thumbnail';

				if ( 'default' !== $individual_featured_image ) {
					$image_size = $individual_featured_image;
					$class[]    = 'from-metabox';
				} else {
					$layout = christmasbell_get_theme_layout();
				}

				$class[] = $individual_featured_image;
				?>
				<div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
					<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $image_size ); ?>
					</a>
				</div>
		   	<?php
			}
		} // End if().
	}
endif; // christmasbell_content_image.

if ( ! function_exists( 'christmasbell_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own christmasbell_featured_image(), and that function will be used instead.
	 *
	 * @since Catch Base 1.0
	 */
	function christmasbell_featured_image() {
		if ( is_post_type_archive( 'jetpack-testimonial' ) ) :
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) : ?>
				<div class="post-thumbnail archive-header-image">
					<?php echo wp_get_attachment_image( (int) $jetpack_options['featured-image'], 'post-thumbnail' ); ?>
				</div>
			<?php endif;

		elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) :

			$jetpack_portfolio_featured_image = get_option( 'jetpack_portfolio_featured_image' );
			if ( '' !== $jetpack_portfolio_featured_image ) : ?>
				<div class="post-thumbnail archive-header-image">
					<?php echo wp_get_attachment_image( (int) $jetpack_portfolio_featured_image, 'post-thumbnail' ); ?>
				</div>
			<?php endif;

		elseif ( has_custom_header() ) : ?>
			<div class="custom-header-media">
				<?php the_custom_header_markup(); ?>
			</div>

			<?php get_template_part( 'template-parts/header/header-media', 'text' ); ?>
		<?php
		endif;

	} // christmasbell_featured_image
endif;

if ( ! function_exists( 'christmasbell_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own christmasbell_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_featured_page_post_image() {
		if ( ! has_post_thumbnail() ) {
			christmasbell_featured_image();
			return;
		}
		?>
		<div class="post-thumbnail singular-header-image">
			<?php the_post_thumbnail( 'christmasbell-slider' ); ?>
		</div><!-- .post-thumbnail -->
		<?php
	} // christmasbell_featured_page_post_image
endif;


if ( ! function_exists( 'christmasbell_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own christmasbell_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_featured_overall_image() {
		global $post, $wp_query;
		$enable = get_theme_mod( 'christmasbell_header_media_option', 'homepage' );

		// Get Page ID outside Loop
		$page_id = absint( $wp_query->get_queried_object_id() );

		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'christmasbell-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			}
			elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
				christmasbell_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				christmasbell_featured_image();
			}
		}
		// Check Excluding Homepage
		if ( 'exclude-home' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return false;
			}
			else {
				christmasbell_featured_image();
			}
		}
		elseif ( 'exclude-home-page-post' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				christmasbell_featured_page_post_image();
			}
			else {
				christmasbell_featured_image();
			}
		}
		// Check Entire Site
		elseif ( 'entire-site' === $enable ) {
			christmasbell_featured_image();
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' === $enable ) {
			if ( is_page() || is_single() || ( is_home() && $page_for_posts === $page_id ) ) {
				christmasbell_featured_page_post_image();
			}
			else {
				christmasbell_featured_image();
			}
		}
		// Check Page/Post
		elseif ( 'pages-posts' === $enable ) {
			if ( is_page() || is_single() ) {
				christmasbell_featured_page_post_image();
			}
		}
	} // christmasbell_featured_overall_image
endif;


if ( ! function_exists( 'christmasbell_rss_redirect' ) ) :
	/**
	 * Redirect WordPress Feeds To FeedBurner
	 *
	 * @action template_redirect
	 *
	 * @since Christmas Bell 0.1.2
	 */
	function christmasbell_rss_redirect() {
		$feed = get_theme_mod( 'christmasbell_feed_redirect' );

	    if ( $feed ) {
			$url = 'Location: ' . $feed;

			if ( is_feed() && ! preg_match( '/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
				header( esc_url( $url ) );
				header( 'HTTP/1.1 302 Temporary Redirect' );
			}
		}
	}
endif; //christmasbell_rss_redirect
add_action( 'template_redirect', 'christmasbell_rss_redirect' );
