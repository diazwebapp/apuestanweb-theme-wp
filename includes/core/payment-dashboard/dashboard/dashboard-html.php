<?php
include 'form-add-method.php';
function html_table_payment_methods(){
  $array_payment_methods = aw_select_payment_method();
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
        $tr = "";
        if($array_payment_methods[0]){
          $array = array_keys((array)$array_payment_methods[0]);
          foreach($array as $key => $newth){
            if($key == 0):
              $th .= '<th>#</th>';
            endif;
            if($newth != "id"):
                $th  .= '<th>'.$newth.'</th>';
            endif;

          }

          foreach($array_payment_methods as $keym => $method){
            $method = (array)$method;
            $tr .= "<tr>";
            foreach($array as $key => $newth){
              $class= "rounded rounded-circle ";
              if($newth == "status" and $method[$newth] == 1){
                $class .= "bg-success ";
              }
              if($key == 0):
                $tr .= '<th>'.($keym+1).'</th>';
              endif;
              if($newth != "id"){
                $tr .= '<td>'.($newth == "status" ? '<div style="width:10px;height:10px;" class="'.$class.'" ></div> ': $method[$newth]).'</td>';
              }
            }
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
