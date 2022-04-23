<?php
$params = get_query_var('params');

    //menu
    $html['menubar'] = '<ul class="nav nav-pills" id="pills-tab">{menuitems}</ul>';
    $html['tmp_menu_bar'] = '';
    //cuerpo desktop
    $html['cardbody'] = "<div class='price_box_wrapper'>{bodyitems}</div>";
    $html['tmp_body_items'] = '';
    //cuerpo mobile
    $html['cardbodymobile'] = "<div class='tab-content' id='pills-tabContent'>{bodyitemsmobile}</div>";
    $html['tmp_body_items_mobile'] = '';
    if(count($params['memberships']) == 0):
        return;
    endif;
    $count = 0;
    
    foreach($params['memberships'] as $id => $level):
        $button_label = '';
        $currency = !empty(get_option( 'ihc_custom_currency_code', true )) ? get_option( 'ihc_custom_currency_code', true ) : get_option( 'ihc_currency', true );
        if(isset($level['button_label']) && $level['button_label'] != ''){
            $button_label = $level['button_label'];
        }
        $count++;
        $table = $wpdb->prefix."ihc_memberships";
        global $wpdb;
        $level_meta = $wpdb->get_row("SELECT payment_type, short_description, label, price FROM $table WHERE id=$id");
        
        $html['tmp_menu_bar'] .= '<li class="nav-item">
                    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-'."{$id}".'">'.ihc_correct_text($level['label']).'</a>
                </li>';
        $html['tmp_body_items'] .= "<div class='price_box price_box$count'>
                                        <h5>".ihc_correct_text($level['label'])."</h5>
                                        <p class='price'>".$currency. ihc_correct_text($level['price']) ."</p>
                                        <div class='box_p'>                                        
                                            <p>". ihc_correct_text($level['description']) ."</p>
                                        </div>
                                        <div class='price_btn'>
                                            <button class='btn w-100' lid='".$id."' type='".$level_meta->payment_type."' onClick='aw_detect_user_level(this)' dest='".$params['register_url']."?lid=".$id."' >".$button_label."</buton>
                                        </div>
                            </div>";
        $html['tmp_body_items_mobile'] .= "<div class='tab-pane fade' id='pills-$id'>
                                            <div class='price_box price_box1'>
                                                <h5>".ihc_correct_text($level['label'])."</h5>
                                                <div class='box_p'>
                                                    <p>". ihc_correct_text($level['description']) ."</p>
                                                </div>
                                                <div class='price_btn'>
                                                    <button class='btn w-100' lid='".$id."' type='".$level_meta->payment_type."' onClick='aw_detect_user_level(this)' dest='".$params['register_url']."?lid=".$id."' >".$button_label."</button>
                                                </div>
                                            </div>
                                        </div>";
    endforeach;
    $html['menubar'] = str_replace('{menuitems}',$html['tmp_menu_bar'],$html['menubar']);
    $html['cardbody'] = str_replace('{bodyitems}',$html['tmp_body_items'],$html['cardbody']);
    $html['cardbodymobile'] = str_replace('{bodyitemsmobile}',$html['tmp_body_items_mobile'],$html['cardbodymobile']);
    
$logo =  get_template_directory_uri().'/assets/img/logo.svg';
if ( carbon_get_theme_option( 'logo' ) ):
    $logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
endif;

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
            ".$html['menubar']."
        </div>
        <div class='col-lg-12 d-md-none d-block'>
            ".$html['cardbodymobile']."
        </div>
    </div>
    <div class='d-md-block d-none'>        
        ".$html['cardbody']."
    </div>  
</div>
</div>";
echo "<script>
    document.addEventListener('DOMContentLoaded',()=>{
        let nav_link = document.querySelectorAll('#pills-home-tab')
        let items = document.querySelector('#pills-tabContent')
        if(nav_link.length > 0){
            nav_link[0].classList.add('active')
        }
        if(items){
            let childs = items.querySelectorAll('div.tab-pane')
            if(childs.length > 0){
                childs[0].classList.add('active')
                childs[0].classList.add('show')
            }
        }
    })
</script>";
