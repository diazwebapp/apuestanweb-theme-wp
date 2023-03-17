<?php
require_once('bk-location-list.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("MYSQL_TABLE_COUNTRIES",$wpdb->prefix . "aw_countries");
define("MYSQL_TABLE_BK_COUNTRY_RELATIONS",$wpdb->prefix . "aw_bk_country_relations");

//creamos la tabla 

function mysql_table_aw_countries(){
    global $charset_collate;
    $table_1 = MYSQL_TABLE_COUNTRIES;

    $sql = "CREATE TABLE $table_1 (
        id bigint(50) NOT NULL auto_increment,
        country_name TEXT,
        country_code TEXT,
        UNIQUE KEY id (id)
    ) ";

    dbDelta($sql);
}

add_action('init','mysql_table_aw_countries');

function insert_default_country(){
  global $wpdb;
  $table = MYSQL_TABLE_COUNTRIES;
  $query = "select country_code from $table where country_code ='WW'";
  $result = $wpdb->get_var($query);
  if(!$result):
    $insert = $wpdb->insert($table,["country_name"=>"World Wide","country_code"=>"WW"]);
    if(is_wp_error($insert)):
      echo "hubo un error";
      die;
    endif;
  endif;
}
add_action('admin_init','insert_default_country');

function mysql_table_aw_bk_country_relations(){
  global $charset_collate;
  $table_1 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;

  $sql = "CREATE TABLE IF NOT EXISTS $table_1 (
      id bigint(50) NOT NULL auto_increment,
      country_id TEXT,
      bookmaker_id TEXT,
      on_page BOOLEAN default 0,
      on_single BOOLEAN default 0,
      UNIQUE KEY id (id)
  ) ";

  dbDelta($sql);
}

add_action('init','mysql_table_aw_bk_country_relations');

if(!function_exists('aw_select_countries')):
  function aw_select_countries($limit = 2){
    global $wpdb;
    $table = MYSQL_TABLE_COUNTRIES;
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
    if(isset($limit) and $limit <= $count){
      $list = $wpdb->get_results("SELECT * FROM $table LIMIT $limit");
    }
    if(isset($limit) and $limit > $count){
      $limit = $count;
      $list = $wpdb->get_results("SELECT * FROM $table LIMIT $limit");
    }
    return ["countries_array"=>$list,"total_countries"=>$count,"current_countries"=>count($list)];
  }
else:
  echo "aw_select_countries ya existe";
  die;
endif;


if(!function_exists('aw_select_country')):
  function aw_select_country($params=["country_code"=>"WW","table_id"=>null]){
    global $wpdb;
    $table = MYSQL_TABLE_COUNTRIES;
    $sentencia = "SELECT * FROM $table WHERE 1";
    if(isset($params["country_code"])):
      $sentencia = "SELECT * FROM $table WHERE country_code = '{$params["country_code"]}' ";
    endif;
    if(isset($params["table_id"]) and !empty($params["table_id"])):
      $sentencia = "SELECT * FROM $table WHERE id = '{$params["table_id"]}' ";
    endif;
    
    $country = $wpdb->get_row($sentencia);

    if(!isset($country)):
      $sentencia = "SELECT * FROM $table WHERE country_code = 'WW' ";
    endif;
    $country = $wpdb->get_row($sentencia);
    return $country;
  }
else:
  echo "aw_select_country ya existe";
  die;
endif;


if(!function_exists('aw_add_country')):
  function aw_add_country($params){
    global $wpdb;
    $table = MYSQL_TABLE_COUNTRIES;
    $add = $wpdb->insert($table,$params);
    return $add;
  }
else:
  echo "aw_add_country ya existe";
  die;
endif;

if(!function_exists('aw_delete_country')):
  function aw_delete_country($id_country){
    global $wpdb;
    $table = MYSQL_TABLE_COUNTRIES;
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $delete_country = $wpdb->delete($table,["id"=>$id_country]);
    $delete_relations_country = $wpdb->delete($table2,["country_id" =>$id_country]);
    return $delete_country;
  }
else:
  echo "aw_delete_country ya existe";
  die;
endif;


if(!function_exists('aw_select_relate_bookmakers')):
  function aw_select_relate_bookmakers($country_id, $params=["unique"=>false,"random"=>false,"on_page"=>false,"on_single"=>false, "limit"=>false]){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $query = "SELECT * FROM $table Where exists (select * from $table2 Where ".(isset($params["on_page"]) ? "$table2.on_page ='1' and " : '')." ".(isset($params["on_single"]) ? "$table2.on_single ='1' and " : '')." $table2.country_id = $country_id and $table.ID = $table2.bookmaker_id ) AND $table.post_type='bk' AND $table.post_status='publish' ".(isset($params["random"]) ? "ORDER BY RAND()" : '')." ".(isset($params["limit"]) ? "LIMIT {$params['limit']}" : '')." ";
    
    if(isset($params["unique"])){
      $bookmaker["name"] = "no bookmaker";
      $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
      $bookmaker["logo_2x1"] = get_template_directory_uri() . '/assets/img/logo2.svg';
      $bookmaker["background_color"] = '#000';
      $bookmaker["ref_link"] = "#";
      $bookmaker["bonus_slogan"] = "";
      $bookmaker["bonus_amount"] = 0;
      $bookmaker["feactures"] = [];
      $bookmaker["rating"] = [];
                
      $list = $wpdb->get_row($query);
      //Si existe una casa de apuesta seteamos sus valores
      if($list):
        $bookmaker['name'] = $list->post_title;
        $aw_system_country = aw_select_country(["table_id"=>$country_id]);
        
        $bonuses = carbon_get_post_meta($list->ID, 'country_bonus');
        if(isset($bonuses) and count($bonuses) > 0):
          foreach($bonuses as $bonus_data):
              if(strtoupper($bonus_data["country_code"]) == strtoupper($aw_system_country->country_code)):
                $bookmaker["bonus_slogan"] = $bonus_data['country_bonus_slogan'];
                $bookmaker["bonus_amount"] = $bonus_data['country_bonus_amount'];
                $bookmaker["ref_link"] = $bonus_data['country_bonus_ref_link'];
              endif;
          endforeach;
        endif;
       
        $bookmaker["background_color"] = carbon_get_post_meta($list->ID, 'background-color');
        $bookmaker["feactures"] = carbon_get_post_meta($list->ID, 'feactures');
        $bookmaker["rating"] = carbon_get_post_meta($list->ID, 'rating');
        if (carbon_get_post_meta($list->ID, 'logo')):
          $logo = carbon_get_post_meta($list->ID, 'logo');
          $bookmaker["logo"] = wp_get_attachment_url($logo);
        endif; 
        if (carbon_get_post_meta($list->ID, 'logo_2x1')):
          $logo = carbon_get_post_meta($list->ID, 'logo_2x1');
          $bookmaker["logo_2x1"] = wp_get_attachment_url($logo);
        endif;        
      endif;
        $list = $bookmaker;
    }
    if(!isset($params["unique"])){
      $list = $wpdb->get_results($query);
    }
    return $list;
  }
else:
  echo "aw_select_relate_bookmakers ya existe";
  die;
endif;
if(!function_exists('aw_detect_bookmaker_on_page')):
  function aw_detect_bookmaker_on_page($country_id,$bookmaker_id){
    global $wpdb;
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $query = "SELECT id FROM $table2 where on_page=1 and bookmaker_id='$bookmaker_id' and country_id='$country_id' ";
    $list = $wpdb->get_var($query);
    return $list;
  }
else:
  echo 'aw_detect_bookmaker_on_page ya existe';
  die;
endif;

if(!function_exists('aw_detect_bookmaker_on_single')):
  function aw_detect_bookmaker_on_single($country_id,$bookmaker_id){
    global $wpdb;
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $query = "SELECT id FROM $table2 where on_single=1 and bookmaker_id='$bookmaker_id' and country_id='$country_id' ";
    $list = $wpdb->get_var($query);
    return $list;
  }
else:
  echo 'aw_detect_bookmaker_on_single ya existe';
  die;
endif;

if(!function_exists('aw_detect_bookmaker_on_country')):
  function aw_detect_bookmaker_on_country($country_id,$bookmaker_id){
    global $wpdb;
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $query = "SELECT id FROM $table2 where country_id='$country_id' and bookmaker_id='$bookmaker_id' ";
    $list = $wpdb->get_var($query);
    return $list;
  }
else:
  echo 'aw_detect_bookmaker_on_country ya existe';
  die;
endif;

if(!function_exists('aw_select_unrelate_bookakers')):
  function aw_select_unrelate_bookakers($country_id){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $list = $wpdb->get_results("SELECT * FROM $table Where Not exists (select * from $table2 Where $table2.country_id = $country_id and $table.ID = $table2.bookmaker_id) AND $table.post_type='bk' AND $table.post_status='publish' ");
    return $list;
  }
else:
  echo "aw_select_unrelate_bookakers ya existe";
  die;
endif;

if(!function_exists('aw_select_table_relations_bk_lc')):
  function aw_select_table_relations_bk_lc($params){
    global $wpdb;
    $table = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $list = $wpdb->get_results("SELECT * FROM $table WHERE country_id='{$params['country_id']}'");
    return $list;
  }
else:
  echo "aw_select_table_relations_bk_lc ya existe";
  die;
endif;

if(!function_exists('aw_insert_table_relations_bk_lc')):
  function aw_insert_table_relations_bk_lc($params){
    global $wpdb;
    $table = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $list = $wpdb->insert($table,$params);
    return $list;
  }
else:
  echo "aw_insert_table_relations_bk_lc ya existe";
  die;
endif;
if(!function_exists('aw_delete_relations_bk_lc')):
  function aw_delete_relations_bk_lc($id_country,$id_bookamer){
    global $wpdb;
    $table = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $delete_relations_country = $wpdb->delete($table,["country_id" =>$id_country,"bookmaker_id"=>$id_bookamer]);
    return $delete_relations_country;
  }
else:
  echo "aw_delete_relations_bk_lc ya existe";
  die;
endif;
if(!function_exists('aw_update_relations_bk_lc')):
  function aw_update_relations_bk_lc($params,$where){
    global $wpdb;
    $table = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $delete_relations_country = $wpdb->update($table,$params,$where);
    return $delete_relations_country;
  }
else:
  echo 'aw_update_relations_bk_lc ya existe';
endif;
/*
  ELIMINAR DE LA TABLA RELATED_BK_LOC LOS BOOKMAKERS ELIMINADOS EN DASHBOARD
*/
add_action( 'admin_init', 'aw_detect_deleted_bookmaker' );
function aw_detect_deleted_bookmaker() {
    add_action( 'wp_trash_post','aw_delete_related_bookmakers' );
}
 
function aw_delete_related_bookmakers() {
    global $wpdb;
    $table = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    if(isset( $_GET['post'] ) && isset($_GET['action'])){
      if($_GET['action'] == 'trash'){
        if(is_array($_GET['post'])){
          foreach($_GET['post'] as $pid){
            $query = $wpdb->delete($table,["bookmaker_id"=>$pid]);
          }
        }else{
          $query = $wpdb->delete($table,["bookmaker_id"=>$_GET['post']]);
        }
      }
    }
    
}
/* add_action( 'admin_menu', function(){
  add_submenu_page( 'bookmaker-location', 'bookmaker history', 'bookmaker history', 'manage_options', 'bookmaker-history', 'aw_bookmaker_history', 2 );
  add_submenu_page( 'bookmaker-location', 'bookmaker methods', 'bookmaker settings', 'manage_options', 'bookmaker-mehods', 'panel_bookmaker_methods', 2 );
}); */


add_action( 'admin_enqueue_scripts', function(){
  wp_enqueue_script('admin-js',get_template_directory_uri() . '/assets/js/admin.js');
  wp_enqueue_style('admin-css');
  //$countries = get_countries_json();
  $data = json_encode([
      "rest_url"=>rest_url(),
      //"countries"=>$countries
    ]);
  wp_add_inline_script( 'admin-js', 'const bookmaker_scripts='.$data, 'before' );
} );
