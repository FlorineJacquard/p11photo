<?php get_header(); ?>
<main>
    <?php
    // Requête pour récupérer une image aléatoire
    $random_photo_query = new WP_Query(array(
        'post_type' => 'photos',
        'posts_per_page' => 1,
        'orderby' => 'rand', // Trier aléatoirement
    ));

    // Si la requête renvoie des résultats
    if ($random_photo_query->have_posts()) :
        while ($random_photo_query->have_posts()) : $random_photo_query->the_post();
            // Récupérer l'URL de l'image 
            if (has_post_thumbnail()) {
                $background_image_url = get_the_post_thumbnail_url();
            }
        endwhile;
        wp_reset_postdata(); // Remet la requête principale après l'usage de WP_Query
    endif;
    ?>

    <div class="hero" style="background-image: url('<?php echo esc_url($background_image_url); ?>');">
        <div class="hero-content">
            <h1>PHOTOGRAPHE EVENT</h1>
        </div>
    </div>
    <div class="page-container">
    <div class="filters">
    <div class="filter-first-container">
        <!-- Filtre Catégories -->
        <div class="dropdown">
            <button class="dropbtn" id="category-button">
                CATEGORIE
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/upArrow.png'); ?>" class="icon-default" style="display: inline;">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/downArrow.png'); ?>" class="icon-down" style="display: none;">
            </button>
            <div class="dropdown-content" id="category-options">
                <div class="option reset-option" data-value=""></div> <!-- Option de réinitialisation -->
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'categorie',
                    'hide_empty' => false
                ));
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        echo '<div class="option" data-value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</div>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Filtre Formats -->
        <div class="dropdown">
            <button class="dropbtn" id="format-button">FORMATS
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/upArrow.png'); ?>" class="icon-default" style="display: inline;">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/downArrow.png'); ?>" class="icon-down" style="display: none;">
            </button>
            <div class="dropdown-content" id="format-options">
                <div class="option reset-option" data-value=""></div> <!-- Option de réinitialisation -->
                <?php
                $formats = get_terms(array(
                    'taxonomy' => 'format',
                    'hide_empty' => false
                ));
                if (!empty($formats)) {
                    foreach ($formats as $format) {
                        echo '<div class="option" data-value="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Filtre pour le tri par date -->
    <div class="dropdown">
        <button class="dropbtn" id="sort-button">TRIER PAR
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/upArrow.png'); ?>" class="icon-default" style="display: inline;">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/downArrow.png'); ?>" class="icon-down" style="display: none;">
        </button>
        <div class="dropdown-content" id="sort-options">
            <div class="option reset-option" data-value=""></div> <!-- Option de réinitialisation -->
            <div class="option" data-value="DESC">PLUS RECENTES</div>
            <div class="option" data-value="ASC">PLUS ANCIENNES</div>
        </div>
    </div>
</div>



        <div class="photo-list-container">
            <?php
            // Arguments de la requête pour récupérer les posts de type 'photos'
            $args = array(
                'post_type'      => 'photos',
                'posts_per_page' => 8,
            );

            // Créer une nouvelle requête WP_Query avec les arguments
            $photo_query = new WP_Query($args);

            // Vérifier s'il y a des photos à afficher
            if ($photo_query->have_posts()) :
                while ($photo_query->have_posts()) : $photo_query->the_post();
                    // Inclure le bloc d'affichage de chaque photo
                    get_template_part('template_parts/photo_block');
                endwhile;

                // Remettre les données de post en place après la requête custom
                wp_reset_postdata();
            else :
                echo '<p>Aucune photo trouvée.</p>';
            endif;
            ?>
            <!-- Ajout du bouton "Charger plus" -->
        </div>
        <div class="load-more-container">
            <button id="load-more" class="load-more-btn style-btn">Charger plus</button>
        </div>
    </div>
</main>
<?php get_footer(); ?>