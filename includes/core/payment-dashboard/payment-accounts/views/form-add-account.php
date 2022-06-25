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
            $html_inputs .= '<input id="'.$ids.'" type="'.$input->type.'" name="'.$input->name.'" class="form-control dynamic-input" required autocomplete="off"/>';
            $html_inputs .= '</div>';
        }
    }
    //input country_code
    $country_array = get_countries_json();
    
    $option_datalist = "";
    
    foreach($country_array as $key => $country){
        $option_datalist .= '<option value="'.$country->country_short_name.'">'.$country->country_name.'</option>';
    }
    $html = '<form method="post" id="aw-form-add-account">
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="">payment method</label>
                    <input readonly type="text" name="payment_method_name" required value="'.$array_payment_methods[0]->payment_method.'" class="form-control"/>                
                </div>

                <div class="form-group col-6">
                    <label>status</label>
                    <div class="custom-control custom-switch ">
                        <input type="checkbox" class="custom-control-input" name="status" id="enabled" checked>
                        <label class="custom-control-label" title="enable" for="enabled"></label>
                    </div>              
                </div>
            </div>

            <div class="form-group">
                <label for="">country</label>
                <input type="text" name="country_code" required value="VE" list="country_datalist" class="form-control"/>
                <datalist id="country_datalist" >{optioncountry}</datalist>
            </div>
            
            <input type="hidden" name="payment_method_id" required value="'.$array_payment_methods[0]->id.'" />
                
            {dynamicinputs}

            <div class="form-group">
                <button class="btn btn-primary" >Add</button>
            </div>
        
    </form>';
    $html = str_replace("{optioncountry}",$option_datalist,$html);
    $html = str_replace("{dynamicinputs}",$html_inputs,$html);
  return $html;
}
