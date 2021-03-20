<?php 

$casas_apuestas = $wpdb->get_results( 
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='casaapuesta' ")
); 

foreach ($casas_apuestas as $key => $casa_apuesta) { 
    $imagen_url = get_the_post_thumbnail_url($casa_apuesta->ID);
    ?>
    
    <div class="tarjeta_casa_apuesta">
        <div>
            <div class="circle" >
                <img src="<?php echo $imagen_url ?>" />
            </div>
            <div class="rectangle" ><?php echo __('Rango','apuestanweb-lang') ?></div>
        </div>
        <div>
            <b><?php echo $casa_apuesta->post_title ?></b>
            <a class="btn_outline_blue" href="#" >Hacer apuesta</a>
        </div>
    </div>
    <?php } ?>
    
    <?php ?>