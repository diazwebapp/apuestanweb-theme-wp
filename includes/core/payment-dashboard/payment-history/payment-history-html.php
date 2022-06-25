<?php
function generate_history_payment_table(){
  global $wpdb;

  $query = select_payment_history();
  if(isset($_POST["filter_table_history"])){
    $text = false;$data=false;
    
    if(isset($_POST["username"]) and $_POST["username"] != ""){
      $text["key"] = "username";
      $text["value"] = $_POST["username"];
    }
    if(isset($_POST["status"]) and $_POST["status"] != ""){
      $text["key2"] = "status";
      $text["value2"] = $_POST["status"];
    }
    if(isset($_POST["date_1"]) or isset($_POST["date_2"])){

      if( isset($_POST["date_1"]) and !empty($_POST["date_1"]) ){
        $data["key"] = "payment_date";
        $data["value"] = $_POST["date_1"];
      }
  
      if( isset($_POST["date_2"]) and !empty($_POST["date_2"]) and !empty($_POST["date_1"]) ){
        $data["value2"] = $_POST["date_2"];
      }
    }

    $query = select_payment_history($data,$text);
  }

  $table_html = '<table class="table table-hover table-dark" >
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
        $btn_completed = '<span class="dashicons dashicons-yes" title="complete" status="completed" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></span><br/>';
        $btn_pending = '<span class="dashicons dashicons-clock" title="pending" status="pending" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></span><br/>';
        $btn_fail = '<span class="dashicons dashicons-no-alt" title="fail" status="failed" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></span><br/>';
        $btn_trash = '<span class="dashicons dashicons-trash" title="trash" status="trashed" element="'.strval($value->id).'" onClick="change_payment_status(this)" ></span>';
        
        foreach($llaves as $keyth => $th){
          
          if(!is_array($th)){
            $html_td .= '<td>'.$th.'</td>';
            $html_th .= '<th>'.$keyth.'</th>';
          }
          if(is_array($th)){
            foreach ($th as $keyth2 => $thvalue) {
              $html_th .= '<th>'.$thvalue->key.'</th>';
              $html_td .= '<td>'.$thvalue->value.'</td>';
            }
          }
        }
        $html_th .= '<th>Action</th>';
        $html_td .= '<td>
          '.($value->status!='pending' ? $btn_pending:'').'
          '.($value->status!='completed' ? $btn_completed:'').'
          '.($value->status!='failed' ? $btn_fail:'').'
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
  
  $update = update_payment_history($array_data,$array_id);
  if(!is_wp_error( $update )){
    header("Location:".$_SERVER["HTTP_REFERER"]);
    die;
  }
}
function aw_payment_history(){
  $table_payment_history = generate_history_payment_table();
  
    $dashboard = '<main class="container-fluid">
              <h4>'._x("payment history","jbetting").'</h4>
                <div class="col-md-12 mb-2">
                      <h3>Filtrar consulta</h3>
                      <form method="post" class="form-row">
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
                          <label>.</label>
                          <button class="btn btn-primary form-control" name="filter_table_history" >filtrar</button>
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