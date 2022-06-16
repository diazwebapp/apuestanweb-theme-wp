<?php
$form_metadata["bank_transfer"] = '<div class="form-group" >
<label>Account number</label>
<input class="form-control" type="number"  required name="account number"  autocomplete="off"/>
</div>';
$form_metadata["mobile_payment"] = '<div class="form-group" >
<label>Teléfono <small>incluyed area code example ve: +58414000000</small></label>
<input class="form-control" type="text"  required name="phone"  autocomplete="tel"/>
</div>
<div class="form-group" >
<label>Codigo del banco</label>
<input class="form-control" type="number"  required name="bank code"  autocomplete="off"/>
</div>';
$form_metadata["binance"] = '<div class="form-group" >
<label>Username</label>
<input class="form-control" type="text"  required name="username"  autocomplete="username"/>
</div>
<div class="form-group" >
<label>binance pay</label>
<input class="form-control" type="text"  required name="binace pay"  autocomplete="off"/>
</div>
<div class="form-group" >
<label>binance email</label>
<input class="form-control" type="email"  required name="binace email"  autocomplete="email"/>
</div>';
$form_metadata["airtm"] = '<div class="form-group" >
<label>Username</label>
<input class="form-control" type="text"  required name="username"  autocomplete="username"/>
</div>
<div class="form-group" >
<label>airtm email</label>
<input class="form-control" type="email"  required name="airtm email"  autocomplete="email"/>
</div>';
function add_account($method){
    global $form_metadata;
    $countries = get_countries_json();
    $query_methods = get_payment_methods();
    
    $form_new_account = '<form method="post" id="aw-form-add-account" class="form">
                                <div class="form-group" >
                                    <label>Nombre del banco</label>
                                    <input class="form-control" type="text" required name="bank_name" autocmplete="off"/>
                                </div>
                                
                                <input type="hidden" required id="payment_method" name="payment_method" value="'.$method.'"/>
                                
                                <div class="form-group" >
                                    <label>Pais del banco</label>
                                    <input class="form-control" type="text" list="country_list" required name="country_code" value="VE" autocomplete="off"/>
                                    <datalist id="country_list" >{data}</datalist>
                                </div>
                                <div class="form-group" >
                                    <label>Document type</label>
                                    <input id="list_dni" class="form-control" type="text"  required name="type_dni" value="V"  autocomplete="off"/>
                                    <datalist id="list_dni">
                
                                        <option value="E">E</option>
                                    
                                        <option value="V" selected>V</option>
                                    
                                        <option value="J">J</option>
                                    
                                        <option value="G">G</option>
                                    
                                    </datalist>
                                </div>
                                <div class="form-group" >
                                    <label>dni</label>
                                    <input class="form-control" type="number"  required name="dni"  autocomplete="off"/>
                                </div>
                                <div class="form-group" >
                                    <label>titular</label>
                                    <input class="form-control" type="text"  required name="titular"  autocomplete="off"/>
                                </div>
                                <input class="form-control" type="hidden"  required name="status" value="1" />
                                
                                <div class="form-group" id="form-metadata">
                                    {metadata}
                                </div>

                                <div class="form-group" >
                                    <button type="submit" class="btn btn-primary form-control" name="new_payment_method" >Insert</button>
                                </div>
                                
                            </form>
                        ';
                        
    if($method == 'mobile_payment'): 
        $form_new_account = str_replace("{metadata}",
        $form_metadata["mobile_payment"],
        $form_new_account);   
                          
    endif;

    $datalist_items = "";
    foreach($countries as $country):
        $datalist_items .= '<option value="'.$country->country_short_name.'" >'.$country->country_name.'</option>';
    endforeach;
    $form_new_account = str_replace("{data}",$datalist_items,$form_new_account);
    return $form_new_account;
}

add_action( 'admin_enqueue_scripts', function(){
    global $form_metadata;
    wp_enqueue_script('admin-js',get_template_directory_uri() . '/assets/js/admin.js');
    $data = json_encode($form_metadata);
    wp_add_inline_script( 'admin-js', 'const php_form_metadata='.$data, 'before' );
} );