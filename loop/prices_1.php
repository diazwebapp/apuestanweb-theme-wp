<?php
$params = get_query_var('params');
function get_memberships(){
    global $wpdb;
    $memberships = $wpdb->get_results("select * from {$wpdb->prefix}ihc_memberships");
    //menu
    $html['menubar'] = '<ul class="nav nav-pills" id="pills-tab">{menuitems}</ul>';
    $html['tmp_menu_bar'] = '';
    //cuerpo desktop
    $html['cardbody'] = "<div class='price_box_wrapper'>{bodyitems}</div>";
    $html['tmp_body_items'] = '';
    //cuerpo mobile
    $html['cardbodymobile'] = "<div class='tab-content' id='pills-tabContent'>{bodyitemsmobile}</div>";
    $html['tmp_body_items_mobile'] = '';
    if(count($memberships) == 0):
        return;
    endif;
    $count = 0;
    foreach($memberships as $key => $value):
        $query_membership_metas = $wpdb->get_results("select meta_key,meta_value from {$wpdb->prefix}ihc_memberships_meta where membership_id={$value->id}");
        $membership_metas['button_label'] = '';
        foreach($query_membership_metas as $key => $metas):
            if($metas->meta_key == 'button_label'):
                $membership_metas['button_label'] = $metas->meta_value;
            endif;
        endforeach;
        $count++;
        $html['tmp_menu_bar'] .= '<li class="nav-item">
                    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-'."{$value->name}".'">'.$value->label.'</a>
                </li>';
        $html['tmp_body_items'] .= "<div class='price_box price_box$count'>
                                        <h5>$value->label</h5>
                                        <p class='price'>$value->price</p>
                                        <div class='box_p'>
                                            <p>$value->short_description</p>
                                        </div>
                                        <div class='price_btn'>
                                            <a href='$value->name' class='button'>{$membership_metas['button_label']}</a>
                                        </div>
                            </div>";
        $html['tmp_body_items_mobile'] .= "<div class='tab-pane fade' id='pills-$value->name'>
                                            <div class='price_box price_box1'>
                                                <h5>$value->label</h5>
                                                <p class='price'>$value->price</p>
                                                <div class='box_p'>
                                                    <p>$value->short_description</p>
                                                </div>
                                                <div class='price_btn'>
                                                    <a href='$value->name' class='button'>{$membership_metas['button_label']}</a>
                                                </div>
                                            </div>
                                        </div>";
    endforeach;
    $html['menubar'] = str_replace('{menuitems}',$html['tmp_menu_bar'],$html['menubar']);
    $html['cardbody'] = str_replace('{bodyitems}',$html['tmp_body_items'],$html['cardbody']);
    $html['cardbodymobile'] = str_replace('{bodyitemsmobile}',$html['tmp_body_items_mobile'],$html['cardbodymobile']);
    return $html;
}

$logo =  get_template_directory_uri().'/assets/img/logo.svg';
if ( carbon_get_theme_option( 'logo' ) ):
    $logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
endif;

$menuitems = get_memberships();

echo "<div class='price_wrapper'>
<div class='container'>
    <div class='row justify-content-between'>
        <div class='col-lg-12'>
            <div class='price_heading'>
                <img src='$logo' class='img-fluid' alt=''>
                <h2>{$params['slogan']}</h2>
            </div>
        </div>
        <div class='col-lg-12 d-md-none d-block'>
            ".$menuitems['menubar']."
        </div>
        <div class='col-lg-12 d-md-none d-block'>
            ".$menuitems['cardbodymobile']."
        </div>
    </div>
    <div class='d-md-block d-none'>        
        ".$menuitems['cardbody']."
    </div>  
</div>
</div>";
