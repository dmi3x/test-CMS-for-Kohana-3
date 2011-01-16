<script type="text/javascript">
$(function() {
    $(".tabs").tabs();
});
</script>
<!--<a href="#" class="button" onclick="productQa.showAddBox(); return false;">Add Item</a>-->

<h1>Edit Config</h1>
<form method="post" action="">
    <div class="tabs">
	<ul>
	    <li><a href="#tabs-1">Main</a></li>
	</ul>
	<div id="tabs-1">
          <table width="100%" class="formTable" cellpadding="6">
          <tr>
            <th width="150">Name</th>
            <th width="250">Value</th>
            <th>Description</th>
          </tr>
	    <?php foreach($conf['db_main'] as $key=>$val):?>
             <tr>
                  <td><?php echo $val['name']?></td>
                  <td><input type="text" name="<?php echo $val['group_name']?>[<?php echo $val['config_key']?>]" value="<?php echo unserialize($val['config_value'])?>" style="width: 100%;"/></td>
                  <td><?php echo $val['description']?></td>
             </tr>
          <?php endforeach?>
          </table>
	</div>
	<div class="formButtonsBox" align="center"><input type="submit" value="Save" /></div>
    </div>
</form>