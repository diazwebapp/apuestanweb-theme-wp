<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options()
{

    
        $countries = get_countries_for_carbonmeta();
        Container::make('theme_options', "Apuestan")
            ->set_icon('dashicons-admin-site-alt2')
            ->add_tab(__("General settings", "jbetting"), array(
                Field::make( 'checkbox', 'devmode', __( 'Dev mode','jbetting' ) )
                    ->set_default_value( true ),
                Field::make('checkbox', 'bk_show', __("Activar vista en todos los shortcodes de pronosticos", "jbetting"))
                        ->set_option_value('yes')
                        ->set_default_value(true),
                Field::make('image', 'logo', __("Site logo(183*19)", "jbetting")),
                //selecion de pagina vip por defecto
                Field::make('association', 'page_vip', __("Select vip page", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'page',
                        )
                    ))->set_min(1)->set_max(1),
                //selecion de pagina login por defecto
                Field::make('association', 'login_page', __("Select login page", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'page',
                        )
                    ))->set_min(1)->set_max(1),
                //selecion de pagina register por defecto
                Field::make('association', 'register_page', __("Select register page", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'page',
                        )
                    ))->set_min(1)->set_max(1),
                //selecion de pagina profile por defecto
                Field::make('association', 'profile_page', __("Select profile page", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'page',
                        )
                    ))->set_min(1)->set_max(1),
                Field::make('select', 'geolocation_api', __("geolocation api", "jbetting"))
                    ->add_options([
                        "abstractapi" => "abstractapi",
                        "ipwhois" => "ipwhois",
                    ]),
                    Field::make('text', 'geolocation_api_key', __("geolocation api key", "jbetting")),
                    Field::make('text', 'copy', __("Copyright", "jbetting")),
                    
        ))

            
            ->add_tab(__("country regulations","jbetting"),array(
                Field::make('complex', 'country_reg', __("country regulations", "jbetting"))
                ->set_layout("tabbed-horizontal")
                ->setup_labels(["plural_name"=>"tests","singular_name"=>"test"])
                    ->add_fields(array(
                        Field::make('textarea', 'text_reg', __("Footer Regulation", "jbetting")),
                        Field::make('textarea', 'text_reg2', __("PopUp text", "jbetting")),
                        Field::make('select', 'country_code', __("country", "jbetting"))
                            ->add_options($countries),
                        Field::make('complex', 'images', __("images", "jbetting"))
                        ->add_fields(array(
                            Field::make('image', 'image', __("image", "jbetting"))
                                ->set_type(array("image")),
                            Field::make('text', 'url', __("url", "jbetting"))
                        ))
                    ))
            
            ))
            ->add_tab(__("Redes Sociales","jbetting"), array(
                
                Field::make('text', 'tl', __("Telegram", "jbetting")),
                Field::make('text', 'fb', __("Facebok", "jbetting")),
                Field::make('text', 'tw', __("Twitter", "jbetting")),
                Field::make('text', 'ig', __("Instagram", "jbetting"))
  
            
            ))
            ->add_tab(__("notificaciones","jbetting"), array(
                
                Field::make( 'checkbox', 'notificaciones', __( 'Notificaciones','jbetting' ) )
                ->set_option_value( 'yes' ),
            
            ))
            ->add_tab(__("Header/footer","jbetting"), array(
                Field::make( 'header_scripts', 'crb_header_script' ),
                Field::make( 'footer_scripts', 'crb_footer_script' ),
            ) );

        Container::make('comment_meta', __("Review fields", "jbetting"))
            ->add_fields(array(
                Field::make('text', 'rating', __("User rating", "jbetting")),
                Field::make('textarea', 'plus', __("Positive", "jbetting")),
                Field::make('textarea', 'minus', __("Negative", "jbetting")),
            ));


        Container::make('term_meta', __("Category fields", "jbetting"))
            ->where('term_taxonomy', '=', 'category')
            ->add_fields(array(
                Field::make('text', 'h1', __("Custom H1", "jbetting")),
                Field::make('text', 'fa_icon_class', __("FA icon class", "jbetting"))
            ));


        Container::make('post_meta', __("Page settings", "jbetting"))
            ->where('post_type', '=', 'page')
            ->add_tab(__(__("icon and background", "jbetting")), array(
                Field::make('image', 'wbg', __("Top background banner", "jbetting")),
                Field::make('text', 'fa_icon_class', __("FA icon class", "jbetting"))
                    
            ))
            ->add_tab(__(__("custom texts", "jbetting")), array(                
                Field::make('text', 'custom_h1', __("Custom h1", "jbetting")),
                Field::make('checkbox', 'disable_title', __("disable_title", "jbetting")),
                Field::make('checkbox', 'disable_table', __("Activar tabla de contenidos", "jbetting")),
                Field::make('text', 'before_post', __("Replace sub-header? (shortcode only)", "jbetting")),
                Field::make('rich_text', 'faq', __("faq area", "jbetting")),
            ))
            ->add_tab(__(__("custom layout", "jbetting")), array(
                Field::make('text', 'sidebar', __("Disable sidebar? (yes, default no)", "jbetting")),
                Field::make('text', 'banner_top', __("Disable top banner? (yes, default no)", "jbetting")),
                Field::make('text', 'custom_banner_top', __("Replace top banner? (shortcode only)", "jbetting")),
                Field::make('text', 'custom_banner_bottom', __("Banner al final del post", "jbetting"))
            ));
        
        Container::make('post_meta', __("Bookmaker", "jbetting"))
            ->where('post_type', '=', 'bk')
            ->add_tab(__("General", "jbetting"), array(
                    Field::make('checkbox', 'disable_table', __("Desactivar tabla de contenidos", "jbetting")),
                    Field::make('select', 'rating', __("Rating(1,2,3,4,5)", "jbetting"))
                        ->add_options(array(
                            '1' => '1.0',
                            '1.1' => '1.1',
                            '1.2' => '1.2',
                            '1.3' => '1.3',
                            '1.4' => '1.4',
                            '1.5' => '1.5',
                            '1.6' => '1.6',
                            '1.7' => '1.7',
                            '1.8' => '1.8',
                            '1.9' => '1.9',
                            '2' => '2.0',
                            '2.1' => '2.1',
                            '2.2' => '2.2',
                            '2.3' => '2.3',
                            '2.4' => '2.4',
                            '2.5' => '2.5',
                            '2.6' => '2.6',
                            '2.7' => '2.7',
                            '2.8' => '2.8',
                            '2.9' => '2.9',
                            '3' => '3.0',
                            '3.1' => '3.1',
                            '3.2' => '3.2',
                            '3.3' => '3.3',
                            '3.4' => '3.4',
                            '3.5' => '3.5',
                            '3.6' => '3.6',
                            '3.7' => '3.7',
                            '3.8' => '3.8',
                            '3.9' => '3.9',
                            '4' => '4.0',
                            '4.1' => '4.1',
                            '4.2' => '4.2',
                            '4.3' => '4.3',
                            '4.4' => '4.4',
                            '4.5' => '4.5',
                            '4.6' => '4.6',
                            '4.7' => '4.7',
                            '4.8' => '4.8',
                            '4.9' => '4.9',
                            '5' => '5.0',
                        )),
                    
                    Field::make('image', 'logo', __("logo cuadrado", "jbetting")),
                    Field::make('image', 'logo_2x1', __("logo horizontal", "jbetting")),
                    Field::make("color", "background-color", "Background Color")
                )
                
            )
            ->add_tab(__("feactures", "jbetting"), array( 
                Field::make('complex', 'feactures', __("feactures", "jbetting"))
                    ->set_layout("tabbed-horizontal")
                    ->add_fields(array(
                        Field::make('text', 'feacture', __("feacture text", "jbetting")),
                    )),
                Field::make('complex', 'general_feactures', __("general feactures", "jbetting"))
                    ->set_layout("tabbed-horizontal")
                    ->add_fields(array(
                        Field::make('text', 'feacture', __("feacture text", "jbetting")),
                        Field::make('text', 'points', __("points", "jbetting")),
                    )),
                )
                
            )

            ->add_tab(__("payment methods", "jbetting"), array( 
                    Field::make('complex', 'payment_methods', __("payment methods", "jbetting"))
                    ->set_layout("tabbed-horizontal")
                    ->add_fields(array(
                        Field::make('association', 'payment_method', __("Payment_method", "jbetting"))
                            ->set_types(array(
                                array(
                                    'type' => 'term',
                                    'taxonomy' => 'bookmaker-payment-methods',
                                )
                            ))->set_min(1)->set_max(1),
                        Field::make('complex', 'caracteristicas', __("caracteristicas", "jbetting"))
                            ->set_layout("tabbed-vertical")
                            ->add_fields(array(
                                Field::make('text', 'title', __("Title", "jbetting")),
                                Field::make('text', 'content', __("value", "jbetting")),
                            ))
                    )),
                )
                
            )

        ->add_tab(__("country bonus", "jbetting"), array(
            Field::make('complex', 'country_bonus', __("country bonus", "jbetting"))
                ->add_fields(array(
                    Field::make('text', 'country_bonus_slogan', __("Slogan", "jbetting")),
                    Field::make('text', 'country_bonus_amount', __("amount $", "jbetting")),
                    Field::make('text', 'country_bonus_ref_link', __("ref_link", "jbetting")),
                    Field::make('select', 'country_code', __("country", "jbetting"))
                            ->add_options($countries),
                ))
         ));


        Container::make('post_meta', __("Team", "jbetting"))
            ->where('post_type', '=', 'team')
            ->add_tab(__("1. General", "jbetting"), array(
                Field::make('image', 'team_logo', __("Team logo( min 300x300px.png)", "jbetting")),
                Field::make('text', 'acronimo', __("acronimo", "jbetting")),
                Field::make('text', 'id_api', __("ID", "jbetting"))

            ));



        Container::make('post_meta', __("Informacion del evento", "jbetting"))
            ->where('post_type', '=', 'forecast')
            ->add_tab(__("1. General", "jbetting"), array(
                Field::make('checkbox', 'vip', __("Premium event", "jbetting")),
                Field::make('checkbox', 'disable_table', __("Desactivar tabla de contenidos", "jbetting")),
                Field::make('date_time', 'data', __("Fecha&hora", "jbetting"))->set_required( true ),                          
                Field::make('complex', 'predictions', __("Pronósticos", "jbetting"))
                    ->set_layout("tabbed-horizontal")
                    ->add_fields(array(
                        Field::make('select', 'market', __("Mercado", "jbetting"))
                        ->add_options(array(
                            'Moneyline' => 'Moneyline',
                            'Handicap' => 'Handicap',
                            'Over' => 'Over',
                            'Under' => 'Under',
                            '5' => '5',
                        )),
                        Field::make('text', 'title', __("Pick", "jbetting")),
                        Field::make('text', 'cuote', __("Cuota", "jbetting")),
                        Field::make('select', 'tvalue', __("Stake (1,2,3,4,5)", "jbetting"))
                            ->add_options(array(
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                            )),

                    )),
                Field::make('select', 'status', __("Status event", "jbetting"))
                    ->add_options(array(
                        'undefined' => 'Indefinido',
                        'ok' => 'Acertado',
                        'fail' => 'No acertado',
                        'null' => 'nulo'
                    )),
            ))
            ->add_tab(__("2. Equipos/Cuotas", "jbetting"), array(
                Field::make('association', 'team1', __("Select team 1", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'team',
                        )
                    ))->set_min(1)->set_max(1)->set_required( true ),
                Field::make('association', 'team2', __("Select team 2", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'team',
                        )
                    ))->set_min(1)->set_max(1)->set_required( true ),
                    Field::make('text', 'p1', __("Team 1 cuota", "jbetting"))->set_required( true ),
                    Field::make('text', 'p2', __("Team 2 cuota", "jbetting"))->set_required( true ),
                    Field::make('text', 'x', __("Empate cuota", "jbetting"))->set_required( true ),
            ))
            ->add_tab(__("3. Casa de apuesta", "jbetting"), array(
                Field::make('association', 'bk', __("Select bookmaker", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'bk',
                        )
                    ))->set_min(1)->set_max(1),
            ));
            
        Container::make('post_meta', __("Parley", "jbetting"))
            ->where('post_type', '=', 'parley')
            ->add_tab(__("General", "jbetting"), array(
                Field::make('date_time', 'data', __("parley date", "jbetting"))
                    ->set_picker_options(array(
                        'time_24hr' => true,
                        'dateFormat' => 'dd.mm.YY',
                    )),            
                Field::make('checkbox', 'vip', __("Premium event", "jbetting")),
                Field::make('select', 'status', __("Status event", "jbetting"))
                    ->add_options(array(
                        'undefined' => 'Indefinido',
                        'ok' => 'Acertado',
                        'fail' => 'No acertado',
                        'null' => 'nulo'
                    )),
                Field::make('complex', 'predictions', __("Predictions", "jbetting"))
                    ->set_layout("tabbed-horizontal")
                    ->add_fields(array(
                        Field::make('text', 'title', __("Title", "jbetting")),
                        Field::make('text', 'cuote', __("Cuote text", "jbetting")),
                        Field::make('select', 'tvalue', __("trush value (1,2,3,4,5)", "jbetting"))
                            ->add_options(array(
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                            )),
                    )),
            ))
            ->add_tab(__("forecasts", "jbetting"), array(
                Field::make('association', 'forecasts', __("Select forecasts", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'forecast',
                        )
                    ))->set_min(1)->set_max(10)
            ))
            ->add_tab(__("Casa de apuesta?", "jbetting"), array(
                Field::make('association', 'bk', __("Select bookmaker", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'bk',
                        )
                    ))->set_min(1)->set_max(1),
            ));


        Container::make('post_meta', __("bonus_slogan", "jbetting"))
            ->where('post_type', '=', 'bonus_slogan')
            ->add_tab(__("General", "jbetting"), array(
                Field::make('association', 'bk', __("Select the bookmaker to which the bonus belongs", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'bk',
                        )
                    ))->set_min(1)->set_max(1),
                Field::make('text', 'summa', __("Bonus ammount", "jbetting")),
                Field::make('text', 'link', __("Link 'Claim bonus'", "jbetting")),
                Field::make('text', 'short', __("Short description for widget", "jbetting")),
                Field::make('text', 'mini', __("Medium description for shortcode", "jbetting")),
            ));



        Container::make('term_meta', __("League", "jbetting"))
            ->where('term_taxonomy', '=', 'league')
            ->add_fields(array(
                Field::make('image', 'wbg', __("Sidebar background", "jbetting")),
                Field::make('text', 'h1', __("Custom H1", "jbetting")),
                Field::make('text', 'fa_icon_class', __("FA icon class", "jbetting")),
                Field::make('association', 'taxonomy_page', __("Select taxonomy page", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'page',
                        )
                    ))->set_min(1)->set_max(1)
            ));
        Container::make('term_meta', __("bookmaker payment methods", "jbetting"))
            ->where('term_taxonomy', '=', 'bookmaker-payment-methods')
            ->add_fields(array(
                Field::make( 'image', 'logo_1x1', __( 'icono cuadrado' ) ),
                Field::make( 'image', 'logo_2x1', __( 'icono horizontal' ) )
            ));

        Container::make('term_meta', __("Content Hub", "jbetting"))
            ->where('term_taxonomy', '=', 'categoria_content_hub')
            ->add_fields(array(
                Field::make('image', 'hub_image', __("Image background", "jbetting")),
                Field::make('text', 'h1_hub', __("Custom H1", "jbetting")),
                Field::make('text', 'fa_icon_class_hub', __("FA icon class", "jbetting")),
                Field::make( 'text', 'custom_order', 'Order' ),
                Field::make('association', 'selected_entry', __("Select taxonomy page", "jbetting"))
                ->set_types(array(
                    array(
                        'type' => 'post',
                        'post_type' => 'content_hub',
                    )
                ))->set_min(1)->set_max(1)
        ));


    
}

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
    require_once(get_template_directory() . '/includes/libs/carbon-fields/vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}
