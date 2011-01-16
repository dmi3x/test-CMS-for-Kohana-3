var Testimonials = function (addBoxId, editBoxId, pageNum, ajaxUrl) {
    this.init(addBoxId, editBoxId, pageNum, ajaxUrl);
}

Testimonials.prototype.config = {
    mainBox : '#mainBox',
    ajaxUrl : '',
    pageNum : 1,
    addBoxId : '',
    editBoxId : '',
    editObj : null
}

Testimonials.prototype.init = function(addBoxId, editBoxId, pageNum, ajaxUrl) {
    var self = this;
    if(!addBoxId) {
	alert('Require Add Box Id');
    }
    if(!editBoxId) {
	alert('Require Edit Box Id');
    }
    self.config.addBoxId = addBoxId;
    self.config.editBoxId = editBoxId;
    self.config.pageNum = pageNum || 1;
    self.config.ajaxUrl = ajaxUrl;

    $(function() {
	$(self.config.addBoxId).dialog({autoOpen: false, width: 400, height: 200, modal: true});
	$(self.config.editBoxId).dialog({autoOpen: false, width: 400, height: 200, modal: true});
    })    
}

Testimonials.prototype.showAddBox = function() {
    var self = this;
    $(self.config.addBoxId).dialog('open');
}

Testimonials.prototype.showEditBox = function(id) {
    var self = this;

    $.ajax({type: "POST",
	  url: self.config.ajaxUrl,
	  data: '&action=get&id='+id,
	  success: function(res){
	      if(!res) {
		    return;
	      }
	      if(res.substr(0, 1)==1) {
		    var arr = eval('(' + res.substr(1) + ')');
		    $(self.config.editBoxId).dialog('open');
		    $('form input[name=title]', $(self.config.editBoxId)).val(arr.title);
		    $('form [name=text]', $(self.config.editBoxId)).val(arr.text);
		    $('form input[name=id]', $(self.config.editBoxId)).val(arr.id);
		    return;
	      }
	      alert(res);
	  }
    })
}