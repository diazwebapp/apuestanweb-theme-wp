<?php
/*
Template Name: Plantilla Personalizada para Shortcode
*/

// Incluye WordPress
require_once('wp-load.php');
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <link rel="stylesheet" href="<?php echo plugins_url('NFLpicks-DB-1/css/style.css'); ?>">
</head>
<body>

    <?php
    // Llama al shortcode [nfl_schedule]
    echo do_shortcode('[nfl_schedule]');
    ?>
    <script>
        var nfl_ajax = {
            plugin_url: '<?php echo plugins_url("NFLpicks-DB-1/"); ?>',
            ajax_url: '<?php echo admin_url("admin-ajax.php"); ?>' // Puedes agregar más variables si es necesario
        };
    </script>
    <script src="<?php echo plugins_url('NFLpicks-DB-1/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo plugins_url('NFLpicks-DB-1/js/func.js'); ?>"></script>


</body>
</html>
