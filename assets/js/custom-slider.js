document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".slide");
  const slider = document.querySelector(".slider");
  const sliderContainer = document.querySelector(".slider-container");
  const prevBtn = document.querySelector(".prev-btn");
  const nextBtn = document.querySelector(".next-btn");
  let currentSlide = 0;

  // Detecta el tipo de animación según la clase del contenedor principal
  const isTranslateAnimation = sliderContainer.classList.contains("translate-animation");

  // Función para la transición por desplazamiento
  function updateSliderPosition() {
    slider.style.transform = `translateX(-${currentSlide * 100}%)`; // Calcula la posición del slider
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === currentSlide); // Activa la diapositiva actual
    });
  }

  // Determina cuál función usar según la clase
  let updateSlider;
  if (isTranslateAnimation) {
    updateSlider = updateSliderPosition;
  } else {
    console.error("No valid animation class found on slider-container.");
    return; // Detiene el script si no hay clase válida
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length; // Avanza a la siguiente diapositiva
    updateSlider();
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length; // Retrocede a la diapositiva anterior
    updateSlider();
  }

  nextBtn.addEventListener("click", nextSlide); // Controla el botón "Siguiente"
  prevBtn.addEventListener("click", prevSlide); // Controla el botón "Anterior"

  // Cambio automático cada 5 segundos
  setInterval(nextSlide, 5000);

  // Inicializa el primer estilo
  updateSlider();
});
