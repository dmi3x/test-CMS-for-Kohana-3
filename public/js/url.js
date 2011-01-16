function str2URL (str)
{
	//if(!str) return '';
	
	var newStr='';
	var arr = {'ё':'e','й':'i','ц':'c','у':'y','к':'k','е':'e','н':'n','г':'g','ш':'sh','щ':'sh','з':'z','х':'h','ъ':'','ф':'f','ы':'i','в':'v','а':'a','п':'p','р':'r','о':'o','л':'l','д':'d','ж':'j','э':'e','я':'ya','ч':'ch','с':'s','м':'m','и':'i','т':'t','ь':'','б':'b','ю':'u'};
	str = str.toLocaleLowerCase();
	for (i=0;i<str.length;i++)
	{
	   if (typeof(arr[str.charAt(i)])!=='undefined') {
	       newStr += arr[str.charAt(i)];
	   }
	   else {
	       newStr += str.charAt(i);
	   }
	}
	newStr = newStr.replace(/\s+/g,'-');
	newStr = newStr.replace(/-+/g,'-');
	newStr = newStr.replace(/[^a-z0-9_-]/g,'');
	return newStr;
}

function insertURLBox (prefix, url, width)
{
	if(!width) {
	    width = 99;
	}
	var html = '';
	html += '<input id="'+prefix+'FullURL" type="text" readonly="readonly" class="textBox" value="" style="width: '+width+'%" />';
	html += '&nbsp;&nbsp; <a href="#" onclick="return updateURL(\''+prefix+'\');">Generate</a>';
	html += '&nbsp;&nbsp; <a href="#" onclick="return changeURLAlert(\''+prefix+'\')">Change</a>';
	html += '<input id="'+prefix+'URL" name="alias" type="hidden" value="'+url+'" />';
	html += '<input id="'+prefix+'ParentURL" type="hidden" value="" />'		
    
	$("#"+prefix+"URLHolder").html(html);
	updateURLParent(prefix);
}

function updateURLParent (prefix)
{
	$("#"+prefix+"ParentID").attr("disabled", "disabled");
	
	var parentID = $("#"+prefix+"ParentID").val();
	$.post('/admin/structure/getParentURL', { parentID: parentID}, function(data)
	{
		$("#"+prefix+"ParentURL").val(data);
		updateURL (prefix, $("#"+prefix+"URL").val());
		$("#"+prefix+"ParentID").attr("disabled", "");
	});	
}

function updateURL (prefix, url)
{	
	if (url) {
	    url = str2URL(url);
	}
	else {
	    url = str2URL($("#"+prefix+"Title").val());
	}
	
	if ($("#"+prefix+"Home").attr("checked")) {
	    url = "";
	}
	
	var parentURL = $("#"+prefix+"ParentURL").val();

	if(parentURL!='') {
	    parentURL = '/'+parentURL;
	}
	$("#"+prefix+"FullURL").val(parentURL + "/" + url);
	$("#"+prefix+"URL").val(url);
	
	return false;
}

function changeURLAlert (prefix) 
{
	var url = prompt("Address mast contain only latin or numbers or symbols _-", "");
	updateURL(prefix, url);
	return false;
}