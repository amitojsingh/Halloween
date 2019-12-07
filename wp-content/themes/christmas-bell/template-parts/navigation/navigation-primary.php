<?php
/**
 * Displays Primary Navigation
 *
 * @package Christmas_Bell
 */
?>

<button id="primary-menu-toggle" class="menu-primary-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false">
	<?php
	echo christmasbell_get_svg( array( 'icon' => 'bars' ) );
	echo christmasbell_get_svg( array( 'icon' => 'close' ) );
	echo '<span class="menu-label-prefix">'. esc_attr__( 'Primary ', 'christmas-bell' ) . '</span><span class="menu-label">'. esc_attr__( 'Menu', 'christmas-bell' ) . '</span>';
	?>
</button>

<div id="site-header-menu" class="site-primary-menu">
	<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
		<nav id="site-primary-navigation" class="main-navigation site-navigation custom-primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'christmas-bell' ); ?>">
			<?php wp_nav_menu( array(
				'theme_location'	=> 'menu-1',
				'container_class'	=> 'primary-menu-container',
				'menu_class'		=> 'primary-menu',
			) ); ?>
		</nav><!-- #site-primary-navigation.custom-primary-menu -->
	<?php else : ?>
		<nav id="site-primary-navigation" class="main-navigation site-navigation default-page-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'christmas-bell' ); ?>">
			<?php wp_page_menu(
				array(
					'menu_class' => 'primary-menu-container',
					'before'     => '<ul id="primary-page-menu" class="primary-menu">',
					'after'      => '</ul>',
				)
			); ?>
		</nav><!-- #site-primary-navigation.default-page-menu -->

	<?php endif; ?>

	<div class="primary-social-search-wrapper">
		<button id="search-toggle" class="menu-search-toggle menu-toggle"><?php echo christmasbell_get_svg( array(
			'icon' => 'search',
		), true ); echo christmasbell_get_svg( array(
			'icon' => 'close',
		), true ); ?><span class="screen-reader-text"><?php esc_html_e( 'Search', 'christmas-bell' ); ?></span></button>

        <div id="search-social-container" class="displaynone">
        	<div class="search-container">
            	<?php get_search_form(); ?>
            </div><!-- .search-container -->
            <?php if ( has_nav_menu( 'social-primary' ) ) : ?>
					<nav id="social-primary-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'christmas-bell' ); ?>">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'social-primary',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>' . christmasbell_get_svg( array( 'icon' => 'chain' ) ),
							) );
						?>
					</nav><!-- .social-navigation -->
				<?php endif; ?>
		</div><!-- #search-social-container -->
	</div><!-- .primary-social-search-wrapper -->
</div><!-- .site-header-main -->
