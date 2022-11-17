<?php get_header();

// background
$thumbnail_url = aq_resize(get_the_post_thumbnail_url(get_the_ID()), 600, 350, true, true, true);
$term_page_att = carbon_get_post_meta(get_the_ID(), 'wbg');
if($term_page_att){
    $thumbnail_url = aq_resize(wp_get_attachment_url($term_page_att), 600, 350, true, true, true);
}
if(!$thumbnail_url): $thumbnail_url = get_template_directory_uri( ) . '/assets/img/baner2.png'; endif;
$sidebar=false;
 ?>

	<main>
		<div class="bookmaker_wrapper pb_100">
			<div class="container">
                <div class="row" >
                    <div class="col-lg-9">
                        <?php if(have_posts()){
                            while (have_posts()):the_post();
                                $post_date = get_the_date( "d M h:i a", get_the_ID());
                                $time = carbon_get_post_meta(get_the_ID(), 'data');
                                $title = get_the_title( get_the_ID() ); 
                                $fecha = date('d M', strtotime($time)) .' - '. date('g:i a', strtotime($time));
                                $author_name = get_the_author_meta("display_name" );
                                $author_id =  get_the_author_meta('ID') ;
                                $author_url = PERMALINK_PROFILE.'?profile='.$author_id;
                            ?>
                                    <h1 class="blog_title"><?php echo $title ?></h1>
                                    <p class="mt_30 author_text">Por <a href="<?php echo $author_url ?>"><?php echo $author_name ?></a> <?php echo $post_date ?></p>
                                    <img src="<?php echo $thumbnail_url ?>" class="single_img" alt="<?php echo $title ?>">
                                    <div class="single_event_content text-break">
                                        <?php the_content(); ?>
                                <?php   endwhile; }
                            ?>
                        </div>
                        <?php echo do_shortcode( "[related_posts model='1' num='4' title='Lee también']" )?>
                    </div>
						
                    <div class="col-lg-3">
                        <div class="row">
                            <?php dynamic_sidebar( 'forecast-right' ); ?>
                        </div>				
                    </div>
                </div>
			</div>
		</div>
	</main>
<?php get_footer(); ?>
