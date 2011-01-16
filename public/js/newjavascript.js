var debugging=false;
var pageID=0;
var pageVersion=0;
var flashReady=false;
var flashInitalized=false;
var removeWatchedDiv=false;
var clockAdd=0;
var priceAdd=0;
var auctionDetailedID=0;
var buyitnowTime=0;
var timerBuyItNowID;
var clockTime=0;
var realBids=0;
var realBidsValue=0;
var freeBids=0;
var accountUsername="";
var lastBidReplace="";
var bidoActive=false;
var auctionWorth=0;
var ignoreOf=false;
var lastUpdateCount=0;
var isGeoEnabled=false;
var isProfilesEnabled=false;
var reloadTimeout=null;
var reloadTimeoutBig=null;
var hasWatchedAuctions=false;
function Class_Auctions(){
    var O=new Array();
    var H=new Array();
    var n=new Array();
    var k=new Array();
    var C;
    var I=new Array();
    var ab=new Array();
    var ae=0;
    var u=0;
    var T=1;
    var ac=new Array();
    var D=0;
    var ad=0;
    var N=0;
    var r=true;
    var u=0;
    var b;
    var g;
    var f=0;
    var o=0;
    var j=false;
    var ah=false;
    var h=0;
    var ag="";
    var L=0;
    var Z=0;
    var P=0;
    var v=0;
    var K=0;
    var B=new Array();
    var U=false;
    var i=new Date();
    var R=0;
    var Q=i.getTime();
    var A=i.getTime();
    var J="";
    var G=0;
    var y=1;
    var a="";
    var d=new Array();
    this.getPauseState=function(){
	return U
	};

    this.initializeInterval=function(){
	try{
	    if(flashReady==true&&flashInitalized==false){
		loadFeatured()
		}
		if(loggedIn&&pageID==2){
		T=1
		}
		if(O.length>0){
		Auctions.auctionInterval();
		C=$.timer(T*1000,Auctions.auctionInterval)
		}
	    }catch(ai){
	if(debugging&&console){
	    console.log(ai,"JS Error")
	    }
	}
};

this.killAuctions=function(){
    try{
	if(debugging&&y>=2){
	    console.log("Pausing updates")
	    }
	    O=new Array();
	U=true;
	if(C){
	    C.stop()
	    }
	    C=null
	}catch(ai){
	if(debugging&&console){
	    console.log(ai,"JS Error")
	    }
	}
};

this.registerFeatured=function(ai){
    try{
	if(ai==null){
	    return
	}
	if(ai.constructor.toString().indexOf("Array")==-1){
	    H.push(""+ai+"")
	    }else{
	    $.each(ai,function(al,ak){
		H.push(""+ak+"")
		})
	    }
	    this.registerAuctions(ai)
	}catch(aj){
	if(debugging&&console){
	    console.log(aj,"JS Error")
	    }
	}
};

this.registerAuctionSpot=function(ak,ai){
    try{
	if(!ak||!ai){
	    return
	}
	if(debugging&&y>=2){
	    console.log("Registering Spot: "+ak+" ("+ai+")")
	    }
	    O.push(""+ak+"");
	O=$.unique(O);
	if(!ac[ai]){
	    ac[ai]=new Array()
	    }
	    ac[ai].push(""+ak+"")
	}catch(aj){
	if(debugging&&console){
	    console.log(aj,"JS Error")
	    }
	}
};

this.registerAuctions=function(ai){
    try{
	if(ai==null){
	    return
	}
	if(ai.constructor.toString().indexOf("Array")==-1){
	    if(debugging&&y>=2){
		console.log("Registering: "+ai)
		}
		O.push(""+ai+"")
	    }else{
	    $.each(ai,function(al,ak){
		O.push(""+ak+"");
		if(debugging&&y>=2){
		    console.log("Registering: "+ak)
		    }
		})
	}
	O=$.unique(O)
    }catch(aj){
    if(debugging&&console){
	console.log(aj,"JS Error")
	}
    }
};

this.unregisterAuction=function(ak){
    try{
	var ai=new Array();
	if(debugging&&y>=2){
	    console.log("Unregistering: "+ak)
	    }
	    $.each(O,function(am,al){
	    if(""+al+""!=""+ak+""){
		ai.push(""+al+"")
		}
	    });
    O=ai
    }catch(aj){
    if(debugging&&console){
	console.log(aj,"JS Error")
	}
    }
};

this.unregisterAuctionSpots=function(aj){
    try{
	if(aj==null){
	    return
	}
	if(debugging&&y>=2){
	    console.log("Unregistering Category: "+aj)
	    }
	    if(!ac[aj]){
	    ac[aj]=new Array()
	    }
	    if(debugging&&y>=2){
	    console.log(ac[aj],"category")
	    }
	    var ai=new Array();
	$.each(O,function(am,al){
	    if(!jQuery.inArray(""+al+"",ac[aj])||""+al+""==""+auctionDetailedID+""){
		ai.push(""+al+"")
		}
	    });
    O=ai;
    ac[aj]=new Array()
    }catch(ak){
    if(debugging&&console){
	console.log(ak,"JS Error")
	}
    }
};

this.clearCh=function(){
    J=""
    };

this.auctionInterval=function(){
    try{
	if(U==true){
	    if(debugging&&y>=2){
		console.log("Updates paused...")
		}
		return
	}
	if(O.length<1){
	    if(C!=null){
		C.stop()
		}
		return
	}
	if(flashReady==true&&flashInitalized==false){
	    loadFeatured()
	    }
	    var ak=new Date();
	var am=ak.getTime();
	var ao=false;
	var ai=am-R;
	if(ai>0){
	    ai/=1000
	    }
	    if(am-G>=30*1000||G==0){
	    G=am;
	    ao=true
	    }
	    var al=new Array();
	$.each(O,function(ap,ar){
	    if(!ao&&""+auctionDetailedID+""!=""+ar+""&&((ab[ar]>120)||(loggedIn&&ab[ar]>20&&lastUpdateCount<2)||(!loggedIn&&ab[ar]-ai>3&&ab[ar]>20&&lastUpdateCount<2))){
		var aq=Array();
		aq.sl=ab[ar]-ai;
		if(aq.sl<1){
		    aq.sl=1
		    }
		    if(a=="Paused"){
		    aq.s="Paused"
		    }
		    if($("#auction_"+ar+"s")){
		    l(ar+"s",aq,true,true)
		    }
		    if($("#auction_"+ar)||auctionDetailedID==ar){
		    l(ar,aq,true,true)
		    }
		}else{
	    al.push(ar+""+(I[ar]?"|"+I[ar]:""))
	    }
	});
lastUpdateCount++;
if(lastUpdateCount>=2){
    lastUpdateCount=0
    }
    R=am;
if(al.length==0){
    return
}
var aj="/ajax/u.php?ids="+al.join(",");
if(pageID&&pageID>0){
    aj+="&p="+pageID
    }
    aj+="&o=3";
if(J!=""){
    aj+="&ch="+J
    }
    if(K){
    aj+="&l="+K
    }
    if(auctionDetailedID>0){
    aj+="&lb_id="+auctionDetailedID+"&lb="+u+"&c="+clockAdd
    }
    if(bidoActive){
    aj+="&bido=1"
    }
    if(r){
    aj+="&f=1"
    }
    $.ajax({
    url:aj,
    cache:false,
    dataType:"json",
    timeout:1500,
    success:af
});
var ak=new Date();
if(!ignoreOf&&R-A>3600000){
    U=true;
    $("#popupModal").html("<strong>You have not had any activity in 30 minutes, are you still here?</strong>");
    $(function(){
	$("#popupModal").dialog({
	    modal:true,
	    title:"QuiBids Inactivity",
	    width:300,
	    buttons:{
		"I'm Back!":function(){
		    location.reload(true);
		    $(this).dialog("close");
		    return true
		    }
		}
	})
    })
}
}catch(an){
    if(debugging&&console){
	console.log(an,"JS Error")
	}
    }
};

var af=function(av){
    try{
	if(av.errorText){
	    if(av.errorText.indexOf("You have now used more bids than the product is worth. Please use the BuyItNow option.")>-1){
		var au=new Array();
		au=av.errorText.split("#");
		if(au.length>1){
		    BuyItNowPopup(au[1],true);
		    return
		}
	    }else{
	    errorMsg(av.errorText)
	}
	return
    }
    if(J!=""){
	setTimeout("Auctions.clearCh()",1000*5)
	}
	var aq=false;
    var ar=null;
    if(flashReady){
	ar=document.getElementById("quibids")
	}
	for(id in av){
	try{
	    if(id=="bidinfo"){
		Auctions.updateBidsAvailable(av[id],true);
		continue
	    }else{
		if(id=="realbids"){
		    realBids=av[id];
		    aq=true;
		    continue
		}else{
		    if(id=="freebids"){
			freeBids=av[id];
			aq=true;
			continue
		    }else{
			if(id=="k"){
			    J=av[id];
			    continue
			}else{
			    if(id=="realbidsvalue"){
				realBidsValue=av[id];
				aq=true;
				continue
			    }else{
				if(id=="limits"){
				    q(av[id]);
				    continue
				}else{
				    if(id=="message"){
					errorMsg(av[id]);
					continue
				    }else{
					if(id=="hcgw"){
					    z();
					    continue
					}else{
					    if(id=="rateLimit"){
						var ai=new Date();
						if(ai.getTime()-h>100000){
						    var ak="<font color='red'>Warning:</font> It has been detected that you are utilizing more than your allocated resources on QuiBids. This is typically caused by having an excess number of 'windows' or 'tabs' open with active QuiBids auctions. Please reduce your number of windows/tabs open to no more than 4. Failure to do so will result in your computer being temporarily banned from participation in auctions. Please contact support@quibids.com if you have questions.";
						    errorMsg(ak,"Rate Limits");
						    h=ai.getTime();
						    G=0
						    }
						    continue
					    }else{
						if(id=="bido"&&bidoActive){
						    if(!$("#bido_num_show")){
							continue
						    }
						    if(av[id].avail=="0"){
							p();
							continue
						    }
						    $("#bido_num_show").html(av[id].avail+" / "+av[id].num);
						    continue
						}else{
						    if(id=="clockAdd"&&$("#clockImage")){
							clockAdd=av[id];
							if($("#clockImage").hasClass("clock10")){
							    $("#clockImage").removeClass("clock10")
							    }
							    if($("#clockImage").hasClass("clock15")){
							    $("#clockImage").removeClass("clock15")
							    }
							    if($("#clockImage").hasClass("clock20")){
							    $("#clockImage").removeClass("clock20")
							    }
							    if(clockAdd==10){
							    if(!$("#clockImage").hasClass("clock10")){
								$("#clockImage").toggleClass("clock10")
								}
							    }else{
							if(clockAdd==15){
							    if(!$("#clockImage").hasClass("clock15")){
								$("#clockImage").toggleClass("clock15")
								}
							    }else{
							if(!$("#clockImage").hasClass("clock20")){
							    $("#clockImage").toggleClass("clock20")
							    }
							}
						}
					    continue
				    }else{
					if(id=="lateBid"){
					    if($("#costs")&&(av[id]==auctionDetailedID||id==auctionDetailedID)){
						var aw="Your bid was successful, but would have been too late<br>if someone else had not bid! You should bid sooner.";
						$("#costs").html('<strong><font color="red">WARNING: <span onmouseout="UnTip()" onmouseover="Tip(\''+aw+"')\">You're waiting too long to bid!</span></font></strong>");
						if(g){
						    clearTimeout(g)
						    }
						    g=setTimeout("Auctions.lateBidSwitch()",6000)
						}
						continue
					}else{
					    if(id=="bc"){
						if(av[id]!=N&&$("#bh_Bidders")){
						    N=av[id];
						    $("#bh_Bidders").html(N+" Bidder"+(N>1?"s":""))
						    }
						    continue
					    }else{
						if(id=="bc_geo"){
						    if(isGeoEnabled){
							setTimeout("updateGeoMap('"+av[id]+"')",10)
							}
							continue
						}else{
						    if(av[id].constructor.toString().indexOf("Number")>0){
							var at=Array();
							at.sl=av[id];
							if($("#auction_"+id+"s")){
							    l(id+"s",at,true)
							    }
							    if($("#auction_"+id)||auctionDetailedID==id){
							    l(id,at,true)
							    }
							    continue
						    }
						}
					    }
				    }
			    }
		    }
	    }
    }
    }
}
}
}
}
}
}
if($("#auction_"+id+"s")){
    l(id+"s",av[id],false)
    }
    if($("#auction_"+id)||auctionDetailedID==id){
    l(id,av[id],false)
    }
    if(auctionDetailedID==id){
    var ap="default";
    if(av[id].av){
	ap=av[id].av
	}
	if($("#avatarimage")){
	$("#avatarimage").attr("src","http://s1.quibidscdn.com/avatards/"+ap+".png")
	}
    }
if(auctionDetailedID==id&&av[id].bh&&av[id].bh.length>0){
    var aj=false;
    var an=0;
    $.each(av[id].bh,function(ax,ay){
	if(ay.id==u){
	    return
	}
	if(ay.id>u){
	    u=ay.id
	    }
	    aj=true;
	k.push(ay);
	an++
    });
    k.sort(function(ax,ay){
	if(ax.id<ay.id){
	    return -1
	    }
	    if(ax.id>ay.id){
	    return 1
	    }
	    if(ax.id==ay.id){
	    return 0
	    }
	});
if(k.length>15){
    k.shift()
    }
    if(aj){
    setTimeout("Auctions.updateBidHistory("+an+")",10)
    }
}
}catch(ao){
    if(debugging&&console){
	console.log(ao,"JS Error")
	}
	continue
}
}
var ai=new Date();
B.push(ai.getTime()-R);
if(B.length>5){
    B.shift()
    }
    Auctions.updateConnectionSpeed();
if(r){
    r=false
    }
    if(aq){
    c()
    }
    if(flashReady&&ar){
    for(id in av){
	if(H.indexOf(id)>-1){
	    if(av[id].s&&av[id].s=="Paused"&&av[id].sl&&av[id].p){
		var al=av[id].p;
		var am=al.toFixed(2);
		ar.updateAuction(id,am,0)
		}else{
		if(av[id].sl&&av[id].p){
		    var al=av[id].p;
		    var am=al.toFixed(2);
		    ar.updateAuction(id,am,av[id].sl)
		    }
		}
	}
    }
}
}catch(ao){
    if(debugging&&console){
	console.log(ao,"JS Error")
	}
    }
};

this.updateBidsAvailable=function(al,ai){
    try{
	bidsAvailable=al.Total;
	if($("#bids_available")){
	    $("#bids_available").html(bidsAvailable)
	    }
	    bidsAvailable_Real=al.Real;
	if($("#bids_available2")){
	    var aj=bidsAvailable_Real+" Real / "+bidsAvailable_Free+" Voucher Left";
	    $("#bids_available2").attr("title",aj)
	    }
	    bidsAvailable_Free=al.Free;
	if($("#bids_available2")){
	    var aj=bidsAvailable_Real+" Real / "+bidsAvailable_Free+" Voucher Left";
	    $("#bids_available2").attr("title",aj)
	    }
	    try{
	    if(ai){
		QBar.updateBidsAvailable(al)
		}
	    }catch(ak){}
}catch(ak){
    if(debugging&&console){
	console.log(ak,"JS Error")
	}
    }
};

var l=function(am,ay,ak,al){
    try{
	var aw=(am==auctionDetailedID?"2":"");
	var aj=am.replace("s","");
	var az="Active";
	if(ay.s){
	    az=ay.s;
	    if(az!=a&&!al){
		a=az
		}
	    }
	if(a=="Paused"&&az!="Completed"&&ay.s){
	az="Paused"
	}
	var ax="#button_"+am;
    if(az=="Completed"){
	var ao="#soldtag_"+am;
	if($(ao)&&!$(ao).hasClass("sold-stamp-visible")){
	    $(ao).toggleClass("sold-stamp-visible")
	    }
	    Auctions.unregisterAuction(""+aj+"");
	n.push(aj);
	if(pageID==1){
	    if(!reloadTimeout){
		reloadTimeout=setTimeout("Auctions.reloadAuctions()",1000*20)
	    }
	}else{
	if(pageID==2&&aj!=auctionDetailedID){
	    if(!reloadTimeout){
		reloadTimeout=setTimeout("Auctions.reloadAuctions()",1000*20)
		}
	    }else{
	if(pageID==9){
	    if(!reloadTimeout){
		reloadTimeout=setTimeout("Auctions.reloadAuctions()",1000*5)
		}
	    }
    }
}
if($(ax)){
    if($(ax).hasClass("paused")){
	$(ax).removeClass("paused")
	}
	if($(ax).hasClass("bid-logged")){
	$(ax).removeClass("bid-logged")
	}
	if($(ax).hasClass("bid")){
	$(ax).removeClass("bid")
	}
	if($(ax).hasClass("bidonme")){
	$(ax).removeClass("bidonme")
	}
	if($(ax).hasClass("bidonme_orange")){
	$(ax).removeClass("bidonme_orange")
	}
	if($(ax).hasClass("loginfirst")){
	$(ax).removeClass("loginfirst")
	}
	if($(ax).hasClass("loginfirst_orange")){
	$(ax).removeClass("loginfirst_orange")
	}
	if($(ax).hasClass("bidonme_small")){
	$(ax).removeClass("bidonme_small")
	}
	if(aj!=auctionDetailedID){
	if(!$(ax).hasClass("sold")){
	    $(ax).toggleClass("sold")
	    }
	}
}
if(pageID==2&&aj==auctionDetailedID){}
ay.sl=0
}else{
    if($(ax)&&az=="Paused"){
	if($(ax).hasClass("bid-logged")){
	    $(ax).removeClass("bid-logged")
	    }
	    if($(ax).hasClass("bid")){
	    $(ax).removeClass("bid")
	    }
	    if($(ax).hasClass("bidonme")){
	    $(ax).removeClass("bidonme")
	    }
	    if($(ax).hasClass("bidonme_orange")){
	    $(ax).removeClass("bidonme_orange")
	    }
	    if($(ax).hasClass("loginfirst")){
	    $(ax).removeClass("loginfirst")
	    }
	    if($(ax).hasClass("loginfirst_orange")){
	    $(ax).removeClass("loginfirst_orange")
	    }
	    if($(ax).hasClass("bidonme_small")){
	    $(ax).removeClass("bidonme_small")
	    }
	    if(!$(ax).hasClass("paused")){
	    $(ax).toggleClass("paused")
	    }
	}else{
    if($(ax)&&az=="Active"&&auctionDetailedID==aj&&!ax.endsWith("s")){
	if($(ax).hasClass("paused")){
	    $(ax).removeClass("paused")
	    }
	    if(loggedIn){
	    if(!$(ax).hasClass("bid-logged")){
		$(ax).toggleClass("bid-logged")
		}
	    }else{
	if(!$(ax).hasClass("bid")){
	    $(ax).toggleClass("bid")
	    }
	}
}else{
    if($(ax)&&az=="Active"){
	if($(ax).hasClass("paused")){
	    $(ax).removeClass("paused")
	    }
	    if(loggedIn){
	    if(ax.endsWith("s")&&!$(ax).hasClass("bidonme_orange")){
		$(ax).toggleClass("bidonme_orange")
		}else{
		if(!ax.endsWith("s")&&!$(ax).hasClass("bidonme")){
		    $(ax).toggleClass("bidonme")
		    }
		}
	}else{
    if(ax.endsWith("s")&&!$(ax).hasClass("loginfirst_orange")){
	$(ax).toggleClass("loginfirst_orange")
	}else{
	if(!ax.endsWith("s")&&!$(ax).hasClass("loginfirst")){
	    $(ax).toggleClass("loginfirst")
	    }
	}
}
}
}
}
}
if(az=="Active"&&ay.p&&I[aj]>0&&ay.p<I[aj]){
    return
}
var an="#timer_"+am;
if($(an)&&(ay.sl>0&&az=="Active")){
    if(!$(an).hasClass("timer"+aw)){
	$(an).toggleClass("timer"+aw)
	}
	if(aw=="2"){
	clockTime=ay.sl
	}
	if(ay.sl&&aj){
	var av=ay.sl;
	ab[""+aj+""]=av
	}
	if(ay.sl<=10){
	if(!$(an).hasClass("timer_10togo")){
	    $(an).toggleClass("timer_10togo")
	    }
	    if(aw&&$(an).hasClass("timer"+aw)){
	    $(an).removeClass("timer"+aw)
	    }
	    if(!aw&&$(an).hasClass("timer"+aw)){
	    $(an).removeClass("timer"+aw)
	    }
	    if(aw&&!$(an).hasClass("timer2ending")){
	    $(an).toggleClass("timer2ending")
	    }
	    if($(an).hasClass("time-left")){
	    $(an).removeClass("time-left")
	    }
	    if(!$(an).hasClass("time-leftending")){
	    $(an).toggleClass("time-leftending")
	    }
	}else{
    if($(an).hasClass("timer_10togo")){
	$(an).removeClass("timer_10togo")
	}
	if($(an).hasClass("time-leftending")){
	$(an).removeClass("time-leftending")
	}
	if(!$(an).hasClass("time-left")){
	$(an).toggleClass("time-left")
	}
	if(aw=="2"&&$(an).hasClass("timer2ending")){
	$(an).removeClass("timer2ending")
	}
    }
var at="";
if(ay.sl<1){
    ay.sl=1
    }
    var au=0;
au=parseInt(ay.sl/3600);
at+=((au>9)?"":"0")+au+":";
au=parseInt((ay.sl/60)%60);
at+=((au>9)?"":"0")+au+":";
au=parseInt(ay.sl%60);
at+=((au>9)?"":"0")+au;
$(an).html(at);
try{
    if(qBarEnabled){
	QBar.auctionUpdateTime(aj,ay.sl,at)
	}
    }catch(aq){}
if(aw){
    D=(ay.sl-ad);
    if(D<0){
	D=0
	}
	ad=ay.sl
    }
}else{
    if(az=="Paused"&&$(an)){
	if(!$(an).hasClass("ended"+aw)){
	    $(an).toggleClass("ended"+aw)
	    }
	    if($(an)){
	    $(an).html("--:--:--")
	    }
	    if($(an+"2")){
	    $(an+"2").html("--:--:--")
	    }
	}else{
    if($(an)&&az=="Completed"){
	if(!$(an).hasClass("ended"+aw)){
	    $(an).toggleClass("ended"+aw)
	    }
	    $(an).html("<font color='silver'>Ended</font>");
	try{
	    if(qBarEnabled){
		QBar.auctionUpdateTime(aj,0)
		}
	    }catch(aq){}
    if(aw=="2"){
	clockTime=0
	}
	if(aj){
	ab[""+aj+""]=0
	}
    }
}
}
if(ak){
    return
}
if(ay.p!=undefined){
    var ar="#price_"+am;
    I[aj]=ay.p;
    var ap=parseCurrency(ay.p);
    if($(ar)&&$(ar).html()!="$"+ap){
	$(ar).html("$"+ap+"");
	try{
	    if(qBarEnabled){
		QBar.auctionUpdatePrice(aj,ap)
		}
	    }catch(aq){}
    if(auctionDetailedID==aj){
	if(ay.p>ae){
	    ae=ay.p
	    }
	    c()
	}
	if(!r){
	$(ar).effect("highlight",{
	    color:"#f66b6b"
	},600)
	}
    }
}
if(ay.lb||(ay.lb!=undefined&&ay.lb=="")){
    var ai="#winning_"+am;
    if(ay.lb==""){
	ay.lb="No Bids Yet!"
	}
	if($(ai)&&$(ai).html()!=ay.lb){
	$(ai).html(ay.lb)
	}
	if(aw=="2"){
	ag=ay.lb
	}
    }
}catch(aq){
    if(debugging&&console){
	console.log(aq,"JS Error")
	}
    }
};

var c=function(){
    try{
	var ao=auctionWorth-ae-realBidsValue;
	if(ao<0){
	    ao=0
	    }
	    var ai=parseCurrency(ae);
	var am=parseCurrency(ao);
	var ak=parseCurrency(realBidsValue);
	if($("#price2")){
	    $("#price2").html(ai+"")
	    }
	    if($("#saving")){
	    $("#saving").html("$"+am)
	    }
	    if($("#savings2")){
	    $("#savings2").html(W(am))
	    }
	    if($("#bido_from")&&($("#bido_from").val()==""||$("#bido_from").val()<ae)){
	    $("#bido_from").val(ai)
	    }
	    if($("#realBidsValue1")){
	    $("#realBidsValue1").html(ak)
	    }
	    if($("#realBidsValue2")){
	    $("#realBidsValue2").html(ak)
	    }
	    if($("#realBids")){
	    var aj="";
	    if(freeBids==0){
		aj=realBids+" Bids"
		}else{
		aj=realBids+" Bids ("+freeBids+" Voucher)"
	    }
	    $("#realBids").html(aj)
	    }
	    if($("#buyItNowPrice")){
	    var al=auctionWorth-realBidsValue;
	    if(al<0){
		al=0
		}
		$("#buyItNowPrice").html(W(parseCurrency(al)))
	    }
	}catch(an){
    if(debugging&&console){
	console.log(an,"JS Error")
	}
    }
};

var W=function(aj){
    aj+="";
    x=aj.split(".");
    x1=x[0];
    x2=x.length>1?"."+x[1]:"";
    var ai=/(\d+)(\d{3})/;
    while(ai.test(x1)){
	x1=x1.replace(ai,"$1,$2")
	}
	return x1+x2
    };

this.updateBidHistory=function(ao){
    try{
	var ak=k.length-1;
	var am=k.length-9;
	if(am<0){
	    am=0
	    }
	    var al=1;
	var aj=0;
	for(var ai=ak;ai>=am;ai--){
	    if(aj==k[ai].a){
		am--;
		if(am<0){
		    am=0
		    }
		    continue
	    }
	    $("#bhp_"+al).html("$"+k[ai].a);
	    $("#bhb_"+al).html(k[ai].u);
	    $("#bht_"+al).html(k[ai].t);
	    aj=k[ai].a;
	    al++
	}
	if(isProfilesEnabled){
	    X(ao)
	    }
	    if(!r){
	    $("#bh_active").effect("highlight",{
		color:"#ffff99"
	    },400);
	    if($("#bh_Bids")){
		$("#bh_Bids").html(ao+" Bid"+(ao>1?"s":""))
		}
		if($("#bh_BidsInfo")){
		$("#bh_BidsInfo").html("$"+parseCurrency(priceAdd*ao)+" + "+D+" seconds")
		}
		if(b){
		clearTimeout(b);
		Z+=ao;
		P+=priceAdd;
		v+=D
		}else{
		Z=ao;
		P=priceAdd;
		v=D
		}
		if($("#bh_Bids")){
		$("#bh_Bids").html(Z+" Bid"+(Z>1?"s":""))
		}
		if($("#bh_BidsInfo")){
		$("#bh_BidsInfo").html("$"+parseCurrency(priceAdd*Z)+" + "+v+" seconds")
		}
		$("#bh_Bids").show();
	    $("#bh_BidsInfo").show();
	    b=setTimeout("Auctions.fadeBidInfoText()",1000)
	    }
	}catch(an){
    if(debugging&&console){
	console.log(an,"JS Error")
	}
    }
};

this.lateBidSwitch=function(){
    if($("#costs")){
	$("#costs").html("")
	}
	g=null
    };

this.fadeBidInfoText=function(){
    $("#bh_Bids").fadeOut(200,function(){
	$("#bh_Bids").html("");
	$("#bh_Bids").attr("display","block")
	});
    $("#bh_BidsInfo").fadeOut(200,function(){
	$("#bh_BidsInfo").html("");
	$("#bh_BidsInfo").attr("display","block")
	});
    b=null
    };

this.placeBid=function(al){
    var ak=true;
    $.each(n,function(am,an){
	if(al==an){
	    document.location="/auction.php?id="+an;
	    ak=false
	    }
	});
if(!loggedIn){
    document.location="/auction.php?id="+auction_id;
    return
}
if(!ak){
    return
}
var aj=new Date();
if(o==al&&f+500>aj.getTime()){
    return
}
f=aj.getTime();
A=f;
o=al;
var ai="/ajax/bid.php?id="+al+"&n=1";
if(J!=""){
    ai+="&o="+J
    }
    if(pageID&&pageID>0){
    ai+="&p="+pageID
    }
    if(auctionDetailedID>0){
    ai+="&lb_id="+auctionDetailedID+"&lb="+u+"&c="+clockAdd
    }
    if(I[al]){
    ai+="&lp="+I[al]
    }
    ai+="&t="+aj.getTime();
$.ajax({
    url:ai,
    cache:false,
    dataType:"json",
    success:function(am){
	if(am.errorText){
	    errorMsg(am.errorText,"Error Placing Bid")
	    }else{
	    af(am)
	    }
	}
})
};

this.updateConnectionSpeed=function(){
    if(Math.floor(Math.random()*5)!=1){
	return
    }
    var ai=0;
    if(B.length>0){
	$.each(B,function(ak,al){
	    ai+=al
	    });
	ai=ai/B.length;
	ai.toFixed(0)
	}
	try{
	if(qBarEnabled){
	    QBar.updateConnectionSpeed(ai)
	    }
	}catch(aj){}
};

this.reloadAuctions=function(){
    var aj=new Date();
    if(reloadTimeoutBig){
	clearTimeout(reloadTimeoutBig)
	}
	if(reloadTimeout){
	clearTimeout(reloadTimeout)
	}
	reloadTimeout=null;
    reloadTimeoutBig=null;
    if(pageID==1){
	var ai="/ajax/spots.php?action=reloadAuctions&pageID=1";
	if(ac.endingspot.length>0){
	    ai+="&zs="+ac.endingspot.join(",")
	    }
	    $.ajax({
	    url:ai,
	    cache:false,
	    dataType:"json",
	    success:function(am){
		var ak=true;
		for(id in am){
		    if(id=="Beginner"||id=="Live"||id=="EndingSoon"){
			ak=true;
			break
		    }
		}
		if(ak){
		for(id in am){
		    if(id=="Beginner"||id=="Live"||id=="EndingSoon"){
			var ao="";
			if(id=="Beginner"){
			    ao="beginnerspot"
			    }else{
			    if(id=="Live"){
				ao="livespot"
				}else{
				if(id=="EndingSoon"){
				    ao="endingspot"
				    }
				}
			}
		    if(ao==""){
		    continue
		}
		Auctions.unregisterAuctionSpots(ao)
		    }
		}
	    }
	for(id in am){
    if(id=="Beginner"||id=="Live"||id=="EndingSoon"){
	var ao="";
	if(id=="Beginner"){
	    ao="beginnerspot"
	    }else{
	    if(id=="Live"){
		ao="livespot"
		}else{
		if(id=="EndingSoon"){
		    ao="endingspot"
		    }
		}
	}
    if(ao==""){
    continue
}
var al=1;
for(spotID in am[id]){
    var an=am[id][spotID];
    if(an.id&&an.id>0&&$("#"+ao+"_"+al)){
	$("#"+ao+"_"+al).html(an.html);
	if(an.status=="Active"){
	    Auctions.registerAuctionSpot(an.id,ao)
	    }
	    al++
    }
}
for(x=al;x<=65;x++){
    if(!$("#"+ao+"_"+x)){
	break
    }
    $("#"+ao+"_"+x).html("")
    }
}
}
}
})
}else{
    if(pageID==2){
	var ai="/ajax/spots.php?action=reloadAuctions&pageID=2&ignoreID="+auctionDetailedID+"";
	if(ac.topspot.length>0){
	    ai+="&zs="+ac.topspot.join(",")
	    }
	    $.ajax({
	    url:ai,
	    cache:false,
	    dataType:"json",
	    success:function(al){
		Auctions.unregisterAuctionSpots("topspot");
		var ak=1;
		for(id in al){
		    if(al[id].id&&al[id].id>0){
			$("#topspot_"+ak).html(al[id].html);
			if(al[id].status=="Active"){
			    Auctions.registerAuctionSpot(al[id].id,"topspot")
			    }
			    ak++
		    }
		}
		}
	    })
}else{
    if(pageID==9){
	var ai="/ajax/spots.php?action=reloadAuctions&pageID=9";
	$.ajax({
	    url:ai,
	    cache:false,
	    dataType:"json",
	    success:function(al){
		Auctions.unregisterAuctionSpots("endingspot");
		for(id in al){
		    if(id=="EndingSoon"){
			var an="";
			if(id=="EndingSoon"){
			    an="endingspot"
			    }
			    if(an==""){
			    continue
			}
			var ak=1;
			for(spotID in al[id]){
			    var am=al[id][spotID];
			    if(am.id&&am.id>0&&$("#"+an+"_"+ak)){
				$("#"+an+"_"+ak).html(am.html);
				if(am.status=="Active"){
				    Auctions.registerAuctionSpot(am.id,an)
				    }
				    ak++
			    }
			}
			for(x=ak;x<=200;x++){
			if(!$("#"+an+"_"+x)){
			    break
			}
			$("#"+an+"_"+x).html("")
			}
		    }
		}
	    }
	})
}
}
}
};

var Y=function(){
    try{
	if(limitIds&&limitText&&limitClass){
	    for(x=0;x<8;x++){
		var aj="#limit_"+(x+1);
		if(!$(aj)){
		    continue
		}
		if($(aj).hasClass("won")){
		    $(aj).removeClass("won")
		    }else{
		    if($(aj).hasClass("on")){
			$(aj).removeClass("on")
			}else{
			if($(aj).hasClass("off")){
			    $(aj).removeClass("off")
			    }
			}
		}
	    $(aj).toggleClass(limitClass[x]);
	    $(aj).attr("title",limitText[x])
	    }
	}
}catch(ai){
    if(debugging&&console){
	console.log(ai,"JS Error")
	}
    }
};

var q=function(aj){
    try{
	if(!limitIds){
	    return
	}
	var ai=0;
	K=0;
	for(x=0;x<8;x++){
	    limitIds[x]=0;
	    limitText[x]="Open";
	    limitClass[x]="off"
	    }
	    for(x=0;x<8;x++){
	    if(!aj[x]||!aj[x].id){
		ai++;
		continue
	    }
	    if(aj[x].id==0){
		limitIds[ai]=0;
		limitText[ai]="Open";
		limitClass[ai]="off"
		}else{
		limitIds[ai]=aj[x].id;
		if(aj[x].t){
		    limitText[ai]=aj[x].t
		    }
		    if(aj[x].c){
		    limitClass[ai]=aj[x].c
		    }
		    if(aj[x].c=="on"){
		    K+=1
		    }else{
		    if(aj[x].c=="won"){
			K+=10
			}
		    }
	    }
	ai++
    }
    Y()
}catch(ak){
    if(debugging&&console){
	console.log(ak,"JS Error")
	}
    }
};

this.processBido=function(){
    try{
	var ai=[];
	m("bido_to",false);
	m("bido_from",false);
	m("bido_num",false);
	if($("#bido_from").val()==""){
	    ai.push("Enter a starting bid! It must be larger than the current price of $"+parseCurrency(ae)+".");
	    m("bido_from",true)
	    }
	    if($("#bido_to").val()==""){
	    ai.push("Enter a ending bid! It must be at least $1 more than the current price of $"+parseCurrency(ae)+".");
	    m("bido_to",true)
	    }
	    if(parseFloat($("#bido_from").val())<=ae){
	    if($("#bido_from")){
		$("#bido_from").val(parseCurrency(ae))
		}
	    }
	if(parseFloat($("#bido_to").val())<=parseFloat($("#bido_from").val())){
	ai.push("The ending bid must be higher than your starting price of $"+parseCurrency($("#bido_from").val())+".");
	m("bido_to",true)
	}
	if($("#bido_num").val()==""||parseFloat($("#bido_num").val())<3){
	ai.push("You must specify at least 3 automatic bids.");
	m("bido_num",true)
	}else{
	if(parseFloat($("#bido_num").val())>bidsAvailable){
	    ai.push("You do not have enough bids credits. You only have "+bidsAvailable+" bids left in your account.");
	    m("bido_num",true)
	    }else{
	    if(parseFloat($("#bido_num").val())>25){
		ai.push("You are not allowed to use more than 25 bids for a BidOMatic.");
		m("bido_num",true)
		}
	    }
    }
if(ai.length==0){
    var am=new Date();
    var aj="/ajax/bidomatic.php?auctionid="+auctionDetailedID+"&bido_from="+parseFloat($("#bido_from").val())+"&bido_to="+parseFloat($("#bido_to").val())+"&bido_num="+parseFloat($("#bido_num").val())+"&t="+am.getTime();
    $.ajax({
	url:aj,
	cache:false,
	dataType:"json",
	success:M
    })
    }else{
    var ak='<div align="left"><strong>The following errors occured:</strong><small><ul style="margin-left:10px">';
    for(var al=0;al<ai.length;al++){
	ak+="<li>- "+ai[al]+"</li>"
	}
	ak+="</ul></small></div>";
    errorMsg(ak,"BidOMatic Setup")
    }
}catch(an){
    if(debugging&&console){
	console.log(an,"JS Error")
	}
    }
return false
};

var M=function(ai){
    try{
	if(ai.errorText){
	    errorMsg(errorText,"BidOMatic Error");
	    return
	}
	var aj=0;
	if(!ai.to||!ai.num||!ai.avail){
	    errorMsg("BidOMatic Error");
	    return
	}
	$("#bido_from_show").html("$"+parseCurrency(ai.from));
	$("#bido_to_show").html("$"+parseCurrency(ai.to));
	$("#bido_num_show").html(ai.avail+" / "+ai.num);
	$("#bido_to").val("");
	$("#bido_from").val("");
	$("#bido_num").val("");
	$("#bido_overview").css("display","block");
	$("#bido_setup").css("display","none");
	bidoActive=true
	}catch(ak){
	if(debugging&&console){
	    console.log(ak,"JS Error")
	    }
	}
};

var p=function(){
    try{
	$("#bido_overview").css("display","none");
	$("#bido_setup").css("display","block");
	$("#bido_from_show").html(parseCurrency(ae));
	$("#bido_to_show").html("");
	$("#bido_num_show").html("");
	bidoActive=false
	}catch(ai){
	if(debugging&&console){
	    console.log(ai,"JS Error")
	    }
	}
};

this.removeBido=function(){
    try{
	var aj=new Date();
	var ai="/ajax/bidomatic.php?action=delete&n=1&auctionid="+auctionDetailedID+"&t="+aj.getTime();
	$.ajax({
	    url:ai,
	    cache:false,
	    dataType:"json",
	    success:function(al){
		p();
		errorMsg("Your Bid-O-Matic was successfully deactivated.")
		}
	    })
    }catch(ak){
    if(debugging&&console){
	console.log(ak,"JS Error")
	}
    }
return false
};

var m=function(ai,aj){
    if(aj&&ai!=null&&$("#"+ai)){
	$("#"+ai).css("outline","1px solid red")
	}
	if(!aj&&ai!=null&&$("#"+ai)){
	$("#"+ai).css("outline","")
	}
    };

this.checkWatched=function(){
    try{
	var ai="/ajax/watch.php?action=check";
	$.ajax({
	    url:ai,
	    cache:false,
	    success:function(ak){
		if(ak==1){
		    hasWatchedAuctions=true
		    }else{
		    hasWatchedAuctions=false
		    }
		}
	})
}catch(aj){
    if(debugging&&console){
	console.log(aj,"JS Error")
	}
    }
return false
};

this.addWatched=function(al){
    try{
	var ai=new Date();
	var aj="/ajax/watch.php?action=add&auctionid="+al+"&t="+ai.getTime();
	$.ajax({
	    url:aj,
	    cache:false,
	    success:function(ao){
		var an=false;
		if(readCookie("watchNotificationDisabled")){
		    an=true
		    }
		    if($("#watch_"+al)&&al==auctionDetailedID){
		    $("#watch_"+al).html('<a href="#" onclick="Auctions.removeWatched('+al+',false);return false;" class="view-all-btn">Remove from watchlist</a>')
		    }else{
		    if($("#watch_"+al)){
			$("#watch_"+al).html('<img src="http://s2.quibidscdn.com/images/watch_remove.png" onclick="Auctions.removeWatched('+al+');"> <a href="#" onclick="Auctions.removeWatched('+al+');return false;">Remove From Watch List</a>')
			}
		    }
		if(!an){
		var am="Auction added to your watch list!<br><br><a href='/account/index.php'><img src='http://s1.quibidscdn.com/images/watch_add.png' border='0'> View Watch List</a> <small><br><br><input type='checkbox' onchange='Auctions.changeWatchNotification();' id='notificationCheckbox'>Hide this popup notification?</small>";
		errorMsg(am,"Auction Watch List")
		}
		hasWatchedAuctions=true
	    }
	})
}catch(ak){
    if(debugging&&console){
	console.log(ak,"JS Error")
    }
}
return false
};

this.changeWatchNotification=function(){
    var ai=false;
    if($("#notificationCheckbox:checked").val()=="on"){
	ai=true
	}
	createCookie("watchNotificationDisabled",ai,180)
    };

this.removeWatched=function(am,ak){
    try{
	var ai=new Date();
	var aj="/ajax/watch.php?action=delete&auctionid="+am+"&t="+ai.getTime();
	$.ajax({
	    url:aj,
	    cache:false,
	    success:function(an){
		if(ak){
		    location.reload(true)
		    }else{
		    if(removeWatchedDiv){
			if($("#auction_"+am)){
			    $("#auction_"+am).hide()
			    }
			    Auctions.unregisterAuction(am)
			}else{
			if($("#watch_"+am)&&am==auctionDetailedID){
			    $("#watch_"+am).html('<a href="#" onclick="Auctions.addWatched('+am+');return false;" class="view-all-btn">Add auction to watchlist</a>')
			    }else{
			    if($("#watch_"+am)){
				$("#watch_"+am).html('<img src="http://s1.quibidscdn.com/images/watch_add.png" onclick="Auctions.addWatched('+am+');"> <a href="#" onclick="Auctions.addWatched('+am+');return false;">Add To Watch List</a>')
				}
			    }
		    }
		if(Number(an)===0){
		hasWatchedAuctions=false
		}
		return
	}
	}
    })
}catch(al){
    if(debugging&&console){
	console.log(al,"JS Error")
	}
    }
return false
};

$(document).ready(function(){
    if(pageID==2&&isProfilesEnabled){
	$("#bhb_1").mouseover(function(){
	    E("bhb_1")
	    });
	$("#bhb_1").mouseleave(function(){
	    V("bhb_1")
	    });
	$("#bhb_2").mouseover(function(){
	    E("bhb_2")
	    });
	$("#bhb_2").mouseleave(function(){
	    V("bhb_2")
	    });
	$("#bhb_3").mouseover(function(){
	    E("bhb_3")
	    });
	$("#bhb_3").mouseleave(function(){
	    V("bhb_3")
	    });
	$("#bhb_4").mouseover(function(){
	    E("bhb_4")
	    });
	$("#bhb_4").mouseleave(function(){
	    V("bhb_4")
	    });
	$("#bhb_5").mouseover(function(){
	    E("bhb_5")
	    });
	$("#bhb_5").mouseleave(function(){
	    V("bhb_5")
	    });
	$("#bhb_6").mouseover(function(){
	    E("bhb_6")
	    });
	$("#bhb_6").mouseleave(function(){
	    V("bhb_6")
	    });
	$("#bhb_7").mouseover(function(){
	    E("bhb_7")
	    });
	$("#bhb_7").mouseleave(function(){
	    V("bhb_7")
	    });
	$("#bhb_8").mouseover(function(){
	    E("bhb_8")
	    });
	$("#bhb_8").mouseleave(function(){
	    V("bhb_8")
	    });
	$("#bhb_9").mouseover(function(){
	    E("bhb_9")
	    });
	$("#bhb_9").mouseleave(function(){
	    V("bhb_9")
	    });
	$("#prof-popup-content").mouseover(function(){
	    e()
	    });
	$("#prof-popup-content").mouseleave(function(){
	    V(w)
	    })
	}
    });
var w;
var t=0;
var S;
function E(aj,ai){
    var al=$("#"+aj).html();
    if(al==""||al=="&nbsp;"||al=="No bidders yet!"||al=="No Bids Yet!"){
	return
    }
    w=aj;
    if(!ai){
	t=parseInt(aj.replace("bhb_",""))
	}else{
	t=0
	}
	S="";
    if(!d[al]){
	$("#profile-left").html();
	$("#profile-right").html('<p><br/><img src="http://s2.quibidscdn.com/images/qbar/ajax-loader.gif" /><br/><br/>&nbsp;</p>');
	var ak="/ajax/profiles.php?username="+al;
	$.ajax({
	    url:ak,
	    cache:true,
	    success:function(am){
		if(am.profile){
		    d[al]=am.profile;
		    F(d[al],aj,ai)
		    }
		}
	})
}else{
    F(d[al],aj,ai)
    }
    $("#profile-popup").clearQueue();
aa(aj,ai);
$("#profile-popup").show()
}
function aa(ak,aj){
    var al=$("#"+ak).offset().left-($("#profile-popup").width()/2);
    if(aj){
	al+=100
	}else{
	al+=70
	}
	var ai=$("#"+ak).offset().top-$("#profile-popup").height();
    if(aj){
	ai-=10
	}else{
	ai+=1
	}
	$("#profile-popup").css({
	top:ai,
	left:al
    })
    }
    function V(ai){
    if(ai!=w){
	return
    }
    S=ai;
    setTimeout("Auctions.hideProfileActually('"+ai+"');",500)
    }
    this.hideProfileActually=function(ai){
    if(S!=ai){
	return
    }
    t=-1;
    $("#profile-popup").clearQueue();
    $("#profile-popup").hide()
    };

function X(aj){
    if(pageID==2&&isProfilesEnabled&&t>0){
	var ai=t;
	t+=aj;
	if(t>9){
	    t=0;
	    console.log(t,"hiding");
	    S=w;
	    Auctions.hideProfileActually(w)
	    }else{
	    console.log(t,"moving");
	    aa("bhb_"+t)
	    }
	}
}
function e(){
    S=""
    }
    function F(an,ao,am){
    if(!an.username){
	return
    }
    var al="";
    al+='<img src="http://s1.quibidscdn.com/avatards/'+an.avatar+'.png" />';
    al+='<p class="userNameTitle">'+an.username+"</p>";
    $("#profile-left").html(al);
    var aj="";
    if(an.joined){
	aj+="<p><strong>Member Since</strong></p>";
	aj+="<p>"+an.joined+"</p>"
	}
	if(an.location){
	aj+="<p><strong>Location</strong></p>";
	aj+="<p>"+an.location+"</p>"
	}
	if(an.win){
	aj+="<p><strong>Latest Win</strong></p>";
	aj+="<p>"+an.win+"</p>"
	}
	if(an.badges&&an.badges.length>0){
	aj+="<p><strong>Latest Achievements</strong></p>";
	aj+="<p>";
	for(id in an.badges){
	    var ak=an.badges[id];
	    if(ak.image&&ak.title){
		aj+=' <img src="'+ak.image+'" title="'+ak.title+'" width="30" height="30" />'
		}
	    }
	aj+="</p>"
    }
    $("#profile-right").html(aj);
var ai=$("#"+ao).offset().top-$("#profile-popup").height();
if(am){
    ai-=10
    }else{
    ai+=-1
    }
    $("#profile-popup").css({
    top:ai
})
}
this.showConsole=function(ai){
    if(debugging&&console){
	console.log(ai)
	}
    };

var z=function(){
    if(!ah){
	ah=true
	}else{
	return
    }
    popupImage("http://s1.quibidscdn.com/images/popup_highcogswarning.png","694","530")
    }
}
function updateGeoMap(a){
    if(mapReady){
	if(pending!=""){
	    quimap.updateGeoMap(pending);
	    pending=""
	    }
	    quimap.updateGeoMap(a)
	}else{
	if(pending!=""){
	    pending+=","+a
	    }else{
	    pending=a
	    }
	}
}
function commandGeoMap(a){
    if(mapReady){
	switch(a){
	    case"enableMap":
		mapEnabled=a;
		$("#map-max").show("fast");
		$("#map-min").show("fast");
		$("#map-display-hide").removeClass("selected");
		$("#map-display-show").addClass("selected");
		setMapCookies();
		if(mapSize!="normalSize"&&mapSize!="fullSize"){
		mapSize="normalSize"
		}
		commandGeoMap(mapSize);
		break;
	    case"disableMap":
		mapEnabled=a;
		$("#map-display-show").removeClass("selected");
		$("#map-display-hide").addClass("selected");
		$("#q-map").css("height","66px");
		$("#map-max").hide("fast");
		$("#map-min").hide("fast");
		setMapCookies();
		break;
	    case"normalSize":
		mapSize=a;
		$("#q-map").css("height","167px");
		quimap.height="100px";
		$("#map-max").removeClass("selected");
		$("#map-min").addClass("selected");
		setMapCookies();
		break;
	    case"fullSize":
		mapSize=a;
		$("#q-map").css("height","267px");
		quimap.height="200px";
		$("#map-max").addClass("selected");
		$("#map-min").removeClass("selected");
		setMapCookies();
		break
		}
		quimap.commandGeoMap(a)
	}
    }
function fromMap(a){
    if(a.indexOf("created map successfully")>=0){
	mapReady=true;
	quimap=swfobject.getObjectById("quimap");
	getMapCookies();
	$("#map-max").hide("fast");
	$("#map-min").hide("fast");
	commandGeoMap(mapSize);
	commandGeoMap(mapEnabled);
	return
    }
    if(mapReady){}
}
function setMapCookies(){
    createCookie("qmapEnabled",mapEnabled,180);
    createCookie("qmapSize",mapSize,180)
    }
    function getMapCookies(){
    mapEnabled=readCookie("qmapEnabled");
    mapSize=readCookie("qmapSize")
    }
    function parseCurrency(b){
    try{
	var a=parseFloat(b);
	if(isNaN(a)){
	    a=0
	    }
	    var c="";
	if(a<0){
	    c="-"
	    }
	    a=Math.abs(a);
	a=parseInt((a+0.005)*100);
	a=a/100;
	s=new String(a);
	if(s.indexOf(".")<0){
	    s+=".00"
	    }
	    if(s.indexOf(".")==(s.length-2)){
	    s+="0"
	    }
	    s=c+s;
	return s
	}catch(d){
	if(debugging&&console){
	    console.log(d,"JS Error")
	    }
	}
}
function errorMsg(b,a){
    if(!a){
	a="Information"
	}
	var c="<br><br><div style='float:right'><input type='button' value='Close' onclick='$(\"#popupModal\").dialog( \"close\" );'></div>";
    $("#popupModal").html("<strong>"+b+"</strong>"+c);
    $(function(){
	$("#popupModal").dialog({
	    modal:true,
	    title:a,
	    width:400
	})
	})
    }
    function infoMsg(a){
    errorMsg(a)
    }
    function BuyItNowPopup(c,b){
    var a="/auction_buyitnow.php?id="+c;
    if(b){
	a+="&overbid=1"
	}
	popupDiv(a,620,465)
    }
    function buyitnowCountdown(b){
    var a=new Date();
    buyitnowTime=(a.getTime()/1000)+(b);
    timerBuyItNowID=$.timer(1000,buyitnowTick)
    }
    function buyitnowTick(){
    if($("#buyitnowTimeLeft")){
	var a=new Date();
	var d=buyitnowTime-(a.getTime()/1000);
	if(d<0){
	    location.reload(true)
	    }
	    var b="";
	if(d<0){
	    b="00:00:00"
	    }else{
	    var e=0;
	    e=parseInt(d/86400);
	    if(e>0){
		hours=parseInt((d-e*86400)/3600);
		b+=e+" day"+((e>1)?"s":"")+", ";
		b+=hours+" hour"+((hours>1)?"s":"")
		}else{
		var c=0;
		c=parseInt(d/3600);
		b+=((c>9)?"":"0")+c+":";
		c=parseInt((d/60)%60);
		b+=((c>9)?"":"0")+c+":";
		c=parseInt(d%60);
		b+=((c>9)?"":"0")+c
		}
	    }
	$("#buyitnowTimeLeft").html(b)
    }
}
function switchImage(a){
    try{
	document.getElementById("prodimg").style.backgroundImage="url("+a+")"
	}catch(b){}
}
function killAuctions(){
    if(Auctions){
	Auctions.killAuctions()
	}
    }
Auctions=new Class_Auctions();
$(document).ready(function(){
    Auctions.initializeInterval()
    });
auctionsEnabled=true;