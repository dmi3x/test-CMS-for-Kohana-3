<?php
/*
	First Previous 1 2 3 ... 22 23 24 25 26 [27] 28 29 30 31 32 ... 48 49 50 Next Last
*/

// Number of page links in the begin and end of whole range
$count_out = ( ! empty($config['count_out'])) ? (int) $config['count_out'] : 3;
// Number of page links on each side of current page
$count_in = ( ! empty($config['count_in'])) ? (int) $config['count_in'] : 5;

// Beginning group of pages: $n1...$n2
$n1 = 1;
$n2 = min($count_out, $total_pages);

// Ending group of pages: $n7...$n8
$n7 = max(1, $total_pages - $count_out + 1);
$n8 = $total_pages;

// Middle group of pages: $n4...$n5
$n4 = max($n2 + 1, $current_page - $count_in);
$n5 = min($n7 - 1, $current_page + $count_in);
$use_middle = ($n5 >= $n4);

// Point $n3 between $n2 and $n4
$n3 = (int) (($n2 + $n4) / 2);
$use_n3 = ($use_middle && (($n4 - $n2) > 1));

// Point $n6 between $n5 and $n7
$n6 = (int) (($n5 + $n7) / 2);
$use_n6 = ($use_middle && (($n7 - $n5) > 1));

// Links to display as array(page => content)
$links = array();

// Generate links data in accordance with calculated numbers
for ($i = $n1; $i <= $n2; $i++)
{
	$links[$i] = $i;
}
if ($use_n3)
{
	$links[$n3] = '&hellip;';
}
for ($i = $n4; $i <= $n5; $i++)
{
	$links[$i] = $i;
}
if ($use_n6)
{
	$links[$n6] = '&hellip;';
}
for ($i = $n7; $i <= $n8; $i++)
{
	$links[$i] = $i;
}

?>
<p class="pagination">

	<!--<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo Html::entities($page->url($first_page)) ?>" rel="first"><?php echo __('First') ?></a>
	<?php else: ?>
		<?php echo __('First') ?>
	<?php endif ?>-->

	<?php if ($previous_page !== FALSE): ?>
		<a class="prev arr" href="<?php echo Html::entities($page->url($previous_page)) ?>">&larr;</a><a class="prev" href="<?php echo Html::entities($page->url($previous_page)) ?>"><?php echo __('Prev') ?></a>
	<?php else: ?>
		<span class="arr">&larr;</span><span class="prev"><?php echo __('Prev') ?></span>
	<?php endif ?>

	<?php foreach ($links as $number => $content): ?>

		<?php if ($number === $current_page): ?>
			<span class="page"><?php echo $content ?></span>
		<?php else: ?>
			<a class="page" href="<?php echo Html::entities($page->url($number)) ?>"><?php echo $content ?></a>
		<?php endif ?>

	<?php endforeach ?>

	<?php if ($next_page !== FALSE): ?>
		<a class="next" href="<?php echo Html::entities($page->url($next_page)) ?>"><?php echo __('Next') ?></a><a class="next arr" href="<?php echo Html::entities($page->url($next_page)) ?>">&rarr;</a>
	<?php else: ?>
		<span class="next"><?php echo __('Next') ?></span><span class="arr">&rarr;</span>
	<?php endif ?>

	<!--<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo Html::entities($page->url($last_page)) ?>" rel="last"><?php echo __('Last') ?></a>
	<?php else: ?>
		<?php echo __('Last') ?>
	<?php endif ?>-->

</p><!-- .pagination -->