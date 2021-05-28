
let indice = 1;
window.addEventListener('load',()=>{
    let slides = document.getElementsByClassName('miSlider')
    let atras = document.getElementById('atras')
    let adelante = document.getElementById('adelante')

    muestraSlides(indice,slides);

    setInterval(function tiempo(){
        muestraSlides(indice+=1,slides)
            if(indice > slides.length){
                indice = 1;
            }
    },5000);


    if(adelante && atras){
        adelante.addEventListener('click',()=>{
            avanzaSlide(slides,1)
        })
        atras.addEventListener('click',()=>{
            avanzaSlide(slides,-1)
        })
    }
    
    function muestraSlides(indice,slides){
        let i;

        
        if(indice > slides.length){
            indice = 1;
        }
        if(indice < 1){
            indice = slides.length;
        }
        for(i = 0; i < slides.length; i++){
            slides[i].style.display = 'none';
        }
       
        slides[indice-1].style.display = 'block';
      
    }
    
    function avanzaSlide(slides,param){
        let newIndice = indice+=param
        muestraSlides( newIndice,slides,param );
    }
   //===
// VARIABLES
//===

// DOM for render
const SLIDE_ITEMS = document.querySelectorAll('.slide_item_pronostico_top');

//===
// FUNCTIONS
//===

/**
 * Method that updates the countdown and the sample
 */
function updateCountdown(html_element) {
    const INPUT_DATE = html_element.querySelector('#date_slide');
    const SPAN_DAYS = html_element.querySelector('#slide_dias');
    const SPAN_HOURS = html_element.querySelector('#slide_horas');
    const SPAN_MINUTES = html_element.querySelector('#slide_minutos');
    const SPAN_SECONDS = html_element.querySelector('#slide_segundos');

    const DATE_TARGET = new Date(INPUT_DATE.value);

    // Milliseconds for the calculations
    const MILLISECONDS_OF_A_SECOND = 1000;
    const MILLISECONDS_OF_A_MINUTE = MILLISECONDS_OF_A_SECOND * 60;
    const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;
    const MILLISECONDS_OF_A_DAY = MILLISECONDS_OF_A_HOUR * 24

    // Calcs
    const NOW = new Date()
    const DURATION = DATE_TARGET - NOW;
    const REMAINING_DAYS = Math.floor(DURATION / MILLISECONDS_OF_A_DAY);
    const REMAINING_HOURS = Math.floor((DURATION % MILLISECONDS_OF_A_DAY) / MILLISECONDS_OF_A_HOUR);
    const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
    const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MILLISECONDS_OF_A_SECOND);
    

    // Render
    SPAN_DAYS.textContent = REMAINING_DAYS+': ';
    SPAN_HOURS.textContent = REMAINING_HOURS+': ';
    SPAN_MINUTES.textContent = REMAINING_MINUTES+': ';
    SPAN_SECONDS.textContent = REMAINING_SECONDS;
}

//===
// INIT
//===

SLIDE_ITEMS.forEach(item=>{
    setInterval(()=>{
        updateCountdown(item)
    },1000)
})
// Refresh every second
})

