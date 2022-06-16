<?php

include "payment-methods-sql.php";
include 'views/add-account.php';
include 'views/table-accounts.php';
function panel_payment_methods(){
    //form payment accounts
    $countries = get_countries_json();
    $query_methods = get_payment_methods();

    

    //table payment methods
    $list_payment_methods = '<nav class="menu-payment-methods">
                                {data}
                            </nav>';
    
    $list_payment_methods_li = "";
    
    if(count($query_methods) > 0):
        for($key =0; $key<count($query_methods); $key++):
            $list_payment_methods_li .= '<button class="'.($key==0?'active method-item':'method-item').'" id="'.$query_methods[$key]["key"].'" >'.$query_methods[$key]["name"].'</button>';
        endfor;
    endif;
    $list_payment_methods = str_replace("{data}",$list_payment_methods_li,$list_payment_methods);
    $form_new_account = add_account('mobile_payment');
    $table_accounts = print_accounts('mobile_payment');
    $html = '<div id="container-fluid">
                <div class="row mb-3" >
                    <div class="col-md-6" >
                        <h2>Añadir metodos de pago</h2>
                        <form>
                            <div class="form-row" id="type_method">
                                <div class="form-group" >
                                    <label>Type method</label>
                                    <input type="text" name="key" value="bank_transfer" required/>
                                    <datalist>
                                        <option value="bank_transfer" >Bank Transfer</option>
                                        <option value="mobile_payment" >Mobile payment</option>
                                        <option value="digital" >Digital</option>
                                    </datalist>
                                </div>
                            </div>
                            <div>
                                <h3>datos que usará el cliente para realizar un pago</h3>
                                <div><b onClick="aw_add_new_payment_data()" >añadir dato de pago</b></div>
                            </div>
                            <div class="form-row" id="fields-received-paid" >
                                
                                <div class="form-group" >
                                    <label>Banco</label>
                                    <input name="banco" title="banco" id="Escriba en nombre de la entidad bancaria" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-row" id="fields-registred-paid">
                            </div>
                        </form>
                        <template id="fields-received-paid-template" >
                            <div class="form-group" >
                                <label form="" ></label>
                                <input type="text" name="key" required autocomplete="off"/>
                            </div>
                        </template>
                    </div>
                </div>
                '.$list_payment_methods.'
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>add account</h2>
                            <div class="card">
                                '.$form_new_account.'
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h2>Listado de cuentas</h2>
                            <div class="aw-container-table" id="aw-container-table">
                                '.$table_accounts.'
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
  return $html;
}

?>