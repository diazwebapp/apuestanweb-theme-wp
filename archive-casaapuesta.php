<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 

?>
<main>
    <section>
            <article>
            <?php if(have_posts()):
                    while(have_posts()):
                        the_post() ;

                        echo do_shortcode('[casa_apuesta paginate="'.false.'" model="2" id='.$post->ID.']');
                        
            endwhile; endif;?>

            <div class="container_pagination" >
                <?php echo paginate_links() ?>
            </div>
            </article>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();