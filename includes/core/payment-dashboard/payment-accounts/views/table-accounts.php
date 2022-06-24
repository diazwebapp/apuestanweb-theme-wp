<?php
function html_table_payment_accounts(){
  $get_id = isset($_GET['method_page']) ? $_GET['method_page'] : false;
  $array_payment_accounts = aw_select_payment_account(false,$get_id);
  $table ='<table class="table table-hover table-dark">
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
            $tr .= "</tr>";
          }
        }
  $table = str_replace("{dynamicth}",$th,$table);
  $table = str_replace("{dynamictr}",$tr,$table);
  return $table;
}