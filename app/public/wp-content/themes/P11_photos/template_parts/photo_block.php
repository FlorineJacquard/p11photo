<div class="related-photo" 
     data-ref="<?php echo esc_attr(get_field('reference')); ?>" 
     data-category="<?php 
        $category = get_the_terms(get_the_ID(), 'categorie'); 
        echo esc_attr($category ? $category[0]->name : ''); 
     ?>">
    <a href="<?php the_permalink(); ?>" class="photo-link">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail([564, 495]); ?>
        <?php else : ?>
            <p>Pas de miniature disponible</p>
        <?php endif; ?>

        <div class="overlay-photo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye.png" alt="Voir les détails" class="icon-eye">
            <div class="photo-info">
                <h3 class="photo-title"><?php the_title(); ?></h3>
                <span class="photo-category">
                    <?php 
                    $category = get_the_terms(get_the_ID(), 'categorie'); 
                    echo $category ? $category[0]->name : ''; 
                    ?>
                </span>
            </div>
        </div>
    </a>

    <!-- Icône fullscreen reste dans l'overlay mais en dehors du lien -->
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fullScreen.png" alt="Voir en plein écran" class="icon-fullscreen">
</div>
