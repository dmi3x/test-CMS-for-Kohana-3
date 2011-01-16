    <?php if ($childs):?>
    <ul>
    <?php foreach ($childs as $key=>$val):?>
	<?php if(!$val['module']) { $val['module'] = $parentType; } ?>
      	<li id="item<?php echo $val['id']?>" rel="<?php if($val['module']):?><?php echo $val['module']?><?php else:?><?php echo $parentType?><?php endif?>" >
	    <a href="#" onclick="onTreeItemClick($(this)); return false;">
		<ins>&nbsp;</ins><?php echo $val['name']?>
	    </a>
	    <?php echo View::factory('admin/structure/tree')->set('childs', $val['childs'])->set('parentType', $val['module'])->render();?>
	</li>
   <?php endforeach?>
   </ul>
   <?php endif?>