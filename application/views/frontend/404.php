<?php echo Page::breadcrumbs()->render(); ?>

<?php if(!empty($text)):?>
    <?php echo $text?>
<?php else:?>
    <h1>Page not found</h1>
    <p>Error 404 - page not found.</p>
    <p>Go to the <a href="<?php echo Uri::lang(true)?>/">Main page</a> and try to search there</p>
<?php endif?>