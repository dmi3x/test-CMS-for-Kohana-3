<h1>News</h1>
<small>[<a href="/admin/structure/edit/<?php echo $structureId?>">Edit page</a>]</small>

<?php if(!empty($list)):?>
    <table class="formTable listTab ui-widget ui-widget-content" cellpadding="10" width="100%">
	<tr class="ui-widget-header">
	    <th width="40"></th>
	    <th width="50">Date</th>
	    <th>Name</th>
	</tr>
	<?php foreach($list as $val):?>
	<tr>
	    <td>
		<a href="/admin/news/edit/<?php echo $val['id']?>"><img src="/public/images/admin/edit.gif" alt="" /></a>
		<a href="/admin/news/delete/<?php echo $val['id']?>/<?php echo $val['structureId']?>" onclick="return confirm('Realy delete?')"><img src="/public/images/admin/delete.gif" alt="" /></a>
	    </td>
	    <td><?php echo date('d.m.Y', $val['date'])?></td>
	    <td><a href="/<?php echo $parentUrl?>/<?php echo $val['alias']?>"><?php echo $val['name']?></a></td>
	</tr>
	<?php endforeach?>
    </table>

    <?php echo $pagination?>
<?php else:?>
    <p>Empty</p>
<?php endif?>