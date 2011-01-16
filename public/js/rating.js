var Rating = function(starsSelector, itemId, alreadyRated) {
    var self = this;
    self.rating = 0;
    $(document).ready(function(){
	self.init(starsSelector, itemId, alreadyRated);
    })
}

Rating.prototype.init = function(starsSelector, itemId, alreadyRated) {
    var self = this;
    if(alreadyRated) {
	return false;
    }
    self.itemId = itemId;
    self.obj = $(starsSelector);

    $('span', self.obj).css('cursor', 'pointer');

     $('span', self.obj).hover(
	  function(){
	     var index = $(this).parent().find('span').index(this);
	     $(this).parent().find('span:lt('+(index+1)+')').addClass('hover1');
	     $(this).parent().find('span:gt('+(index)+')').addClass('hover0');
	  },
	  function(){
	     if(self.rating>0) {
		 $(this).parent().find('span').removeClass('hover1').removeClass('hover0');
		 $(this).parent().find('span:lt('+(self.rating)+')').addClass('hover1');
	     }
	     else {
		 $(this).parent().find('span').removeClass('hover1').removeClass('hover0');
	     }
	     
	  }
     );

     $('span', self.obj).click(function(){
	    self.set(this)
     });
}

// comments variant
Rating.prototype.set = function(obj) {
    var self = this;
    var index = $(obj).parent().find('span').index(obj);
    self.rating = index + 1;
    $('[name=rating]', self.form).val(self.rating);
}

// ajax variant
//Rating.prototype.set = function(obj)
//{
//    var self = this;
//
//    var index = $(obj).parent().find('span').index(this);
//
//    $.ajax({
//	  type: "POST",
//	  url: "/ajax",
//	  data: "rate="+(index+1)+"&id="+self.itemId,
//	  async: false,
//	  success: function(msg) {
//		 if(msg.substr(0,1)=='1') {
//		      $('span', self.obj).unbind('mouseenter').unbind('mouseleave').unbind('click').css('cursor','default');
//		      //showMsg('Ваш голос засчитан',1);
//		      alert('ok');
//		 }
//		 else if (msg=='') {
//		     return false;
//		 }
//		 else {
//		     //showMsg(msg,0);
//		     alert(msg);
//		 }
//	   }
//    });
//    return false;
//}