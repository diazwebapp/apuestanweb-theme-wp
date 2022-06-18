<?php

function html_form_new_payment_method(){
    
    $html = '<div class="toast" style="position:absolute;z-index:9000;right:0;" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <strong class="mr-auto">Notification</strong>
                </div>
                <div class="toast-body">
                    
                </div>
            </div>
                <div class="row">
                    <form class="col-12 form-row" id="aw-add-payment-method-form" method="post" >
                        
                        <div class="form-group col-md-3">
                            <label>Type method</label>
                            <input type="text" list="list_methods" name="payment_method" class="form-control" value="" required/>
                            <datalist id="list_methods" >
                                
                            </datalist>
                        </div>
                        
                        <div class="form-group col-md-2">
                            <label for="">icon service</label>
                            <input type="text" list="datalist-icons-service" class="form-control" name="icon_service" value="font awesome" required />
                            <datalist>
                                <option value="font awesome" >font awesome</option>
                            </datalist>
                        </div>
                        <div class="form-group col-md-2">
                            <label>icon class</label>
                            <input type="text" name="icon_class" class="form-control" placeholder="fa fa-star" />
                        </div>
                        <div class="form-group col-md-2 pt-3">
                            <div class="custom-control custom-switch mt-4">
                                <input type="checkbox" class="custom-control-input" name="status" id="enabled" checked>
                                <label class="custom-control-label" title="enable" for="enabled"></label>
                            </div>
                        </div>

                        <div class="form-group col-md-6" id="fields-received-paid" >
                            <div class="form-group d-flex justify-content-between" >
                                <h6>datos que usará el cliente para realizar un pago</h6>
                                <b role="button" onClick="aw_add_new_payment_data(this)" class="dashicons dashicons-plus btn-primary" style="border-radius:50%;padding-top:1px;" ></b>
                            </div>
                        </div>
                        <div class="form-group col-md-6" id="fields-register-paid">
                            <div class="form-group d-flex justify-content-between" >
                                <h6>datos que usará el cliente para realizar un pago</h6>
                                <b role="button" onClick="aw_add_new_payment_data(this)" class="dashicons dashicons-plus btn-primary" style="border-radius:50%;padding-top:1px;" ></b>
                            </div>
                        </div>
                        <div class="form-group col-md-2" >
                            <button class="btn btn-primary">Añadir</button>
                        </div>
                    </form>
                </div>
                <template id="fields-received-paid-template" >
                    <div class="form-row form-group inputs" >
                        <div class="form-group col-md-2">
                            <input list="input-data-list" type="text" name="type" class="form-control" required autocomplete="off" placeholder="type" />
                            <datalist id="input-data-list">
                                <option value="text" >texto</option>
                                <option value="email" >email</option>
                                <option value="tel" >phone</option>
                                <option value="url" >url</option>
                                <option value="number" >number</option>
                                <option value="checkbox" >checkbox</option>
                                <option value="date" >date</option>
                            </datalist>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" name="name" required autocomplete="off" class="form-control" placeholder="name"/>
                        </div>
                        <div class="form-group col-md-1">
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" name="show_ui" id="show" checked>
                                <label class="custom-control-label" title="show ui" for="show"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <b role="button" onClick="aw_drop_new_payment_data(this)" style="border-radius:50%;" class="dashicons dashicons-minus btn-danger" ></b>
                        </div>
                    </div>
                </template>
                <template id="fields-register-paid-template" >
                    <div class="form-row form-group inputs" >
                        <div class="form-group col-md-2">
                            <input list="input-data-list" type="text" name="type" class="form-control" required autocomplete="off" placeholder="type" />
                            <datalist id="input-data-list">
                                <option value="text" >texto</option>
                                <option value="email" >email</option>
                                <option value="tel" >phone</option>
                                <option value="url" >url</option>
                                <option value="number" >number</option>
                            </datalist>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" name="name" required autocomplete="off" class="form-control" placeholder="name"/>
                        </div>
                        <div class="form-group col-md-1">
                            <b role="button" onClick="aw_drop_new_payment_data(this)" style="border-radius:50%;" class="dashicons dashicons-minus btn-danger" ></b>
                        </div>
                    </div>
                </template>';
  return $html;
}
