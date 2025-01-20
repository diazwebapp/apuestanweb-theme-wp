<?php
function taxonomy_menu($attr){
	extract( shortcode_atts( array( 'model' => 1, 'sport_id' => get_the_ID()), $attr ) );
	
	$children = get_children($sport_id);
	$current_permalink = get_the_permalink(get_the_ID());
	
	$html = '';
	if(count($children) > 0):
		
		if($model == 1): 
					$html = "<div class='header_bottom bg-primary text-center'>
						<div class='container'>
							<ul>";
								foreach($children as $child):
									$title = get_the_title($child->ID);
									$status = get_post_status( $child->ID );
									$permalink = get_the_permalink($child->ID);
									$active = '';
									$parent_id = wp_get_post_parent_id( $child->ID );
									if($permalink == $current_permalink){ $active = 'active'; }
									if($status == 'publish')
										$html .= "<li><a class='$active text-light' href='$permalink'>$title</a></li>";
								endforeach;
					$html .=	"</ul>
						</div>
					</div>";
		endif;
	endif;

	
	return $html;
}

add_shortcode('menu_leagues','taxonomy_menu');