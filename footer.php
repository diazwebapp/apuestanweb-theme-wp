<?php if(is_active_sidebar('bottom_widget')) :
    dynamic_sidebar('bottom_widget');
endif; ?>
	
		<footer class="aw_footer" >
		
		<?php if(is_active_sidebar('footer_widget')) :
			echo '<div class="widget_1" >';
			dynamic_sidebar('footer_widget');
			echo '</div>';
		endif; ?>

		<?php if(is_active_sidebar('footer_widget_2')) :
			echo '<div class="widget_2" >';
			dynamic_sidebar('footer_widget_2');
			echo '</div>';
		endif; ?>

		<?php if(is_active_sidebar('footer_widget_3')) :
			echo '<div class="widget_3" >';
			dynamic_sidebar('footer_widget_3');
			echo '</div>';
		endif; ?>
		

		<?php if(is_active_sidebar('footer_widget_4')) :
			echo '<div class="widget_4" style="border-top:1px solid var(--primary-color);" >';
			dynamic_sidebar('footer_widget_4');
			echo '</div>';
		endif; ?>
			
		</footer><!-- #site-footer -->
		<?php wp_footer(); ?>
	</body>
	<?php
		if(!is_user_logged_in()){ ?>
			<div id="aw_modal_effect" ></div>
			<div style="dispay:none;"  id="aw_modal_login" >
				<?php echo do_shortcode('[aw_form_login]'); ?>
			</div>
		<?php }
	?>
</html>
