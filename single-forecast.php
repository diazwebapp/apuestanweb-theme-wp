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
                            
                            // Preprocesamiento de deporte y liga
                            $sport = $league = false;

                            if (!empty($tax_leagues)) {
                                foreach ($tax_leagues as $tax_league) {
                                    if ($tax_league->parent == 0) {
                                        $sport = $tax_league;
                                        $icon_class = carbon_get_term_meta($sport->term_id, 'fa_icon_class');
                                        $sport->icon_html = !empty($icon_class) ? '<i class="' . esc_attr($icon_class) . '" ></i>' : '<img loading="lazy" src="' . esc_url($icon_img) . '" alt="icon" />';
                                    }
                                }

                                // Redirección y enlace de deporte
                                if ($sport) {
                                    $sport_page = get_page_by_title($sport->name);
                                    $taxonomy_page = carbon_get_term_meta($sport->term_id, 'taxonomy_page');
                                    $sport->redirect = $taxonomy_page[0] ?? null;
                                    $sport->permalink = isset($sport->redirect) ? get_permalink($sport->redirect["id"]) : get_term_link($sport, 'league');
                                }
                            }

                            // Preprocesamiento de la liga
                            if ($sport) {
                                foreach ($tax_leagues as $leaguefor) {
                                    if ($leaguefor->parent == $sport->term_id) {
                                        $league = $leaguefor;
                                        $icon_class = carbon_get_term_meta($league->term_id, 'fa_icon_class');
                                        $league->icon_html = !empty($icon_class) ? '<i class="' . esc_attr($icon_class) . '" ></i>' : '<img loading="lazy" src="' . esc_url($icon_img) . '" alt="icon" />';
                                    }
                                }

                                // Redirección y enlace de liga
                                if ($league) {
                                    $league_page = get_page_by_title($league->name);
                                    $taxonomy_page = carbon_get_term_meta($league->term_id, 'taxonomy_page');
                                    $league->redirect = $taxonomy_page[0] ?? null;
                                    $league->permalink = isset($league->redirect) ? get_permalink($league->redirect["id"]) : get_term_link($league, 'league');
                                }
                            }

                            // Equipos de pronóstico
                            $teams = get_forecast_teams($post_id, ["w" => 50, "h" => 50]);
                ?>
                            <section class="col-lg-8 mt-5 con-t">
                                <article>
                                    <div class="single_envent_heading">
                                        <h1 class="title_lg"><?php the_title(); ?></h1>
                                    </div>
                                    <!-- breadcrumb -->
                                    <?php echo migas_de_pan(); ?>

                                    <!-- header forecast-->
                                    <div class="single_event_banner" style="background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%), url(<?php echo esc_url($background_header); ?>);">
                                        <div class="single_event_banner_top">
                                            <div class='single_banner_top_left'>
                                                <?php echo isset($sport->icon_html) ? $sport->icon_html : ''; ?>
                                                <p><?php echo esc_html($sport->name ?? ''); ?></p>
                                            </div>
                                            <div class='single_banner_top_left'>
                                                <?php echo isset($league->icon_html) ? $league->icon_html : ''; ?>
                                                <p><?php echo esc_html($league->name ?? ''); ?></p>
                                            </div>
                                        </div>
                                        <div class="single_event_banner_middle">
                                            <div class="single_team1">
                                                <img width="110" height="110" class="img-fluid" loading="lazy" src="<?php echo esc_url($teams["team1"]["logo"] ?? $icon_img); ?>" alt="<?php echo esc_attr($teams["team1"]["name"] ?? ''); ?>" title="<?php echo esc_attr($teams["team1"]["name"] ?? ''); ?>">
                                                <p ><?php echo esc_html($teams["team1"]["name"] ?? ''); ?></p>
                                            </div>
                                            <div class="event_start">
                                                <time datetime="<?php echo esc_attr($datetime->format("Y-m-d H:i:s")); ?>"><?php echo esc_html($datetime->format("h:i a")); ?></time>
                                                <?php echo esc_html(date_i18n("d M Y", strtotime($datetime->format("d M Y")))); ?>   
                                            </div>
                                            <div class="single_team1">
                                                <img width="110" height="110" class="img-fluid" loading="lazy" src="<?php echo esc_url($teams["team2"]["logo"] ?? $icon_img); ?>" alt="<?php echo esc_attr($teams["team2"]["name"] ?? ''); ?>" title="<?php echo esc_attr($teams["team2"]["name"] ?? ''); ?>">
                                                <p><?php echo esc_html($teams["team2"]["name"] ?? ''); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="single_event_content text-break">
                                        
                                        <?php remove_filter('the_content', 'wpautop'); ?>
                                        <?php if (!$disable_table): ?>
                                            <hr></hr>
                                            <!-- Toggle Table of Contents -->
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#table-of-contents" aria-expanded="false" aria-controls="table-of-contents" style="font-size: 1.8rem; margin-block-end: 1rem;">
                                                <?php echo __('Contenidos', 'jbetting'); ?>
                                                <i>❓</i>
                                            </button>

                                            <!-- Table of Contents -->
                                            <div class="collapse" id="table-of-contents">
                                                <div class="card mt-3">
                                                    <div class="card-header">
                                                        <?php echo __('Tabla de Contenido', 'jbetting'); ?>
                                                    </div>
                                                    <ul class="list-group list-group-flush"></ul>
                                                </div>
                                            </div>
                                            
                                        <?php endif; ?>
                                        <?php the_content(); ?>
                                        
                                        <?php echo do_shortcode("[social_contact]"); ?>
                                        <p class="text-muted"><?php echo __('Las cuotas mostradas son una aproximación, verifica antes de hacer tu apuesta'); ?></p>
                                    </div>

                                    <div class="stats-w"><?php echo do_shortcode("[user_stats]"); ?></div>

                                    <section>    
                                        <div class="title_wrap single_event_title_wrap">
                                            <h2 class="title-b mt-5 order-lg-1">Otros pronósticos de <?php echo esc_html($sport->name ?? ''); ?></h2>
                                            <a href="<?php echo esc_url($sport->permalink ?? '/'); ?>" class="mt-5 dropd order-lg-3">Ver Todo</a>
                                        </div>
                                        <?php echo do_shortcode("[related-forecasts model='2' num='6' league='{$sport->name}']"); ?>        
                                    </section>
                                </article>
                            </section>

                            <!-- Sidebar -->
                            <section class="col-lg-3">
                                <div class="row justify-content-end"><?php dynamic_sidebar("forecast-right"); ?></div>
                            </section>

                        <?php endwhile; endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
