<?php
require 'pages/page_1.php';

function aw_admin_page() {
	wp_register_script('js_cpanel', PATH_IMP_SCRIPT . '/assets/js/scripts_admin.js', '1', true);
	wp_enqueue_script('js_cpanel');
	wp_localize_script( 'js_cpanel', 'aw_rest_api_settigns', array(
		'root' => esc_url_raw( rest_url() ),
		'nonce' => wp_create_nonce( 'aw_wp_rest' )
	) );

	add_menu_page(
		__( 'Custom Menu Title', 'apuestanweb-lang' ),
		'aw settings',
		'manage_options',
		'apuestanweb_theme_setting',
		'func_custon_admin_page',
		get_template_directory_uri(). '/assets/images/icon.webp',
		6
	);
}
function func_custon_admin_page(){ ?>
	<style>
		*{
			margin:0;
			box-sizing:border-box;
		}
		
		.aw_admin_container{
			width:98%;
			background:white;
		}
		.aw_admin_container > nav button{
			padding:5px 10px;
			background-color:orange;
			border:unset;
			cursor:pointer;
		}
		#aw_admin_body > article{
			display:none;
			transition:all .3s ease;
		}
		
		#aw_admin_body .show{
			display:block;
		}
		#aw_admin_body > #aw_page_1{
			display:grid;
			grid-template-columns:repeat(6,1fr);
			gap:3px;
			margin:10px auto;
		}
	</style>
	
	<div class="aw_admin_container" >
		<nav>
			<button id="btn_aw_page_1" >Promos</button>
		</nav>
		<main>
			<section id="aw_admin_body" >
			<!-- Page 1-->
				<article id="aw_page_1">
					<?php aw_cpanel_page_1() ?>
				</article>
			</section>
		</main>
	</div>
	
<?php }
add_action( 'admin_menu', 'aw_admin_page' );