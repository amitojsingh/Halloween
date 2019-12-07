<?php
/**
 * The main template file
 **/

get_header();

$page_for_posts = get_option( 'page_for_posts' );
$pagetitle = get_post_meta($page_for_posts, 'pagetitle', true);
$header_visiblity_style = get_post_meta($page_for_posts, 'header_visiblity_style', true);
$page_title = get_theme_mod('pagetitle',1); 

if($page_title): ?>
<div class="heading-wrap blog-heading-wrap" >
    <div class="heading-layer">
        <div class="heading-title">
            <h4><?php esc_html_e('Blog ','fitness-freak'); ?></h4>
        </div>
    </div>
</div> 
<?php endif; ?>
<?php get_template_part('template-parts/content');
get_footer(); ?>