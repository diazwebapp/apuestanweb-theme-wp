<?php
include 'form-add-method.php';
if(isset($_GET['disable_method'])):
  aw_update_payment_method(["status"=>false],["id"=>"{$_GET['disable_method']}"]);
  header("Location:".$_SERVER["HTTP_REFERER"]);
  die;
endif;

if(isset($_GET['enable_method'])):
  aw_update_payment_method(["status"=>true],["id"=>"{$_GET['enable_method']}"]);
  header("Location:".$_SERVER["HTTP_REFERER"]);
  die;
endif;

if(isset($_GET['delete_method'])):
  aw_delete_payment_method($_GET['delete_method']);
  aw_delete_payment_method_received_inputs(["payment_method_id"=>$_GET['delete_method']]);
  aw_delete_payment_method_register_inputs(["payment_method_id"=>$_GET['delete_method']]);
  $array_payment_accounts = aw_select_payment_account(false,$_GET['delete_method']);
  if($array_payment_accounts[0]){
          
    foreach($array_payment_accounts as $keym => $method){
      aw_delete_payment_account(["id"=>$method->id]);
      aw_delete_payment_account_metas(["account_id"=>$method->id]);
    }
  }
  header("Location:".$_SERVER["HTTP_REFERER"]);
  die;
endif;

function html_table_payment_methods(){
  $path = $_SERVER['REQUEST_URI'];
  $array_payment_methods = aw_select_payment_method(false,'any');
  $table ='<table class="table table-hover ">
        <thead>
          <tr>
            {dynamicth}
          </tr>
        </thead>
        <tbody>
          {dynamictr}
        </tbody>
      </table>';
        $th = "";
        $tr = "";
        if($array_payment_methods[0]){          

          foreach($array_payment_methods as $keym => $method){
            $method = (array)$method;
            $array = array_keys($method);
            $th = "";
            
            foreach($array as $keyth => $newth){
              if($keyth == 0):
                $th .= '<th>#</th>';
              endif;
              if($newth != "id"):
                  $th  .= '<th>'.$newth.'</th>';
              endif;
            }
            //th actions
            $th  .= '<th>actions</th>';

            $tr .= "<tr>";
            foreach($array as $key => $newth){
              $class= "rounded rounded-circle ";
              if($newth == "status" and $method[$newth] == 1){
                $class .= "bg-success ";
              }
              if($newth == "status" and $method[$newth] == 0){
                $class .= "bg-danger ";
              }
              if($key == 0):
                $tr .= '<th>'.($keym+1).'</th>';
              endif;
              if($newth != "id"){
                $tr .= '<td>'.($newth == "status" ? '<div style="width:10px;height:10px;" class="'.$class.'" ></div> ': $method[$newth]).'</td>';
              }
            }
            //td actions
            $tr .= '<td><a '.($method['status'] ? ' href="'.$path.'&disable_method='.$method['id'].'" title="disable" >disable': ' href="'.$path.'&enable_method='.$method['id'].'" title="enable" >enable').'</a></td>';
            
            $tr .= '<td><a href="'.$path.'&delete_method='.$method['id'].'" title="delete" >delete</a></td>';

            $tr .= "</tr>";
          }
        }
  $table = str_replace("{dynamicth}",$th,$table);
  $table = str_replace("{dynamictr}",$tr,$table);
  return $table;
}
function aw_payment_dashboard(){
  
  $html = '<div class="container">
            {html-form-add-method}
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  {tablemethods}
                </div>
              </div>
            </div>
          </div>';

  $form_add_method = html_form_new_payment_method();
  $html = str_replace("{html-form-add-method}",$form_add_method,$html);
  $table = html_table_payment_methods();
  $html = str_replace("{tablemethods}",$table,$html);
  echo $html;
}