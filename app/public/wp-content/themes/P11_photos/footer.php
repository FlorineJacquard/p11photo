<footer>
    <div class="footer-container">
        <!-- Menu du footer -->
        <nav role="navigation" aria-label="<?php _e('Menu footer', 'text-domain'); ?>" class="footer-menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer-menu',
                'container_class'=> 'footer-nav',
                'menu_class'     => 'footer-menu-items',
            ]);
            ?>
        </nav>
    </div>
    <?php get_template_part('template_parts/modal-contact'); ?>
    <?php get_template_part('template_parts/lightbox'); ?>

    <!-- Appel essentiel à wp_footer() -->
    <?php wp_footer(); ?>
</footer>

</body>
</html>
