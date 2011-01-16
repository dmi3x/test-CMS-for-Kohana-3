function trim (str, charlist) {

    var whitespace, l = 0, i = 0;
    str += '';

    if (!charlist) {
        // default list
        whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    }

    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }

    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }

    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

var checkAll = function(obj){
    var checkboxes = $(obj).parents('form').find('input[type=checkbox]:not(.checkAll)');
    var checked = $(obj).attr('checked') ? 'checked': '';
    checkboxes.each(function(){
	$(this).attr('checked', checked);
    })
}

var checkOne = function(obj) {
    var checkboxes = $(obj).parents('form').find('input[type=checkbox]:not(.checkAll)');
    var countAll = checkboxes.length;
    var countChecked = checkboxes.filter(':checked').length;
    if (countAll==countChecked) {
	$(obj).parents('form').find('.checkAll').attr('checked', 'checked');
    }
    else if(!countChecked) {
	$(obj).parents('form').find('.checkAll').attr('checked', '');
    }
}

function message(text, isOk) {
    $('#messbox .text').html(text);
    $('#messbox').css('opacity',1);
    if(isOk) {
	$('#messbox .inner').addClass('ui-state-highlight');
	$('#messbox .inner').removeClass('ui-state-error');
    }
    else {
	$('#messbox .inner').addClass('ui-state-error');
	$('#messbox .inner').removeClass('ui-state-highlight');
    }
    $('#messbox').show();
    fadeMessage();
}

var fadeMessageTimer;
function fadeMessage()
{
    fadeMessageTimer = setTimeout(function(){
	$('#messbox').animate({'opacity':'0.7'}, 1000);
    }, 1000);
}

$(function(){
    fadeMessage();
})