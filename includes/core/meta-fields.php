<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options()
{

    if (get_key()):
        Container::make('theme_options', "jBetting")
            ->set_icon('dashicons-admin-site-alt2')
            ->add_tab(__("General settings", "jbetting"), array(
                Field::make('image', 'logo', __("Site logo(183*19)", "jbetting")),
                //selecion de pagina vip por defecto
                Field::make('association', 'page_vip', __("Select default vip", "jbetting"))
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
            ));


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
                    Field::make('text', 'ref', __("Refferal link", "jbetting")),
                    Field::make('text', 'rating', __("Rating(1,2,3,4,5)", "jbetting")),
                    Field::make('text', 'bonus', __("Bonus slogan", "jbetting")),
                    Field::make('text', 'bonus_sum', __("Bonus ammount", "jbetting")),
                    Field::make('image', 'mini_img', __("Transparent logo(.png)", "jbetting")),
                    Field::make('image', 'wbg', __("Background of the block with basic information inside the BC overview", "jbetting")),
                    Field::make('complex', 'feactures', __("feactures", "jbetting"))
                        ->set_layout("tabbed-horizontal")
                        ->add_fields(array(
                            Field::make('text', 'feacture', __("feacture text", "jbetting")),
                        )),
                    Field::make('complex', 'countries', __("Country", "jbetting"))
                        ->set_layout("tabbed-horizontal")
                        ->add_fields(array(
                            Field::make('text', 'bonus', __("Bonus slogan", "jbetting")),
                            Field::make('text', 'ref', __("Refear link", "jbetting")),
                            Field::make('select', 'country_code', __("country code", "jbetting"))
                                ->add_options('get_countries_for_carbonmeta'),
                        )),
                    Field::make('complex', 'alt_bk', __("Alternative Bookmaker", "jbetting"))
                        ->set_layout("tabbed-horizontal")
                        ->add_fields(array(
                            Field::make('select', 'country_code', __("country code", "jbetting"))
                                ->add_options('get_countries_for_carbonmeta'),
                            Field::make('association', 'bk', __("Select alternative bookmaker", "jbetting"))
                                ->set_types(array(
                                    array(
                                        'type' => 'post',
                                        'post_type' => 'bk',
                                    )
                                ))->set_min(1)->set_max(1),
                        )),
                )
        );
        
        Container::make('post_meta', __("Team", "jbetting"))
            ->where('post_type', '=', 'team')
            ->add_tab(__("General", "jbetting"), array(
                Field::make('image', 'team_logo', __("Team logo(square .png)", "jbetting")),
                Field::make('text', 'acronimo', __("acronimo", "jbetting"))
            ));



        Container::make('post_meta', __("Forecast", "jbetting"))
            ->where('post_type', '=', 'forecast')
            ->add_tab(__("General", "jbetting"), array(
                Field::make('date_time', 'data', __("Forecast date", "jbetting")),            
                Field::make('checkbox', 'vip', __("Premium event", "jbetting")),
                Field::make('text', 'stadium', __("Stadium", "jbetting")),
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
            ->add_tab(__("Game Teams?", "jbetting"), array(
                Field::make('text', 'p1', __("Team 1 cuote", "jbetting")),
                Field::make('association', 'team1', __("Select team 1", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'team',
                        )
                    ))->set_min(1)->set_max(1),
                    Field::make('text', 'p2', __("Team 2 cuote", "jbetting")),
                Field::make('association', 'team2', __("Select team 2", "jbetting"))
                    ->set_types(array(
                        array(
                            'type' => 'post',
                            'post_type' => 'team',
                        )
                    ))->set_min(1)->set_max(1),
                    Field::make('text', 'x', __("X other cuote", "jbetting")),
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
                        //Field::make('text', 'tvalue', __("trush value (1,2,3,4,5)", "jbetting")),
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


        Container::make('post_meta', __("Bonus", "jbetting"))
            ->where('post_type', '=', 'bonus')
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
                Field::make('image', 'wbg', __("Sidebar background(if using 283*73)", "jbetting")),
                Field::make('text', 'h1', __("Custom H1", "jbetting")),
                Field::make('text', 'fa_icon_class', __("FA icon class", "jbetting"))
            ));

    endif;
}

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
    require_once(get_template_directory() . '/includes/libs/carbon-fields/vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}
