<?php
/*
 * Search Template File
 */
get_header(); ?>
<style type="text/css">
.blog-heading-wrap {
    background-image: url('<?php header_image(); ?>');
}
</style>
<div class="heading-wrap blog-heading-wrap">
    <div class="heading-layer">
        <div class="heading-title">
            <h4><?php
                esc_html_e('Search results for', 'fitness-freak');
                echo " : " . get_search_query();
            ?></h4>
        </div>
    </div>
</div>
<?php if (have_posts()) : ?>
    <?php get_template_part('template-parts/content'); ?>
<?php else : ?>
    <div class="fitness-freak-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="blog-content-area fadeIn animated">
                        <div class="search-area">
                            <p class="spage">
                                <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords', 'fitness-freak'); ?>.</p>
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; get_footer(); ?>