<?php
include 'views/form-add-account.php';
include 'views/table-accounts.php';

function html_navbar_payment_methods($payment_methods){
  
  $payment_method_navbar = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
                              <div class="container-fluid">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                  <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                  <ul class="navbar-nav me-auto">
                                    {replace-li-navbar}
                                  </ul>
                                </div>
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
      $li .= '<li class="nav-item"><a class="nav-link '.$class.'" href="'.$path.'">'.$method->payment_method.'</a></li>';
    }
    $payment_method_navbar = str_replace("{replace-li-navbar}",$li,$payment_method_navbar);
    return $payment_method_navbar;
}
function html_body_payment_method(){
  
      //////////////////Formulario

  $form = html_form_new_payment_account();
  $html = '<div class="row">
      <div class="col-md-4">
        <h2 class="card-title">añadir cuentas</h2>
        '.$form.'
      </div>
      <div class="col-md-8">
          <h2>listado de cuentas</h2>
          <div class="table-responsive">
            {dynamictableacounts}
          </div>
      </div>
  </div>
  ';
  $table = html_table_payment_accounts();
  $html = str_replace("{dynamictableacounts}",$table,$html);
  return $html;
}
function panel_payment_methods(){
    
    $array_payment_methods = aw_select_payment_method();
    $navbar = html_navbar_payment_methods($array_payment_methods);
    $body_payment_data = html_body_payment_method();
    $html = '<div class="container">
              {html-navbar}
              {html-body-payment-data}
            </div>';
    $html = str_replace("{html-navbar}",$navbar,$html);
    $html = str_replace("{html-body-payment-data}",$body_payment_data,$html);
  echo $html;
}
