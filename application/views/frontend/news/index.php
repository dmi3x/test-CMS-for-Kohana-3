<?php echo Page::breadcrumbs()->render(); ?>

<?php if(!empty($currentPage)):?>
    <?php echo $currentPage['text']?>
<?php endif?>

<div class="news">
<?php if(!empty($list)):?>
    <?php foreach($list as $val):?>
	<div class="item">
	    <div class="date"><small><?php echo date('d.m.Y', $val['date'])?></small></div>
	    <a class="title" href="<?php echo Uri::lang(true)?>/<?php echo $val['url']?>"><?php echo $val['name']?></a>
	    <div class="text"><?php echo Text::limit_chars(strip_tags($val['text']), 220, '...', true)?></div>
	</div>
    <?php endforeach?>
<?php endif?>
</div>

<?php echo $pagination?>