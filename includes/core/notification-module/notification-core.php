<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("NOTIFICATIONS_MYSQL_TABLE",$wpdb->prefix . "aw_notification_table");

function create_table_aw_notification(){

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

if(!function_exists('select_notification_not_view')):
    function select_notification_not_view($setup=["post_type"=>'forecast',"post_meta"=>false,"id_user"=>false]){
        
        global $wpdb;
        $table_notification = NOTIFICATIONS_MYSQL_TABLE;
        $table_posts = $wpdb->prefix."posts";
        $current_user = ($setup['id_user'] ? $setup['id_user'] : get_current_user_id());
        $result = [];
        $new_result = [];
        
        if(isset($current_user)):
            $sql = $wpdb->prepare(
                "SELECT * FROM $table_posts 
                 WHERE NOT EXISTS (
                     SELECT 1 
                     FROM $table_notification 
                     WHERE $table_notification.id_pronostico = $table_posts.ID 
                     AND $table_notification.id_user = %d
                 ) AND $table_posts.post_type = %s 
                 AND $table_posts.post_status = 'publish'",
                 $current_user, $setup['post_type']
            );
            
            $result = $wpdb->get_results($sql);
            
            if(count($result) > 0):
                foreach($result as $notify_post){
                    $vip = carbon_get_post_meta($notify_post->ID,'vip');
                    if($vip): //SOLO MOSTRAMOS SI SON VIP
                        $new_result[] = $notify_post;
                    endif;
                }
            endif;
        endif; 
        return $new_result;
    }
    
endif;

if(!function_exists('insert_multi_notificacions_views')):
    function insert_multi_notificacions_views($setup=['id_user'=>false]){
        $current_user = ($setup['id_user'] ? $setup['id_user'] : get_current_user_id( ));
        $result = false;
        if(isset($current_user)):
            $notificaciones = select_notification_not_view(["post_type"=>'forecast',"id_user"=>$current_user]);
            if(count($notificaciones) > 0){
                foreach($notificaciones as $post){
                    $result = insert_notification_view(["id_pronostico"=>$post->ID,"id_user"=>$current_user]);
                }
            }
        endif;
        return $result ;
    }
endif;

if(!function_exists('insert_notification_view')):
    function insert_notification_view($setup=['id_post'=>false,"id_user"]){
        global $wpdb;
        $table_notification = NOTIFICATIONS_MYSQL_TABLE;

        $current_user = ($setup['id_user'] ? $setup['id_user'] : get_current_user_id( ));
        $result = false;
        if(isset($current_user)):
            $result = $wpdb->insert($table_notification,$setup);
        endif;
        return $result ;
    }
endif;