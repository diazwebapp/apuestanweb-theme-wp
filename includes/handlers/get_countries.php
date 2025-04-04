<?php
stream_context_set_default(array(
    'ssl'                => array(
    'peer_name'          => 'generic-server',
    'verify_peer'        => FALSE,
    'verify_peer_name'   => FALSE,
    'allow_self_signed'  => TRUE
     )));
$country_json_file = file_get_contents(get_template_directory() . '/includes/libs/countries.json',false);
function get_countries_for_carbonmeta(){
    global $country_json_file;
    $parse_countries = json_decode($country_json_file);
    foreach($parse_countries as $country):
        $select[$country->country_short_name] = $country->country_name;        
    endforeach;
    return $select;
}

function get_countries_json(){
    global $country_json_file;
    $parse_countries = json_decode($country_json_file);
    return $parse_countries;
}