			<table class="menu">
			   <tr>
			       <td class="level_1<?php if(!Uri::instance()->segment(1)):?> active<?php endif?>">
				    <a href="<?php echo Uri::lang(true)?>/">Home</a>
			       </td>
			       <td class="level_1<?php if(Uri::instance()->segment(1)=='about'):?> active<?php endif?>">
				   <a href="<?php echo Uri::lang(true)?>/about-us">About</a>
			       </td>
			       <td class="level_1<?php if(Uri::instance()->segment(1)==Uri::getModule('news')):?> active<?php endif?>">
				   <a href="<?php echo Uri::lang(true)?>/<?php echo Uri::getModule('news')?>">News</a>
			       </td>
			   </tr>
		       </table>