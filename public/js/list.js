var List = function (addBoxId, editBoxId, pageNum, ajaxUrl) {
    this.init(addBoxId, editBoxId, pageNum, ajaxUrl);
}

List.prototype.config = {
    mainBox : '#mainBox',

    ajaxUrl : '',
    pageNum : 1,
    addBoxId : '',
    editBoxId : '',
    editObj : null,
    dislogOptions : {autoOpen: false, width: 400, height: 150, modal: true}
}

List.prototype.init = function(addBoxId, editBoxId, pageNum, ajaxUrl) {
    var self = this;
    if(!addBoxId) {
	return false;
    }
    if(!editBoxId) {
	return false;
    }
    self.config.addBoxId = addBoxId;
    self.config.editBoxId = editBoxId;
    self.config.pageNum = pageNum || 1;
    self.config.ajaxUrl = ajaxUrl;

    $(function() {
	$(self.config.addBoxId).dialog(self.config.dislogOptions);
	$(self.config.editBoxId).dialog(self.config.dislogOptions);
    })    
}

List.prototype.add = function() {
    var self = this;
    var data = $('form', $(self.config.addBoxId)).serialize();
    $('form input', $(self.config.addBoxId)).attr('disabled', 'disabled');

    $.ajax({type: "POST",
	  url: self.config.ajaxUrl,
	  data: data + '&add=1',
	  success: function(res){
	      if(res) {
		  if(res.substr(0, 1)==1) {
		        $(self.config.mainBox).html(res.substr(1));
		        $('.mes', $(self.config.addBoxId)).stop();
		        $('.mes', $(self.config.addBoxId)).css({opacity:1}).html('added').animate({opacity:'0.4'}, 2000);
		  }
		  else {
			alert(res);
		  }
	      }
	  },
	  complete: function(){
	      $('form input', $(self.config.addBoxId)).attr('disabled', '');
	      $('form input[name=name]', $(self.config.addBoxId)).val('').focus();
	  }
    })
}

List.prototype.save = function() {
    var self = this;
    var data = $('form', $(self.config.editBoxId)).serialize();
    $('form input', $(self.config.editBoxId)).attr('disabled', 'disabled');

    $.ajax({type: "POST",
	  url: self.config.ajaxUrl+"?page="+self.config.pageNum,
	  data: data + '&save=1',
	  success: function(res){
	      if(res) {
		  if(res.substr(0, 1)==1) {
			$(self.config.mainBox).html(res.substr(1));
		  }
		  else {
		        alert(res);
		  }
	      }
	  },
	  complete: function(){
	      $('form input', $(self.config.editBoxId)).attr('disabled', '');
	      $(self.config.editBoxId).dialog('close');
	  }
    })
}

List.prototype.showAddBox = function() {
    var self = this;
    $(self.config.addBoxId).dialog('open');
    $('.mes', $(self.config.addBoxId)).html('');
}

List.prototype.showEditBox = function(id, val, obj) {
    var self = this;
    self.config.editObj = obj;
    $(self.config.editBoxId).dialog('open');
    $('form input[name=name]', $(self.config.editBoxId)).val(val);
    $('form input[name=id]', $(self.config.editBoxId)).val(id);
}