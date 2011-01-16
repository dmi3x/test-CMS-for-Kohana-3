<?php echo Page::breadcrumbs()->render(); ?>

<p><small><?php echo date('d.m.Y', $item['date'])?></small></p>

<h1><?php echo $item['name']?></h1>

<?php echo $item['text']?>