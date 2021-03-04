<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Apuestan_web
 * @since Apuestan web 1.0
 */

?>

</main>
			<footer>

				<div class="container_casas_apuestas" >
					<div>
						<h2>Has tus mejores apuestas y garantiza tu dinero</h2>
						<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, saepe.</p>
					</div>
					<a href="#" >Casas de apuestas</a>

					<div>
						<?php include 'components/casas_apuestas.php' ?>
					</div>
				</div>
			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
