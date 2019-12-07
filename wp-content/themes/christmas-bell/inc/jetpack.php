<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.me/
 *
 * @package Christmas_Bell
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function christmasbell_jetpack_setup() {
	/**
	 * Setup Infinite Scroll using JetPack if navigation type is set
	 */
	$pagination_type = get_theme_mod( 'christmasbell_pagination_type', 'default' );

	if ( 'infinite-scroll' === $pagination_type ) {
		add_theme_support( 'infinite-scroll', array(
			'container'      => 'main',
			'wrapper'        => false,
			'render'         => 'christmasbell_infinite_scroll_render',
			'footer'         => false,
			'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4', 'sidebar-5' ),
		) );
	}

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'featured-content', array(
		'filter'     => 'christmasbell_get_featured_posts',
		'max_posts'  => 3,
		'post_types' => array( 'post', 'page' ),
	) );

	// Add theme support for JetPack Portfolio.
	add_theme_support( 'jetpack-portfolio', array(
		'title'          => true,
		'content'        => true,
		'featured-image' => true,
	) );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'post-details'    => array(
			'stylesheet' => 'christmasbell-style',
			'date'       => '.posted-on, .sep',
			'categories' => '.cat-links'
		),
	) );

	// Add theme support for testimonials.
	add_theme_support( 'jetpack-testimonial' );
}
add_action( 'after_setup_theme', 'christmasbell_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function christmasbell_infinite_scroll_render() {
	do_action( 'christmasbell_jetpack_infinite_scroll_before' );
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content/content', 'search' );
		else :
			get_template_part( 'template-parts/content/content', get_post_format() );
		endif;
	}

	do_action( 'christmasbell_jetpack_infinite_scroll_after' );
}

/**
		 * Jetpack infinite scroll duplicates posts where orderby is anything other than modified or date
		 * This filter offsets the products returned by however many are displayed per page
		 *
		 * @link https://github.com/Automattic/jetpack/issues/1135
		 * @param  array $args infinite scroll args.
		 * @return array       infinite scroll args.
		 */
		function fix_duplicate_products( $args ) {
			if ( ( isset( $args['post_type'] ) && 'product' === $args['post_type'] ) || ( isset( $args['taxonomy'] ) && 'product_cat' === $args['taxonomy'] ) ) {
				$args['offset'] = $args['posts_per_page'] * $args['paged'];
			}

		 	return $args;
		}
add_filter( 'infinite_scroll_query_args', 'fix_duplicate_products', 100 );

/**
 * Portfolio Title
 *
 * @param  string $before before title content.
 * @param  string $after after title content.
 */
function christmasbell_portfolio_title( $before = '', $after = '' ) {
	get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'christmas-bell' ) );
	$title = '';

	if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
		if ( isset( $jetpack_portfolio_title ) && '' !== $jetpack_portfolio_title ) {
			$title = $jetpack_portfolio_title;
		} else {
			$title = post_type_archive_title( '', false );
		}
	} elseif ( is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
		$title = single_term_title( '', false );
	}

	$title = $before . $title . $after;

	echo $title;
}

/**
 * Portfolio Content
 *
 * @param  string $before before title content.
 * @param  string $after after title content.
 */
function christmasbell_portfolio_content( $before = '', $after = '' ) {
	$jetpack_portfolio_content = get_option( 'jetpack_portfolio_content' );
	$title = '';

	if ( is_tax() && get_the_archive_description() ) {
		$title = $before . get_the_archive_description() . $after;
	} elseif ( isset( $jetpack_portfolio_content ) && '' !== $jetpack_portfolio_content ) {
		$content = convert_chars( convert_smilies( wptexturize( stripslashes( wp_kses_post( addslashes( $jetpack_portfolio_content ) ) ) ) ) );
		$title = $before . $content . $after;
	}

	echo $title;
}

/**
 * Support JetPack featured content
 */
function christmasbell_get_featured_posts() {
	$type = get_theme_mod( 'christmasbell_featured_content_type', 'category' );

	if ( 'tag' === $type ) {
		return apply_filters( 'christmasbell_get_featured_posts', false );
	}

	$number = get_theme_mod( 'christmasbell_featured_content_number', 3 );

	$post_list    = array();

	$args = array(
		'posts_per_page'      => $number,
		'post_type'           => 'post',
		'ignore_sticky_posts' => 1, // ignore sticky posts.
	);

	// Get valid number of posts.
	if ( 'post' === $type || 'page' === $type || 'featured-content' === $type ) {
		$args['post_type'] = $type;

		for ( $i = 1; $i <= $number; $i++ ) {
			$post_id = '';

			if ( 'post' === $type ) {
				$post_id = get_theme_mod( 'christmasbell_featured_content_post_' . $i );
			} elseif ( 'page' === $type ) {
				$post_id = get_theme_mod( 'christmasbell_featured_content_page_' . $i );
			} elseif ( 'featured-content' === $type ) {
				$post_id = get_theme_mod( 'christmasbell_featured_content_cpt_' . $i );
			}

			if ( $post_id && '' !== $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );
			}
		}

		$args['post__in'] = $post_list;
		$args['orderby']  = 'post__in';
	} elseif ( 'category' === $type && $cat = get_theme_mod( 'christmasbell_featured_content_select_category' ) ) {
		$args['category__in'] = $cat;
	}

	$featured_posts = get_posts( $args );

	return $featured_posts;
}