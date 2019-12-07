<?php
/**
 * The template for displaying Services
 *
 * @package Christmas_Bell
 */



if ( ! function_exists( 'christmasbell_service_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook christmasbell_before_content.
	*
	* @since Christmas Bell 0.1
	*/
	function christmasbell_service_display() {
		$output = '';

		// get data value from options
		$enable_content = get_theme_mod( 'christmasbell_service_option', 'disabled' );

		if ( christmasbell_check_section( $enable_content ) ) {
			$content_select = get_theme_mod( 'christmasbell_service_type', 'category' );
			$headline       = get_theme_mod( 'christmasbell_service_headline', esc_html__( 'Services', 'christmas-bell' ) );
			$subheadline    = get_theme_mod( 'christmasbell_service_subheadline' );
			$main_image     = get_theme_mod( 'christmasbell_service_main_image' );

			$classes[] = 'section';
			$classes[] = $content_select ;

			if ( $main_image ) {
				$classes[] = 'has-main-image';
			}

			$output = '
				<div id="service-section" class="' . esc_attr( implode( ' ', $classes ) ) . '">
					<div class="wrapper">';

			// Service Main Image.
			if ( $main_image = get_theme_mod( 'christmasbell_service_main_image' ) ) {

				$thumbnail_url = wp_get_attachment_image_src($main_image, 'full', true );
				$output .= '<div class="main-image post-thumbnail" style="background-image: url( ' . esc_url( $thumbnail_url[0] ) . ' )">';

				if ( $image_link = get_theme_mod( 'christmasbell_service_main_image_link' ) ) {
					$output .= '<a class="cover-link" href="' . esc_url( $image_link ) . '" target="' . esc_attr( get_theme_mod( 'christmasbell_service_main_image_target' ) ? '_blank' : '_self' ) . '"></a>';
				}

				$output .= '
				</div><!-- .main-image.post-thumbnail -->';
			}

			$output .= '<div class="service-content-area layout-three">';

			if ( ! empty( $headline ) || ! empty( $subheadline ) ) {
				$output .= '<div class="section-heading-wrap service-section-headline">';

				if ( ! empty( $headline ) ) {
					$output .= '<div class="section-title-wrapper"><h2 class="section-title">' . wp_kses_post( $headline ) . '</h2></div>';
				}

				if ( ! empty( $subheadline ) ) {
					$output .= '<div class="taxonomy-description-wrapper">' . wp_kses_post( $subheadline ) . '</div>';
				}

				$output .= '
				</div><!-- .section-heading-wrap -->';
			}
			$output .= '
				<div class="service-content-wrapper layout-three">';

			// Select content
			if ( 'post' === $content_select || 'ect-service' === $content_select || 'page' === $content_select || 'category' === $content_select ) {
				$output .= christmasbell_post_page_category_service();
			} elseif ( 'image' === $content_select ) {
				$output .= christmasbell_image_service();
			}

			$output .= '
						</div><!-- .service-wrapper -->
					</div><!-- .service-content-area -->
				</div><!-- .wrapper -->
			</div><!-- #service-section -->';

		}

		echo $output;
	}
endif;
add_action( 'christmasbell_service', 'christmasbell_service_display', 10 );


if ( ! function_exists( 'christmasbell_post_page_category_service' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @param $options: christmasbell_theme_options from customizer
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_post_page_category_service() {
		global $post;

		$quantity   = get_theme_mod( 'christmasbell_service_number', 3 );
		$no_of_post = 0; // for number of posts
		$post_list  = array();// list of valid post/page ids
		$type       = get_theme_mod( 'christmasbell_service_type', 'category' );
		$output     = '';

		$args = array(
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'post' === $type || 'ect-service' === $type || 'page' === $type  ) {
			$args['post_type'] = $type;

			for ( $i = 1; $i <= $quantity; $i++ ) {
				$post_id = '';

				if ( 'post' === $type ) {
					$post_id = get_theme_mod( 'christmasbell_service_post_' . $i );
				} elseif ( 'page' === $type ) {
					$post_id = get_theme_mod( 'christmasbell_service_page_' . $i );
				} elseif ( 'ect-service' === $type ) {
					$post_id = get_theme_mod( 'christmasbell_service_cpt_' . $i );
				}

				if ( $post_id && '' !== $post_id ) {
					// Polylang Support.
					if ( class_exists( 'Polylang' ) ) {
						$post_id = pll_get_post( $post_id, pll_current_language() );
					}

					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
		} elseif ( 'category' === $type ) {
			$no_of_post = $quantity;

			$cats = get_theme_mod( 'christmasbell_service_select_category' );

			if ( $cats ) {
				$args['category__in'] = get_theme_mod( 'christmasbell_service_select_category' );
			}

			$args['post_type'] = 'post';
		}

		if ( 0 === $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop     = new WP_Query( $args );

		while ( $loop->have_posts() ) {
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$i = absint( $loop->current_post + 1 );

			$output .= '
				<article id="service-post-' . $i . '" class="status-publish has-post-thumbnail hentry ' . esc_attr( $type ) . '">';

				// Default value if there is no first image
				$image = '<img class="wp-post-image" src="' . trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg" >';

				if ( has_post_thumbnail() ) {
					$image = get_the_post_thumbnail( $post->ID, 'christmasbell-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
				}
				else {
					// Get the first image in page, returns false if there is no image.
					$first_image = christmasbell_get_first_image( $post->ID, 'christmasbell-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

					// Set value of image as first image if there is an image present in the page.
					if ( $first_image ) {
						$image = $first_image;
					}
				}

				$output .= '
					<a class="post-thumbnail" href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
						'. $image . '
					</a>
					<div class="entry-container">';

				if ( get_theme_mod( 'christmasbell_service_enable_title', 1 ) ) {
					$output .= the_title( '<header class="entry-header"><h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2></header><!-- .entry-header -->', false );
				}

				$content_show = get_theme_mod( 'christmasbell_service_show', 'excerpt' );

				if ( 'excerpt' === $content_show ) {
					//Show Excerpt
					$output .= '
						<div class="entry-summary"><p>' . get_the_excerpt() . '</p></div><!-- .entry-summary -->';
				}
				elseif ( 'full-content' === $content_show ) {
					//Show Content
					$content = apply_filters( 'the_content', get_the_content() );
					$content = str_replace( ' )]>', ' )]&gt;', $content );
					$output .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
				}

				$output .= '
					</div><!-- .entry-container -->
				</article><!-- .featured-post-' . $i . ' -->';
			} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // christmasbell_post_page_category_service


if ( ! function_exists( 'christmasbell_image_service' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @get the data value from theme options
	 * @displays on the index
	 *
	 * @useage Featured Image, Title and Excerpt of Post
	 *
	 * @uses set_transient
	 *
	 * @since Christmas Bell 0.1
	 */
	function christmasbell_image_service() {
		$quantity = get_theme_mod( 'christmasbell_service_number', 3 );
		$output   = '';

		for ( $i = 1; $i <= $quantity; $i++ ) {
			$content = get_theme_mod(  'christmasbell_service_content_'. $i ) ? '<div class="entry-content">' . get_theme_mod(  'christmasbell_service_content_'. $i ) . '</div>' : '';
			$target  = get_theme_mod(  'christmasbell_service_target_' . $i ) ? '_blank' : '_self';
			$link    = '#';
			$title   = '';
			$image   = '';

			// Checking Link.
			if ( get_theme_mod(  'christmasbell_service_link_' . $i ) ) {
				// support qTranslate plugin.
				if ( function_exists( 'qtrans_convertURL' ) ) {
					$link = qtrans_convertURL( get_theme_mod(  'christmasbell_service_link_' . $i ) );
				} else {
					$link = get_theme_mod(  'christmasbell_service_link_' . $i );
				}
			}

			// Checking Title.
			if ( get_theme_mod(  'christmasbell_service_title_'. $i ) ) {
				$title = '
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="' . esc_attr( get_theme_mod(  'christmasbell_service_title_'. $i ) ) . '" href="' . esc_url( $link ) . '" target="' . $target . '">' . esc_html( get_theme_mod(  'christmasbell_service_title_'. $i ) ) . '</a>
					</h2>
				</header>';
			}

			$img_src = get_theme_mod(  'christmasbell_service_image_' . $i );

			if ( $img_src ) {
				$image .= '
				<a class="post-thumbnail" title="' . esc_attr( $title ) . '" href="' . esc_url( $link ) . '" target="' . $target . '">
					<img src="' . esc_url( $img_src ) . '" class="wp-post-image" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '">
				</a>';
			}

			$output .= '
			<article id="service-post-' . esc_attr( $i ) . '" class="post hentry custom-service">
				' . $image . '
				<div class="entry-container">
					' . $title . $content . '
				</div><!-- .entry-container -->
			</article>';
		} // End for().

		return $output;
	}
endif; // christmasbell_image_service.
