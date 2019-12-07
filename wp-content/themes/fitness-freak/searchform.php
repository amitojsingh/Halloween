<?php
/**
 * Template for displaying search forms in Theme
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html(__('Search for :', 'fitness-freak') ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e('Search','fitness-freak' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_html(__('Search', 'fitness-freak') ); ?></span></button>
</form>
