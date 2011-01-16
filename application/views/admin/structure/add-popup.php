<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
    new urlGenerator({form : $('#structureAddForm')});
/*]]>*/
</script>

<form name="form" id="structureAddForm" method="post" action="/admin/structure/add/<?php echo $parentId?>">
    <input type="hidden" name="parentId" value="<?php echo $parentId?>" />
    <input type="hidden" name="folderId" value="" />
    <table class="formTable" width="98%" border="0" cellpadding="10" cellspacing="1" >
	<tr>
	    <td width="20%">
		<b>Page name:</b>
	    </td>
	    <td width="80%" align="right">
		<input class="textBox" name="name" type="text" value="" style="width: 99%;" /><br />
	    </td>
	</tr><tr>
	    <td>Module</td>
	    <td>
		<?php $modules = Modules::instance()->get_list()?>
		<?php if(count($modules)>1):?>
		    <select name="module" style="width: 150px;" class="textBox">
		    <?php foreach ($modules as $alias=>$val):?>
			<option value="<?php echo $alias?>"><?php echo $val['name']?></option>
		    <?php endforeach?>
		    </select>
		<?php else:?>
		    <?php $current = current($modules); echo $current['name']?>
		<?php endif?>
	    </td>
	</tr><tr>
	    <td><b>Address:</b></td>
	    <td>
	     <?php echo View::factory('admin/url')
			   ->set('alias', Arr::get($_POST, 'alias'))
			   ->set('parentUrl', $parentUrl);
	     ?>
	    </td>
	</tr>
    </table>
    <div class="formButtonsBox" align="center"><input type="submit" value="Create" /></div>
</form>