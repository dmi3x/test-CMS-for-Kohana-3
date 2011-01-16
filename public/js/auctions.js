// Action for Create Button
$(function(){
    $('#createAuction').dialog({autoOpen: false, width: 300, height: 240, modal: true, close: function(event, ui) {$('#createAuction').html('');}});
})

function showAddAuctionPopup(productId)
{
    $('#createAuction').dialog('open');
    $("#createAuction").html('<div id="modalWindowLoader"></div>');
    $("#createAuction").load("/admin/auction/add/"+productId);
}

function addAuction()
{
    var data = $("#createAuction form").serialize();
    $.ajax({
	'url'  : '/admin/auction/add',
	'data' : data,
	'type' : 'post',
	'success' : function(res) {
	    if(res!='') {
		alert(res);
	    }
	    else {
		$('#createAuction').dialog('close');
		message('Auction added success', true);
	    }
	}
    })
}