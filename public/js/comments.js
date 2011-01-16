// For frontend
var Comments = function(commentsBlockId, itemId, moduleName, perPage, editBoxSelector) {
    var self = this;
    self.editBox = editBoxSelector;
    $(function(){
	self.init(commentsBlockId, itemId, moduleName, perPage);
    })
    //self.isAjax = false;
    // define public functions and properties
}

Comments.prototype.config = {
    hash : '',
    view : ''
}

Comments.prototype.init = function(commentsBlockSelector, itemId, moduleName, perPage)
{
    var self = this;
    if(commentsBlockSelector) {
	self.commentsBlockSelector = commentsBlockSelector;
	self.obj = $(self.commentsBlockSelector);
    }
    if(!self.itemId && !itemId) {
	self.itemId = 0;
    }
    if(itemId) {
	self.itemId = itemId;
    }
    if(moduleName) {
	self.moduleName = moduleName;
    }
    if(perPage) {
	self.perPage = perPage;
    }
    if(!self.pageNum) {
	self.pageNum = 1;
    }

    if(self.adminMode) {
	$(self.editBox).dialog({autoOpen: false, width: 400, height: 200, modal: true});
    }

    //self.paginationKeyMatch = self.isAjax ? '#([0-9]+)' : 'cpage=([0-9]+)';
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
	self.remove(id);
	return false;
    });
    $('a.edit', self.obj).click(function(){
	var href = $(this).attr('href');
	var expr = new RegExp(self.paginationKeyMatch, 'ig');
	var res = expr.exec(href);
	var id = res ? res[1] : 0;
	self.edit(id, this);
	return false;
    })
}

Comments.prototype.getList = function()
{
    var self = this;
    var data =  'action=getList';
	data += '&pageNum=' + self.pageNum;
	data += '&perPage=' + self.perPage;
	if(self.itemId) {
	    data += '&itemId=' + self.itemId;
	}
	data += '&moduleName=' + self.moduleName;
	data += '&hash=' + self.config.hash;

    if(self.config.view) {
	data += '&view=' + self.config.view;
    }

    $.ajax({type: "POST",
	  url: '/widget/comments',
	  data: data,
	  success: function(res) {
		self.write(res);
	  }
    })
}

Comments.prototype.write = function(res)
{
    var self = this;
    $(document).scrollTop(parseInt(self.obj.offset().top));
    if(res.substr(0, 1)==1) {
	$('.list', self.obj).html(res.substr(1));
	self.init();
    }
}

Comments.prototype.add = function()
{
    var self = this;
    var form = $('form', self.obj);

    var rating = $('[name=rating]', form).val();

    var data = form.serialize()
	data += '&perPage=' + self.perPage;
	data += '&itemId=' + self.itemId;
	data += '&moduleName=' + self.moduleName;
	data += '&hash=' + self.config.hash;
	data += '&rating=' + rating;
	data += '&action=add';

    $('input, textarea', form).attr('disabled', 'disabled');

    $.ajax({type: "POST",
	  url: '/widget/comments',
	  data: data,
	  success: function(res) {
		self.write(res);
	  },
	  complete: function() {
	        $('[name=text]', form).val('');
	        $('input, textarea', form).attr('disabled', '');
		//self.isAjax = true;
	  }
    })
}

// For admin
Comments.prototype.remove = function(commentId)
{
    var self = this;
    var data =  'action=delete';
	data += '&commentId=' + commentId;
	data += '&itemId=' + self.itemId;
	data += '&pageNum=' + self.pageNum;
	data += '&perPage=' + self.perPage;
	data += '&hash=' + self.config.hash;

    if(self.config.view) {
	data += '&view=' + self.config.view;
    }

    $.ajax({type: "POST",
	  url: '/widget/comments',
	  data: data,
	  success: function(res) {
		self.write(res);
	  }
    })
}

Comments.prototype.aprove = function(commentId)
{
    var self = this;
    var data =  'action=aprove';
	data += '&commentId=' + commentId;
	data += '&itemId=' + self.itemId;
	data += '&pageNum=' + self.pageNum;
	data += '&perPage=' + self.perPage;
	data += '&hash=' + self.config.hash;

    if(self.config.view) {
	data += '&view=' + self.config.view;
    }

    $.ajax({type: "POST",
	  url: '/widget/comments',
	  data: data,
	  success: function(res) {
		self.write(res);
	  }
    })
}

Comments.prototype.edit = function(id, obj)
{
    var self = this;
    $(self.editBox).dialog('open');
    self.id = id;
    var userName = $(obj).parents('tr:first').find('.userName').html();
    var text = $(obj).parents('tr:first').find('.text').html();
    var rating = $(obj).parents('tr:first').find('.rating').html();

    $('[name=userName]', self.editBox).val(userName);
    $('[name=text]', self.editBox).val(text);
    $('[name=rating]', self.editBox).val(rating);
}

Comments.prototype.save = function()
{
    var self = this;
    var data =  'action=save';
	data += '&userName=' + $('[name=userName]', self.editBox).val();
	data += '&text=' + $('[name=text]', self.editBox).val();
	data += '&rating=' + $('[name=rating]', self.editBox).val();
	data += '&id=' + self.id;
	data += '&itemId=' + self.itemId;
	data += '&pageNum=' + self.pageNum;
	data += '&perPage=' + self.perPage;
	data += '&hash=' + self.config.hash;

    if(self.config.view) {
	data += '&view=' + self.config.view;
    }

    $('input, textarea', self.saveBox).attr('disabled', 'disabled');

    $.ajax({type: "POST",
	  url: '/widget/comments',
	  data: data,
	  success: function(res) {
		self.write(res);
	  },
	  complete: function(res) {
	        $('[name=userName]', self.saveBox).val('');
	        $('[name=text]', self.saveBox).val('');
	        $('[name=rating]', self.saveBox).val('');
	        $('input, textarea', self.saveBox).attr('disabled', '');
		$(self.editBox).dialog('close');
	  }
    })
}