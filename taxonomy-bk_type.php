<?php get_header(); ?>
<?php
$term = get_queried_object();
$term_id = $term->term_id;
if (carbon_get_term_meta($term_id, 'h1')) {
    $h1 = carbon_get_term_meta($term_id, 'h1');
} else {
    $h1 = single_term_title('', false);
}
$textbefore = carbon_get_term_meta($term_id, 'before_list');
$textafter = carbon_get_term_meta($term_id, 'after_list');
?>
<div class="wrap flex">
    <div class="page-left-col">
        <h1 class="block-name"><?php echo $h1; ?></h1>
        <div class="text-page">
            <?php
            if ($textbefore):
                echo apply_filters('the_content', $textbefore);
            endif;
            ?>
            <?php
            global $wp_query;
            $per_page_global = carbon_get_theme_option('count_bookmaker');
            if ($per_page_global) {
                $perpage = $per_page_global;
            } else {
                $perpage = 6;
            }
            $pos = 1;
            $args = array_merge($wp_query->query_vars, ['posts_per_page' => $perpage]);
            query_posts($args);
            if (have_posts()):
                ?>
                <div class="companies-rating">
                    <table>
                        <thead>
                        <tr>
                            <td class="pos"><?php echo __('№', 'jbetting'); ?></td>
                            <td><?php echo __('Bookmaker', 'jbetting'); ?></td>
                            <td><?php echo __('Rating', 'jbetting'); ?></td>
                            <td><?php echo __('Bonus', 'jbetting'); ?></td>
                            <td><?php echo __('Reviews', 'jbetting'); ?></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            while (have_posts()):the_post();
                                get_template_part("loop/bookmaker-table", '', array('pos' => $pos++));
                            endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <?php if ($wp_query->max_num_pages > 1) : ?>
                <?php
                    if (get_query_var('paged')) {
                        $current_page = get_query_var('paged');
                    } else {
                        $current_page = 1;
                    }
                    $casino_pos = $current_page * $perpage;
                ?>
                <script>
                    var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                    var posts = '<?php echo serialize($wp_query->query_vars); ?>';
                    var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                    var casino_pos = "<?php echo $casino_pos; ?>";
                    var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                </script>
                <button class="loadmore bookmaker_table"><?php echo __('Load more', 'jbetting'); ?></button>
            <?php endif; ?>

            <?php
                if ($textafter):
                    echo apply_filters('the_content', $textafter);
                endif;
            ?>
        </div>
    </div>
    <div class="page-right-col">
        <?php dynamic_sidebar('home-right'); ?>
    </div>
</div>
<?php get_footer(); ?>
