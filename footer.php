<?php if(is_active_sidebar('bottom_widget')) :
    dynamic_sidebar('bottom_widget');
endif; ?>
	
		<footer class="aw_footer" >
		
		<?php if(is_active_sidebar('footer_widget')) :
			dynamic_sidebar('footer_widget');
		endif; ?>
		
		<div style="min-width:100%;width:100%;display:block;" ></div>

		<?php if(is_active_sidebar('footer_widget_2')) :
			dynamic_sidebar('footer_widget_2');
		endif; ?>

		<div style="min-width:100%;width:100%;display:block;" ></div>

		<?php if(is_active_sidebar('footer_widget_3')) :
			dynamic_sidebar('footer_widget_3');
		endif; ?>
			
		</footer><!-- #site-footer -->
		<?php wp_footer(); ?>
	</body>
</html>
