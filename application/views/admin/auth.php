<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>CMS</title>
    <link href="/public/css/admin.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="/public/jquery-ui/themes/ui-lightness/ui.all.css" rel="stylesheet" />
    <script type="text/javascript" src="/public/js/jquery.js"></script>
</head>

<body>

<table id="header" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	<td height="34" align="center">CMS</td>
    </tr>
</table>

<table style="border: #8f8f8f 1px solid" width="98%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td valign="middle" class="mainBody">
	<div id="messbox">
	<?php $mess = messages::get_last_message();?>
	    <?if(@$mess):?>
		    <?if(@$mess['ok']):?>
			    <div class="ui-widget">
				    <div class="ui-state-highlight ui-corner-all" style="margin: 5px 0; padding: 0 10px;">
					    <p>
						    <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						    <b><?=$mess['text']?></b>
					    </p>
				    </div>
			    </div>
		    <?else:?>
			    <div class="ui-widget">
				    <div class="ui-state-error ui-corner-all" style="margin: 5px 0; padding: 0 10px;">
					    <p>
						    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						    <b><?=$mess['text']?></b>
					    </p>
				    </div>
			    </div>
		    <?endif;?>
	    <?endif;?>
	</div>

	<div align="center">
	<h1>Authorization</h1>
	<form name="form" method="post" action="">
	    <table style="margin:100px" >
		<tr>
		    <td>Login:</td>
		    <td><input class="textBox" name="login" type="input" /></td>
		</tr>
		<tr>
		    <td>Password:</td>
		    <td><input class="textBox" name="pass" type="password" /></td>
		</tr>
		<tr>
		    <td colspan="2" align="center"><input name="signin" type="submit" value="Enter" /></td>
		</tr>
	    </table>
	</form>
	</div>

    </td>
</tr>
</table>

<table class="footer" width="100%" border="0" cellpadding="0">
<tr>
<td align="center"></td>
</tr>
</table>

</body>

</html>

