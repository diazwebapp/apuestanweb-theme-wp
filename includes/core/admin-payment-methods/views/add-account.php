<?php
$form_metadata["transferencia"] = '<div class="form-group" >
            <label>Account number</label>
            <input type="number"  required name="account_number"  autocomplete="off"/>
        </div>';
$form_metadata["pago movil"] = '<div class="form-group" >
            <label>Teléfono</label>
            <input type="number"  required name="phone"  autocomplete="tel"/>
        </div>
        <div class="form-group" >
            <label>Codigo del banco</label>
            <input type="number"  required name="bank_code"  autocomplete="off"/>
        </div>';
function add_account($method){
    global $form_metadata;
    $countries = get_countries_json();
    $query_methods = get_payment_methods();
    
    $form_new_account = '<form method="post" class="aw-add-account-form" id="aw-form-add-account" >
                                <div class="form-group" >
                                    <label>Nombre del banco</label>
                                    <input type="text" required name="bank_name" autocmplete="off"/>
                                </div>
                                
                                <input type="hidden" required id="payment_method" name="payment_method" value="'.$method.'"/>
                                
                                <div class="form-group" >
                                    <label>Pais del banco</label>
                                    <input type="text" list="country_list" required name="country_code" value="VE" autocomplete="off"/>
                                    <datalist id="country_list" >{data}</datalist>
                                </div>
                                <div class="form-group" >
                                    <label>dni</label>
                                    <input type="number"  required name="dni"  autocomplete="off"/>
                                </div>
                                <div class="form-group" >
                                    <label>titular</label>
                                    <input type="text"  required name="titular"  autocomplete="off"/>
                                </div>
                                <input type="hidden"  required name="status" value="1" />
                                
                                <div class="form-group" id="form-metadata">
                                    {metadata}
                                </div>

                                <div class="form-group" >
                                    <button type="submit" name="new_payment_method" >Insert</button>
                                </div>
                                
                            </form>
                        ';
                        
    if($method == 'pago movil'): 
        $form_new_account = str_replace("{metadata}",
        $form_metadata["pago movil"],
        $form_new_account);   
                          
    endif;

    $datalist_items = "";
    foreach($countries as $country):
        $datalist_items .= '<option value="'.$country->country_short_name.'" >'.$country->country_name.'</option>';
    endforeach;
    $form_new_account = str_replace("{data}",$datalist_items,$form_new_account);
    return $form_new_account;
}
wp_enqueue_script('admin-js',get_template_directory_uri() . '/assets/js/admin.js');
$data = json_encode($form_metadata);
wp_add_inline_script( 'admin-js', 'const php_form_metadata='.$data, 'before' );