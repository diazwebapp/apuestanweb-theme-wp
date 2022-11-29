<?php

function generate_history_payment_table(){
  global $wpdb;
  $params["status"] = "completed";
  if(isset($_GET["status"])){
    $params["status"] = $_GET["status"];
  }
  if(isset($_POST["filter_table_history"])){
    
    if(isset($_POST["username"]) and $_POST["username"] != ""){
      $params["username"] = $_POST["username"];
    }
    
    
    /*
    if(isset($_POST["date_1"]) or isset($_POST["date_2"])){

      if( isset($_POST["date_1"]) and !empty($_POST["date_1"]) ){
        $data["key"] = "payment_date";
        $data["value"] = $_POST["date_1"];
      }
  
      if( isset($_POST["date_2"]) and !empty($_POST["date_2"]) and !empty($_POST["date_1"]) ){
        $data["value2"] = $_POST["date_2"];
      }
    } */

    
  }
  var_dump($params);
  $query = select_payment_history($params);
  $table_html = '<table class="table table-hover " >
      <thead>
        <tr>
          {thead_data}
        </tr>
      </thead>
      <tbody>
        {tbody_data}
      </tbody> 
  </table>';

  $table_data["thead"] = '{theaddata}';
  $table_data["tbody"] = '';
    $html_th = "";
    $html_td;
    if(!is_wp_error( $query ) and count($query) > 0):
      foreach ($query as $key => $value) {
        $llaves = get_object_vars($value);
        $keys = array_keys($llaves);
        $table_data["tbody"] .= '<tr>';
        $html_th = "";
        $html_td = "";
        //botones de accion
        $btn_completed = '<i role="button" style="margin:0 5px;" class="dashicons dashicons-yes" title="complete" status="completed" username="'.$value->username.'" lid="'.$value->membership_id.'" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></i>';
        $btn_pending = '<i role="button" style="margin:0 5px;" class="dashicons dashicons-clock" title="pending" status="pending" username="'.$value->username.'" lid="'.$value->membership_id.'" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></i>';
        $btn_fail = '<i role="button" style="margin:0 5px;" class="dashicons dashicons-no-alt" title="fail" status="failed" username="'.$value->username.'" lid="'.$value->membership_id.'" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></i>';
        $btn_trash = '<i role="button" style="margin:0 5px;" class="dashicons dashicons-trash" title="trash" status="trashed" username="'.$value->username.'" lid="'.$value->membership_id.'" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></i>';
        
        foreach($llaves as $keyth => $th){
          
          if(!is_array($th)){
            if($keyth!=='payment_account_id'):
              $user_link = '<a href="?page=ihc_manage&tab=user-details&uid={iduser}" >{username}</a>';
              if($keyth=='username'):
                $id_user = username_exists( $th );
                $user_link = str_replace("{username}",$th,$user_link);
                $user_link = str_replace("{iduser}",$id_user,$user_link);
              endif;
              $html_th .= '<th>'.$keyth.'</th>';
              $html_td .= '<td>'.($keyth=="username"?$user_link:$th).'</td>';
            endif;
          }
          if(is_array($th)){
            foreach ($th as $keyth2 => $thvalue) {
              $html_th .= '<th>'.$thvalue->meta_key.'</th>';
              $html_td .= '<td>'.$thvalue->meta_value.'</td>';
            }
          }
        }
        $html_th .= '<th colspan="2" >Action</th>';
        $html_td .= '<td colspan="2">
          '.($value->status!='pending' ? $btn_pending:'').'
          '.($value->status!='completed' ? $btn_completed:'').'
          '.($value->status!='failed' ? $btn_fail:'').'
          '.$btn_trash.'
        </td>';
        $table_data["tbody"] .= $html_td;
        $table_data["tbody"] .= '</tr>';
      }
    
    endif;
    $table_data["thead"] = str_replace("{theaddata}",$html_th,$table_data["thead"]);

    $table_html = str_replace("{thead_data}",$table_data["thead"],$table_html);
    $table_html = str_replace("{tbody_data}",$table_data["tbody"],$table_html);
    return $table_html;
}


if(isset($_GET["update_payment_history_id"]) and isset($_GET["status"])){
  $array_id['id'] = $_GET["update_payment_history_id"];
  $array_data["status"] = $_GET["status"];
  $activate_send_data["username"] = $_GET["username"];
  $activate_send_data["lid"] = $_GET["lid"];
  $activate_sql_params = aw_generate_activation_membership_data($activate_send_data);
  $activated = aw_activate_membership($activate_sql_params);
  if(!is_wp_error( $activated )){
    $update = update_payment_history($array_data,$array_id);
    header("Location:".$_SERVER["HTTP_REFERER"]);
    die;
  }
  header("Location:".$_SERVER["HTTP_REFERER"]."&error=1");
}
function aw_payment_history(){
  $path = $_SERVER['REQUEST_URI'] ."&status=";
  $table_payment_history = generate_history_payment_table();
  $payment_method_navbar = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
                              <div class="container-fluid">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                  <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                  <ul class="navbar-nav me-auto">
                                    <li class="nav-item"><a class="nav-link" href="'.$path.'pending">pending</a></li>
                                    <li class="nav-item"><a class="nav-link" href="'.$path.'completed">completed</a></li>
                                    <li class="nav-item"><a class="nav-link" href="'.$path.'trashed">trashed</a></li>
                                    <li class="nav-item"><a class="nav-link" href="'.$path.'failed">failed</a></li>
                                  </ul>
                                </div>
                              </div>
                            </nav>';
    $dashboard = '<main class="container-fluid">
    '.$payment_method_navbar.'
              <h4>'._x("payment history","jbetting").'</h4>
                <div class="col-md-12 mb-2">
                      <h3>Filtrar consulta</h3>
                      <form method="post" class="row">
                        <div class="col" >
                          <label>Username</label>
                          <input type="text" name="username" class="form-control" />
                        </div>
                        <div class="col" >
                          <label>Status</label>
                          <input type="text" list="status_list" name="status" class="form-control" autocomplete="off" />
                          <datalist id="status_list">
                            <option value="completed" selected ></option>
                            <option value="pending" ></option>
                            <option value="failed" ></option>
                            <option value="trashed" ></option>
                          </datalist>
                        </div>
                        <div class="col" >
                          <label>Date start</label>
                          <input type="date" name="date_1" class="form-control"/>
                        </div>
                        <div class="col" >
                          <label>Date end</label>                        
                          <input type="date" name="date_2" class="form-control"/>
                        </div>
                        <div class="col" >
                          <button class="btn btn-primary mt-4" name="filter_table_history" >filtrar</button>
                        </div>
                      </form>
                </div>
                <div class="col-md-12" >
                  <div class="table-responsive" >
                    '.$table_payment_history.'
                  </div>
                </div>
              
        </main>';
    echo $dashboard ;
}
