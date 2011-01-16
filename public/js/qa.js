// For frontend
var Qa = function(qaBlockId, itemId, perPage, addBox, saveBox) {
    var self = this;
    self.addBox = addBox;
    self.saveBox = saveBox;
    $(function(){
	self.init(qaBlockId, itemId, perPage);
    })
}

Qa.prototype.config = {
    hash : '',
    view : ''
}

Qa.prototype.init = function(qaBlockId, itemId, perPage)
{
    var self = this;
    if(qaBlockId) {
	self.qaBlockId = qaBlockId;
	self.obj = $(self.qaBlockId);
    }
    if(itemId) {
	self.itemId = itemId;
    }
    if(perPage) {
	self.perPage = perPage;
    }
    if(!self.pageNum) {
	self.pageNum = 1;
    }

    self.paginationKeyMatch = '#([0-9]+)$';
    self.pagination = $('.pagination', self.obj);
    $('a', self.pagination).click(function(){
	var href = $(this).attr('href');
	var expr = new RegExp(self.paginationKeyMatch, 'ig');
	var res = expr.exec(href);
	self.pageNum = res ? res[1] : 1;
	self.getList();
	return false;
    });

    if(self.config.view=='admin') {
	$(self.addBox).dialog({ autoOpen: false, width: 400, height: 200, modal: true });
	$(self.saveBox).dialog({ autoOpen: false, width: 400, height: 200, modal: true });
	$('a.delete', self.obj).click(function(){
	    if(!confirm('Realy delete?')) {
		return false;
	    }
	    var href = $(this).attr('href');
	    var expr = new RegExp(self.paginationKeyMatch, 'ig');
	    var res = expr.exec(href);
	    var id = res ? res[1] : 0;
	    if($('a.delete', self.obj).length<2) {
		self.pageNum = 1;
	    }
	    alert($('a.delete', self.obj).length); return false;
	    self.remove(id);
	    return false;
	});
	$('a.edit', self.obj).click(function(){
	    var href = $(this).attr('href');
	    var expr = new RegExp(self.paginationKeyMatch, 'ig');
	    var res = expr.exec(href);
	    var id = res ? res[1] : 0;
	    self.showSaveBox(id, this);
	    return false;
	})
    }
}

Qa.prototype.toggle = function(obj)
{
    if($(obj).parents('.one').hasClass('hidden')) {
	$(obj).parents('.one').removeClass('hidden');
    }
    else {
	$(obj).parents('.one').addClass('hidden');
    }    
}

Qa.prototype.getList = function()
{
    var self = this;
    var data =  'action=getList';
	data += '&pageNum=' + self.pageNum;
	data += '&perPage=' + self.perPage;
	if(self.itemId) {
	    data += '&itemId=' + self.itemId;
	}

    if(self.config.view) {
	data += '&view=' + self.config.view;
	data += '&hash=' + self.config.hash;
    }

    $.ajax({type: "POST",
	  url: '/widget/qa',
	  data: data,
	  success: function(res) {
		self.write(res);
	  }
    })
}

Qa.prototype.write = function(res)
{
    var self = this;
    if(res.substr(0, 1)==1) {
	$(self.obj).html(res.substr(1));
	self.init();
    }
}

// For admin
Qa.prototype.showAddBox = function()
{
    var self = this;
    $(self.addBox).dialog('open');
}

Qa.prototype.showSaveBox = function(id, obj)
{
    var self = this;
    $(self.saveBox).dialog('open');
    var question = $(obj).parents('tr:first').find('.question').html();
    var answer = $(obj).parents('tr:first').find('.answer').html();

    $('[name=question]', self.saveBox).val(question);
    $('[name=answer]', self.saveBox).val(answer);

    self.id = id;
}

Qa.prototype.add = function()
{
    var self = this;

    var data  = 'question=' + $('[name=question]', self.addBox).val();
	data += '&answer=' + $('[name=answer]', self.addBox).val();
	data += '&perPage=' + self.perPage;
	data += '&itemId=' + self.itemId;
	data += '&action=add';

    if(self.config.view) {
	data += '&hash=' + self.config.hash;
	data += '&view=' + self.config.view;
    }

    $('input, textarea', self.addBox).attr('disabled', 'disabled');

    $.ajax({type: "POST",
	  url: '/widget/qa',
	  data: data,
	  success: function(res) {
		self.write(res);
	  },
	  complete: function() {
	        $('[name=question]', self.addBox).val('');
	        $('[name=answer]', self.addBox).val('');
	        $('input, textarea', self.addBox).attr('disabled', '');
	  }
    })
}

Qa.prototype.save = function()
{
    var self = this;

    var data  = 'question=' + $('[name=question]', self.saveBox).val();
	data += '&answer=' + $('[name=answer]', self.saveBox).val();
	data += '&perPage=' + self.perPage;
	data += '&itemId=' + self.itemId;
	data += '&action=save';

    if(self.id) {
	data += '&id=' + self.id;
    }

    if(self.config.view) {
	data += '&hash=' + self.config.hash;
	data += '&view=' + self.config.view;
    }

    $('input, textarea', self.saveBox).attr('disabled', 'disabled');

    $.ajax({type: "POST",
	  url: '/widget/qa',
	  data: data,
	  success: function(res) {
		self.write(res);
	  },
	  complete: function() {
	        $('[name=question]', self.saveBox).val('');
	        $('[name=answer]', self.saveBox).val('');
	        $('input, textarea', self.saveBox).attr('disabled', '');
		$(self.saveBox).dialog('close');
	  }
    })
}

Qa.prototype.remove = function(commentId)
{
    var self = this;
    var data =  'action=delete';
	data += '&id=' + commentId;
	data += '&pageNum=' + self.pageNum;
	data += '&perPage=' + self.perPage;
	data += '&hash=' + self.config.hash;

    if(self.config.view) {
	data += '&view=' + self.config.view;
    }

    $.ajax({type: "POST",
	  url: '/widget/qa',
	  data: data,
	  success: function(res) {
		self.write(res);
	  }
    })
}