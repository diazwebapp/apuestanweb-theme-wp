<?php
require_once('bk-location-list.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("MYSQL_TABLE_COUNTRIES",$wpdb->prefix . "aw_countries");
define("MYSQL_TABLE_BK_CLOUNTRY_RELATIONS",$wpdb->prefix . "aw_bk_country_relations");

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
  $table_1 = MYSQL_TABLE_BK_CLOUNTRY_RELATIONS;

  $sql = "CREATE TABLE IF NOT EXISTS $table_1 (
      id bigint(50) NOT NULL auto_increment,
      country_id TEXT,
      bookmaker_id TEXT,
      UNIQUE KEY id (id)
  ) ";

  dbDelta($sql);
}

add_action('init','mysql_table_aw_bk_country_relations');
if(!function_exists('aw_select_countries')):
  function aw_select_countries(){
    global $wpdb;
    $table = MYSQL_TABLE_COUNTRIES;
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
    $list = $wpdb->get_results("SELECT * FROM $table limit 2");
    return ["countries_array"=>$list,"total_countries"=>$count];
  }
else:
  echo "aw_select_countries ya existe";
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

if(!function_exists('aw_select_bookakers')):
  function aw_select_bookakers(){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $list = $wpdb->get_results("SELECT * FROM $table WHERE post_type='bk'");
    return $list;
  }
else:
  echo "aw_select_bookakers ya existe";
  die;
endif;

if(!function_exists('aw_select_relate_bookakers')):
  function aw_select_relate_bookakers(){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $table2 = MYSQL_TABLE_BK_CLOUNTRY_RELATIONS;
    $list = $wpdb->get_results("SELECT * FROM $table INNER JOIN $table2 ON $table2.bookmaker_id = $table.ID WHERE post_type='bk'");
    return $list;
  }
else:
  echo "aw_select_relate_bookakers ya existe";
  die;
endif;

if(!function_exists('aw_select_unrelate_bookakers')):
  function aw_select_unrelate_bookakers(){
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $table2 = MYSQL_TABLE_BK_CLOUNTRY_RELATIONS;
    $list = $wpdb->get_results("SELECT * FROM $table Where Not exists (select 1 from $table2 B Where $table.ID = B.bookmaker_id) AND post_type='bk'");
    return $list;
  }
else:
  echo "aw_select_unrelate_bookakers ya existe";
  die;
endif;

if(!function_exists('aw_select_table_relations_bk_lc')):
  function aw_select_table_relations_bk_lc($params){
    global $wpdb;
    $table = MYSQL_TABLE_BK_CLOUNTRY_RELATIONS;
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
    $table = MYSQL_TABLE_BK_CLOUNTRY_RELATIONS;
    $list = $wpdb->insert($table,$params);
    return $list;
  }
else:
  echo "aw_insert_table_relations_bk_lc ya existe";
  die;
endif;
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