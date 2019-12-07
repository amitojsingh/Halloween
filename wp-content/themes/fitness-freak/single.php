<?php
/*
* Single Post template file
*/
get_header();
$pagetitle = 1; ?>    
    <?php if($pagetitle == 1) : ?>
    <div class="heading-wrap blog-heading-wrap">
        <div class="heading-layer">
            <div class="heading-title">
                <h4><?php the_title(); ?></h4>
            </div>
        </div>
    </div>
    <?php endif; ?>
<div class="single-blog-wrapper">
    <div class="fitness-freak-section">
        <div class="container">
            <div class="row responsive">
                 <?php 
                $blog_layout_class=(get_theme_mod('blogsinglesidebar',1) == 1)?"9":((get_theme_mod('blogsinglesidebar',1) == 2)?"9":"12");
                if(get_theme_mod('blogsinglesidebar',1) == 1 ):
                        get_sidebar();
                 endif;
                ?>  
                <div class="col-md-<?php echo esc_attr($blog_layout_class); ?> col-sm-12 col-xs-12 content">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="single-blog-content-area fadeIn animated">
                            <div class="single-blog-content">
                                <div class="title-data fadeIn animated">
                                    <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                                    <?php if(get_theme_mod('blogSingleMetaTag',1) == 1): ?>
                                           <?php wp_kses_post(fitness_freak_entry_meta()); ?>
                                    <?php endif; ?>
                                </div>
                                <?php if ( has_post_thumbnail() ) : ?>
                                 <div class="single-blog-images">
                                    <?php the_post_thumbnail( 'fitness_freak_ThumbnailImage', array( 'class' => 'img-responsive') ); ?>
                                </div>
                                <?php endif;
                                    the_content(); ?>
                            </div>                            
                           <?php if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif; ?>
                        </div>
                        <?php 
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fitness-freak' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'fitness-freak' ) . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );
                    // Previous/next page navigation.
                    the_post_navigation( array(
                        'prev_text'          => __( 'Previous Post', 'fitness-freak' ),
                        'next_text'          => __( 'Next Post', 'fitness-freak' ),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'fitness-freak' ) . ' </span>',
                    ) ); ?>
                <?php endwhile; ?>
                </div>
                 <?php 
                if(get_theme_mod('blogsinglesidebar',1) == 2 ):
                        get_sidebar();
                 endif;
                ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>