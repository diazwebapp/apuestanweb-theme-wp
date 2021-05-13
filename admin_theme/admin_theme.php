<?php
function wpdocs_register_my_custom_menu_page() {
	add_menu_page(
		__( 'Custom Menu Title', 'apuestanweb-lang' ),
		'aw settings',
		'manage_options',
		'custompage',
		'func_custon_admin_page',
		get_template_directory_uri(). '/assets/images/icon2.png',
		6
	);
}
function func_custon_admin_page(){ ?>
	<style>
		*{
			margin:0;
			padding:0;
			box-sizing:border-box;
		}
		:root{
			--shadow-color:grey;
		}
		.aw_admin_container{
			width:98%;
			height:max-content;
			position:relative;
			border-radius:5px;
			padding:10px;
		}
		.aw_admin_container > main{
			position:relative;
		}
		.aw_admin_body{
			position:relative;
		}
		.aw_admin_body > article{
			position:absolute;
			background:white;
			width:100%;
			top:0:left:0;right:0;
		}
		.aw_page_active{
			z-index:3;
		}
		.aw_admin_container_ca{
			display:grid;
			grid-template-columns:1fr;
			gap:10px;
		}
		.aw_admin_container_ca > li{
			border-radius:5px;
			box-shadow:0px 0px 3px var(--shadow-color);
			position:relative;
			display:grid;
			grid-template-columns:1fr;
			gap:10px;
			padding:10px;
		}
		
		@media(min-width:720px){
			.aw_admin_container_ca > li {
				grid-template-columns:1fr 1fr;
			}
		}
		@media(min-width:1280px){
			.aw_admin_container_ca{
				grid-template-columns:repeat(3,1fr);
			}
			.aw_admin_container_ca > li {
				grid-template-columns:1fr ;
			}
		}
		@media(min-width:1600px){
			.aw_admin_container_ca{
				grid-template-columns:repeat(4,1fr);
			}
		}
	</style>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			const primer_article = document.querySelector('.aw_admin_body').querySelector('article')
			primer_article.classList.add('aw_page_active')
		});

		const active = (id_html_element)=>{
			const articles = document.querySelector('.aw_admin_body').querySelectorAll('article')
			articles.forEach(element => {
				element.classList.remove('aw_page_active')
			});
			id_html_element.classList.add('aw_page_active')
			
		}
	</script>
	<div class="aw_admin_container" >
		<nav>
			<button onClick="active(aw_page_1)" >ShortCodes</button>
		</nav>
		<main>
			<section class="aw_admin_body" >
				<article id="aw_page_1">
					<ul class="aw_admin_container_ca">
						<li>
							<span>
								<b>Todas las casas de apuestas</b>
								<p>[t_casa_apuesta_2]</p>
							</span>
							<div>
								<?php echo do_shortcode("[t_casa_apuesta_2 limit=1]"); ?>
							</div>
						</li>
						<li>
							<span>
								<b>Todas las casas de apuestas</b>
								<p>[puntuacion_pronostico]</p>
							</span>
							<div>
								<?php echo do_shortcode("[puntuacion_pronostico]"); ?>
							</div>
						</li>
					</ul>
				</article>
			</section>
		</main>
	</div>
<?php }
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );