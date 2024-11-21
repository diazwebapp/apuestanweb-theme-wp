<?php
get_header();

// Obtener todos los metadatos de la publicación en una sola llamada
$post_id = get_the_ID();
$post_meta = carbon_get_post_meta($post_id);

$faq_area = do_shortcode(wp_kses_post(wpautop($post_meta['faq'] ?? '')));
$textbefore = $post_meta['before_post'] ?? '';
$custom_h1 = esc_html($post_meta['custom_h1'] ?? '');
$disable_sidebar = $post_meta['sidebar'] ?? 'no';
$banner_top = $post_meta['banner_top'] ?? 'no';
$custom_banner_top = $post_meta['custom_banner_top'] ?? '';
$custom_banner_bottom = $post_meta['custom_banner_bottom'] ?? '';
$disable_title = $post_meta['disable_title'] ?? 'no';
$disable_table = $post_meta['disable_table'] ?? 'no';

// Imprimir texto antes del contenido si está presente
if ($textbefore) {
    echo do_shortcode(wp_kses_post($textbefore));
}
?>

<main>
    <?php 
    // Mostrar banner superior si está habilitado
    if ($banner_top !== 'yes') {
        echo $custom_banner_top 
            ? do_shortcode(wp_kses_post($custom_banner_top)) 
            : do_shortcode("[banner title='" . esc_attr($custom_h1 ?: get_the_title($post_id)) . "']");
    }
    ?>
    <div class="event_area pb-5">
        <div class="container">
            <?php if ($disable_sidebar !== 'yes') : ?>
                <div class="row">
            <?php endif; ?>
                
                <?php if ($disable_sidebar === 'no') echo '<section class="col-lg-9 mt-3">'; ?>
                    
                    <?php 
                    if (have_posts()) : 
                        the_post();

                        // Escapar y filtrar el contenido
                        $content = apply_filters('the_content', get_the_content());
                        $formatted_content = do_shortcode(wp_kses_post($content));

                        // Mostrar título personalizado o por defecto
                        if ($disable_title === 'no') {
                            echo "<h1 class='title mt-4 mb-4 order-lg-1'>" . esc_html($custom_h1 ?: get_the_title($post_id)) . "</h1>";
                        }

                        // Mostrar contenido principal
                        echo "<section class='page_content text-break'>$formatted_content</section>";
                    endif;

                    // Mostrar tabla de contenido si está habilitada
                    if ($disable_table === 'no') :
                        ?>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#table-of-contents" aria-expanded="false" aria-controls="table-of-contents" style="font-size: 1.8rem; margin-block-start: 1rem; margin-block-end: 1rem;">
                            Tabla de Contenido
                            <i class="fas fa-angle-down"></i>
                        </button>

                        <div class="collapse" id="table-of-contents">
                            <div class="card mt-3">
                                <div class="card-header">
                                    Tabla de Contenido
                                </div>
                                <ul class="list-group list-group-flush"></ul>
                            </div>
                        </div>
                    <?php
                    endif;

                    // Mostrar sección de FAQ si está presente
                    if ($faq_area) :
                        ?>
                        <section class="single_event_content mb-5 text-break">
                            <div class="row">
                                <div>
                                    <?php echo $faq_area; ?>
                                </div>
                            </div>
                        </section>
                        <?php
                    endif;
                    ?>

                <?php if ($disable_sidebar === 'no') echo '</section>'; ?>

                <?php if ($disable_sidebar !== 'yes') : ?>
                    <section class="col-lg-3">
                        <div class="row">
                            <?php dynamic_sidebar('forecast-right'); ?>
                        </div>
                    </section>
                <?php endif; ?>
            
            <?php if ($disable_sidebar !== 'yes') : ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php 
    // Mostrar banner inferior si está configurado
    if ($custom_banner_bottom) {
        echo do_shortcode(wp_kses_post($custom_banner_bottom));
    }
    ?>
</main>

<?php get_footer(); ?>
