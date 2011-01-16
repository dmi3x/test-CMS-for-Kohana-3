<script type="text/javascript" src="/public/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/public/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/public/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="/public/js/ckeditor.js"></script>
<script type="text/javascript">
window.onload = function() {
    new CKinit('[name="text"]');
}
$(function() {
    $(".tabs").tabs();
    new urlGenerator({form : $('#structureEditForm')}); 
});
</script>

<h1>Edit page</h1>
<p>Some of page fields are <b>required</b>. You can change Page to other site module.</p>
<form id="structureEditForm" method="post" action="">
    <div class="tabs">
    	<?if(count(Kohana::config('langs.list')) > 1):?>
		<select name="lang" class="langSelect textBox" onchange="window.location='/admin/structure/edit/<?=@$item['id']?>/'+this.value">
		<?foreach(Kohana::config('langs.list') as $langCode => $langTitle):?>
			<option value="<?=$langCode?>" <?if($lang == $langCode):?>selected="selected"<?endif?>><?=$langTitle?></option>
		<?endforeach?>
		</select>
	<?endif?>
	<ul>
	    <li><a href="#tabs-1">Main</a></li>
	    <li><a href="#tabs-2">Meta</a></li>
	    <li><a href="#tabs-3">Text</a></li>
	</ul>
	<div id="tabs-1">
	    <table class="formTable" width="100%" border="0" cellpadding="10" cellspacing="1" >
	      <tr>
		    <td width="20%">
			    <b>Page name:</b>
		    </td>
		    <td width="80%" align="right">
			<input class="textBox" name="name" type="text" value="<?php echo Html::entities(Arr::get($_POST, 'name', $item['name']))?>" style="width: 99%;" /><br />
		    </td>
	      </tr>
	      <?php if(count(Kohana::config('langs.list')) > 1 && $lang == Kohana::config('langs.default')):?>
	      <tr>
		    <td>Module</td>
		    <td>
		    <?php if($item['module']['alias']):?>
			<?php $modules = Modules::instance()->get_list($item['module']['alias'], $item['hasChildren'])?>
			<?php if(count($modules)>1):?>
			      <select name="module" style="width: 150px;" class="textBox">
				    <?php foreach ($modules as $alias=>$val):?>
				    <option value="<?php echo $alias?>" <?php if (Arr::get($_POST, 'module', $item['module']['alias']) == $alias):?>selected=""<?php endif?>><?php echo $val['name']?></option>
				    <?php endforeach?>
			      </select>
			<?php else:?>
			    <?php $current = current($modules); echo $current['name']; ?>
			<?php endif?>
		    <?php else:?>
			<i>system</i>
		    <?php endif?>
		    </td>
	      </tr>
	      <tr>
		    <td><b>URL:</b></td>
		    <td>
		      <?php if(!$item['module']['required'] && $item['module']['alias']):?>
			    <?php echo View::factory('admin/url')
					   ->set('alias', Arr::get($_POST, 'alias', $item['alias']))
					   ->set('parentUrl', $item['parentUrl']);
			    ?>
		      <?php else:?>
			    <?php if($item['parentUrl']):?>/<?php echo $item['parentUrl']?><?php endif?>/<?php echo $item['alias']?>
		      <?php endif?>
		    </td>
	      </tr>
	      <?php else:?>
	      <tr>
		    <td>Module</td>
		    <td>
			<?php $modules = Modules::instance()->get_list($item['module']['alias'], $item['hasChildren'])?>
			<?php $current = current($modules); echo $current['name']; ?>
		    </td>
	      </tr>
	      <tr>
		    <td>URL:</td>
		    <td>
			<?php if($item['parentUrl']):?>/<?php echo $item['parentUrl']?><?php endif?>/<?php echo $item['alias']?>
		    </td>
	      </tr>
	      <?php endif?>
	    </table>

	</div>
	<div id="tabs-2">
	    <table class="formTable" width="100%" border="0" cellpadding="10" cellspacing="1" >
		<tr>
		    <td width="20%">
			Title:
		    </td>
		    <td width="80%" align="right">
			<!-- <p align="left">You can use variables:<br /> %site% = site name,<br /> %sep% = separator,<br /> %suf% = suffix,<br /> %pref% = prefix,<br /> %title% = auto title</p> -->
			<input class="textBox" type="text" name="title" value="<?php echo Html::entities(Arr::get($_POST, 'title', $item['title']))?>" style="width: 99%;" /><br />
		    </td>
		</tr>
		<tr>
		    <td>Keywords:</td>
		    <td align="right">
			<input class="textBox" type="text" name="keywords" value="<?php echo Html::entities(Arr::get($_POST, 'keywords', $item['keywords']))?>" style="width: 99%;" /><br />
		    </td>
		</tr>
		<tr>
		    <td height="26">Description:</td>
		    <td align="right">
			<input class="textBox" type="text" name="description" value="<?php echo Html::entities(Arr::get($_POST, 'description', $item['description']))?>" style="width: 99%;" /><br />
		    </td>
		</tr>
	    </table>
	</div>
	<div id="tabs-3">
	    <textarea name="text" rows="" cols=""><?php echo Arr::get($_POST, 'text', $item['text'])?></textarea>
	</div>
	<div class="formButtonsBox" align="center"><input type="submit" value="Save" /></div>
    </div>
</form>