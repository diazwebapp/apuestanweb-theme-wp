<?php
function taxonomy_menu($attr){
	extract( shortcode_atts( array( 'model' => 1, 'sport_id' => get_the_ID()), $attr ) );
	if (!is_page()) { return ''; }
	$children = get_children(array( 'post_parent' => $sport_id, 'post_type' => 'page', 'orderby' => 'title', 'order' => 'ASC', ));
	$current_permalink = get_the_permalink(get_the_ID());
	
	$html = '';
	if(count($children) > 0):
		
		if($model == 1): 
					$html = "<div class='header_bottom bg-primary text-center'>
						<div class='container'>
							<ul>";
								foreach($children as $child):
									$title = get_the_title($child->ID);
									$permalink = get_the_permalink($child->ID);
									$active = '';
									if($permalink == $current_permalink){ $active = 'active'; }
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