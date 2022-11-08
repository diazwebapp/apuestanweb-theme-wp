<?php
//geolocation
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("GEOLOCATION_CACHE",$wpdb->prefix . "aw_geolocation_cache");


//creamos la tabla 


global $charset_collate;
$table = GEOLOCATION_CACHE;

$sql = "CREATE TABLE $table (
    id bigint(50) NOT NULL auto_increment,
    ip TEXT,
    country TEXT,
    country_code TEXT,
    timezone TEXT,
    flag_uri TEXT,
    UNIQUE KEY id (id)
) $charset_collate;";

dbDelta($sql);

function select_geolocation_cache($ip){
    global $wpdb ;
    $results = $wpdb->get_results("SELECT * FROM ".GEOLOCATION_CACHE." WHERE ip='$ip'");
    return $results;
}

function insert_geolocation_cache($data){
    global $wpdb;
    $insert = $wpdb->insert(GEOLOCATION_CACHE,$data);
    return $insert;
}

function geolocation_api(){
    
    
}