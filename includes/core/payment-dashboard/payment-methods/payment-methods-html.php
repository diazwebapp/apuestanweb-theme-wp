<?php
include "payment-methods-sql.php";
include 'views/form-add-method.php';

function html_navbar_payment_methods($payment_methods){
  
  $payment_method_navbar = '<nav class="navbar navbar-expand-lg navbar-light bg-light">
                              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                  {replace-li-navbar}
                                </ul>
                              </div>
                            </nav>';
    $li="";
    foreach($payment_methods as $key => $method){
      $path = $_SERVER['REQUEST_URI'] ."&method_page=". $method->id ;
      $class="";
      
      if(isset($_GET['method_page']) and strval($_GET['method_page'])==strval($method->id)){
        $class = "active";
      }
      if($key == 0){
        $class = "active";
      }
      $li .= '<li class="nav-item '.$class.'"><a class="nav-link" href="'.$path.'">'.$method->payment_method.'</a></li>';
    }
    $payment_method_navbar = str_replace("{replace-li-navbar}",$li,$payment_method_navbar);
    return $payment_method_navbar;
}
function html_body_payment_method(){
  $array_payment_methods = aw_select_payment_method();
  $table ='<table class="table table-hover table-dark">
  <thead>
    <tr>
      {dynamicth}
    </tr>
  </thead>
  <tbody>
    <tr>
      
    </tr>
  </tbody>
</table>';
  $th = "";
  if($array_payment_methods[0]){
    $array = array_keys((array)$array_payment_methods[0]);
    foreach($array as $newth){
      $th .= '<th>'.$newth.'</th>';
    }
  }
  $table = str_replace("{dynamicth}",$th,$table);

  $html = '<div class="row">
      <div class="col-md-4">
        <div class="card">
          <h2 class="card-title">añadir cuentas</h2>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <h2 class="card-title">listado de cuentas</h2>
          <div class="table-responsive">
            '.$table.'
          </div>
        </div>
      </div>
  </div>
  ';
  return $html;
}
function panel_payment_methods(){
    $form_add_method = html_form_new_payment_method();
    $array_payment_methods = aw_select_payment_method();
    $navbar = html_navbar_payment_methods($array_payment_methods);
    $body_payment_data = html_body_payment_method();
    $html = '<div class="container">
              {html-form-add-method}
              {html-navbar}
              {html-body-payment-data}
            </div>';
    $html = str_replace("{html-form-add-method}",$form_add_method,$html);
    $html = str_replace("{html-navbar}",$navbar,$html);
    $html = str_replace("{html-body-payment-data}",$body_payment_data,$html);
  echo $html;
}
