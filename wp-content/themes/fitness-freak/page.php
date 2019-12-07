<?php
/**
 * Main Page template file
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
            <?php 
                $blog_layout_class=(get_theme_mod('pagesidebar',1) == 1)?"9":((get_theme_mod('pagesidebar',1) == 2)?"9":"12");
                if(get_theme_mod('pagesidebar',1) == 1):
                        get_sidebar();
                 endif;
                ?>                
            <div class="col-md-<?php echo esc_attr($blog_layout_class); ?> col-sm-12 col-xs-12 blog-article">
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

                
            </div>
            <?php 
                if(get_theme_mod('pagesidebar',1) == 2):
                        get_sidebar();
                 endif;
                ?> 
        </div>
    </div>
<?php get_footer(); ?>