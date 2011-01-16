<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>CMS</title>
    <link href="/public/css/admin.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="/public/jquery-ui/themes/ui-lightness/jquery-ui-1.8.7.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="/public/js/jquery.js"></script>

    <script type="text/javascript" src="/public/jquery-ui/ui/jquery-ui-1.8.7.custom.min.js"></script>
    <script type="text/javascript" src="/public/jquery-ui/external/jquery.cookie.js"></script>

    <script type="text/javascript" src="/public/jquery-tree/jquery.tree.js"></script>
    <script type="text/javascript" src="/public/jquery-tree/plugins/jquery.tree.cookie.js"></script>

    <script type="text/javascript" src="/public/js/common.js"></script>
    <script type="text/javascript" src="/public/js/url2.js"></script>

    <script language="JavaScript" type="text/javascript">
    /*<![CDATA[*/
	$(function(){
	    $('#admin_nav .group').hover(
		function(){
		    $(this).find('.list').show();
		},
		function(){
		    $(this).find('.list').hide();
		}
	    )
	})
    /*]]>*/
    </script>
</head>

<body>
    
<table id="header" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	<td height="34" align="center">
	    CMS
	    <div id="links"><a href="/admin/auth/logout">Exit</a></div>
	</td>
    </tr>
</table>

<div id="admin_nav">
   <a href="/admin/structure" class="ui-state-default ui-corner-all<?if (Uri::instance()->segment(2)=='structure'):?> ui-state-hover<?endif?>">Structure</a>
   <a href="/admin/config" class="ui-state-default ui-corner-all<?if (Uri::instance()->segment(2)=='config'):?> ui-state-hover<?endif?>">Config</a> 
</div>
<br/>

<table style="border: #8f8f8f 1px solid" width="98%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>

<td width="25%" valign="top" class="mainMenu">
  <?php echo !empty($left)? $left: ''; ?>
</td>
    
<td width="75%" valign="top" class="mainBody">
    <?php $mess = messages::get_last_message();?>
    <div id="messbox" <?php if(!empty($mess)):?>style="display:block"<?php endif?>>
	<div class="ui-widget">
	    <div class="inner <?php if(Arr::get($mess, 'ok')):?>ui-state-highlight<?php else:?>ui-state-error<?php endif?> ui-corner-all" style="margin: 5px 0; padding: 0 10px;">
		<p>
		    <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		    <b class="text"><?php echo Arr::get($mess, 'text', '')?></b>
		</p>
	    </div>
	</div>
    </div>

    <?php echo $breadcrumbs?>

    <div id="mainBox">
	<?php echo !empty($main)? $main: ''; ?>
    </div>
  
</td>
</tr>
</table>

<table class="footer" width="100%" border="0" cellpadding="0">
<tr>
    <td align="center"></td>
</tr>
</table>  

<?php //echo View::factory('profiler/stats');?>

</body>

</html>
