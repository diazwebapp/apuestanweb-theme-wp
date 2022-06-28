<?php
if(isset($_GET['disable_account'])):
  aw_update_payment_account(["status"=>false],["id"=>"{$_GET['disable_account']}"]);
  header("Location:".$_SERVER["HTTP_REFERER"]);
  die;
endif;

if(isset($_GET['enable_account'])):
  aw_update_payment_account(["status"=>true],["id"=>"{$_GET['enable_account']}"]);
  header("Location:".$_SERVER["HTTP_REFERER"]);
  die;
endif;

if(isset($_GET['delete_account'])):
  
  aw_delete_payment_account(["id"=>$_GET['delete_account']]);
  aw_delete_payment_account_metas(["account_id"=>$_GET['delete_account']]);
    
  header("Location:".$_SERVER["HTTP_REFERER"]);
  die;
endif;

function html_table_payment_accounts($method_id=false){
  $path = $_SERVER['REQUEST_URI'];
  $get_id = isset($_GET['method_page']) ? $_GET['method_page'] : $method_id;
  $array_payment_accounts = [];
  $array_payment_accounts = aw_select_payment_account(false,'any',$get_id);

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
        $thmetas = "";
        $tr = "";
        if($array_payment_accounts[0]){
          
          foreach($array_payment_accounts as $keym => $method){
            $th = "";
            $thmetas = "";
            $method = (array)$method;
            $metas = aw_select_payment_account_metas($method["id"]);
            $array = array_keys($method);
            foreach($array as $keyth => $newth){
              if($keyth == 0):
                $th .= '<th>#</th>';
              endif;
              if($newth == "status"):
                  $th  .= '<th>'.$newth.'</th>';
              endif;
  
            }
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
                    if($newth == "status"){
                      $tr .= '<td>'.($newth == "status" ? '<div style="width:10px;height:10px;" class="'.$class.'" ></div> ': $method[$newth]).'</td>';
                    }
                }

                foreach($metas as $keymeta => $meta){
                    $tr .= '<td>'.$meta->value.'</td>';
                    $th .= '<th>'.$meta->key.'</th>';
                }
                //td actions
              $tr .= '<td><a '.($method['status'] ? ' href="'.$path.'&disable_account='.$method['id'].'" title="disable" > disable': ' href="'.$path.'&enable_account='.$method['id'].'" title="enable" >enable').'</a>';
              $tr .= '<br/>';
              $tr .= '<a href="'.$path.'&delete_account='.$method['id'].'" title="delete" >delete</a></td>';
              $tr .= "</tr>";
          }
        }
  $table = str_replace("{dynamicth}",$th,$table);
  $table = str_replace("{dynamictr}",$tr,$table);
  return $table;
}