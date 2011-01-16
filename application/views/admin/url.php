<input type="text" class="fullUrl" value="<?php echo !empty($parentUrl) ? '/'.trim($parentUrl,'/') : '' ?>/<?php echo !empty($alias)? $alias : '[alias]'?>" style="width:99%" readonly="readonly" /><br />
<a href="#" class="generateUrl">Generate</a>
<a href="#" class="changeUrl">Change</a>
<input type="hidden" class="alias"  name="alias" value="<?php echo $alias?>" />
<input type="hidden" class="parentUrl" value="<?php echo $parentUrl?>" />
