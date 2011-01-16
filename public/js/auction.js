var Class_Auctions = function() {
    var self = this;
    self.types = {};
    self.lots = {};
    self.updateUrl = '/widget/auction/update';
    self.VERSION = 1;
    self.LIVE   = 'live';
    self.ENDING = 'ending';
    self.ENDED  = 'ended';
    self.config = {
	"liveInterval"   : 5000,
	"endingStart"    : 30,
	"hotStart"	 : 10,
	"minBidInterval" : 3,
	"userId"	 : 0
    }
    self.text = {
	"ended"   : 'Ended',
	"stopped" : 'Stopped'
    }
    self.prefix = {
	"lot"      : '#lot_',
	"timer"    : '#timer_',
	"price"    : '#price_',
	"user"     : '#user_',
	"button"   : '#button_',
	"clock"    : '#clock_',
	"bids"     : '#bids'
    }
    self.stopped = false;
    
    $(function(){
	self.init();
    })
}

// Инициируем все лоты через ajax запрос
Class_Auctions.prototype.init = function() {
    var self = this;
    var data = {};
    if(self.lots.length==0) {
	return;
    }
    for(var id in self.lots) {
	data[id] = self.lots[id].price;
	// Forbidden to bet by unregistered users
	if(!self.config.userId) {
	    $(self.prefix.button+id).addClass('disabled');
	}
    }
    self.update(data, function(){
	setTimeout(function(){
	    // Запускаем шарманки
	    self.updateEnding();
	    self.updateLive();
	}, 1000);
    });
    self.countdown();
}

// add, save or replace Lot info
Class_Auctions.prototype.saveLot = function(id, timer, price, user, userId, timeForBid) {
    var self = this;
    var type;

    if(!id) {
	return;
    }
    var liveInterval = self.config.liveInterval/1000;
    // Check timer type
    if(typeof(timer)=='number') {
	if(timer > (self.config.endingStart+liveInterval)) {
	    type = self.LIVE;
	} else if(timer>0 && timer<=(self.config.endingStart+liveInterval)) { 
	    type = self.ENDING;
	} else if(timer<=0) {
	    type = self.ENDED;
	}
    }
    // create new type object
    if(type) {
	if(!self.types[type]) {
	    self.types[type] = {};
	}
	// if already exists but has other type, then delete id from old type
	if(self.lots[id] && self.lots[id].type && self.lots[id].type!=type) {
	    delete self.types[self.lots[id].type][id];
	}
	self.types[type][id] = id;
    }

    // create lot with default values
    if(!self.lots[id]) {
	self.lots[id] = {
	    "id"     : id,
	    "type"   : type,
	    "timer"  : timer,
	    "price"  : price || 0,
	    "user"   : user  || '',
	    "prevPrice"   : 0,
	    // 
	    "timeForBid"  : 0,
	    "userId"	  : 0,
	    "lastBidTime" : 0
	}
	return;
    }
    
    // save new lot info
    if(typeof(timer)=='number') {
	self.lots[id].timer = timer;
    }
    if(price) {
	self.lots[id].prevPrice = self.lots[id].price;
	self.lots[id].price = price;
    }
    if(user) {
	self.lots[id].user = user;
    }
    if(userId) {
	self.lots[id].userId = userId;
    }
    if(type) {
	self.lots[id].type = type;
    }
    if(timeForBid) {
	self.lots[id].timeForBid = timeForBid;
    }
}

// Remove Lot from memory and DOM
Class_Auctions.prototype.removeLot = function(id) {
    var self = this;
    var type;
    if(self.lots[id]) {
	type   = self.lots[id].type;
	delete self.lots[id];
    }
    if(type && typeof(self.types[type][id])!='undefined') {
	delete self.types[type][id];
    }
    if($(self.prefix.lot+id).length>0) {
	$(self.prefix.lot+id).remove();
    }
}

// Send ajax request and save response
Class_Auctions.prototype.update = function(data, callback) {
    var self = this;
    //data = JSON.stringify(data);
    if(typeof(data)!='object') {
	return;
    }
    // script version
    data.ver = self.VERSION;
    
    $.ajax({
	"url"  : self.updateUrl,
	"data" : data,
	"timeout" : 1000,
	"success" : function(res) {
	    self.processResponse(data, res);
	},
	"complete" : function() {
	    if(callback) { 
		callback()
	    }
	}
    })
}

// Process this.update() ajax result
Class_Auctions.prototype.processResponse = function(data, res) {
    var self = this;
    var json;
    try {
	json = eval(res);
    } catch(e) {
	alert(e);
    }
    if(typeof(json)!='object') {
	return;
    }
    // Processing json response
    //	    Server Messages
    if(json.mes) {
	self.message(json.mes);
    }
    //	    Server Command
    if(json.com) {
	if(json.com.redirect) {
	    self.stop();
	    if(json.com.redirect===true) {
		window.location.reload();
	    }
	    else {
		window.location.href = json.com.redirect;
	    }
	    return;
	}
	else if(json.com.stop) {
	    self.stop();
	    return;
	}
    }
    if(json.bids) {
	$(self.prefix.bids).html(json.bids);
    }
    //	   Process Lots
    if(!json.lots) {
	return;
    }
    // if this is bid request
    if(data.bid) {
	var bid = data.bid;
	data = {};
	data[bid] = 0;
    }

    for(var id in data) {
	if(typeof(json.lots[id])=='undefined') {
	    self.removeLot(id);
	    continue;
	}
	// If lot was bidded
	if(typeof(json.lots[id])=='object') {
	    var lot = json.lots[id];
	    try {
		self.saveLot(id, lot.s, lot.p, lot.u, lot.uid, lot.t);
		self.showInfo(id);
	    } catch (e) {
		alert(e);
	    }
	}
	// Update time only
	else {
	    self.saveLot(id, json.lots[id]);
	    // If lot is Ended
	    if(json.lots[id]==0) {
		self.showInfo(id);
	    }
	}
    }
}

// Send ajax request and save response
Class_Auctions.prototype.updateEnding = function() {
    var self = this;
    var data = {};

    // check is empty ending object
    var is_empty = function(){for(var p in self.types.ending) return false; return true;};
    
    if(!self.types.ending || is_empty()) {
	return;
    }

    for(var id in self.types.ending) {
	data[id] = self.lots[id].price;
    }
    self.update(data);
}

// Send ajax request and save response
Class_Auctions.prototype.updateLive = function() {
    var self = this;
    var data = {};

    // check is empty ending object
    var is_empty = function(){for(var p in self.types.live) return false; return true;};

    if(!self.types.live || is_empty()) {
	return;
    }

    for(var id in self.types.live) {
	data[id] = self.lots[id].price;
    }
    self.update(data, function(){
	setTimeout(function(){
	    self.updateLive();
	}, self.config.liveInterval);
    });
}

/* SHOW INFO FUNCTIONS */
Class_Auctions.prototype.showTimer = function(id) {
    var self = this;
    // Get timer string
    var timer;
    if(typeof(self.lots[id].timer)!='number') {
	return;
    }
    if(self.lots[id].timer<=0) {
	timer = self.text.ended;
    }
    else {
	timer = self.getTimer(self.lots[id].timer);
    }

    // Check when lot become Hot
    if(self.lots[id].timer>0 && self.lots[id].timer<=self.config.hotStart) {
	$(self.prefix.lot + id).addClass('hot');
    }
    else {
	$(self.prefix.lot + id).removeClass('hot');
    }
    // Check isset timer block and update it
    if($(self.prefix.timer+id).length>0) {
	$(self.prefix.timer+id).html(timer);	
    }
}

// Update lot html info
Class_Auctions.prototype.showInfo = function(id) {
    var self = this;
    // Update timer
    self.showTimer(id);
    // Do highlight effect of new bid
    if(self.lots[id].prevPrice && self.lots[id].prevPrice != self.lots[id].price) {
	$(self.prefix.timer+id).effect("highlight",{color:"#f00"},600);
    }
    // Update price
    $(self.prefix.price+id).html(self.lots[id].price);
    // Update user
    if(self.lots[id].user && $(self.prefix.user+id).length) {
	$(self.prefix.user+id).html(self.lots[id].user);
    }
    // Check and update Ended lots
    if(self.lots[id].type==self.ENDED && $(self.prefix.lot+id).length) {
	$(self.prefix.lot+id).addClass(self.ENDED);
    }
    // Update "Time for bid"
    if(self.lots[id].timeForBid && $(self.prefix.clock+id).length) {
        $(self.prefix.clock+id).html(self.lots[id].timeForBid);
    }
}
/* END */

// Generate formated timer string from seconds
Class_Auctions.prototype.getTimer = function(secondsLeft) {
    var hours = parseInt(secondsLeft/3600);
    var minutes = parseInt((secondsLeft-hours*3600)/60);
    var seconds = parseInt(secondsLeft-(hours*3600+minutes*60));
    hours = (hours<0) ? 0 : hours;
    hours = (hours<10) ? '0' + hours : hours;
    minutes = (minutes<0) ? 0 : minutes;
    minutes = (minutes<10) ? '0' + minutes : minutes;
    seconds = (seconds<0) ? 0 : seconds;
    seconds = (seconds<10) ? '0' + seconds : seconds;
    return hours + ':' + minutes + ':' + seconds;
}

// Countdown timer, witch update html time of lots
Class_Auctions.prototype.countdown = function() {
    var self = this;

    if(self.stopped) {
	return;
    }

    var is_empty = function(){for(var p in self.lots) return false; return true;};
    if(is_empty()) {
	return;
    }

    // Ending auction interval is 1 sec, like countdown timer
    self.updateEnding();
    
    for(var id in self.lots) {
	var lot = self.lots[id];
	if(lot.type==self.ENDED || lot.timer==1) {
	    continue;
	}
	// Check when lot become Ending
	var liveInterval = self.config.liveInterval/1000;
	if(lot.type!=self.ENDING && lot.timer>0 && lot.timer<=(self.config.endingStart+liveInterval)) {
	    self.saveLot(id);
	}

	var currentTime = new Date().getTime();
	// Forbidden to bet more than minBidInterval
	if($(self.prefix.button+id).length) {
	    if( (currentTime-self.lots[id].lastBidTime) < self.config.minBidInterval*1000 ) {
		$(self.prefix.button+id).addClass('disabled');
	    }
	    // Forbidden to bet Live auction if you are last Bidder
	    else if( self.lots[id].type==self.LIVE && self.lots[id].userId==self.config.userId ) {
		$(self.prefix.button+id).addClass('disabled');
	    }
	    else {
		$(self.prefix.button+id).removeClass('disabled');
	    }
	}

	// update timer
	lot.timer = (lot.timer>0) ? (lot.timer-1) : 0;
	self.showTimer(id);
    }  

    setTimeout(function(){self.countdown()}, 1000);
}

// Do bid
Class_Auctions.prototype.bid = function(id) {
    var self = this;

    if($(self.prefix.button+id).hasClass('disabled')) {
	return;
    }

    var currentTime = new Date().getTime();

    self.lots[id].lastBidTime = currentTime;
    // Do ajax request
    self.update({"bid":id});
}

Class_Auctions.prototype.message = function(message) {
   if(message.text) {
	alert(message.text);
   }
   else {
	alert(message);
   }
}

Class_Auctions.prototype.stop = function() {
    var self = this;
    self.stopped = true;
    if(!self.lots) {
	return;
    }
    for(var id in self.lots) {
	if(self.lots[id].type==self.ENDED || $(self.prefix.lot+id).hasClass('ended')) {
	    continue;
	}
	$(self.prefix.timer+id).html(self.text.stopped);
	$(self.prefix.lot+id).addClass('stopped');
	$(self.prefix.button+id).addClass('disabled');
    }
}

var Auctions = new Class_Auctions;
