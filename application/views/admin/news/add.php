<script type="text/javascript" src="/public/js/url.js"></script>
<script type="text/javascript" src="/public/jquery-ui/ui/i18n/ui.datepicker-ru.js"></script>
<script type="text/javascript" src="/public/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/public/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/public/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="/public/js/ckeditor.js"></script>
<script type="text/javascript">
window.onload = function() {
    new CKinit('[name="text"]');
}
$(function() {
    $(".datePicker").datepicker($.datepicker.regional['ru']);
    $(".tabs").tabs();
    new urlGenerator({form : $('#newsAddForm')});
});
</script>

<h1>Add news</h1>
<p>Some of news fields are <b>required</b>.</p>
<form id="newsAddForm" method="post" action="">
<input type="hidden" name="parentId" disabled="disabled" value="<?php echo $structureId?>" />
	<div class="tabs">
		<ul>
			<li><a href="#tabs-1">Main</a></li>
			<li><a href="#tabs-2">Text</a></li>
		</ul>
		<div id="tabs-1">
		<table class="formTable" width="100%" border="0" cellpadding="10" cellspacing="1" >
		    <tr>
			    <td width="20%">
				   Date:
			    </td>
			    <td width="80%">
				    <input class="textBox datePicker" name="date" value="<?php echo date('d.m.Y')?>" /><br />
			    </td>
		    </tr>
		    <tr>
			    <td>
				   <b>News name:</b>
			    </td>
			    <td align="right">
				    <input class="textBox" name="name" type="text" value="<?=Arr::get($_POST, 'name')?>" style="width: 99%;" /><br />
			    </td>
		    </tr>
		    <tr>
			 <td><b>URL:</b></td>
			 <td>
			    <?php echo View::factory('admin/url')
					   ->set('alias', Arr::get($_POST, 'alias'))
					   ->set('parentUrl', $parentUrl);
			    ?>
			 </td>
		    </tr>
    		</table>
		</div>
		<div id="tabs-2">
			<textarea name="text" rows="" cols=""><?=Arr::get($_POST, 'text')?></textarea>
		</div>
		<div class="formButtonsBox" align="center"><input type="submit" value="Create" /></div>
	</div>
</form>