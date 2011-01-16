var Offers = function (addBoxId, editBoxId, pageNum, ajaxUrl) {
    this.init(addBoxId, editBoxId, pageNum, ajaxUrl);
}

Offers.prototype.config = {
    mainBox : '#mainBox',
    ajaxUrl : '',
    pageNum : 1,
    addBoxId : '',
    editBoxId : '',
    editObj : null
}

Offers.prototype.init = function(addBoxId, editBoxId, pageNum, ajaxUrl) {
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
	$(self.config.addBoxId).dialog({autoOpen: false, width: 400, height: 240, modal: true});
	$(self.config.editBoxId).dialog({autoOpen: false, width: 400, height: 240, modal: true});
    })    
}

Offers.prototype.add = function() {
    var self = this;
    var data = $('form', $(self.config.addBoxId)).serialize();
    $('form input, form textarea', $(self.config.addBoxId)).attr('disabled', 'disabled');

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
	      $('form input, form textarea', $(self.config.addBoxId)).attr('disabled', '');
	      $('form textarea', $(self.config.addBoxId)).val('');
	      $('form [name=name]', $(self.config.addBoxId)).val('').focus();
	  }
    })
}

Offers.prototype.save = function() {
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
	      $('form input, form textarea', $(self.config.editBoxId)).attr('disabled', '');
	      $(self.config.editBoxId).dialog('close');
	  }
    })
}

Offers.prototype.showAddBox = function() {
    var self = this;
    $(self.config.addBoxId).dialog('open');
    $('.mes', $(self.config.addBoxId)).html('');
}

Offers.prototype.showEditBox = function(id, obj) {
    var self = this;
    self.config.editObj = obj;

    $.ajax({type: "POST",
	  url: self.config.ajaxUrl,
	  data: '&get=1&id='+id,
	  success: function(res){
	      if(res) {
		  if(res.substr(0, 1)==1) {
			var arr = eval('(' + res.substr(1) + ')');
			$(self.config.editBoxId).dialog('open');
			$('form input[name=name]', $(self.config.editBoxId)).val(arr.name);
			$('form textarea[name=description]', $(self.config.editBoxId)).val(arr.description);
			$('form input[name=id]', $(self.config.editBoxId)).val(arr.id);
		  }
		  else {
		        alert(res);
		  }
	      }
	  }
    })
}