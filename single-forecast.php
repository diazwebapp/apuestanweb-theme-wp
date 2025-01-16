<?php get_header(); ?>

<main>
    <div class="event_area single_event_area">
        <div class="container">
            <div class="row">
                <?php 
                    if (have_posts()) : 
                        while (have_posts()) : the_post();
                            global $wpdb;
                            $post_id = get_the_ID();

                            // Validación de la geolocalización
                            $geolocation = isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : null;

                            // Obtención de metadatos
                            $date = carbon_get_post_meta($post_id, 'data');
                            $datetime = new DateTime($date);
                            $datetime->setTimezone(new DateTimeZone($geolocation->timezone ?? 'UTC'));

                            // Meta información
                            $link = carbon_get_post_meta($post_id, 'link');
                            $disable_table = carbon_get_post_meta($post_id, 'disable_table');
                            
                            // Fondo de la cabecera
                            $background_header = get_template_directory_uri() . '/assets/img/s49.png';
                            $img_att = carbon_get_post_meta($post_id, 'wbg');
                            if (!empty($img_att)) {
                                $background_header = aq_resize(wp_get_attachment_url($img_att), 1080, 600, true, true, true);
                            }

                            // Taxonomías
                            $tax_leagues = wp_get_post_terms($post_id, 'league');
                            $icon_img = get_template_directory_uri() . '/assets/img/logo2.svg';
                            
                            // Obtener los términos de la taxonomía personalizada 'leagues'
                            $terms = get_the_terms(get_the_ID(), 'league');
                            $parent_taxonomy = [];
                            
                            if ($terms && !is_wp_error($terms)) {
                                // Filtrar solo los términos principales (parent = 0)
                                $parent_terms = array_filter($terms, function ($term) {
                                   
                                    return  $term->parent === 0;
                                     
                                });
                                
                                
                                //Obtener los atos de los términos principales
                                $parent_taxonomy['name'] = implode(', ', wp_list_pluck($parent_terms, 'name'));
                                $parent_taxonomy['term_id'] = intval(implode(', ', wp_list_pluck($parent_terms, 'term_id')));
                                $parent_taxonomy['slug'] = implode(', ', wp_list_pluck($parent_terms, 'slug'));
                                $taxonomy_page = carbon_get_term_meta($parent_taxonomy['term_id'],'taxonomy_page');
                                $parent_taxonomy["redirect"] = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;
                                $parent_taxonomy['permalink'] = isset($parent_taxonomy["redirect"]) ? get_permalink($parent_taxonomy["redirect"]["id"]) : get_term_link($parent_taxonomy['term_id'], 'league');
                                
                            } else {
                                $parent_taxonomy = 'No main league assigned'; // Texto predeterminado si no hay términos principales
                            }     
                            
                            // Equipos de pronóstico
                            $teams = get_forecast_teams($post_id, ["w" => 50, "h" => 50]);
                ?>
                            <section class="col-lg-8 mt-5 con-t">
                                <article>
                                    <div class="single_envent_heading">
                                        <h1 class="title"><?php the_title(); ?></h1>
                                    </div>
                                    <!-- breadcrumb -->
                                    <?php echo migas_de_pan(); ?>

                                    <!-- header forecast-->
                                    
                                    
                                    <div class="single-forecast-banner row py-3 px-2 px-md-4 mx-md-0" style="background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%), url(<?php echo esc_url($background_header); ?>);">
                                        <div class="col-12">
                                            <div class=''>
                                                <?php echo isset($sport->icon_html) ? $sport->icon_html : '<img width="20" height="20" src="'.$icon_img.'" alt="">'; ?>
                                                <p class="text-light d-inline"><?php echo esc_html($parent_taxonomy['name'] ?? ''); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4 p-0 my-4 d-flex flex-column text-center single-forecast-teams">
                                            <img width="60" height="60" class="mx-auto" loading="lazy" src="<?php echo esc_url($teams["team1"]["logo"] ?? $icon_img); ?>" alt="<?php echo esc_attr($teams["team1"]["name"] ?? ''); ?>" title="<?php echo esc_attr($teams["team1"]["name"] ?? ''); ?>">
                                            <p class="text-light"><?php echo esc_html($teams["team1"]["name"] ?? ''); ?></p>
                                        </div>
                                        <div class="col-4 p-0 my-4 d-flex flex-column text-center text-light single-forecast-date">
                                            <?php echo esc_html(date_i18n("d M Y", strtotime($datetime->format("d M Y")))); ?>   
                                            <time class="font-weight-bold text-light" datetime="<?php echo esc_attr($datetime->format("Y-m-d H:i:s")); ?>"><?php echo esc_html($datetime->format("h:i a")); ?></time>
                                        </div>
                                        <div class="col-4 p-0 my-4 d-flex flex-column text-center single-forecast-teams">
                                            <img width="60" height="60" class="mx-auto" loading="lazy" src="<?php echo esc_url($teams["team2"]["logo"] ?? $icon_img); ?>" alt="<?php echo esc_attr($teams["team2"]["name"] ?? ''); ?>" title="<?php echo esc_attr($teams["team2"]["name"] ?? ''); ?>">
                                            <p class="text-light"><?php echo esc_html($teams["team2"]["name"] ?? ''); ?></p>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="single_event_content text-break">
                                        
                                        <?php remove_filter('the_content', 'wpautop'); ?>
                                        <?php if (!$disable_table): ?>
                                            <hr></hr>
                                            <!-- Toggle Table of Contents -->
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#table-of-contents" aria-expanded="false" aria-controls="table-of-contents" >
                                                <?php echo __('Contenidos', 'jbetting'); ?>
                                            </button>

                                            <!-- Table of Contents -->
                                            <div class="collapse" id="table-of-contents">
                                                <div class="card mt-3">
                                                    <div class="card-header">
                                                        <b><?php echo __('Tabla de Contenido', 'jbetting'); ?></b> 
                                                    </div>
                                                    <ul class="list-group list-group-flush"></ul>
                                                </div>
                                            </div>
                                            <hr></hr>  
                                        <?php endif; ?>
                                        <?php the_content(); ?>
                                        
                                        <?php echo do_shortcode("[social_contact]"); ?>
                                        <p class="text-muted"><?php echo __('Las cuotas mostradas son una aproximación, verifica antes de hacer tu apuesta'); ?></p>
                                    </div>

                                    <?php echo do_shortcode("[user_stats]"); ?>

                                    <section>    
                                        <div class="title_wrap single_event_title_wrap">
                                            <h2 class="title-b mt-5 order-lg-1">Otros pronósticos de <?php echo esc_html($parent_taxonomy['name']); ?></h2>
                                            <a href="<?php echo esc_url($parent_taxonomy['permalink']); ?>" class="mt-5 dropd order-lg-3">Ver Todo</a>
                                        </div>
                                        <?php echo do_shortcode("[related-forecasts num='6' model='2']"); ?>        
                                    </section>
                                </article>
                            </section>

                            <!-- Sidebar -->
                            <section class="col-lg-4 col-xl-3">
                                <div class="row justify-content-end"><?php dynamic_sidebar("forecast-right"); ?></div>
                            </section>

                        <?php endwhile; endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
