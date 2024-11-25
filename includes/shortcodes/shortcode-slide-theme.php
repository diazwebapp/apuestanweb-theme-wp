<?php
// Registrar el shortcode
function custom_slider_shortcode($atts) {
    // Atributos predeterminados
    $atts = shortcode_atts([
        'post_type' => '', // Detectar automáticamente si no se especifica
        'posts_per_page' => 4, // Cantidad de posts a consultar
    ], $atts, 'custom_slider');

    // Detectar el tipo de post automáticamente si no se especifica
    if (empty($atts['post_type'])) {
        if (is_page()) {
            $atts['post_type'] = 'page';
        } elseif (is_single()) {
            $atts['post_type'] = 'post';
        } else {
            $atts['post_type'] = 'post';
        }
    }

    // Configurar la consulta
    $args = [
        'post_type' => $atts['post_type'],
        'posts_per_page' => intval($atts['posts_per_page']),
        'post_status' => 'publish',
    ];
    $query = new WP_Query($args);

    // Generar el HTML del slider
    ob_start();
    $slide_bg = get_template_directory_uri() . '/assets/img/banner2.png';
    if ($query->have_posts()) {

        ?>
        <div class="slider-container translate-animation" style="background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%),url( <?php echo $slide_bg ?>); background-repeat:no-repeat;background-size:cover;">

            <div class="slider">
    <?php
        $is_first = true; // Para añadir la clase "active" solo en la primera diapositiva
        while ($query->have_posts()): $query->the_post();
        if( $atts['post_type'] = 'forecast'){
            
            $event_bg_att = carbon_get_post_meta(get_the_ID(), 'wbg');
            $stadium = carbon_get_post_meta(get_the_ID(), 'stadium');
            $event_bg = wp_get_attachment_url($event_bg_att);
            if($event_bg):
                $slide_bg = $event_bg;
            endif;
            //Equipos
            $teams = get_forecast_teams(get_the_ID());
        
            $p1 = carbon_get_post_meta(get_the_ID(), 'p1');
            $x = carbon_get_post_meta(get_the_ID(), 'x');
            $p2 = carbon_get_post_meta(get_the_ID(), 'p2');
        
            $oddsp1 = new Converter($p1, 'eu');
            $oddsx = new Converter($x, 'eu');
            $oddsp2 = new Converter($p2, 'eu');
        
            $p1 = $oddsp1->doConverting();
            $x = $oddsx->doConverting();
            $p2 = $oddsp2->doConverting();
            $p1 = $p1[get_option('odds_type')]; $x = $x[get_option('odds_type')]; $p2 = $p2[get_option('odds_type')];
            if (!$p1) {
                $p1 = 'n/a';
            }
        
            if (!$x) {
                $x = 'n/a';
            }
        
            if (!$p2) {
                $p2 = 'n/a';
            }
        }
            ?>
            <!-- Slide 1 -->
            <div class="slide <?php if($is_first) echo "active";  ?>">
              <div class="row align-items-center">
                <!-- Logos -->
                <div class="col-md-4 text-center">
                  <div class="logos d-flex justify-content-center align-items-center">
                    <div class="team-logo bg-white rounded-circle p-3 mx-2">
                        <img width="50" height="50" src="<?php echo $teams['team1']['logo'] ?>"  alt="<?php echo $teams['team1']['name'] ?>">
                    </div>
                    <div class="team-logo bg-white rounded-circle p-3 mx-2">
                        <img width="50" height="50" src="<?php echo $teams['team2']['logo'] ?>" alt="<?php echo $teams['team2']['name'] ?>">
                    </div>
                  </div>
                </div>
                <!-- Títulos -->
                <div class="col-md-4 text-center">
                  <p class="small text-uppercase font-weight-bold mb-1">Enfrentamiento</p>
                  <h3 class="match-title font-weight-bold"><?php the_title()  ?></h3>
                  <p class="match-time">22 Abr 1:20 PM</p>
                  <button class="btn btn-outline-light btn-sm mt-2">Ver pronóstico</button>
                </div>
                <!-- Odds -->
                <div class="col-md-4 text-center">
                  <div class="odds d-flex justify-content-center">
                    <span class="badge badge-light p-2 mx-1">2.9</span>
                    <span class="badge badge-secondary p-2 mx-1">n/a</span>
                    <span class="badge badge-light p-2 mx-1">1.41</span>
                  </div>
                </div>
              </div>
            </div>
            
            <?php
            $is_first = false; // Después del primer post, remover la clase "active"
        endwhile;
        ?>
    </div>
    <button class="prev-btn">&lt;</button>
    <button class="next-btn">&gt;</button>
  </div>
  <!-- Controles de desplazamiento -->
  <div class="slider-controls d-flex justify-content-center mt-3"></div>
</div>

        <?php
    } else {
        echo '<p>No se encontraron publicaciones.</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('custom_slider', 'custom_slider_shortcode');


// Registrar y cargar CSS y JS solo donde se usa el shortcode
function custom_slider_enqueue_scripts() {
    if (!has_shortcode(get_post()->post_content, 'custom_slider')) {
        return; // Salir si el shortcode no está en la página actual
    }

    // Registrar scripts y estilos
    wp_register_style('custom-slider-style', get_template_directory_uri() . '/assets/css/custom-slider.css', [], '1.0');
    wp_register_script('custom-slider-script', get_template_directory_uri() . '/assets/js/custom-slider.js', [], '1.0', true);

    // Encolar scripts y estilos
    wp_enqueue_style('custom-slider-style');
    wp_enqueue_script('custom-slider-script');
}
add_action('wp_enqueue_scripts', 'custom_slider_enqueue_scripts');
