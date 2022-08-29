<?php

if(!function_exists('aw_bookmaker_location')):
    
    function aw_bookmaker_location(){
        $countries = get_countries_json();
        if(isset($_POST['add_country'])):
            if(!empty($_POST['country_name'])):
                foreach($countries as $country):
                    if($country->country_name == $_POST['country_name']):
                        aw_add_country(["country_name"=>$country->country_name,"country_code"=>$country->country_short_name]);
                    endif;
                endforeach;
            endif;
            
        endif;
        if(isset($_POST['add_bookmaker_to_country'])):
            if(count($_POST["bookmaker_id"]) > 0):
                foreach($_POST["bookmaker_id"] as $id_bk):
                    aw_insert_table_relations_bk_lc(["country_id"=>$_GET['country'],"bookmaker_id"=>$id_bk]);
                endforeach;
            endif;
        endif;
        $path = $_SERVER['REQUEST_URI'];
        $html["panel"] = '<div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="post">
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" autocomplete="false" list="countries_datalist" name="country_name"/>
                            <datalist id="countries_datalist">
                                {countries_datalist_options}
                            </datalist>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="añadir" name="add_country">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="table-responive">
                        <table class="table table-hover ">
                            <thead>
                            <tr>
                                <th>pais</th>
                                <th>codigo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                {listado_paises}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    {edit_view}
                </div>
            </div>
        </div>';
        //CONSULTA DE PAISES DEL JSON
        
        $html["countries_datalist_options"] = '';
        foreach($countries as $country):
            $html["countries_datalist_options"] .= '<option value="'.$country->country_name.'">'.$country->country_name.'</option>';
        endforeach;
        //AÑADIR OPTIONS AL DATALIST HTML
        $html["panel"] = str_replace("{countries_datalist_options}",$html["countries_datalist_options"],$html["panel"]);

        //QUERY DE LA TABLA DE PAISES
        $countries_data = aw_select_countries();
        $html["countries_list_table_body"] = '';
        foreach($countries_data["countries_array"] as $country):
            $html["countries_list_table_body"] .= '<tr>
                <td>'.$country->country_name.'</td>
                <td>'.$country->country_code.'</td>
                <td><a href="'.$path.'&country='.$country->id.'&name='.$country->country_name.'" class="btn btn-primary"><i class="dashicons dashicons-edit"></i></a></td>
            </tr>';
        endforeach;
        //AÑADIR PAISES A LA TABLA HTML
        $html["panel"] = str_replace("{listado_paises}",$html["countries_list_table_body"],$html["panel"]);

        //DETECTAMOS PARAMETROS GET PARA EDITAL UN PAIS
        $html["edit_view"] = "";
        if(isset($_GET['country']) and isset($_GET['name'])):
             
            $bookmakers = aw_select_bookakers();
            $relations = aw_select_table_relations_bk_lc(["country_id"=>$_GET['country']]);
            $related_bookmakers = aw_select_relate_bookakers($_GET['country']);
            $unrelated_bookmakers = aw_select_unrelate_bookakers($_GET['country']);
            $html["edit_view"] = '
            <div class="row">
                <div class="col-12">
                    <h3>'.$_GET['name'].'</h3>
                </div>
                <div class="col-md-6">
                    <form method="post">
                        <div class="form-group">
                            {bookmaker-list-add}
                        </div>
                        <div class="form-group">
                            <input type="submit" name="add_bookmaker_to_country" value="Actualizar">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    {bookmaker-list-view}
                </div>
            </div>
            ';
            $inputs_bk = '';
            
            if(count($unrelated_bookmakers) > 0):
                foreach($unrelated_bookmakers as $bookmaker):
                    $inputs_bk .= '<li><label>'.$bookmaker->post_title.'</label><input name="bookmaker_id[]" type="checkbox" value="'.$bookmaker->ID.'"/></li>';
                endforeach;
            else:
                foreach($related_bookmakers as $bookmaker):
                    $inputs_bk .= '<li><label>'.$bookmaker->post_title.'</label><input name="bookmaker_id[]" type="checkbox" value="'.$bookmaker->ID.'"/></li>';
                endforeach;
            endif;
            $html["edit_view"] = str_replace("{bookmaker-list-add}",$inputs_bk,$html["edit_view"]);

            $list_bk = '';
            foreach($related_bookmakers as $bookmaker):
                $list_bk .= '<li><label>'.$bookmaker->post_title.'</label><input name="bookmaker_id[]" type="checkbox" value="'.$bookmaker->ID.'"/></li>';
            endforeach;
            $html["edit_view"] = str_replace("{bookmaker-list-view}",$list_bk,$html["edit_view"]);                             

        endif;
        $html["panel"] = str_replace("{edit_view}",$html["edit_view"],$html["panel"]);
        echo $html["panel"];
      }
else:
    echo 'aw_bookmaker_location ya existe';
    die;
endif;

function bk_location_panel() {
  add_menu_page(
      __( 'bookmaker location', 'jbetting' ),
      'bookmaker location',
      'manage_options',
      'bookmaker-location' ,
      'aw_bookmaker_location',
      '',
      6
  );
}
add_action( 'admin_menu', 'bk_location_panel' );