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
      if($key == 0 and !isset($_GET['method_page'])){
        $class = "active";
      }
      $li .= '<li class="nav-item"><a class="nav-link '.$class.'" href="'.$path.'">'.$method->payment_method.'</a></li>';
    }
    $payment_method_navbar = str_replace("{replace-li-navbar}",$li,$payment_method_navbar);
    return $payment_method_navbar;
}

function panel_payment_methods(){
    
    $array_payment_methods = aw_select_payment_method(false,true);
    $navbar = html_navbar_payment_methods($array_payment_methods);
    $form = '';
    $table = '';
    if($array_payment_methods[0]):
      $table = html_table_payment_accounts($array_payment_methods[0]->id);
      $form = html_form_new_payment_account($array_payment_methods[0]->id);
    endif;
    $html = '<div class="container">
              {html-navbar}
              <div class="row">
                  <div class="col-md-4">
                    <h2 class="card-title">añadir cuentas</h2>
                    {dynamicform}
                  </div>
                  <div class="col-md-8">
                      <h2>listado de cuentas</h2>
                      <div class="table-responsive">
                        {dynamictableacounts}
                      </div>
                  </div>
              </div>
            </div>';
    $html = str_replace("{html-navbar}",$navbar,$html);
    $html = str_replace("{dynamicform}",$form,$html);
    $html = str_replace("{dynamictableacounts}",$table,$html);
  echo $html;
}
