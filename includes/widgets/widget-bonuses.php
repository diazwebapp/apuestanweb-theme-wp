<?php

class w_bonuses extends WP_Widget {

	function __construct()
    {
        parent::__construct(
            'top_bonuses',
            __('TOP BONUSES', 'jbetting')
        );
    }

	public function widget( $args, $instance ) {
		$title = isset($instance['title']) ? __( $instance['title'], 'jbetting' ) : __( 'TOP bonuses', 'jbetting' );
        $limit = isset($instance['limit']) ? $instance['limit'] : 10;

		
		wp_reset_query();
		$args = array(
			'post_type'      => 'bonus',
			'posts_per_page' => $limit,
		);
		
		$query_bonus = new WP_Query( $args );
		if ( $query_bonus->have_posts() ) {
			echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt_30">
                        <div class="box_header">' . $title . '</div>
                        <div class="box_body">
                        ';
			while ( $query_bonus->have_posts() ):
				$query_bonus->the_post();
				$id = get_the_ID();
				$bk        = get_bookmaker_by_post( $id, ["w"=>69,"h"=>28], ["w"=>100,"h"=>50] );
				
				$link      = carbon_get_post_meta( get_the_ID(), 'link' );
				$short     = carbon_get_post_meta( get_the_ID(), 'short' );
				$summa     = carbon_get_post_meta( get_the_ID(), 'summa' );
				echo '<div class="top_box top_box2">
							<div class="d-flex align-items-center justify-content-between">
								<div class="top_serial">
									<img src="'.$bk['logo'].'" class="img-fluid" alt="'.$bk['name'].'" title="'.$bk['name'].'">
								</div>
								<div class="top_box_content">
									<p>'.$short.'</p>
									<a href="'.$link .'" class="button">'.$summa.'</a>
								</div>
							</div>
						</div>';
			endwhile;
			echo '</div> </div> </div>';
		}


	}

	function update($new_instance, $old_instance){
        // Función de guardado de opciones
        $instance = $old_instance;
        $instance["title"] = strip_tags($new_instance["title"]);
        $instance["limit"] = strip_tags($new_instance["limit"]);
        // Repetimos esto para tantos campos como tengamos en el formulario.
        return $instance;
    }

    function form($instance){
        // Formulario de opciones del Widget, que aparece cuando añadimos el Widget a una Sidebar
        ?>
         <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title del Widget</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">Limit del Widget</label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($instance["limit"]); ?>" />
         </p>
         <?php
    }
}

function register_new_widget2() {
	register_widget( 'w_bonuses' );
}

add_action( 'widgets_init', 'register_new_widget2' );
wp_reset_query();