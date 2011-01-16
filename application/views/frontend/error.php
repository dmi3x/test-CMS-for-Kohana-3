<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Error</title>
    <script type="text/javascript" src="/public/js/jquery.js"></script>
    <link href="/public/css/frontend.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <?php $mess = messages::get_last_message();?>
    <?php if(!empty($mess['text'])):?>
    <div id="messbox" class="<?php if($mess['ok']):?>ok<?php else:?>err<?php endif?>">
	<?php echo $mess['text']?>
    </div>
    <?php endif?>
    <div id="wrap" class="error">
	<div id="container">
	    <div id="header">
		<a href="<?php echo Uri::lang(true)?>/" class="logo">LOGO</a>
	    </div>
	    
	    <div id="outer">
		<div class="main_column">
		     <h1 class="border">Error</h1>
		     <div style="font-size:16px; font-weight:bold; line-height:40px;">
			    There was a terrible mistake<br />
			    Try to go to <a href="<?php echo Uri::lang(true)?>/">Homepage</a>
		     </div>
		</div>
	    </div>
	</div>
    </div>

    <div id="footer">
	<div id="footer_inner">
	    <div class="copy">
		Copyright <?php echo date('Y')?> 
	    </div>
	</div>
    </div>

</body>

</html>