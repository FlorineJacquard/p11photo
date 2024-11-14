<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Appel essentiel à wp_head() -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
    <div class="header-container">
        <!-- Logo -->
        <a href="<?php echo home_url( '/' ); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo">
        </a>  

        <!-- Menu pour le desktop -->
        <nav role="navigation" aria-label="<?php _e('Menu header', 'text-domain'); ?>" class="desktop-menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'header-menu',
                'container_class'=> 'header-nav',
                'menu_class'     => 'header-menu',
            ]);
            ?>
        </nav>
        <!-- Burger and Cross buttons -->
        <div class="menu-buttons">
            <img id="menuButton" class="burger-menu" src="<?php echo get_theme_file_uri('/assets/images/Burger.png'); ?>" alt="menu" onclick="toggleNav()">
            <img id="closeButton" class="Croixburger-menu hidden" src="<?php echo get_theme_file_uri('/assets/images/Burgercroix.png'); ?>" alt="close menu" onclick="toggleNav()">
        </div>
         <!-- Mobile menu -->
    <div id="myNav" class="overlay">
    <nav role="navigation" aria-label="<?php _e('Menu header', 'text-domain'); ?>" class="mobile-menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'header-menu',
                'container_class'=> 'header-nav',
                'menu_class'     => 'header-menu',
            ]);
            ?>
        </nav>
    </div>
</header>
