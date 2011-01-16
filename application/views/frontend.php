<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo !empty($title) ? Text::html2text($title, 300, null, true) : '';  ?></title>
    <meta name="keywords" content="<?php echo !empty($keywords) ? Text::html2text($keywords, 300, null, true) : ''; ?>" />
    <meta name="description" content="<?php echo !empty($description) ? Text::html2text($description, 1000, null, true) : ''; ?>" />
    <script type="text/javascript" src="/public/js/jquery.js"></script>
    <link href="/public/css/frontend.css" rel="stylesheet" type="text/css"/>
</head>

<body class="frontend">
    <?php $mess = messages::get_last_message();?>
    <?php if(!empty($mess['text'])):?>
    <div id="messbox" class="<?php if($mess['ok']):?>ok<?php else:?>err<?php endif?>">
	<?php echo $mess['text']?>
    </div>
    <?php endif?>
    <div id="wrap" class="<?php echo Page::urlObjects()->getLast('structure', true)->module?>">
	<div id="container">
	    <div id="header">
                
                <?php if(!empty($test)):?>
                    <?php echo $test?>
                <?php endif?>
                
		<a href="<?php echo Uri::lang(true)?>/" class="logo">LOGO</a>
		<div id="menu">
		    <?php echo View::factory('frontend/menu')?>
		</div>
		<div class="changeLang">
		    <?php if(count(Kohana::config('langs.list'))>0):?>
			<?php foreach(Kohana::config('langs.list') as $key=>$val):?>
			    <?php if($key==Kohana::config('langs.default')) $key=''?>
			    <a href="<?php echo $key?'/'.$key:''?>/<?php echo Uri::instance()?>"><?php echo $val?></a>
			<?php endforeach?>
		    <?php endif?>
		</div>
	    </div>
	    <div id="outer">
		<!-- Content -->
		<?php echo $content; ?>
		<!-- End Conent -->
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

    <?php // echo View::factory('profiler/stats');?>

</html>