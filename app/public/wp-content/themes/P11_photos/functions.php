<?php
// le style
function enqueue_my_theme_styles()
{
    wp_enqueue_style('my-theme-style', get_template_directory_uri() . '/css/styles.css', array(), null);
}
add_action('wp_enqueue_scripts', 'enqueue_my_theme_styles');

// Charger jQuery et JS
function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery'); // Assurez-vous que jQuery est inclus
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// Enregistrement des menus
function register_my_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Menu header', 'text-domain'),
        'footer-menu' => __('Menu footer', 'text-domain')
    ));
}
add_action('after_setup_theme', 'register_my_menus');

// image dans le formualire
function add_image_to_contact_form($form)
{
    $image = '<img src="' . get_template_directory_uri() . '/assets/images/Contact.png" alt="Logo" class="img-contact">';
    $form = $image . $form; // Ajoute l'image au début du formulaire
    return $form;
}
add_filter('wpcf7_form_elements', 'add_image_to_contact_form');


// Forcer WordPress à utiliser le template single-photos
function use_custom_template_for_photos($single_template)
{
    global $post;

    if ($post->post_type == 'photos') {
        $single_template = get_template_directory() . '/single-photo.php';
    }
    return $single_template;
}
add_filter('single_template', 'use_custom_template_for_photos');

// pagination infinie avec requete ajax
function load_more_photos()
{
    // Vérifier que l'offset est bien défini
    if (!isset($_POST['offset'])) {
        wp_send_json_error('Offset non défini');
        return;
    }

    $offset = intval($_POST['offset']);

    // Arguments de la requête
    $args = array(
        'post_type'      => 'photos',
        'posts_per_page' => 8,  // Charger par lots de 8
        'offset'         => $offset,  // Commencer après les photos déjà affichées
    );

    // Nouvelle requête pour charger plus de photos
    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) {
        ob_start(); // Commencer la mise en tampon de sortie
        while ($photo_query->have_posts()) : $photo_query->the_post();
            get_template_part('template_parts/photo_block'); // Charger le template pour chaque photo
        endwhile;
        wp_reset_postdata();

        // Renvoyer les photos sous forme de chaîne HTML
        $photos_html = ob_get_clean();
        wp_send_json_success($photos_html);
    } else {
        wp_send_json_error('Pas de photos supplémentaires à charger');
    }
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');



function enqueue_theme_scripts()
{
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);

    // Passer les paramètres AJAX au script
    wp_localize_script('theme-scripts', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

// filtres 
function filter_photos() {
    $category = isset($_POST['category']) ? intval($_POST['category']) : '';
    $format = isset($_POST['format']) ? intval($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';

    $args = array(
        'post_type'      => 'photos',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
        'tax_query'      => array(
            'relation' => 'AND',
        ),
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie', 
            'field'    => 'term_id',
            'terms'    => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format', 
            'field'    => 'term_id',
            'terms'    => $format,
        );
    }

    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) {
        ob_start(); // Démarre la capture de la sortie
        while ($photo_query->have_posts()) : $photo_query->the_post();
            get_template_part('template_parts/photo_block');
        endwhile;
        wp_reset_postdata();
        $photos_html = ob_get_clean();
        wp_send_json_success($photos_html); // Envoie la sortie capturée au format JSON
    } else {
        wp_send_json_error('Aucune photo trouvée');
    }

    wp_die(); // Arrête l'exécution du script après avoir envoyé la réponse
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

