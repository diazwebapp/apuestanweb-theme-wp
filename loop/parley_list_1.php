<?php
$params = get_query_var('params');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$content = get_the_content(get_the_ID());
$forecasts = carbon_get_post_meta(get_the_ID(), 'forecasts');
$parley_title = get_the_title(get_the_ID());
$time = carbon_get_post_meta(get_the_ID(), 'data');
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
$fecha = date_i18n('d M', strtotime($date->format("y-m-d h:i:s")));
$hora = date('g:i a', strtotime($date->format('y-m-d h:i:s')));

$bookmaker = [];
///Buscamos el pais en la base de datos
$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);
if(isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
    if($bookmaker["name"] == "no bookmaker"){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
endif;


$parley_id = get_the_ID();

$html_pronosticos = '
    <div class="">
    <img class="img-fluid mt-5" src="'. get_template_directory_uri() . '/assets/img/apnpls.svg'.'" alt="ApuestanPlus">
    <p class="p1 m-0">CONVIERTE EN MIEMBRO PREMIUM</p>
    <div class="">
      <a href="'. $params['vip_link'].'" class="button mt-3">'.$params['text_vip_link'].'</a>
    </div>
  </div>'
    ;

if(!$vip){
    $parley_event = '';
    if($forecasts and count($forecasts) > 0){
        $parley_cuotes = 1;
        
        foreach ($forecasts as $event) {
            $predictions = carbon_get_post_meta($event['id'], 'predictions');
            $prediction = [];
            $permalink_event = get_the_permalink($event['id']);
            $prediction['title'] = isset($predictions[0]) ? $predictions[0]['title']: '';
            $prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote']: 1;
            $parley_cuotes = $parley_cuotes * $prediction['cuote'];
            $oOddsConverter = new Converter($prediction['cuote'], 'eu');
            $odds_result = $oOddsConverter->doConverting();
            $prediction['cuote'] = isset($odds_result[$args["odds"]]) ? $odds_result[$args["odds"]] : 0;
            
            $teams = get_forecast_teams($event['id'],["w"=>24,"h"=>24]);
            $time = carbon_get_post_meta($event['id'], 'data');
            $fecha =  date('d M', strtotime($time));
            $hora =  date('g:i a', strtotime($time));

            $sport_term = wp_get_post_terms($event['id'], 'league', array('fields' => 'all'));

            $sport['name'] = '';
            $sport['logo'] = get_template_directory_uri() . '/assets/img/logo2.svg';

            if ($sport_term) {
                foreach ( $sport_term as $item ) {
                    if($item->parent == 0){
                        $sport_logo = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'logo'));
                        if($sport_logo)
                            $sport['logo'] = $sport_logo;
                        $sport['name'] = $item->name;
                    }
                }
            }

            $parley_event .= '
                <div class="col-12 event">
                    <div class="row align-items-center py-2">
                        <div class="col-12 col-md-2 "><p class="mb-0 text-center"><small>'.$fecha.','.$hora.'</small></p><p class="mb-0 text-center">'.$sport['name'].'</p></div>
                        <div class="col-12 col-md-8 ">
                            <div class="row align-items-center">
                                <div class="col-6 col-md-7 text-center text-md-left text-truncate">
                                    <div>
                                        <span>
                                            <img width="32" height="32" src="'.$teams['team1']['logo'].'" class="img-fluid" alt="">
                                        </span>
                                        <span>'.$teams['team1']['name'].'</span>
                                    </div> 
                                    <div>
                                        <span>
                                            <img width="32" height="32" src="'.$teams['team2']['logo'].'" class="img-fluid" alt="">
                                        </span>
                                        <span>'.$teams['team2']['name'].'</span>
                                    </div> 
                                </div>
                                <div class="col-6 col-md-5 text-center">
                                    <small class="d-block d-xl-inline">'.$prediction['title'].'</small>
                                    <span class="cuote">'.$prediction['cuote'].'</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2  text-center">
                            <a href="'.$permalink_event.'" class="btn outline btn-sm">Ver analisis</a>
                        </div>
                    </div>
                </div>
            ';
        }
    }
}

$new_html = '<div class="parley-box">
            <div class="px-3 py-2 parley_top_content"><strong class="text-light text-capitalize">'.$parley_title .'-'. $fecha.'</strong></div>

            <div class="row event-list mx-0 parley_wrapper" style="border-bottom: .3rem ridge rgb(3 176 244);">
                {replace-events}
            </div>
            
            <div class="parley-data px-2">
                {replace-data}
            </div>
            
        </div>';


$parley_data = '
                <div class="row align-items-center py-2 mx-0 text-center">
                    <div class="col-12 col-sm-3 col-md-3 col-xl-2">
                        <a  href="'.$bookmaker["ref_link"].'" rel="nofollow noopener noreferrer" target="_blank" class="">
                        <img width="80" height="25" style="object-fit:contain;background:'.$bookmaker["background_color"].';border-radius: 6px;padding: 6px;" src="'.$bookmaker["logo_2x1"].'" class="img-fluid" alt="bk-logo">
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-xl-4 px-0 ">
                        <select class="myselect mt-1 mt-sm-0" onchange="parley_calc_cuotes(this)" name="apu" id="apu" data="'.$parley_id.'" >
                            <option value="10">Apuesta $10</option>
                            <option value="15">Apuesta $15</option>
                            <option value="20">Apuesta $20</option>
                            <option value="50">Apuesta $50</option>
                        </select>
                    </div>
                    <div class="col-2 col-sm-1 col-md-2 col-xl-3">
                        <input type="hidden" id="jscuote_$parley_id" value="'.$parley_cuotes.'/>
                       <p>Gana: $ <span id="jsresult_$parley_id" >Gana $'. round($parley_cuotes * 10,2) .'</span></p>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-xl-3 text-center">
                        <a  href="'.$bookmaker["ref_link"].'" rel="nofollow noopener noreferrer" target="_blank" class="btn btn-primary outline ">apostar ahora</a>
                    </div>
                </div>
            ';

$new_html = str_replace("{replace-events}",$parley_event,$new_html);
$new_html = str_replace("{replace-data}",$parley_data,$new_html);
echo $new_html;
