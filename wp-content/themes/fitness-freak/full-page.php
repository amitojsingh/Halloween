<?php
/**
 * Template Name: Full Width
 **/

get_header();
$page_title = get_theme_mod('pagetitle',1);  ?>    
    <?php if(!is_home() && !is_front_page() && $page_title != 0 ): ?>
    <div class="heading-wrap blog-heading-wrap">
        <div class="heading-layer">
            <div class="heading-title">
                <h4><?php the_title(); ?></h4>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">                           
            <div class="col-md-12 col-sm-12 col-xs-12 blog-article">
                <?php while ( have_posts() ) : the_post(); ?>
                        <?php the_content(); 

                           wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fitness-freak' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'fitness-freak' ) . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );?>
                <?php endwhile;  ?> 

                <?php  if(!is_front_page()){ // Previous/next navigation.
                           the_post_navigation( array(
                                'prev_text'          => __('Previous : %title', 'fitness-freak'),
                                'next_text'          => __( 'Next : %title ', 'fitness-freak' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'fitness-freak' ) . ' </span>',
                    ) );
                }?>
            </div>            
        </div>
    </div>
<?php get_footer(); ?>