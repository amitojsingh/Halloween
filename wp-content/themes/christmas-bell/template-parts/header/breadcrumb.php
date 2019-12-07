<?php
/**
 * Display Breadcrumb
 *
 * @package Christmas_Bell
 */
?>

<?php
$enable_breadcrumb = get_theme_mod( 'christmasbell_breadcrumb_option', 1 );

if ( $enable_breadcrumb ) :
    if ( function_exists( 'woocommerce_breadcrumb' ) && ( is_woocommerce() || is_shop() ) ) : ?>
        <div class="breadcrumb-area">
            <div class="wrapper">
                <?php
                    $args = array(
                        'delimiter' => '',
                        'before'    => '<span>',
                        'after'     => '</span>'

                    );

                    woocommerce_breadcrumb( $args );
                ?>
            </div><!-- .wrapper -->
        </div><!-- .breadcrumb-area -->
    <?php else:
        christmasbell_breadcrumb();
    endif;
endif;
