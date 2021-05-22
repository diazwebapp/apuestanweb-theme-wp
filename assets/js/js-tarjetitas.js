window.addEventListener('load',()=>{
    const get_data = async ({term,post_rest_slug,container_tarjetitas,loader,init,current_user=false})=>{
        if(loader) loader.innerHTML = "<b>Loading data....</b>"
        console.log(parseInt(term))
        try{
            const req_posts = await fetch(`/wp-json/wp/v2/${post_rest_slug}?per_page=${parseInt(init) > parseInt(term.count)?term.count:init}&${term.taxonomy}=${term.term_id}`)
            const posts = await req_posts.json()
            
            posts.length > 0 ? posts.map(post=>{
                const div = document.createElement('div')
                div.classList.add('tarjetita_pronostico')
                div.id = post.id
                div.innerHTML = `<h3 class="title_pronostico" >${post.nombre_equipo_1} vs ${post.nombre_equipo_2}</h3>
                                    
                ${post.acceso_pronostico.toString().toLowerCase() == 'vip'?`<b data="${post.acceso_pronostico}" class="sticker_tarjetita" ></b>`:''}
            
            <div class="equipos_pronostico" >
                <div>
                    <img loading="lazy" src="${post.img_equipo_1}" alt="${post.nombre_equipo_1}"/>
                    <p>${post.nombre_equipo_1}</p>  
                </div>
                <div>
                    <p>${post.fecha_partido}</p>
                    <span></span>
                </div>
                <div>
                    <img loading="lazy" src="${post.img_equipo_2}" alt="${post.nombre_equipo_2}"/>   
                    <p>${post.nombre_equipo_2}</p>  
                </div>
            </div>
            <div class="average_pronostico" >
            ${post.acceso_pronostico.toString().toLowerCase() == 'vip' && current_user.ID != 0 ?(
                current_user.roles[0].toString().toLowerCase() == 'administrator' || current_user.roles[0].toString().toLowerCase() == 'vip' ?(
                    `
                <p>${post.average_equipo_1}</p> <p>${post.cuota_empate_pronostico}</p> <p>${post.average_equipo_2}</p>
                
                `  
                ):(
                    '<p></p> <p>lock</p> <p></p>'
                )
            ):post.acceso_pronostico.toString().toLowerCase() == 'vip' && current_user.ID == 0 ?(
                '<p></p> <p>lock</p> <p></p>'
            ):(
                `
                <p>${post.average_equipo_1}</p> <p>${post.cuota_empate_pronostico}</p> <p>${post.average_equipo_2}</p>
                
                `
            )}
            </div>`
    
                let existe = container_tarjetitas.querySelectorAll('.tarjetita_pronostico')
                
                if(existe.length < 1){
                    container_tarjetitas.append(div)
                    return
                }
                if(existe.length > 0){
                    existe.forEach(html=>{
                        if(parseInt(html.id) !== parseInt(div.id)){
                            container_tarjetitas.append(div)
                        }
                        if(parseInt(html.id) == parseInt(div.id)){
                            container_tarjetitas.querySelectorAll('.tarjetita_pronostico').forEach(duplicate=>{
                                if(parseInt(duplicate.id) == parseInt(div.id)){
                                    duplicate.remove()
                                }
                            })
                        }
                    })
                }
             
            if(loader) loader.innerHTML = ""   
            }): loader? loader.innerHTML = "No data fetch":null
        }catch(err){
            loader? loader.innerHTML = err:console.log(err)
        }
    }
    function create(params_object,i){
        let termid, term, scroll, delimiter,loader
        
        if(params_object.container_tarjetitas[i] != undefined){
            termid = params_object.container_tarjetitas[i].attributes.termid.textContent
            term = params_object.terms.find(term => parseInt(term.term_id) == parseInt(termid))
            scroll = document.documentElement.scrollTop + window.innerHeight
            delimiter = params_object.delimiter[i].offsetTop
            loader = params_object.delimiter[i]            
        }
        
        return {termid, term, scroll, delimiter, loader}
    }   
    const initial_set=async(params_object)=>{
        
        for(let i=0; i < params_object.terms.length;i++){
            const {term,loader,delimiter} = create(params_object,i)
            
            if(term != undefined || term != false){  
                let exist = params_object.init.find(term => term.term_id == term.term_id)
                if(!exist){
                    params_object.init.push({term,limit:1})
                    if(delimiter <= window.innerHeight){
                        params_object.init[i].limit++
                    }
                    if(parseInt(term.count) >= params_object.init[i].limit){
                        
                        get_data({...params_object,
                            term,
                            container_tarjetitas:params_object.container_tarjetitas[i],
                            delimiter:loader,
                            init:params_object.init[i].limit
                        })
                    }
                }
                if(exist){
                    
                }
            }
        }
        
    }
    const scroll_pagination = async(params_object)=>{
        
        let block = []
        var lastScrollTop = 0;
        
        var st = window.pageYOffset || document.documentElement.scrollTop; 
        if (st > lastScrollTop){
            //scroll hacia abajo
            for(let i=0;i < params_object.terms.length; i++){
                
                const {term,loader,scroll,delimiter} = create(params_object,i)
                
                if(term != undefined || term != false){
                    block[i] = false
                    let exist = params_object.init.find(term => term.term_id == term.term_id)
                    if(!exist){
                        params_object.init.push({term,limit:1})
                    }
                    if(exist){
                        params_object.init[i] ={...exist,limit:exist.limit+1}
                    
                        if(scroll > delimiter &&  !block[i]){
                            block = true
                            
                            
                            if(parseInt(term.count) >= exist.limit){
                                setTimeout(()=>{ 
                                    
                                    get_data({...params_object,
                                        term:term,
                                        container_tarjetitas:params_object.container_tarjetitas[i],
                                        delimiter:loader,
                                        init:params_object.init[i].limit
                                    })
                                    block = false
                                }, 2000)
                            }
                        }
                    }
                }
            }
        } 
        lastScrollTop = st;
    }
    if(taxonomy_data){

        const params_object = {
            terms:Array.isArray(taxonomy_data.terms)?taxonomy_data.terms:Object.values(taxonomy_data.terms),
            post_rest_slug: taxonomy_data.post_rest_slug,
            container_tarjetitas:document.querySelectorAll(`.${taxonomy_data.class_container_tarjetitas}`),
            delimiter:document.querySelectorAll(`.${taxonomy_data.class_delimiter}`),
            init:[],
            current_user: taxonomy_data.current_user,
        }
        initial_set(params_object)
        document.addEventListener('scroll',()=>{scroll_pagination(params_object)}
        )
    }
})