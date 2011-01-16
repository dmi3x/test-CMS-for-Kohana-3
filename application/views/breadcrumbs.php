<div class="border">
    <div class="whereAmI">
	
    <?php if(!empty($list)):?>
	<?php foreach($list as $key=>$val):?>
	  <?php if (isset($val['url'])):?>
	      <a href="<?php echo uri::lang(true)?><?php echo $val['url']?>"><?php echo $val['name']?></a>
	  <?php else:?>
		<?php echo $val['name']?>
	  <?php endif?>
	 <?php if($key+1 < count($list)):?>
	     &nbsp;&rarr;&nbsp;
	 <?php endif?>
	<?php endforeach?>
    <?php endif?>
    </div>
</div>

