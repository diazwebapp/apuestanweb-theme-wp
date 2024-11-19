<?php get_header(); ?>
<div id="notfound">
		<div class="notfound">
			<h1><?php echo __('Oops!', 'jbetting') ?></h1>
			<h2><?php echo __('Error 404 : Pagina no encontrada', 'jbetting') ?></h2>
			<a href="/"><?php echo __('Inicio', 'jbetting') ?></a>
            <?php            
                 echo'<div class="apn-social">
                    <span>SIGUENOS</span>
                    <a href="'.tl.'" rel="nofollow noreferrer noopener">
                        <i class="fab fa-telegram-plane"></i>
                    </a>                                                     
                    <a href="'.fb.'" rel="nofollow noreferrer noopener">
                        <i class="fab fa-facebook"></i>
                    </a>                        
                    <a href="'.tw.'" rel="nofollow noreferrer noopener">
                        <i class="fab fa-twitter"></i>
                    </a>                        
                    <a href="'.ig.'" rel="nofollow noreferrer noopener">
                        <i class="fab fa-instagram"></i>
                    </a></div>'
            ?>
		</div>
</div>

<?php get_footer(); ?>
