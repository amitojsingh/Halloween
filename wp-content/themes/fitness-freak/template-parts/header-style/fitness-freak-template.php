    <?php 
    $menu_style=0;$header_menu=1;   $header_style = get_theme_mod('menustyle',0);
    if($header_menu != 0 || is_front_page()) : ?>
    <header>
        <div class="header-top <?php if($header_style == 1){ echo 'no-transparent'; } else { echo 'transparent';} ?>" >
            <div class="container">
                <div class="row">
                    <nav class>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="logo">
                                    <?php                     
                                    if(has_custom_logo()){
                                        the_custom_logo();            
                                    } 
                                    $fitness_freak_dark_logo_id=get_theme_mod('FitnessFreakDarkLogo');
                                    $fitness_freak_dark_logo=wp_get_attachment_url($fitness_freak_dark_logo_id);
                                    if($fitness_freak_dark_logo == ''){
                                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                                        $fitness_freak_dark_logo = wp_get_attachment_url( $custom_logo_id );
                                    }
                                    if($fitness_freak_dark_logo != ''){ ?> 
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
                                            <img class="img-responsive logo-dark" src="<?php echo esc_url($fitness_freak_dark_logo); ?>" alt="<?php esc_attr_e('Logo','fitness-freak'); ?>">
                                        </a>
                                        <?php }
                                         if (display_header_text()==true):?>
                                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" id='brand' class="custom-logo-link"><span class="site-title"><h4><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h4><small class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></small></span></a>   
                                        <?php endif; ?> 
                                </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12 mob_nav">
                            <div class="main-menu">  
                                <div id='menu-style-header'>
                                 <?php                                    
                                      $fitness_freak_defaults = array(
                                            'theme_location' => 'primary',
                                            'container'      => false, 
                                            'menu_class'    => 'mobilemenu',
                                        );
                                        wp_nav_menu($fitness_freak_defaults);                                        
                                     ?>  
                                </div>                            
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php endif; ?>