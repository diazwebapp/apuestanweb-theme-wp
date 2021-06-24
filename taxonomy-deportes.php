<?php get_header(); ?>

<main>
	<section>
        <!-- Taxonomy Navegacion -->
		<?php echo do_shortcode('[sportsmenu taxonomy="deportes" term="'.$term.'"]'); ?>
            <?php ?>

            <?php  if($term !=='' && $term){
                echo do_shortcode('[pronosticos deporte='.$term.']');
            } ?>
        
	</section>

    <?php get_sidebar() ?>
</main>
<?php get_footer();