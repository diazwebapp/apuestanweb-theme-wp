<?php
$country_json_file = file_get_contents(get_template_directory_uri(  ) . '/includes/libs/countries.json');
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