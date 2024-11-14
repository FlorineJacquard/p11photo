<?php

get_header();

/* Start the Loop */
while (have_posts()) :
    the_post();
?>
    <div class="page-container">
        <div class="single-photo-page">
            <div class="content-wrapper">
                <!-- Bloc de gauche : Infos photo -->
                <div class="left-column">
                    <div class="photo-info">
                        <h2><?php the_title(); ?></h2>
                        <div class="photo-meta">
                            <p class="ref">Référence : <?php echo get_field('reference'); ?></p>
                            <p class="category">Catégorie : <?php $category = get_the_terms(get_the_ID(), 'categorie');
                                                            echo $category ? $category[0]->name : ''; ?></p>
                            <p class="format"> Format : <?php $format = get_the_terms(get_the_ID(), 'format');
                                                        echo $format ? $format[0]->name : ''; ?></p>
                            <p class="type">Type : <?php echo get_field('type'); ?></p>
                            <p class="date">Année : <?php echo get_the_date('Y'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Bloc de droite : Photo -->
                <div class="right-column">
                    <div class="photo-container">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('full');
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Bloc du bas : Interactions -->
            <div class="interactions">
                <div class="contact-link">
                    <p>Cette photo vous intéresse ?</p>
                    <button id="openContactModal" data-ref-photo="<?php echo get_field('reference'); ?>">Contact </button>
                </div>

                <div class="navigation">
                    <?php
                    // Lien pour la photo précédente
                    $prev_post = get_previous_post();
                    if ($prev_post) {
                        $prev_thumb = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); // URL de la miniature
                        previous_post_link('%link', '<img src="' . get_template_directory_uri() . '/assets/images/leftArrow.png" alt="Photo précédente" data-thumbnail="' . esc_url($prev_thumb) . '">');
                    }

                    // Lien pour la photo suivante
                    $next_post = get_next_post();
                    if ($next_post) {
                        $next_thumb = get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); // URL de la miniature
                        next_post_link('%link', '<img src="' . get_template_directory_uri() . '/assets/images/rightArrow.png" alt="Photo suivante" data-thumbnail="' . esc_url($next_thumb) . '">');
                    }
                    ?>
                </div>

            </div>
            <!-- photos apparentées -->
            <div class="related-container">
                <h3> Vous aimerez aussi</h3>
                <div class="related-photos">
                    <?php
                    // Récupérer les catégories de l'article actuel via la taxonomie 'categorie'
                    $categories = wp_get_post_terms(get_the_ID(), 'categorie');

                    if ($categories) {
                        $category_ids = array_map(function ($cat) {
                            return $cat->term_id;
                        }, $categories);

                        // Requête pour récupérer les photos apparentées dans la même catégorie
                        $related_query = new WP_Query([
                            'post_type' => 'photos',
                            'tax_query' => [
                                [
                                    'taxonomy' => 'categorie',
                                    'field' => 'term_id',
                                    'terms' => $category_ids, // Requêter les mêmes catégories
                                ],
                            ],
                            'post__not_in' => [get_the_ID()], // Exclure la photo actuelle
                            'posts_per_page' => 2, // Limiter l'affichage à 2 photos apparentées
                        ]);

                        if ($related_query->have_posts()) {
                            while ($related_query->have_posts()) {
                                $related_query->the_post();
                                // Inclure le template photo_block pour afficher chaque photo apparentée
                                get_template_part('template_parts/photo_block');
                            }
                            wp_reset_postdata(); // Remettre la requête principale après l'usage de WP_Query
                        } else {
                            echo '<p>Aucune photo apparentée trouvée.</p>';
                        }
                    } else {
                        echo '<p>Pas de catégories trouvées pour cette photo.</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
<?php
endwhile; // End of the loop.

get_footer();
?>
