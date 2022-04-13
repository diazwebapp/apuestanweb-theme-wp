<?php get_header(); ?>
<div class="wrap flex">
    <div class="page-left-col single">
        <h1><?php echo __('Page not found', 'jbetting') ?></h1>
        <div class="text-page"><?php echo __('The page you went to was not found', 'jbetting') ?></div>
    </div>
    <div class="page-right-col">
        <?php dynamic_sidebar('cat-right'); ?>
    </div>
</div>
<?php get_footer(); ?>
