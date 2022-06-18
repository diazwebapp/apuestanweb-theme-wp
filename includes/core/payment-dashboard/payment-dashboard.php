<?php
include "dashboard/dashboard-html.php";
include "payment-methods/payment-methods-html.php";
include "payment-history/payment-history-html.php";

function payment_control_page() {
  add_menu_page(
      __( 'Payment Dashboard', 'jbetting' ),
      'Payment dashboard',
      'manage_options',
      'payment-dashboard' ,
      'aw_payment_dashboard',
      '',
      6
  );
}
add_action( 'admin_menu', 'payment_control_page' );

add_action( 'admin_menu', function(){
  add_submenu_page( 'payment-dashboard', 'Payment history', 'Payment history', 'manage_options', 'payment-history', 'aw_payment_history', 2 );
  add_submenu_page( 'payment-dashboard', 'payment methods', 'payment settings', 'manage_options', 'payment-mehods', 'panel_payment_methods', 2 );
});

add_action( 'admin_enqueue_scripts', function(){

  wp_enqueue_script('admin-js',get_template_directory_uri() . '/assets/js/admin.js');
  wp_enqueue_style('admin-css');
  
  $data = json_encode([
      "rest_url"=>rest_url()]);
  wp_add_inline_script( 'admin-js', 'const php='.$data, 'before' );
} );
