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
<!DOCTYPE html>
<html lang="en">





    <body>
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
                <p class="lead">
                    The page you’re looking for doesn’t exist.
                  </p>
                <a href="index.html" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    </body>


</html>
<?php get_footer(); ?>