<h1>Pages</h1>

    <table class="formTable listTab ui-widget ui-widget-content" cellpadding="10" width="100%">
	<tr class="ui-widget-header">
	    <th width="40"></th>
	    <th>Name</th>
	    <th>Address</th>
	    <th>Modul</th>
	    <th>Date</th>
	</tr>
<?php if(!empty($list)):?>
	<?php foreach($list as $val):?>
	<tr>
	    <td>
		<a href="/admin/structure/edit/<?php echo $val['id']?>"><img src="/public/images/admin/edit.gif" alt="" /></a>
		<!--<a href="/admin/structure/delete" onclick="return confirm('Realy delete?')"><img src="/public/images/admin/delete.gif" alt="" /></a>-->
	    </td>
	    <td><?php echo $val['name']?></td>
	    <td><a href="/<?php echo $val['url']?>">/<?php echo $val['url']?></a></td>
	    <td><?php echo $val['module']?></td>
	    <td width="20px"><small><?php echo date('d.m.Y', $val['dateAdd'])?></small></td>
	</tr>
	<?php endforeach?>
<?php endif?>
    </table>