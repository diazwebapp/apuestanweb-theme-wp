<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();

define("MYSQL_TABLE_PAYMENT_ACCOUNTS",$wpdb->prefix . "aw_payment_accounts");
define("MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS",$wpdb->prefix . "aw_payment_accounts_metas");

//creamos la tabla 
function create_sql_payment_accounts_tables(){
    global $charset_collate;
    $table_1 = MYSQL_TABLE_PAYMENT_ACCOUNTS;

    $sql_payment_accounts = "CREATE TABLE IF NOT EXISTS $table_1 (
        id bigint(50) NOT NULL auto_increment,
        payment_method_name TEXT,
        country_code TEXT,
        payment_method_id bigint(50),
        status BOOLEAN,
        UNIQUE KEY id (id)
    ) $charset_collate;";
    
    dbDelta($sql_payment_accounts);
}
add_action('init','create_sql_payment_accounts_tables');

function create_sql_payment_accounts_tables_2(){
    global $charset_collate;
    $table_2 = MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS;

   $sql_payment_accounts_metas = "CREATE TABLE IF NOT EXISTS $table_2 (
        id bigint(50) NOT NULL auto_increment,
        meta_key TEXT,
        meta_value TEXT,
        status BOOLEAN,
        account_id bigint(50),
        UNIQUE KEY id (id)
    ) $charset_collate;";
    
    dbDelta($sql_payment_accounts_metas);
}
add_action('init','create_sql_payment_accounts_tables_2');

////////payment accounts///////7
if(!function_exists('aw_insert_new_payment_account')){
    function aw_insert_new_payment_account($account_data){
        global $wpdb ;
        //Por ahora se habilita solo una cuenta
        if($account_data["status"] == true){
            $update = $wpdb->update(MYSQL_TABLE_PAYMENT_ACCOUNTS,["status"=>false],["status"=>true,"payment_method_id"=>$account_data['payment_method_id']]);
            
        }
        $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_ACCOUNTS,$account_data);
        if($insert == 1 and !is_wp_error( $insert )):
            $id = $wpdb->get_var("SELECT id FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS." ORDER BY id DESC");
            return ["status"=>"ok","msg"=>"Dato insertado correctamente","id"=>$id];
        endif;
        return ["status"=>"fail","msg"=>"no fue posible insertar el dato"];
    }
}else{
    var_dump("la funcion aw_insert_new_payment_account ya existe");
    die ;
}
if(!function_exists('aw_insert_new_payment_account_metas')){
    function aw_insert_new_payment_account_metas($account_meta){
        global $wpdb ;
        
        $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS,$account_meta);
        if($insert == 1 and !is_wp_error( $insert )):
            $id = $wpdb->get_var("SELECT id FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS." ORDER BY id DESC");
            return ["status"=>"ok","msg"=>"Dato insertado correctamente","id"=>$id];
        endif;
        return ["status"=>"fail","msg"=>"no fue posible insertar el dato"];
    }
}else{
    var_dump("la funcion aw_insert_new_payment_account_metas ya existe");
    die ;
}
if(!function_exists('aw_select_payment_account')){
    function aw_select_payment_account($id=false,$status=false,$payment_method_id=false,$limit=false,$order=false){
        global $wpdb;
        $query = false;
        
        $sql = "SELECT * FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS." WHERE status=$status ";
        if($status == 'any'):
            $sql = "SELECT * FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS." WHERE 1 ";
        endif;
        if($id){
            $sql .= "AND id = $id ";
        }
        if($payment_method_id){
            $sql .= "AND payment_method_id = '$payment_method_id' ";
        }
        
        if($order){
            $sql .= "ORDER BY {$order['key']} {$order['order']} ";
        }
        if($limit){
            $sql .= "LIMIT $limit ";
        }
        
        $query = $wpdb->get_results($sql);
        if(!is_wp_error( $query )){
            return $query;
        }
        return [];
    }
}else{
    var_dump("la funcion aw_select_payment_account ya existe");
    die;
}
if(!function_exists('aw_select_payment_account_metas')){
    function aw_select_payment_account_metas($account_id){
        global $wpdb;
        $query = $wpdb->get_results("select * from ".MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS." WHERE account_id = $account_id");
        if(!is_wp_error( $query )){
            return $query;
        }
        return [];
    }
}else{
    var_dump("la funcion aw_select_payment_account_metas ya existe");
    die ;
}
if(!function_exists('aw_update_payment_account')):
    function aw_update_payment_account($data=false,$where_params=false){
        global $wpdb;
        //Por ahora se habilita solo una cuenta
        if($data["status"] == 1){
            $update = $wpdb->update(MYSQL_TABLE_PAYMENT_ACCOUNTS,["status"=>false],["status"=>true,"payment_method_id"=>$where_params['payment_method_id']]);
            
        }
        $update = $wpdb->update(MYSQL_TABLE_PAYMENT_ACCOUNTS,$data,$where_params);
    }
else:
    echo 'la funcion aw_update_payment_account ya existe';
endif;
if(!function_exists('aw_delete_payment_account')):
    function aw_delete_payment_account($data){
        global $wpdb;
        $delete = $wpdb->delete(MYSQL_TABLE_PAYMENT_ACCOUNTS,$data);
    }
else:
    echo 'la funcion aw_delete_payment_accoun ya existe';
endif;
if(!function_exists('aw_delete_payment_account_metas')):
    function aw_delete_payment_account_metas($data){
        global $wpdb;
        $delete_received = $wpdb->delete(MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS,$data);
    }
else:
    echo 'la funcion aw_delete_payment_account_metas ya existe';
endif;