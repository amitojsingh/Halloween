<div class="blog-wrapper">
    <div class="">
        <div class="container">
            <div id="post-<?php the_ID(); ?>" <?php post_class( 'row responsive' ); ?>>
                <?php 
                $blog_layout_class=(get_theme_mod('blogsidebar',1) == 1)?"9":((get_theme_mod('blogsidebar',1) == 2)?"9":"12");
                if(get_theme_mod('blogsidebar',1) == 1):
                        get_sidebar();
                 endif;
                ?>
                <div class="col-md-<?php echo esc_attr($blog_layout_class); ?> col-sm-12 col-xs-12 content blog-layout-three">
                    <div class="blog-content-area">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 fadeIn animated">
                                <div class="blog-content">                                   
                                    <div class="blog-images">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if ( has_post_thumbnail() ) : 
                                             the_post_thumbnail( 'fitness_freak_ThumbnailImage', array( 'class' => 'img-responsive') );
                                             else: ?>
                                            <div class="no-post-thumbnail" ><i class="fa fa-image"></i> </div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="blog-inner-content">
                                        <div class="title-data fadeIn animated">
                                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            <?php if(get_theme_mod('blogMetaTag',1) == 1): ?>
                                                <?php wp_kses_post(fitness_freak_entry_meta()); ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if(get_theme_mod('blogPostExcerpt',1) == 1): ?> 
                                          <p><?php echo esc_html( fitness_freak_excerpt( absint( get_theme_mod('blogPostExcerptTextLimit',10 ) ) ) ); ?></p>
                                        <?php endif; ?>
                                        <?php if(get_theme_mod('blogPostReadMore',1) == 1): ?> 
                                        <a href="<?php the_permalink();?>" class="btn-light info"><?php esc_html_e('READ MORE','fitness-freak'); ?></a>
                                        <?php endif; ?>
                                    </div>                                
                                </div>
                            </div>
                        <?php endwhile;  ?> 
                        <?php the_posts_pagination( array(
                            'Previous' => __( 'Back', 'fitness-freak' ),
                            'Next' => __( 'Onward', 'fitness-freak' ),
                        ) ); ?>
                    </div>
                </div>

                <?php 
                if(get_theme_mod('blogsidebar',1) == 2):
                        get_sidebar();
                 endif;
                ?> 
            </div>
        </div>
    </div>
</div>