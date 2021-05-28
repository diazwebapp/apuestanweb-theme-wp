window.addEventListener('load',()=>{
    const create_tarjetita = (post,model,current_user,user)=>{
        const div = document.createElement('a')
        div.setAttribute('href',post.link)
        div.classList.add(model)
        div.id = post.id
        
        if(model == 'tarjetita_pronostico_1'){
            div.innerHTML = `<h3 class="title_pronostico" >${post.nombre_equipo_1} vs ${post.nombre_equipo_2}</h3>
                                
            ${post.acceso_pronostico.toString().toLowerCase() == 'vip'?`<b data="${post.acceso_pronostico}" class="sticker_tarjetita" ></b>`:''}
        
            <div class="equipos_pronostico" >
                <div>
                    <img loading="lazy" src="${post.img_equipo_1}" alt="${post.nombre_equipo_1}"/>
                    <p>${post.nombre_equipo_1}</p>  
                </div>
                <div>
                    <p>${post.fecha_partido}</p>
                    <span>${post.hora_partido}</span>
                </div>
                <div>
                    <img loading="lazy" src="${post.img_equipo_2}" alt="${post.nombre_equipo_2}"/>   
                    <p>${post.nombre_equipo_2}</p>  
                </div>
            </div>
            <div class="average_pronostico" >
           
                <p>${post.average_equipo_1}</p> <p>${post.cuota_empate_pronostico}</p> <p>${post.average_equipo_2}</p>
                
            </div>`
        }
        if(model == 'tarjetita_pronostico_2'){
            div.innerHTML = `
           
                <div>
                    <b>${post.hora_partido}</b>
                    <div>
                        
                        <img loading="lazy" src="${post.img_equipo_1}" alt="${post.nombre_equipo_1}"/>
                    
                        <img loading="lazy" src="${post.img_equipo_2}" alt="${post.nombre_equipo_2}"/>
                        
                    </div>
                </div>
                <div>
                    <b>${post.nombre_equipo_1} vs ${post.nombre_equipo_2}</b>
                    <small>${post.eleccion} </small>
                </div>
                <div>
                    <b>${post.acceso_pronostico}</b>
                    <a href="${post.link}" >Ver</a>
                </div>
            
            `
        }
        if(model == 'tarjetita_pronostico_vip'){
            
            div.innerHTML = `
           
                <div>
                    <small>
                        
                        ${post.nombre_equipo_1} ${post.average_equipo_1} vs ${post.nombre_equipo_2} ${post.average_equipo_2} | ${post.fecha_partido}
                        
                    </small>
                    <h2>
                        ${post.average_equipo_1 > post.average_equipo_2? post.nombre_equipo_1:post.nombre_equipo_2} 
                        <span style="
                            ${post.estado_pronostico == 'no_acertado'?'background:orange;color:white;':''}
                            ${post.estado_pronostico == 'acertado'?'background:lightgreen;color:black;':''}
                            ${post.estado_pronostico != 'acertado' && post.estado_pronostico != 'no_acertado'?'background:grey;color:white;':''}                        
                        ">
                        ${post.estado_pronostico == 'no_acertado'?'fail':''}
                        ${post.estado_pronostico == 'acertado'?'win':''}
                        ${post.estado_pronostico != 'acertado' && post.estado_pronostico != 'no_acertado'?'wait':''}
                        </span>
                    </h2>
                ${post.excerpt.rendered}
                </div>
                <div>
                    <img src="http://localhost:5000/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg">

                    <p>${user.name}</p>
                    <p style="display:inline-block;margin:5px;font-size:14px;background:lightgreen;padding:5px 10px;border-radius:4px;color:black;">
                        + ${user.meta.pronosticos_acertados} 
                    </p>
            
                    <p style="display:inline-block;margin:5px;font-size:14px;background:orange;padding:5px 10px;border-radius:4px;color:black;">
                        - ${user.meta.pronosticos_no_acertados} 
                    </p>
            
                    <p> ${user.meta.average_aciertos}% average</p>
                </div>
            `
        }
        return div
    }
    const insert_tajetita_to_container = (model,container_tarjetitas,div,loader)=>{
        let existe = container_tarjetitas.querySelectorAll(`${'.'+model}`)
        
        if(existe.length < 1){
            container_tarjetitas.append(div)
        }
        if(existe.length == 1){
            for(data of existe){
                if(parseInt(data.id) !== parseInt(div.id)){
                    container_tarjetitas.append(div)
                }
            }
        }
        if(existe.length > 1){
            existe.forEach(html=>{
                if(parseInt(html.id) !== parseInt(div.id)){
                    container_tarjetitas.append(div)
                }
                if(parseInt(html.id) === parseInt(div.id)){
                    existe[0].remove()
                }
            })
        }
    
        if(loader) loader.innerHTML = "" 
    }
    const get_data = async ({rank,model,term,post_rest_slug,container_tarjetitas,loader,init,current_user=false})=>{
       
        if(loader) loader.innerHTML = "<b>Loading data....</b>"
        try{
            const req_posts = await fetch(`/wp-json/wp/v2/${post_rest_slug}?per_page=${parseInt(init) > parseInt(term.count)?term.count:init}&${term.taxonomy}=${term.term_id}`)
            const posts = await req_posts.json()
            const requser = await fetch(`/wp-json/wp/v2/users`)
            const users = await requser.json()
            
            posts.length > 0 ? posts.map(async post=>{
                const user = users.find(user => parseInt(user.id) === parseInt(post.author)) 
                if(parseInt(post.puntuacion_p) >= parseInt(rank) && parseInt(user.id) == parseInt(post.author)){
                    const div = create_tarjetita(post,model,current_user,user)
                    insert_tajetita_to_container(model,container_tarjetitas,div,loader)
                    return
                } 
                if(!rank || parseInt(rank) == 0 && parseInt(user.id) == parseInt(post.author)){
                    const div = create_tarjetita(post,model,current_user,user)
                    insert_tajetita_to_container(model,container_tarjetitas,div,loader)
                    return
                }  
            }): loader? loader.innerHTML = "No data fetch":null
        }catch(err){
            console.log(err)
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
                const exist = params_object.init.find(term => term.term_id == term.term_id)
                if(!exist){
                    params_object.init.push({term,limit:1})
                    if(delimiter <= window.innerHeight){
                        params_object.init[i].limit+=2
                    }
                    get_data({...params_object,
                        term,
                        container_tarjetitas:params_object.container_tarjetitas[i],
                        delimiter:loader,
                        init:params_object.init[i].limit
                    })
                }
                if(term && exist){
                    if(parseInt(term.count) >= exist.limit || parseInt(term.count) == 1){
                        if(delimiter <= window.innerHeight){
                           exist.limit+=2
                        }
                        get_data({...params_object,
                            term,
                            container_tarjetitas:params_object.container_tarjetitas[i],
                            delimiter:loader,
                            init:exist.limit
                        })
                    }
                }
            }
        }
        
    }
    const scroll_pagination = async(params_object)=>{
        
        let block = []
        let lastScrollTop = 0;
        
        let st = window.pageYOffset || document.documentElement.scrollTop; 
        if (st > lastScrollTop){
            //scroll hacia abajo
            for(let i=0;i < params_object.terms.length; i++){
                
                const {term,loader,scroll,delimiter} = create(params_object,i)
                
                if(term != undefined || term != false){
                    block[i] = false
                    const exist = params_object.init.find(term => term.term_id == term.term_id)
                    if(!exist){
                        params_object.init.push({term,limit:1})
                    }
                    
                    if(exist && delimiter != undefined){
                        
                        if(scroll > delimiter &&  !block[i]){
                            block = true
                            exist.limit++
                            if(parseInt(term.count) >= exist.limit){
                                setTimeout(()=>{ 
                                    
                                    get_data({...params_object,
                                        term:term,
                                        container_tarjetitas:params_object.container_tarjetitas[i],
                                        delimiter:loader,
                                        init:params_object.init[i].limit
                                    })
                                    block = false
                                }, 1000)
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
            rank:taxonomy_data.rank,
            model:taxonomy_data.model
        }
        
        initial_set(params_object)
        document.addEventListener('scroll',()=>{scroll_pagination(params_object)}
        )
    }
})
