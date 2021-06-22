function calc_cuota(e,params) {
    const valor = e.value
    const {id,cuota} = params
    const div = document.getElementById('bono'+id)
    const gana = parseFloat(valor) / parseFloat(cuota) + parseFloat(valor) 
    div.innerHTML = valor != '' ? gana.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}):0
}
window.addEventListener('load',()=>{
    const input_date = document.getElementById('aw_filter_pronosticos')
    const ul_btn_days = document.getElementById('aw_btn_day_filter')
    let local_date = get_date({format:'fecha'})
//04141426888
    
    function get_date ({date,format,yesterday,tomorrow}){
        if(format == 'time'){
            if(date){
                return new Date(date)
            }
            if(!date){
                return new Date(Date.now())
            }
        }
        if(format == 'fecha' && !yesterday && !tomorrow){
            if(date){
                const new_date = new Date(date)
                return new_date.getDate() + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear()
            }
            if(!date){
                const new_date = new Date()
                return new_date.getDate() + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear()
            }
        }
        if(format == 'fecha_hora'  && !yesterday && !tomorrow){
            if(date){
                const new_date = new Date(date)
                return new_date.getDate() + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear() + " " + new_date.getHours() + ":" + new_date.getMinutes()
            }
            if(!date){
                const new_date = new Date()
                return new_date.getDate() + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear() + " " + new_date.getHours() + ":" + new_date.getMinutes()
            }
        }
        if(format == 'fecha' && yesterday){
            if(date){
                const new_date = new Date(date)
                return (new_date.getDate() - 1 ) + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear()
            }
            if(!date){
                const new_date = new Date(Date.now())
                return (new_date.getDate() - 1 ) + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear()
            }
        }
        if(format == 'fecha' && tomorrow){
            if(date){
                const new_date = new Date(date)
                return (new_date.getDate() + 1 ) + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear()
            }
            if(!date){
                const new_date = new Date(Date.now())
                return (new_date.getDate() + 1 ) + "-" + (new_date.getMonth()+1) + "-" + new_date.getFullYear()
            }
        }
    }

    const create_tarjetita = ({post,model,current_user='',user,deporte,casa_apuesta=''})=>{
        let div = document.createElement('a')
        if(model=='tarjetita_pronostico_3'){
            div = document.createElement('div')
        }
        div.setAttribute('href',post.link)
        div.classList.add(model)
        div.id = post.id 
        let date = new Date(post.fecha_partido)
        post.fecha_partido = date.getDate() + '-' + (date.getMonth()+1) + '-' + date.getFullYear()
       
        if(model == 'tarjetita_pronostico_1'){

            div.innerHTML = `<h3 class="title_pronostico" >${deporte[0].name} ${deporte[1]?deporte[1].name:''}</h3>
                                
            ${post.acceso_pronostico.toString().toLowerCase() == 'vip'?`<b data="${post.acceso_pronostico}" class="sticker_tarjetita" ></b>`:''}
        
            <div class="equipos_pronostico" >
                <div>
                    <img loading="lazy" src="${post.img_equipo_1}" alt="${post.nombre_equipo_1}"/>
                    <p>${post.nombre_equipo_1}</p>  
                </div>
                <div>
                    <p>${post.fecha_partido}</p>
                    <br/>
                    <p>${post.hora_partido}</p>
                </div>
                <div>
                    <img loading="lazy" src="${post.img_equipo_2}" alt="${post.nombre_equipo_2}"/>   
                    <p>${post.nombre_equipo_2}</p>  
                </div>
            </div>
            <div class="average_pronostico" >
           
                <p>${post.average_equipo_1}%</p> <p>${post.cuota_empate_pronostico}%</p> <p>${post.average_equipo_2}%</p>
                
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
                        
                        ${post.nombre_equipo_1} ${post.average_equipo_1}% vs ${post.nombre_equipo_2} ${post.average_equipo_2}% | ${post.fecha_partido}
                        
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
                    <img src="${user.avatar_urls['96']}">

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
        if(model == 'tarjetita_pronostico_3'){
            
            div.innerHTML = `
            <div class="enfrentamiento">
                
                    <img src="${post.img_equipo_1}" />
                
                <div>
                    <small>${post.fecha_partido}</small>
                    <p>${post.hora_partido}</p>
                </div>
                
                    <img src="${post.img_equipo_2}" />

                <div>
                    ${post.nombre_equipo_1} vs ${post.nombre_equipo_2}
                </div>

                </div>
                
                <div class="eleccion_partido" >
                    ${post.acceso_pronostico.toString().toLowerCase() != 'vip'?(
                        `<b>${post.eleccion}</b>
                        <p>$${casa_apuesta.bono_casa_apuesta?casa_apuesta.bono_casa_apuesta:0}</p>`
                        ):'<img width="50" height="50" src="/wp-content/themes/apuestanweb-theme-wp/assets/images/candado.svg" alt=""></img>'}
                </div>
                    
                <div class="recompensa">
                    <div>
                        <small>Apuesta</small>
                        <input onkeyup="calc_cuota(this,{id:${post.id},cuota:${post.cuota_empate_pronostico}})" onchange="calc_cuota(this,{id:${post.id},cuota:${post.cuota_empate_pronostico}})" type="number" step="0.1" value="10" />
                    </div>
                    <div>
                        <small>Gana</small>
                        <p id="bono${post.id}" >$${casa_apuesta.bono_casa_apuesta?casa_apuesta.bono_casa_apuesta:0}</p>
                    </div>
                        <img src="${casa_apuesta.url_logo_casa_apuesta}" alt="${casa_apuesta.title}" ?>
                </div>
                <div class="btn_card" >
                    <a href="${post.link}" ><button>Ver Análisis</button></a>
                </div>
        `
        }
        return div
    }
    const insert_tajetita_to_container = (model,container_tarjetitas,div,loader,index)=>{
        let existe = container_tarjetitas.querySelector(`div`)
        existe.append(div)
        
    }
    const get_data = async ({rank,model,term,post_rest_slug,container_tarjetitas,loader,init,current_user=false})=>{
        let div_container      
        
        if(container_tarjetitas){
            div_container = container_tarjetitas.querySelector(`div`)
        }
        try{
            if(container_tarjetitas){
                div_container.innerHTML = '<div class="loading" >loading...</div>'
            }
            
            const req_posts = await fetch(`/wp-json/wp/v2/${post_rest_slug}?per_page=${parseInt(init) > parseInt(term.count)?term.count:init}&${term.taxonomy}=${term.term_id}`)
            const posts = await req_posts.json()
            
            const requser = await fetch(`/wp-json/wp/v2/users`)
            const users = await requser.json()

            const reqtaxonomy = await fetch(`/wp-json/wp/v2/deportes`)
            const deportes = await reqtaxonomy.json()

            const casa_apuestas_req = await fetch(`/wp-json/wp/v2/casaapuesta`)
            const casas_apuestas = await casa_apuestas_req.json()

            posts.sort(function(a,b){
                let date_a = new Date(a.fecha_partido)
                let date_b = new Date(b.fecha_partido)
                return date_a.getTime() - date_b.getTime()
            })
            if(container_tarjetitas){
                div_container.innerHTML = ''
            }

            posts.length > 0 ? posts.map(async (post,index)=>{
                const user = users.find(user => parseInt(user.id) === parseInt(post.author))
                const casa_apuesta = casas_apuestas.find(casa => casa.slug == post.refear_link)
                
                const deporte = post.deportes.map((id_deporte)=>{
                    return deportes.find(current_term=>current_term.id==id_deporte)
                })
                // condicional comparativo fecha del partido con fecha actual
                
                if(get_date({format:'fecha',date:post.fecha_partido[0]}) == local_date){
                   
                    if(parseInt(post.puntuacion_p) >= parseInt(rank) && parseInt(user.id) == parseInt(post.author)){
                        const div = create_tarjetita({post,model,current_user,user,deporte,casa_apuesta})
                        insert_tajetita_to_container(model,container_tarjetitas,div,loader,index)
                        return
                    } 
                    if(!rank || parseInt(rank) == 0 && parseInt(user.id) == parseInt(post.author)){
                        const div = create_tarjetita({post,model,current_user,user,deporte,casa_apuesta})
                        insert_tajetita_to_container(model,container_tarjetitas,div,loader,index)
                        return
                    } 
                }
            }): div_container.innerHTML = '<div class="loading">empty</div>'
        }catch(err){
            if(container_tarjetitas) div_container.innerHTML = '<div class="loading">Err.</div>'
            
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
                //const exist = params_object.init.find(term => term.term_id == term.term_id)
                
                    
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
        }
        
    }
    const filter_set=async(params_object)=>{
        
        for(let i=0; i <= params_object.terms.length;i++){
            const {term,loader,delimiter} = create(params_object,i)
            
            if(term != undefined || term != false){  
                
                const exist = params_object.init.find(term => term.term_id == term.term_id)
                
                if(term){
                    
                        if(delimiter <= window.innerHeight){
                           exist.limit+=5
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

        let params_object = {
            terms:Array.isArray(taxonomy_data.terms)?taxonomy_data.terms:Object.values(taxonomy_data.terms),
            post_rest_slug: taxonomy_data.post_rest_slug,
            container_tarjetitas:document.querySelectorAll(`.${taxonomy_data.class_container_tarjetitas}`),
            delimiter:document.querySelectorAll(`.${taxonomy_data.class_delimiter}`),
            init:[],
            current_user: taxonomy_data.current_user,
            rank:taxonomy_data.rank,
            model:taxonomy_data.model
        }
        if(input_date && ul_btn_days){
            const btns = ul_btn_days.querySelectorAll('button')
            
            for (let i=0; i<btns.length; i++) {
                btns[i].id = 'day_'+i
                btns[i].addEventListener('click',()=>{
                    click_btn(btns[i],btns)
                })
                if(btns[i].id == 'day_1'){
                    btns[i].style.borderBottom = '2px solid red'
                }
            }
            input_date.addEventListener('change',(e)=>{
                local_date = get_date({format:'fecha',date:e.target.value+' 0:0:0'})
                filter_set(params_object)
                for (let i=0; i<btns.length; i++) {
                    btns[i].style.borderBottom = ''
                }
            })
            
            function click_btn(btn,btns){
                for (let i=0; i<btns.length; i++) {
                    btns[i].id = 'day_'+i
                    btns[i].style.borderBottom = ''

                    if(btns[i].id == btn.id){
                        btns[i].style.borderBottom = '2px solid red'
                    }
                }
                if(btn.id == 'day_0'){
                    local_date = get_date({format:'fecha',yesterday:true})
                    filter_set(params_object)
                }
                if(btn.id == 'day_1'){
                    local_date = get_date({format:'fecha'})
                    filter_set(params_object)
                }
                if(btn.id == 'day_2'){
                    local_date = get_date({format:'fecha',tomorrow:true})
                    console.log(local_date)
                    filter_set(params_object)
                }
            }
        }
  
        initial_set(params_object)
        document.addEventListener('scroll',()=>{scroll_pagination(params_object)}
        )
    }
})
