<?php get_header();
$args['post_type'] = 'post';
$args['posts_per_page'] = 1;
$args['paged'] = 1;
$query_home = new Wp_Query($args);
$h1 = '';
$permalink = '';
$thumb = '';
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
if($query_home->have_posts()):
    while($query_home->have_posts()):
        $query_home->the_post();
        $h1 = get_the_title(get_the_ID());
        $permalink = get_the_permalink(get_the_ID());
        $thumb = get_the_post_thumbnail_url(get_the_ID());
    endwhile;
endif;


?>

<main>
<div class="container slider-container translate-animation py-4">
  <div class="slider-wrapper bg-primary text-white rounded shadow position-relative overflow-hidden">
    <div class="slider d-flex position-relative">
      <!-- Slide 1 -->
      <div class="slide active d-flex flex-column flex-md-row align-items-center p-4 w-100">
        <div class="left-content text-center text-md-left d-flex flex-column align-items-center align-items-md-start flex-shrink-0">
          <p class="small text-uppercase font-weight-bold mb-3">Enfrentamiento</p>
          <div class="logos d-flex align-items-center justify-content-center mb-3">
            <div class="team-logo bg-white rounded-circle d-flex justify-content-center align-items-center p-3 mx-2">
              <img src="MiamiMarlins.svg" alt="Miami Marlins" class="img-fluid">
            </div>
            <div class="team-logo bg-white rounded-circle d-flex justify-content-center align-items-center p-3 mx-2">
              <img src="AtlantaBraves.svg" alt="Atlanta Braves" class="img-fluid">
            </div>
          </div>
          <button class="btn btn-outline-light btn-sm">Ver pronóstico</button>
        </div>
        <div class="right-content d-flex flex-column align-items-center align-items-md-start ml-md-4">
          <h3 class="match-title font-weight-bold mb-2">Miami Marlins <span class="font-weight-normal">VS</span> Atlanta Braves</h3>
          <p class="match-time mb-3">22 Abr 1:20 pm</p>
          <div class="odds d-flex">
            <span class="badge badge-light p-2 mx-1">2.9</span>
            <span class="badge badge-secondary p-2 mx-1">n/a</span>
            <span class="badge badge-light p-2 mx-1">1.41</span>
          </div>
        </div>
      </div>
      <!-- Slide 2 -->
      <div class="slide d-flex flex-column flex-md-row align-items-center p-4 w-100">
        <div class="left-content text-center text-md-left d-flex flex-column align-items-center align-items-md-start flex-shrink-0">
          <p class="small text-uppercase font-weight-bold mb-3">Enfrentamiento</p>
          <div class="logos d-flex align-items-center justify-content-center mb-3">
            <div class="team-logo bg-white rounded-circle d-flex justify-content-center align-items-center p-3 mx-2">
              <img src="MiamiMarlins.svg" alt="Miami Marlins" class="img-fluid">
            </div>
            <div class="team-logo bg-white rounded-circle d-flex justify-content-center align-items-center p-3 mx-2">
              <img src="AtlantaBraves.svg" alt="Atlanta Braves" class="img-fluid">
            </div>
          </div>
          <button class="btn btn-outline-light btn-sm">Ver pronóstico</button>
        </div>
        <div class="right-content d-flex flex-column align-items-center align-items-md-start ml-md-4">
          <h3 class="match-title font-weight-bold mb-2">Example Match <span class="font-weight-normal">VS</span> Another Team</h3>
          <p class="match-time mb-3">22 Abr 4:00 pm</p>
          <div class="odds d-flex">
            <span class="badge badge-light p-2 mx-1">3.2</span>
            <span class="badge badge-secondary p-2 mx-1">n/a</span>
            <span class="badge badge-light p-2 mx-1">1.50</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Botones de navegación -->
    <button class="prev-btn btn btn-dark position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%);">&lt;</button>
    <button class="next-btn btn btn-dark position-absolute" style="top: 50%; right: 15px; transform: translateY(-50%);">&gt;</button>
  </div>
  <!-- Controles de desplazamiento -->
  <div class="slider-controls d-flex justify-content-center mt-3"></div>
</div>

<style>
 /* Slider Container */
.slider-container {
  max-width: 1024px; /* Limita el ancho máximo del slider */
  margin: 0 auto; /* Centra el slider horizontalmente */
  overflow: hidden; /* Asegura que no haya desbordamiento visible */
}

/* Wrapper (Background del slider) */
.slider-wrapper {
  background: linear-gradient(to right, #0072ff, #ff002f); /* Degradado azul a rojo */
  padding: 20px;
  border-radius: 15px;
  position: relative;
  overflow: hidden; /* Oculta cualquier contenido desbordado */
}

/* Slider */
.slider {
  display: flex;
  transition: transform 0.8s ease-in-out;
  width: 100%; /* Se ajusta al ancho del contenedor */
}

/* Cada slide ocupa exactamente el 100% del contenedor */
.slide {
  flex: 0 0 100%; /* Cada slide tiene el ancho completo del contenedor */
  max-width: 100%; /* Evita desbordamientos */
  box-sizing: border-box; /* Incluye el padding en el cálculo del ancho */
}

/* Botones de navegación */
.prev-btn,
.next-btn {
  z-index: 10;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
  border: none;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}

.prev-btn {
  left: 15px;
}

.next-btn {
  right: 15px;
}

.prev-btn:hover,
.next-btn:hover {
  background-color: black;
}

/* Logos dentro de las diapositivas */
.team-logo img {
  width: 50px;
  height: 50px;
  object-fit: cover;
}

.team-logo {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
/* Indicadores */
.slider-controls {
  display: flex;
  gap: 10px;
}

.slider-controls .dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.5);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.slider-controls .dot.active {
  background-color: rgba(255, 255, 255, 1);
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".slide");
  const slider = document.querySelector(".slider");
  const sliderControls = document.querySelector(".slider-controls");
  const prevBtn = document.querySelector(".prev-btn");
  const nextBtn = document.querySelector(".next-btn");
  let currentSlide = 0;

  // Función para actualizar la posición del slider
  function updateSliderPosition() {
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    updateActiveDot();
  }

  // Generar controles de desplazamiento automáticamente
  slides.forEach((_, index) => {
    const dot = document.createElement("div");
    dot.classList.add("dot");
    if (index === 0) dot.classList.add("active");
    dot.addEventListener("click", () => {
      currentSlide = index;
      updateSliderPosition();
    });
    sliderControls.appendChild(dot);
  });

  // Actualizar el indicador activo
  function updateActiveDot() {
    const dots = document.querySelectorAll(".dot");
    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === currentSlide);
    });
  }

  // Funcionalidad de los botones de navegación
  nextBtn.addEventListener("click", () => {
    currentSlide = (currentSlide + 1) % slides.length;
    updateSliderPosition();
  });

  prevBtn.addEventListener("click", () => {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    updateSliderPosition();
  });

  // Inicializar la posición del slider
  updateSliderPosition();
});

</script>
    <div class="blog_hero_area">
        <div class="container">
            <div class="blog_bg" style="background-image: url(<?php echo $thumb ?>);">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog_hero_content">
                            <div class="blog_top_content">
                                <img src="<?php echo $alt_logo ?>" class="img-fluid" alt="icon-apuestan">
                                <p>Blog &amp; Noticias</p>
                            </div>
                            <h2><?php echo $h1 ?></h2>
                            <div class="blog_hero_btn">
                                <a href="<?php echo $permalink ?>" class="btn_2">Leer Articulo</a>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="blog_box_wrapper">
        <div class="container">
            <?php 
                echo do_shortcode("[blog filter='yes' title='Lo más reciente']"); 
            ?>
        </div>
    </div>
</main>

<?php get_footer();?>