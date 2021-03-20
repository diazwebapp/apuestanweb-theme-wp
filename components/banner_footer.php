<?php
if(is_front_page()){ ?>
    <div class="banner before_dow" >
        <div>
            <h2><?php echo __('Has tus mejores apuestas y garantiza tu dinero','apuestanweb-lang') ?></h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, saepe.</p>
        </div>
        <a href="#" ><?php echo __('Casas apuestas','apuestanweb-lang') ?></a>

        <div class="container_casas_apuestas" >
            <?php include 'casas_apuestas.php' ?>
        </div>
    </div>
<?php } ?>