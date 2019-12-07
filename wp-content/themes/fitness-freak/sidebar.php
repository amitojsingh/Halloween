<?php 
/**
 * The right sidebar template file
**/
?>
<div class="col-md-3 col-sm-12 col-xs-12 blog-menu-area sidebar">
    <?php if (is_active_sidebar('sidebar-1')) {
		dynamic_sidebar('sidebar-1');
    } else {
		 //default sidebar if not exist sidebar 1
		$args = array('name' => __( 'Sidebar 1 Default', 'fitness-freak' ),'id' => 'sidebar-1-default','description' => __( 'The Secondary Widget Area Default', 'fitness-freak' ),'before_widget' => '<aside class="menu-left widget ">','after_widget' => '</aside>','before_title' => '<h6>','after_title' => '</h6>',);

		the_widget('WP_Widget_Search', 'title=Search', $args);
		the_widget('WP_Widget_Recent_Posts', null, $args);
		the_widget('WP_Widget_Categories', null, $args);
		the_widget('WP_Widget_Archives', null, $args);
		the_widget('WP_Widget_Tag_Cloud', null, $args);
	} ?>
</div>