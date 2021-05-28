<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$casas_apuestas = new wp_query(array(
    "post_type"=>"casaapuesta"
));
?>
<main>
    <section>
        <?php if(have_posts()): ?>
            <div class="casa_apuesta_prew " >
                <?php 
                    echo do_shortcode('[casa_apuesta id="'.$post->ID.'" ]');
                ?>
            </div>
            <article>
                <?php __(the_content(),'apuestanweb-lang') ?>
            </article>
        <?php endif;?>
        
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();