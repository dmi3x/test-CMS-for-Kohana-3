<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
    var structureTreeConfig = '<?php echo $treeConfig?>';
/*]]>*/
</script>
<script type="text/javascript" src="/public/js/structure.js"></script>
<?php if(!empty($structure)):?>
    <input type="button"  id="createMenuItemBtn" onclick="return showCreateMenuItemDialog();" value="Create" />
    <!--<input type="button" id="editMenuItemBtn" onclick="return editMenuItem();" value="Edit" disabled="disabled" />-->
    <input type="button" id="deleteMenuItemBtn" onclick="return deleteMenuItem();" value="Delete" disabled="disabled" />
    <br /><br />
    <div id="menusTree" class="tree">
	<ul>
	    <li class="open" rel="root">
		<a href="#" onclick="onTreeItemClick($(this)); return false;"><ins>&nbsp;</ins>Structure</a>
		<?php if (Kohana::config('main')->structure_folders):?>
		<ul>
		<?php foreach (Kohana::config('main')->structure_folders as $key=>$val):?>
		    <li id="folder<?php echo $key?>" rel="folder">
			<a href="#" onclick="onTreeItemClick($(this)); return false;">
			    <ins>&nbsp;</ins><?php echo $val?>
			</a>
			<?php if(!empty($structure[$key])):?>
			    <?php echo View::factory('admin/structure/tree')->set('childs', $structure[$key])->render();?>
			<?php endif?>
		    </li>
	       <?php endforeach?>
	       </ul>
	       <?php endif?>
	    </li>
	</ul>
    </div>
    <div class="clear"></div>

    <div id="createMenuItemDialog" style="display: none" title="New page"></div>
    <div id="editMenuItemDialog" style="display: none" title="Edit page"></div>
<?php else:?>
    No pages...
<?php endif?>
 