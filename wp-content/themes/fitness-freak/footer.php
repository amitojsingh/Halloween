<?php
/*
 * fitness-freak default footer file
 */
$footer_options =  1; 
$footer_widget_style = get_theme_mod('footerWidgetStyle',2);
$hide_footer_widget_bar = get_theme_mod('hideFooterWidgetBar',1);
 if($footer_options != 0) : ?>
    <footer>
        <?php if(($hide_footer_widget_bar == 1) || ($hide_footer_widget_bar == '')) : 
            $footer_widget_style = $footer_widget_style+1;
        $footer_col_value = floor(12/($footer_widget_style)); ?>
            <div class="footer-box">
                <div class="container">
                    <div class="row">
                        <?php $flag_widget=true; $k = 1; ?>
                        <?php for( $i=0; $i<$footer_widget_style; $i++) { ?>
                            <?php if (is_active_sidebar('footer-'.$k)) { ?>
                                <div class="col-md-<?php echo esc_attr($footer_col_value); ?> col-sm-<?php echo esc_attr($footer_col_value); ?> col-xs-12"><?php dynamic_sidebar('footer-'.$k); ?></div>
                            <?php $flag_widget=false;}
                            $k++;
                        }
                         if($flag_widget){

                            $fitness_freak_widget=array(
                            'before_widget' => '<aside id="fitness_freak_footer_default_widget" class="footer-widget widget custom_footer_widget"><div class="col-md-'.esc_attr($footer_col_value).' col-sm-'.esc_attr($footer_col_value).' col-xs-12">',

                            'after_widget' => '</div></aside>',

                            'before_title' => '<div class="widget-title">',

                            'after_title' => '</div>', );                            

                            the_widget('WP_Widget_Pages', null, $fitness_freak_widget);
                            
                            the_widget('WP_Widget_Categories', null, $fitness_freak_widget);
                            
                            the_widget('WP_Widget_Archives', null, $fitness_freak_widget);                           
                       
                        }
                         ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="footer-wrap style1">
            <div class="container">
                <div class="fitness-freak-section">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <div class="copyright fadeIn animated">
                                <?php if(get_theme_mod('CopyrightAreaText','') != '') :?>
                                <p><?php echo wp_kses_post(get_theme_mod('CopyrightAreaText')); ?></p>
                                <?php endif; ?>
                                <p><?php esc_html_e('Powered by ','fitness-freak');?><a href="<?php echo esc_url('https://hippothemes.com/wordpress-themes/fitness-freak/'); ?>" target="_blank"><?php esc_html_e('Fitness Freak WordPress Theme','fitness-freak'); ?></a>
                                </p>                                
                            </div>
                        </div>                        
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <div class="footer-social-icon fadeIn animated">
                                <ul>
                                    <?php for($i=1; $i<=6; $i++) : ?>
                                        <?php if(get_theme_mod('FitnessFreakSocialIcon'.$i) != '' && get_theme_mod('FitnessFreakSocialIconLink'.$i) != '' ): ?>
                                            <li>
                                                <a href="<?php echo esc_url(get_theme_mod('FitnessFreakSocialIconLink'.$i)); ?>" class="fb" target="_blank">
                                                 <i class="fa <?php echo esc_attr(get_theme_mod('FitnessFreakSocialIcon'.$i)); ?>"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>