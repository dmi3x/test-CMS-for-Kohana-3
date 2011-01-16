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
    new urlGenerator({form : $('#newsEditForm')});
});
</script>


<h1>Edit news</h1>
<p>Some of news fields are <b>required</b>.</p>
<form id="newsEditForm" method="post" action="">
<input type="hidden" name="parentID" disabled="disabled" value="<?php echo $item['structureId']?>" />
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
			    <input class="textBox datePicker" name="date" value="<?=Arr::get($_POST, 'date', date('d.m.Y',$item['date']))?>" /><br />
		    </td>
		</tr>
		<tr>
		    <td width="20%">
			    <b>Page name:</b>
		    </td>
		    <td width="80%" align="right">
			    <input class="textBox" name="name" type="text" value="<?php echo Arr::get($_POST, 'name', $item['name'])?>" style="width: 99%;" /><br />
		    </td>
		</tr>
		<tr>
		    <td><b>URL:</b></td>
		    <td>
			<?php echo View::factory('admin/url')
				       ->set('alias', Arr::get($_POST, 'alias', $item['alias']))
				       ->set('parentUrl', $item['parentUrl']);
			?>
		    </td>
		</tr>
	    </table>
	</div>
	<div id="tabs-2">
	    <textarea name="text" rows="" cols=""><?=Arr::get($_POST, 'text', $item['text'])?></textarea>
	</div>
	<div class="formButtonsBox" align="center"><input type="submit" value="Save" /></div>
    </div>
</form>