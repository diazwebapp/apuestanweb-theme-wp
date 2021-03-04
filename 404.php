<?php
/**
 * The template for displaying the 404 template in the Apuestan web theme.
 *
 * @package WordPress
 * @subpackage Apuestan_web
 * @since Apuestan web 1.0
 */

get_header();
?>

	<div class="section-inner thin error404-content">

		<h1 class="entry-title"><?php _e( 'Page Not Found', 'twentytwenty' ); ?></h1>

		<div class="intro-text"><p><?php _e( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'twentytwenty' ); ?></p></div>


	</div><!-- .section-inner -->

<?php
get_footer();
