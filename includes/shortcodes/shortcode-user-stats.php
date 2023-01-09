<?php
function shortcode_user_stats($atts)
{
    extract(shortcode_atts(array(
        'id' =>  !empty(get_post_field( 'post_author', get_the_ID() )) ? get_post_field( 'post_author', get_the_ID() ) : 0,
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

    $ret = "<div class='single_event_progress_box'>
    <div class='single_event_progress_left'>
        <img src='$avatar' class='img-fluid' alt=''>
        <p>$display_name</p>
        

    </div>";

    $total = $acerted + $failed + $nulled;

    if ($total >= 42) {
    $ret .= "<div>
    <canvas id='myChart' width='300px' height='140px'></canvas>
    </div>";


    echo "<script>
    window.onload = function() {
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: ['Acertados', 'Fallidos', 'Nulos'],
              datasets: [{
                  label: 'Resultados',
                  data: [$acerted, $failed, $nulled],
                  backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56'
                ],
                borderColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56'
                ],
                  borderWidth: 1,
                  fill: false
              }]
          },
          options: {
            responsive: true,
            animation: {
                duration: 500,
                easing: 'easeInOutElastic'
            },
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
      });
    };
    </script>";
}
else{
    $ret .= "<div>Estadisticas no disponibles.</div>";
}
    

    return $ret;
}


add_shortcode('user_stats', 'shortcode_user_stats');
?>
