<?php


function aw_cpanel_page_1(){ ?>
    <style>
        .create_promo_form{
            grid-column:1 / span 2;
            padding:0 5px;
        }
        .create_promo_form input{
            width:100%;
            display:block;
        }
        .create_promo_form label{
            text-transform:uppercase;
            font-weight:bold;
        }
        .create_promo_form button{
            margin:10px 0;
            background:rgb(70,130,245);
            color:white;
            padding:5px;
            text-transform:uppercase;
            border:unset;
            box-shadow:0px 0px 1px blue;
            cursor:pointer;
        }
        #prev_shortcode{
            grid-column: 1 / span 6;
            box-shadow:0px 0px 1px black;
            border-radius:3px;
            padding:10px;
            margin:10px;
        }
        #prev_shortcode > .title_promo{
            text-align:center;
        }
        #prev_shortcode > .title_promo b{
            text-transform:uppercase;
            font-size:21px;
            padding:10px 0;
        }
        #prev_shortcode > .list_pronosticos > .list_item_pronostico{
            display:grid;
            grid-template-columns:1fr 50px 50px;
            grid-template-rows:25px 25px;
            align-items:center;
        }
        #prev_shortcode > .list_pronosticos > .list_item_pronostico .enfrentamiento{
            grid-column: 1 / 2;
            grid-row:1 / 2
        }
        #prev_shortcode > .list_pronosticos > .list_item_pronostico .eleccion{
            grid-column: 1 / 2;
            grid-row:2 / 3
        }
        #prev_shortcode > .list_pronosticos > .list_item_pronostico .cuota{
            grid-column: 2 / 3;
            grid-row:1 / 3
        }
        #prev_shortcode > .list_pronosticos > .list_item_pronostico .ganancia{
            grid-column: 3 / 4;
            grid-row:1 / 3
        }
        #prev_shortcode > .list_pronosticos > .list_item_pronostico .cuota,
        #prev_shortcode > .list_pronosticos > .list_item_pronostico .eleccion{
            place-items:center;
            place-content:center;
        }
        #aw_cpanel_tabla_promos{
            grid-column: auto / span 4;
        }
        #aw_cpanel_tabla_promos tbody tr:nth-child(2n){
            background:rgb(230,230,230);
        }
        #aw_cpanel_tabla_promos .promos_table_actions button{
            background:lightgreen;
            padding:3px 5px;
            border:unset;
            cursor:pointer;
        }
        #aw_cpanel_tabla_promos .promos_table_actions button:nth-child(2){
            background:darkorange;
        }
    </style>
	<form id="create_promo_form" class="create_promo_form">
        <div>
            <label>Titulo</label>
            <input type="text" name="post_title" required>
        </div>
        <div>
            <label>Bono</label>
            <input type="text" name="bono" required>
        </div>
        <div>
            <label>Refear Link</label>
            <input type="url" name="refear_link" required>
        </div>
        <div>
            <label>Background color</label>            
            <input type="color" name="background_color" required>
        </div>
        <div>
            <label>Title color</label>            
            <input type="color" name="title_color" required>
        </div>
        <div>
            <label>List item border color</label>            
            <input type="color" name="list_item_border_color" required>
        </div>
        <button>crear promo</button>
    </form>
	
    <table id="aw_cpanel_tabla_promos" >
        <thead>
            <tr>
                <td class="id">id</td>
                <td class="titulo">titulo</td>
                <td class="status">status</td>
                <td class="promos_table_actions">acciones</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="id">..</td>
                <td class="titulo">..</td>
                <td class="status">..</td>
                <td class="promos_table_actions">..</td>
            </tr>
        </tbody>
    </table>

    <div id="prev_shortcode">
        <div class="title_promo">
            <b>Titulo de la tabla de anuncios</b>
        </div>
        <div class="list_pronosticos">
            <div class="list_item_pronostico">
                <p class="enfrentamiento" >equipo 1 vs equipo 2</p>
                <p class="eleccion" >Eleccion</p>
                <div class="cuota">0.2</div>
                <div class="ganancia">50$</div>
            </div>
        </div>
    </div>

    <template id="template_body_promos">
        <tr>
            <td class="id">id</td>
            <td class="titulo">titulo</td>
            <td class="status">status</td>
            <td class="promos_table_actions" >
                <button onclick="aw_activate_item(this)" >activar</button>
                <button onclick="aw_delete_item(this)">eliminar</button>
            </td>
        </tr>
    </template>
<?php }