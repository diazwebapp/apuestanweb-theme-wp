<?php
if(isset($_GET['account_id']) and isset($_GET['status_account']) and isset($_GET['method_page'])):
  aw_update_payment_account(["status"=>$_GET['status_account']],["id"=>$_GET['account_id'],"payment_method_id"=>$_GET['method_page']]);
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
                
              $tr .= '<td>
                    <a href="'.$path.'&account_id='.$method['id'].'&status_account='.($method['status'] ? 0:1).'" title="'.($method['status'] ? "disable":"enable").'" >
                     '.($method['status'] ? "disable":"enable").
                    '</a>';
              $tr .= '<br/>';
              $tr .= '<a href="'.$path.'&delete_account='.$method['id'].'" title="delete" >delete</a></td>';
              $tr .= "</tr>";
          }
        }
  $table = str_replace("{dynamicth}",$th,$table);
  $table = str_replace("{dynamictr}",$tr,$table);
  return $table;
}