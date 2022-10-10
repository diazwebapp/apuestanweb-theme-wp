<?php
function shortcode_user_stats($atts)
{
    extract(shortcode_atts(array(
        'id' => 1,
    ), $atts));
    if($id):
        $acerted = get_the_author_meta("forecast_acerted", $id );
        $failed = get_the_author_meta("forecast_failed", $id );
        $nulled = get_the_author_meta("forecast_nulled", $id );
        $rank = get_the_author_meta("rank", $id );
        $display_name = get_the_author_meta("display_name", $id );
        $avatar_url = get_avatar_url($id);
        $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';
        $stats = get_user_stats($id,true);
    endif;
    
    $img_perc = get_template_directory_uri(  ) .'/assets/img/s56.png';
    $fail_gradient = $stats['porcentaje_fallidos'] + $stats['porcentaje_fallidos'];
    $null_gradient = $fail_gradient + $stats['porcentaje_nulos'];
    $ret = "<style>
                .user_graph,.user_graph::before{
                    width:100px;
                    height:100px;
                    background:conic-gradient(#1f78b4 {$stats['porcentaje']}%,#8ed1fc {$stats['porcentaje']}% $fail_gradient%, #b2df8a $fail_gradient% $null_gradient%);
                    position:relative;
                    border-radius:50%;
                }
                .user_graph::before{
                    content:'';
                    left:0;
                    top:0;
                    background:white content-box;
                    position:absolute;
                    padding:10px;
                }
            </style>";
    $ret .= "<div class='single_event_progress_box'>
    <div class='single_event_progress_left'>
        <img src='$avatar' class='img-fluid' alt=''>
        <p>$display_name</p>
    </div>
    <div class='single_event_progress_right'>
        <div class='progress_img'>
            <div class='user_graph'>
            </div> 
            <p>$rank</p>
        </div>
        <div class='progress_percent'>
            <div class='progress_percent_box'>
                <p>Aciertos</p>
                <div class='percent_color text-sm-center'><b>$acerted</b></div>
            </div>
            <div class='progress_percent_box'>
                <p>Fallos</p>
                <div class='percent_color percent_color2 text-sm-center'><b>$failed</b></div>
            </div>
            <div class='progress_percent_box'>
                <p>Nulos</p>
                <div class='percent_color percent_color3 text-sm-center'><b>$nulled</b></div>
            </div>
        </div>
    </div>
</div>";

    return $ret;
}


add_shortcode('user_stats', 'shortcode_user_stats');