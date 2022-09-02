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

    $sql = "CREATE TABLE IF NOT EXISTS $table_1 (
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
      UNIQUE KEY id (id)
  ) ";

  dbDelta($sql);
}
/*
  FALTA MEJORA LA UI Y UX
  FALTA BOTON PARA ELIMINAR BOOKMAKERS DE UN PAIS
  FALTA BOTON PARA ELIMINAR UN PAIS
*/
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
  function aw_select_country($params=["country_code"=>"WW"]){
    global $wpdb;
    $table = MYSQL_TABLE_COUNTRIES;
    $prepare = $wpdb->prepare("SELECT * FROM $table WHERE country_code = %s ",$params["country_code"]);
    $country = $wpdb->get_row($prepare);
    
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


if(!function_exists('aw_select_relate_bookakers')):
  function aw_select_relate_bookakers($country_id, $unique=false, $random=false){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $query = "SELECT * FROM $table Where exists (select 1 from $table2 B Where country_id = $country_id and $table.ID = B.bookmaker_id) AND post_type='bk' AND post_status='publish' ";
    if($unique){
      $bookmaker["name"] = "no bookmaker";
      $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
      $bookmaker["wallpaper"] = get_template_directory_uri() . '/assets/img/baner2.png';
      if($random){
        $query = "SELECT * FROM $table Where exists (select 1 from $table2 B Where country_id = $country_id and $table.ID = B.bookmaker_id) AND post_type='bk' AND post_status='publish' ORDER BY RAND()";
        $list = $wpdb->get_row($query);
      }else{
        $query = "SELECT * FROM $table Where exists (select 1 from $table2 B Where country_id = $country_id and $table.ID = B.bookmaker_id) AND post_type='bk' AND post_status='publish' ";
        $list = $wpdb->get_row($query);
      }
      //Si existe una casa de apuesta seteamos sus valores
      $bookmaker['name'] = $list->post_title;
      $bookmaker["bonus_sum"] = carbon_get_post_meta($list->ID, 'bonus_sum');
      $bookmaker["ref_link"] = carbon_get_post_meta($list->ID, 'ref');
      $bookmaker["bonus"] = carbon_get_post_meta($list->ID, 'bonus');
      if (carbon_get_post_meta($list->ID, 'mini_img')):
        $logo = carbon_get_post_meta($list->ID, 'mini_img');
        $bookmaker['logo'] = wp_get_attachment_url($logo);
      endif;
      if (carbon_get_post_meta($list->ID, 'wbg')):
          $wallpaper = carbon_get_post_meta($list->ID, 'wbg');
          $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
      endif;
      $list = $bookmaker;
    }
    if(!$unique){
      $list = $wpdb->get_results($query);
    }
    return $list;
  }
else:
  echo "aw_select_relate_bookakers ya existe";
  die;
endif;

if(!function_exists('aw_select_unrelate_bookakers')):
  function aw_select_unrelate_bookakers($country_id){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $table2 = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $list = $wpdb->get_results("SELECT * FROM $table Where Not exists (select 1 from $table2 B Where country_id = $country_id and $table.ID = B.bookmaker_id) AND post_type='bk' AND post_status='publish' ");
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
if(!function_exists('aw_relations_bk_lc')):
  function aw_relations_bk_lc($id_country,$id_bookamer){
    global $wpdb;
    $table = MYSQL_TABLE_BK_COUNTRY_RELATIONS;
    $delete_relations_country = $wpdb->delete($table,["country_id" =>$id_country,"bookmaker_id"=>$id_bookamer]);
    return $delete_relations_country;
  }
else:
  echo "aw_relations_bk_lc ya existe";
  die;
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
