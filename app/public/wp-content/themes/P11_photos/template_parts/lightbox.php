<div id="lightbox" class="lightbox-overlay" style="display: none;">
    <div class="lightbox-content">
        <span class="lightbox-close">&times;</span> <!-- Croix de fermeture -->
        <div class="lightbox-photo-container">
            <div class="lightbox-prev">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/prevArrow.png" alt="flèche précédente" class="prevArrow">
            </div>
            <div class="lightbox-center">
                <img id="lightbox-photo" src="" alt="Photo en plein écran">
                <div class="lightbox-info">
                <div class="lightbox-photo-ref">
                    Référence : <?php echo get_field('reference'); ?>
                </div>
                <div class="lightbox-photo-category">
                    Catégorie : 
                    <?php
                    $category = get_the_terms(get_the_ID(), 'categorie');
                    echo $category ? $category[0]->name : '';
                    ?>
                </div>
            </div>
            </div>
            <div class="lightbox-next">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nextArrow.png" alt="flèche suivante" class="nextArrow">
            </div>
        </div>
    </div>
</div>

