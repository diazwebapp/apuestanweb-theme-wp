// aw_rest_api_settigns variable que viene de php
window.addEventListener('load',()=>{
    
    // logica del cpanel
    const ventanas={
      ventana_1:{
        buton:btn_aw_page_1,
        page:aw_page_1,
        create_promo_form:create_promo_form,
        prev:prev_shortcode
      }
    }
    
    if(ventanas.ventana_1.page){
      active_page(ventanas.ventana_1.page)
      //Formulario para crear las promos
      ventanas.ventana_1.create_promo_form.addEventListener('submit',async(e)=>{
          e.preventDefault()
          const promo = {}
          //se obtienen todos los inputs
          const inputs = ventanas.ventana_1.create_promo_form.querySelectorAll('input')
          const button = ventanas.ventana_1.create_promo_form.querySelector('button')
          for(input of inputs){
            if(input.value == ''){
              return alert('campo '+input.name+' vacio')
            }
            promo[input.name] = input.value
          }
          button.disabled = true
          const {status,msg} = await create_promo({body:promo})
          button.disabled = false
          if(status=='error'){
            return alert('Error '+msg)
          }
          const {promos} = await get_promos()
          render_items({items:promos})
      })
      //selecciona los inputs para recrear la vista previa
      const inputs = ventanas.ventana_1.create_promo_form.querySelectorAll('input')
      //se les añade el evento keyup para tener un prev de lo que se está escribiendo
      for(input of inputs){
        input.addEventListener('keyup',(e)=>{          
          render_prev({input:e.target,html_element:ventanas.ventana_1.prev})
        })
        input.addEventListener('change',(e)=>{          
          render_prev({input:e.target,html_element:ventanas.ventana_1.prev})
        })
      }
      (async()=>{
        const {promos} = await get_promos()
        render_items({items:promos})
      })()
    }
});

//methods
const active_page = (page)=>{
  const articles = document.querySelector('#aw_admin_body').querySelectorAll('article')
  articles.forEach(element => {
    element.classList.remove('show')
  });
  page.classList.add('show')
}
const render_prev = ({input,html_element})=>{
  const title_texts = html_element.querySelectorAll('.title_promo b')
  const list_item = html_element.querySelector('.list_pronosticos .list_item_pronostico')
  if(input.name == 'post_title'){
    title_texts[0].textContent = input.value
  }

  if(input.name == 'title_color'){
    title_texts[0].style.color = input.value
  }
  
  if(input.name == 'background_color'){
    html_element.style.backgroundColor = input.value
  }
  if(input.name == 'list_item_border_color'){
    list_item.style.borderBottom = '2px solid '+input.value
  }
}
const render_items = ({items})=>{
  const tbody_promos = document.querySelector("#aw_cpanel_tabla_promos tbody")
  const template_body_promos = document.getElementById("template_body_promos").content  
  const fragment = document.createDocumentFragment()
  tbody_promos.innerHTML = ''
  for(let i=0;i<items.length;i++){
    template_body_promos.querySelector('tr').id = items[i].ID
    template_body_promos.querySelector('tr .id').textContent = items[i].ID
    template_body_promos.querySelector('tr .titulo').textContent = items[i].post_title
    template_body_promos.querySelector('tr .status').textContent = items[i].post_status

    const clone = template_body_promos.cloneNode(true)
    fragment.appendChild(clone)
  }
  tbody_promos.appendChild(fragment)
}
const aw_activate_item = async(e)=>{
  const id = e.parentElement.parentElement.id
  e.textContent = '...'
  e.disabled = true
  const {status,msg} = await activate_promo({id})
  
  if(status=='error' || !status){
    return  alert(msg)
  }
  const {promos} = await get_promos()
 
  render_items({items:promos})
}
const aw_delete_item = async(e)=>{
  const id = e.parentElement.parentElement.id
  e.textContent = '...'
  e.disabled = true
  const {status,msg} = await delete_promo({id})
  console.log(status,msg)
  if(status=='error' || !status){
    return  alert(msg)
  }
  const {promos} = await get_promos()
 
  render_items({items:promos})
}
// HTTP METHODS
const create_promo = async({body})=>{
  try {
    const req = await fetch(`${aw_rest_api_settigns.root}aw_rest_api/v1/create_promo`,{
      method:'post',
      body:JSON.stringify(body)
    })
    return await req.json()
  } catch (error) {
    console.error(error)
  }
}
const get_promos = async()=>{
  try {
    const req = await fetch(`${aw_rest_api_settigns.root}aw_rest_api/v1/get_promos`)
    return await req.json()
  } catch (error) {
    console.error(error)
  }
}
const activate_promo = async({id})=>{
  try {
    const req = await fetch(`${aw_rest_api_settigns.root}aw_rest_api/v1/activate_promo`,{
      method:'PUT',
      body:JSON.stringify({id})
    })
    return await req.json()
  } catch (error) {
    console.error(error)
  }
}
const delete_promo = async({id})=>{
  try {
    const req = await fetch(`${aw_rest_api_settigns.root}aw_rest_api/v1/delete_promo`,{
      method:'DELETE',
      body:JSON.stringify({id})
    })
    return await req.json()
  } catch (error) {
    console.error(error)
  }
}