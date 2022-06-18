<?php

function html_form_new_payment_account(){
    $get_id = isset($_GET['method_page']) ? $_GET['method_page'] : false;
    $array_payment_methods = aw_select_payment_method($get_id,1);
    $inputs = [];
    $html_inputs = "";

    if($array_payment_methods[0]){
        $inputs = aw_select_payment_method_received_inputs($array_payment_methods[0]->id);
    }

    if($inputs[0] and !is_wp_error( $inputs )){
        foreach($inputs as $key => $input){
            $ids = str_replace(" ","-",$input->name);
            $html_inputs .= '<div class="form-group" >';
            $html_inputs .= '<label for="'.$ids.'">'.$input->name.'</label>';
            $html_inputs .= '<input id="'.$ids.'" type="'.$input->type.'" name="'.$ids.'" class="form-control" required autocomplete="off"/>';
            $html_inputs .= '</div>';
        }
    }
    $html = '<form>
        <div>

            {dynamicinputs}

            <div class="form-group">
                <button class="btn btn-primary" >Add</button>
            </div>
        </div>
    </form>';
    $html = str_replace("{dynamicinputs}",$html_inputs,$html);
  return $html;
}
