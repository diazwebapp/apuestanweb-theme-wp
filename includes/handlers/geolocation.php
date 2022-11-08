<?php
//geolocation
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("GEOLOCATION_CACHE",$wpdb->prefix . "aw_geolocation_cache");
function aw_get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        }
    return apply_filters( 'wpb_get_ip', $ip );
    }

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
    $results = $wpdb->get_row("SELECT * FROM ".GEOLOCATION_CACHE." WHERE ip='$ip'");
    return $results;
}

function insert_geolocation_cache($data){
    global $wpdb;
    $insert = $wpdb->insert(GEOLOCATION_CACHE,$data);
    return $insert;
}

function geolocation_api($param){
    $response = false;

    $geolocation = [
        "ip" => $param,
        "country" => "World Wide",
        "country_code" => "WW",
        "timezone" => "America/Caracas",
        "flag_uri" => get_template_directory_uri( ) . "/assets/img/ww.png"
    ];
    
    
    $geolocation_api = empty(carbon_get_theme_option('geolocation_api')) ?"ipwhois": carbon_get_theme_option('geolocation_api') ;
    $geolocation_api_key = carbon_get_theme_option('geolocation_api_key') ;
    
    
    if(!isset($_SESSION["geolocation"])){
        
        if($geolocation["ip"] !== "127.0.0.1" and $geolocation["ip"] !== "::1"):
            
            $data_location = select_geolocation_cache($geolocation["ip"]);
            
            if(is_null($data_location)):
               
                if(empty($geolocation_api) or empty($geolocation_api_key) or $geolocation_api == 'ipwhois'):
                    
                    if(!empty($geolocation_api_key)):
                        $response = wp_remote_get("http://ipwho.pro/bulk/{$geolocation["ip"]}?key=$geolocation_api_key",array('timeout'=>10));
                    endif;
                    if(empty($geolocation_api_key)):
                        $response = wp_remote_get("http://ipwho.is/{$geolocation["ip"]}",array('timeout'=>10));
                    endif;
                    if(!is_wp_error( $response )):
                        $geolocation_resp =  wp_remote_retrieve_body( $response );
                        $geolocation_resp = json_decode($geolocation_resp);
                        
                        if(isset($geolocation_resp->country) and isset($geolocation_resp->flag->img)):
                            $geolocation["country"] = $geolocation_resp->country;
                            $geolocation["country_code"] = $geolocation_resp->country_code;
                            $geolocation["timezone"] = $geolocation_resp->timezone->id;
                            $geolocation["flag_uri"] = $geolocation_resp->flag->img;
                            
                            insert_geolocation_cache($geolocation);
                            $geolocation = json_encode($geolocation);
                            $_SESSION["geolocation"] = $geolocation;
                        else:
                            $geolocation = json_encode($geolocation);
                            define("GEOLOCATION",$geolocation);
                        endif;

                    endif;
                endif;
        
                if($geolocation_api == 'abstractapi' and !empty($geolocation_api_key)):
                    
                    $response = wp_remote_get("https://ipgeolocation.abstractapi.com/v1/?api_key=$geolocation_api_key&ip_address={$geolocation["ip"]}",array('timeout'=>10));
                    if(!is_wp_error( $response )):
                        $geolocation_resp =  wp_remote_retrieve_body( $response );
                        $geolocation_resp = json_decode($geolocation_resp);
                        var_dump($geolocation_resp);
                        if(isset($geolocation_resp->country) and isset($geolocation_resp->flag->svg)):
                            
                            $geolocation["country"] = $geolocation_resp->country;
                            $geolocation["country_code"] = $geolocation_resp->country_code;
                            $geolocation["timezone"] = $geolocation_resp->timezone->name;
                            $geolocation["flag_uri"] = $geolocation_resp->flag->svg; 

                            insert_geolocation_cache($geolocation);
                            $geolocation = json_encode($geolocation);
                            $_SESSION["geolocation"] = $geolocation;
                        else:
                            var_dump("error en la consulta -> ".$geolocation_resp);
                            $geolocation = json_encode($geolocation);
                            define("GEOLOCATION",$geolocation);
                        endif; 
                    else:
                        var_dump("error en el request -> ".$response);
                    endif;
                endif;
            endif;
            if(!is_null($data_location)):
                $geolocation["country"] = $data_location->country;
                $geolocation["country_code"] = $data_location->country_code;
                $geolocation["timezone"] = $data_location->timezone;
                $geolocation["flag_uri"] = $data_location->flag_uri;

                $_SESSION["geolocation"] = json_encode($geolocation);
            endif;
        endif;
    
    }
    
}