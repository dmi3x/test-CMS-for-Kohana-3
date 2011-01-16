<?php echo Page::breadcrumbs()->render(); ?>

<?php if(!empty($currentPage)):?>
    <?php echo $currentPage['text']?>
<?php endif?>