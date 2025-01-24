<?php get_header();

$sidebar=false;

$geolocation = json_decode($_SESSION["geolocation"]);

 ?>

	<main>
		<div class="bookmaker_wrapper pb_100">
			<div class="container">
                <div class="row" >
                    <div class="col-lg-9">
                        <?php if(have_posts()){
                            while (have_posts()):the_post();
                                $post_date = get_the_date( "Y-m-d H:i:s", get_the_ID());
                                $date = new DateTime($post_date);
                                $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));

                                $fecha = date_i18n('F j, Y', strtotime($date->format("F j, Y")));
                                $hora = date('g:i a', strtotime($date->format('g:i a')));

                                $title = get_the_title( get_the_ID() ); 
                                
                                $author_name = get_the_author_meta("display_name" );
                                $author_id =  get_the_author_meta('ID') ;
                                
                                $avatar_url = get_the_author_meta( 'profile_image',$curauth->ID );
                                $avatar = aq_resize($avatar_url,40,40,true,true,true);
                                if (!$avatar) { $avatar = get_template_directory_uri() . '/assets/img/user-svgrepo-com.svg'; }
                            ?>
                                    <h1 class="title"><?php echo $title ?></h1>
                                    <section class="post-author-section">
                                    
                                        <div class="d-flex align-items-center my-3">
                                            <img width="40" height="40" src="<?php echo $avatar ?>" class="rounded-circle bg-dark" alt="foto <?php echo $author_name ?>">
                                            <div class="ml-3">
                                                <div class="text-capitalize d-block" ><?php the_author_posts_link(); ?></div>
                                                <time datetime="<?php echo $post_date ?>" ><?php echo __("Publicado: $fecha $hora"); ?></time>
                                            </div>
                                        </div>
                                    

                                        <div class="row">
                                            <div class="col-sm-12">
                                                
                                                <?php
                                                    if (has_post_thumbnail()) {
                                                        the_post_thumbnail('large',['class' => 'img-fluid, post-featured-img']);
                                                        
                                                        } else {
                                                            ?>
                                                            <div class="caption">
                                                                Esta publicación no tiene imagen destacada.
                                                            </div>
                                                            <?php
                                                        }

                                                    ?>
                                                <hr class="mt-2 mb-3">
                                            </div>
                                        </div>
                                </section>
                                    <div class="post-content single_event_content text-break">
                                    <?php the_content(); ?>
                            <?php  endwhile; }?>
                                        <div class="container text-center my-4">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink( $post->ID )); ?>" aria-label="Share to facebook" class="mx-5" rel="nofollow noreferrer noopener" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" fill="#00203A">
    <path d="M17.525,9H14V7c0-1.032,0.084-1.682,1.563-1.682h1.868v-3.18C16.522,2.044,15.608,1.998,14.693,2 C11.98,2,10,3.657,10,6.699V9H7v4l3-0.001V22h4v-9.003l3.066-0.001L17.525,9z"></path>
</svg></a>
                                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink( $post->ID )); ?>&text=<?php echo urlencode(get_the_title( $post->ID )); ?>" aria-label="Share to twiiter" class="mx-5" rel="nofollow noreferrer noopener" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#00203A">
  <path d="M22.46 6.004c-.77.343-1.596.57-2.465.675.886-.531 1.565-1.371 1.88-2.372-.831.49-1.755.847-2.734 1.04-.785-.837-1.904-1.36-3.145-1.36-2.38 0-4.312 1.923-4.312 4.291 0 .334.041.66.115.974C7.691 9.134 4.067 7.343 1.64 4.345c-.37.638-.578 1.381-.578 2.18 0 1.506.769 2.835 1.932 3.615-.714-.022-1.387-.215-1.975-.54-.001.018-.001.036-.001.054 0 2.105 1.498 3.86 3.483 4.26-.364.1-.75.156-1.147.156-.281 0-.554-.026-.822-.078.556 1.732 2.164 2.993 4.073 3.026-1.491 1.166-3.377 1.864-5.419 1.864-.353 0-.7-.019-1.043-.061 1.933 1.24 4.23 1.965 6.702 1.965 8.035 0 12.433-6.56 12.433-12.246 0-.187-.004-.374-.014-.56.856-.617 1.6-1.39 2.188-2.27z"/>
</svg></a>
                                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_permalink( $post->ID )); ?>" aria-label="Share to whatsapp"  class="mx-5" rel="nofollow noreferrer noopener" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24px" height="24px" viewBox="0,0,256,256">
<g fill="#00203a" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.69047,0 -23,10.30953 -23,23c0,4.0791 1.11869,7.88588 2.98438,11.20898l-2.94727,10.52148c-0.09582,0.34262 -0.00241,0.71035 0.24531,0.96571c0.24772,0.25536 0.61244,0.35989 0.95781,0.27452l10.9707,-2.71875c3.22369,1.72098 6.88165,2.74805 10.78906,2.74805c12.69047,0 23,-10.30953 23,-23c0,-12.69047 -10.30953,-23 -23,-23zM25,4c11.60953,0 21,9.39047 21,21c0,11.60953 -9.39047,21 -21,21c-3.72198,0 -7.20788,-0.97037 -10.23828,-2.66602c-0.22164,-0.12385 -0.48208,-0.15876 -0.72852,-0.09766l-9.60742,2.38086l2.57617,-9.19141c0.07449,-0.26248 0.03851,-0.54399 -0.09961,-0.7793c-1.84166,-3.12289 -2.90234,-6.75638 -2.90234,-10.64648c0,-11.60953 9.39047,-21 21,-21zM16.64258,13c-0.64104,0 -1.55653,0.23849 -2.30859,1.04883c-0.45172,0.48672 -2.33398,2.32068 -2.33398,5.54492c0,3.36152 2.33139,6.2621 2.61328,6.63477h0.00195v0.00195c-0.02674,-0.03514 0.3578,0.52172 0.87109,1.18945c0.5133,0.66773 1.23108,1.54472 2.13281,2.49414c1.80347,1.89885 4.33914,4.09336 7.48633,5.43555c1.44932,0.61717 2.59271,0.98981 3.45898,1.26172c1.60539,0.5041 3.06762,0.42747 4.16602,0.26563c0.82216,-0.12108 1.72641,-0.51584 2.62109,-1.08203c0.89469,-0.56619 1.77153,-1.2702 2.1582,-2.33984c0.27701,-0.76683 0.41783,-1.47548 0.46875,-2.05859c0.02546,-0.29156 0.02869,-0.54888 0.00977,-0.78711c-0.01897,-0.23823 0.0013,-0.42071 -0.2207,-0.78516c-0.46557,-0.76441 -0.99283,-0.78437 -1.54297,-1.05664c-0.30567,-0.15128 -1.17595,-0.57625 -2.04883,-0.99219c-0.8719,-0.41547 -1.62686,-0.78344 -2.0918,-0.94922c-0.29375,-0.10568 -0.65243,-0.25782 -1.16992,-0.19922c-0.51749,0.0586 -1.0286,0.43198 -1.32617,0.87305c-0.28205,0.41807 -1.4175,1.75835 -1.76367,2.15234c-0.0046,-0.0028 0.02544,0.01104 -0.11133,-0.05664c-0.42813,-0.21189 -0.95173,-0.39205 -1.72656,-0.80078c-0.77483,-0.40873 -1.74407,-1.01229 -2.80469,-1.94727v-0.00195c-1.57861,-1.38975 -2.68437,-3.1346 -3.0332,-3.7207c0.0235,-0.02796 -0.00279,0.0059 0.04687,-0.04297l0.00195,-0.00195c0.35652,-0.35115 0.67247,-0.77056 0.93945,-1.07812c0.37854,-0.43609 0.54559,-0.82052 0.72656,-1.17969c0.36067,-0.71583 0.15985,-1.50352 -0.04883,-1.91797v-0.00195c0.01441,0.02867 -0.11288,-0.25219 -0.25,-0.57617c-0.13751,-0.32491 -0.31279,-0.74613 -0.5,-1.19531c-0.37442,-0.89836 -0.79243,-1.90595 -1.04102,-2.49609v-0.00195c-0.29285,-0.69513 -0.68904,-1.1959 -1.20703,-1.4375c-0.51799,-0.2416 -0.97563,-0.17291 -0.99414,-0.17383h-0.00195c-0.36964,-0.01705 -0.77527,-0.02148 -1.17773,-0.02148zM16.64258,15c0.38554,0 0.76564,0.0047 1.08398,0.01953c0.32749,0.01632 0.30712,0.01766 0.24414,-0.01172c-0.06399,-0.02984 0.02283,-0.03953 0.20898,0.40234c0.24341,0.57785 0.66348,1.58909 1.03906,2.49023c0.18779,0.45057 0.36354,0.87343 0.50391,1.20508c0.14036,0.33165 0.21642,0.51683 0.30469,0.69336v0.00195l0.00195,0.00195c0.08654,0.17075 0.07889,0.06143 0.04883,0.12109c-0.21103,0.41883 -0.23966,0.52166 -0.45312,0.76758c-0.32502,0.37443 -0.65655,0.792 -0.83203,0.96484c-0.15353,0.15082 -0.43055,0.38578 -0.60352,0.8457c-0.17323,0.46063 -0.09238,1.09262 0.18555,1.56445c0.37003,0.62819 1.58941,2.6129 3.48438,4.28125c1.19338,1.05202 2.30519,1.74828 3.19336,2.2168c0.88817,0.46852 1.61157,0.74215 1.77344,0.82227c0.38438,0.19023 0.80448,0.33795 1.29297,0.2793c0.48849,-0.05865 0.90964,-0.35504 1.17773,-0.6582l0.00195,-0.00195c0.3568,-0.40451 1.41702,-1.61513 1.92578,-2.36133c0.02156,0.0076 0.0145,0.0017 0.18359,0.0625v0.00195h0.00195c0.0772,0.02749 1.04413,0.46028 1.90625,0.87109c0.86212,0.41081 1.73716,0.8378 2.02148,0.97852c0.41033,0.20308 0.60422,0.33529 0.6543,0.33594c0.00338,0.08798 0.0068,0.18333 -0.00586,0.32813c-0.03507,0.40164 -0.14243,0.95757 -0.35742,1.55273c-0.10532,0.29136 -0.65389,0.89227 -1.3457,1.33008c-0.69181,0.43781 -1.53386,0.74705 -1.8457,0.79297c-0.9376,0.13815 -2.05083,0.18859 -3.27344,-0.19531c-0.84773,-0.26609 -1.90476,-0.61053 -3.27344,-1.19336c-2.77581,-1.18381 -5.13503,-3.19825 -6.82031,-4.97266c-0.84264,-0.8872 -1.51775,-1.71309 -1.99805,-2.33789c-0.4794,-0.62364 -0.68874,-0.94816 -0.86328,-1.17773l-0.00195,-0.00195c-0.30983,-0.40973 -2.20703,-3.04868 -2.20703,-5.42578c0,-2.51576 1.1685,-3.50231 1.80078,-4.18359c0.33194,-0.35766 0.69484,-0.41016 0.8418,-0.41016z"></path></g></g>
</svg></a>
                                            <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink( $post->ID )); ?>" aria-label="Share to instagram"  class="mx-5" rel="nofollow noreferrer noopener" target="_blank"><svg fill="#00203A" width="24px" height="24px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
  <path d="M231.25586,31.73635a15.9634,15.9634,0,0,0-16.29-2.76758L30.40869,101.47365a15.99988,15.99988,0,0,0,2.7124,30.58106L80,141.43069V199.9844a15.99415,15.99415,0,0,0,27.31348,11.31347L133.25684,185.355l39.376,34.65088a15.86863,15.86863,0,0,0,10.51709,4.00293,16.15674,16.15674,0,0,0,4.96338-.78711,15.86491,15.86491,0,0,0,10.68457-11.65332L236.41162,47.43557A15.96073,15.96073,0,0,0,231.25586,31.73635ZM183.20215,207.99416,100.81006,135.4883l118.64453-85.687Z"/>
</svg></a>
                                        </div>
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
