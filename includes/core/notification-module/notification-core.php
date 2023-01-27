<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("NOTIFICATIONS_MYSQL_TABLE",$wpdb->prefix . "aw_notification_table");
function create_table_aw_notification(){
    global $charset_collate;
    $table_1 = NOTIFICATIONS_MYSQL_TABLE;

    $sql = "CREATE TABLE $table_1 (
        id bigint(50) NOT NULL auto_increment,
        id_pronostico bigint(50),
        id_user bigint(50),
        UNIQUE KEY id (id)
    ) ";

    dbDelta($sql);
}

add_action('init','create_table_aw_notification');

if(!function_exists('aw_insert_notification_view')):
    function aw_insert_notification_view($array_data){
        global $wpdb;
        $table = NOTIFICATIONS_MYSQL_TABLE;
        
        $insert = $wpdb->insert($table,$array_data);
    }
endif;

if(!function_exists('select_notification_not_view')):
    function select_notification_not_view(){
        global $wpdb;
        $table_notification = NOTIFICATIONS_MYSQL_TABLE;
        $table_posts = $wpdb->prefix."posts";
        $current_user = get_current_user_id(  );
        $result = [];
        if(isset($current_user)):
            $sql = "SELECT * FROM $table_posts Where Not exists (select * from $table_notification Where $table_notification.id_pronostico = $table_posts.ID AND $table_notification.id_user = $current_user) AND $table_posts.post_type='forecast' AND $table_posts.post_status='publish'";

            $result = $wpdb->get_results($sql);
            if(count($result) > 0):
                foreach($result as $post){
                    $vip = carbon_get_post_meta($post->ID,'vip');
                    $post->vip =$vip;
                }
            endif;
        endif;
        return $result;
    }
endif;

