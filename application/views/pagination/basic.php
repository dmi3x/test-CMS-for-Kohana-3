<p class="pagination">
        <span class="step">
	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo $page->url($previous_page) ?>" rel="prev">&larr;&nbsp;<?php echo __('Prev') ?></a>
	<?php else: ?>
		&larr;&nbsp;<?php echo __('Prev') ?>
	<?php endif ?>
	</span>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<span class="current"><?php echo $i ?></span>
		<?php else: ?>
			<a class="page" href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a class="step" href="<?php echo $page->url($next_page) ?>" rel="next"><?php echo __('Next') ?>&nbsp;&rarr;</a>
	<?php else: ?>
		<span class="step"><?php echo __('Next') ?></span>&nbsp;&rarr;
	<?php endif ?>

</p><!-- .pagination -->