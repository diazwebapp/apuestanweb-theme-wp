<?php
add_action("admin_init",function(){
    if(isset($_GET['delete-country'])):
        $deleted = aw_delete_country($_GET['delete-country']);
        header("Location:".$_SERVER["HTTP_REFERER"]);
        die;
    endif;

    if(isset($_GET['delete-bookmaker']) && isset($_GET['country'])){
        $deleted = aw_delete_relations_bk_lc($_GET['country'],$_GET['delete-bookmaker']);
        header("Location:".$_SERVER["HTTP_REFERER"]);
        die;
    }

    if(isset($_GET['delete-bookmaker-onpage'])){
        $deleted = aw_delete_bookmaker_onpage($_GET['country'],$_GET['delete-bookmaker-onpage']);
        header("Location:".$_SERVER["HTTP_REFERER"]);
        die;
    }
} );
if(!function_exists('aw_bookmaker_location')):
    
    function aw_bookmaker_location(){
        $path = $_SERVER['REQUEST_URI'];
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
        if(isset($_POST['add_bookmaker_to_country']) and count($_POST["bookmaker_id"]) > 0):
            if(isset($_POST['onpage']) and count($_POST['onpage']) > 0):
                    foreach($_POST["bookmaker_id"] as $id_bk):
                        $rs = array_search($id_bk,$_POST['onpage']); 
                        if( is_numeric($rs) ):
                            aw_insert_table_relations_bk_lc(["country_id"=>$_GET['country'],"bookmaker_id"=>$id_bk,"on_page"=>true]);
                        else:
                            aw_insert_table_relations_bk_lc(["country_id"=>$_GET['country'],"bookmaker_id"=>$id_bk]);
                        endif;
                endforeach;
            endif;
            if(!isset($_POST['onpage'])):
                foreach($_POST["bookmaker_id"] as $id_bk):
                    aw_insert_table_relations_bk_lc(["country_id"=>$_GET['country'],"bookmaker_id"=>$id_bk]);
            endforeach;
        endif;
        endif;
        $html["panel"] = '<div class="container pt-2">
            <div class="row">
                <div class="col-lg-4">
                    <form method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Paises para añadir</label>
                            </div>
                            <select name="country_name" class="custom-select" id="inputGroupSelect01">
                                <option selected>Choose...</option>
                                {countries_datalist_options}
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="añadir" name="add_country">
                        </div>
                    </form>

                    <div class="table-responive" style="max-height:400px;overflow:auto;">
                        <table class="table table-sm table-hover" style="max-height:400px;">
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
                    <div>                        
                        {btn_cargar_mas}
                    </div>
                </div>
                <div class="col-lg-8">
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

        $per_page = 10;
        //QUERY DE LA TABLA DE PAISES
        $countries_data = aw_select_countries(isset($_GET['limit']) ? $_GET['limit'] : $per_page);
        //BOTON DE CARGAR MAS REGISTROS
        $link_cargar_mas = '';
        if($countries_data['current_countries'] < $countries_data['total_countries']){
            $link_cargar_mas = '<a href="'.$path.'&limit='.$per_page.'" class="btn btn-primary">Más</a>';
            if(isset($_GET['limit'])){
                $path = str_replace("&limit={$_GET['limit']}","",$path);
                $next = (($_GET['limit'] + $per_page) > $countries_data['total_countries'] ? $countries_data['total_countries'] : $_GET['limit'] + $per_page);
                $link_cargar_mas = '<a href="'.$path.'&limit='.$next.'" class="btn btn-primary">Más</a>';                        
            }
        }
        
        $html["panel"] = str_replace("{btn_cargar_mas}",$link_cargar_mas,$html["panel"]);

        //AÑADIENDO LOS PAISES A LA TABLA HTML
        $html["countries_list_table_body"] = '';
        foreach($countries_data["countries_array"] as $country):
            $html["countries_list_table_body"] .= '<tr>
                <td>'.$country->country_name.'</td>
                <td>'.$country->country_code.'</td>
                <td>
                    <a href="'.$path.'&country='.$country->id.'&name='.$country->country_name.'" class="btn btn-primary"><i class="dashicons dashicons-edit"></i></a>
                    <a href="'.$path.'&delete-country='.$country->id.'" class="btn btn-primary"><i class="dashicons dashicons-trash"></i></a>
                </td>
            </tr>';
        endforeach;
        //AÑADIR PAISES A LA TABLA HTML
        $html["panel"] = str_replace("{listado_paises}",$html["countries_list_table_body"],$html["panel"]);

        //DETECTAMOS PARAMETROS GET PARA EDITAL UN PAIS
        $html["edit_view"] = "";
        if(isset($_GET['country']) and isset($_GET['name'])):
             
            $relations = aw_select_table_relations_bk_lc(["country_id"=>$_GET['country']]);
            $related_bookmakers = aw_select_relate_bookakers($_GET['country']);
            $unrelated_bookmakers = aw_select_unrelate_bookakers($_GET['country']);
            $html["edit_view"] = '
            <div class="row">
                <div class="col-12">
                    <h3>'.$_GET['name'].'</h3>
                </div>
                <div class="col-md-6" style="max-height:800px;overflow:auto;">
                    <h4>Por añadir</h4>
                    <form method="post">
                        <div class="form-group">
                            {bookmaker-list-add}
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="add_bookmaker_to_country" value="Añadir">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4>Añadidos</h4>
                    {bookmaker-list-view}
                </div>
            </div>
            ';
            $inputs_bk = '';
            
            if(count($unrelated_bookmakers) > 0):
                foreach($unrelated_bookmakers as $bookmaker):
                    $inputs_bk .= '<div>
                    <label class="mr-3" for="input_bk">'.$bookmaker->post_title.'</label>
                    <input name="bookmaker_id[]" type="checkbox" id="input_bk" value="'.$bookmaker->ID.'"/>
                    <label class="mr-3" for="input_bk">on page</label>
                    <input name="onpage[]" type="checkbox" id="input_bk" value="'.$bookmaker->ID.'"/>
                    </div>';
                endforeach;
            endif;
            $html["edit_view"] = str_replace("{bookmaker-list-add}",$inputs_bk,$html["edit_view"]);

            $list_bk = '';
            foreach($related_bookmakers as $bookmaker):
                $onpage = aw_detect_bookmaker_onpage($bookmaker->ID);
                var_dump($onpage);
                $list_bk .= '<div>
                        <label class="mr-3">'.$bookmaker->post_title.'</label>
                        <a class="mr-3 text-danger" href="'.$path.'&delete-bookmaker='.$bookmaker->ID.'"><i class="dashicons dashicons-trash"></i></a>

                        <label class="mr-3">on page</label>
                        <a class="mr-3 '.(isset($onpage) ?'text-danger':'').'" href="'.$path.'&delete-bookmaker-onpage='.$bookmaker->ID.'"><i class="dashicons dashicons-admin-page"></i></a>
                    </div>';
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