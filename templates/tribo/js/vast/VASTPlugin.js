// JavaScript Document
window.VAST_API;
window.PLUGINS_API;
var jsF = new Array("VASTHTML5Player.js", "VASTSWFPlayer.js", "swfobject.js", "VASTModule.js", "VASTModuleWrapper.js");
var VASTPlugin = function(wistiaEmbed, id, api, vast, path){
	
	this.config_VastUrl;
	this.config_Path;
	this.config_ContainerId;
	this.config_IsMobile = false;
	
	
	this.playerContentContainer;
	this.playerContent;
	
	this.adContainer;
	this.adPlayer;
		
	this.inViewActive = false;
	
	this.adUnits;
	this.adBitRate;
	
	this.adCompleted=false;
	
	this.TRACKER1 = false; 
	this.TRACKER2 = false; 
	this.TRACKER3 = false;
	
	if(wistiaEmbed)this.wistiaEmbed = wistiaEmbed;
		else return false;
	
	if(api){
		this.config_API = api;
		window.VAST_API = api;
	} else return false;
		
	if(id)this.config_ContainerId = id;
		else return false;

	if(vast)this.config_VastUrl = vast;
		else return false;
				
	if(path)this.config_Path = path;
		else return false;
	
	
	// insert the 'bind on play' function
	this.wistiaEmbed.adPlugin = this;
	this.wistiaEmbed.bind('play', function() {
  		// use the .time() method to jump ahead 10 seconds
		if(!window[window.VAST_API].adComplete){
			this.adPlugin.start();
			wistiaEmbed.time(1);
		}
		return this.unbind;
	});

	
	this.start = function(){
		
		this.wistiaEmbed.pause();
		this.loadJsLibrary();
	}
	
	this.loadJsLibrary = function(){
		var scp;
		for(var a=0; a<jsF.length; a++){
			scp = document.createElement("script");
			scp.setAttribute("src", this.config_Path + jsF[a]);
			scp.setAttribute("type","text/javascript")
  			document.getElementsByTagName("head")[0].appendChild(scp);
		}
		this.checkBitRate();
		this.checkPlugins();
	}
	
	
	this.checkPlugins = function(){
		clearInterval(window.PLUGINS_API);
		window.PLUGINS_API = 0;
		var loaded=false;
		try{
			if(SWFObject && VASTSWFPlayer && VASTHTML5Player){
				loaded = true;
			}
		} catch(e){
		
		}
		
		if(loaded){
			this.searchContainer();
		} else {
			window.PLUGINS_API = setInterval(function(){window[window.VAST_API].checkPlugins();}, 500);
		}
		
	}
	
	this.searchContainer = function(){
		
		var vElementDivGrp = document.getElementsByTagName("div");
		var vElementDiv;
			if(vElementDivGrp.length>0){
				for(var a=0; a<vElementDivGrp.length; a++){
					if(vElementDivGrp[a].id.indexOf(this.config_ContainerId)>-1){
						vElementDiv = vElementDivGrp[a];
						this.playerContentContainer = vElementDiv;
						break;
					}
				}
			}
			
			if(vElementDiv){
				var vElement;
				var vElementGrp = vElementDiv.getElementsByTagName("video");
				if(vElementGrp.length>0){
					for(var a=0; a<vElementGrp.length; a++){
						if(vElementGrp[a].id.indexOf("wistia")>-1){
							vElement = vElementGrp[a];
							break;
						}
					}
				}
				
				if(!vElement){
					var vElementGrp = vElementDiv.getElementsByTagName("object");
					if(vElementGrp.length>0){
						for(var a=0; a<vElementGrp.length; a++){
							if(vElementGrp[a].id.indexOf("wistia")>-1){
								vElement = vElementGrp[a];
								break;
							}
						}
					}
				}
				
				if(!vElement){
					var vElementGrp = vElementDiv.getElementsByTagName("embed");
					if(vElementGrp.length>0){
						for(var a=0; a<vElementGrp.length; a++){
							if(vElementGrp[a].name.indexOf("wistia")>-1){
								vElement = vElementGrp[a];
								break;
							}
						}
					}
				}	
			
			}
			
			if(document.getElementById(vElement.id)){
				this.playerContent = document.getElementById(vElement.id); 
				this.checkUserAgent();
			}
	}
	

	this.checkUserAgent = function(){
		
		if(isMobile.any()){
			this.config_IsMobile = true;
			this.adPlayer = new VASTHTML5Player(this);
		} else {
			this.makeAdContainer();
			this.adPlayer = new VASTSWFPlayer(this);
		}
		this.adPlayer.init();
	},
	
	this.makeAdContainer = function(){
		
		if(!document.getElementById("VASTadContainer" + this.config_ContainerId)){
			var adContainer;
			var style = 'position:absolute; display:block;float:none; z-index:10000;';
			style+='width:' + this.playerContentContainer.offsetWidth + 'px; height:' + this.playerContentContainer.offsetHeight + 'px; ';
			style+='left:' + this.getPos(this.playerContentContainer).x + 'px; top:' + this.getPos(this.playerContentContainer).y + 'px; ';
			style+='background-color:#000;';
			if(this.getBrowser() == "MSIE" && Number(this.getBrowserRelease())<9){
				adContainer = document.createElement("<div id='VASTadContainer" + this.config_ContainerId + "' style='" + style + "'></div>");
			} else {
				adContainer = document.createElement("div");
				adContainer.setAttribute("id", "VASTadContainer" + this.config_ContainerId);
				adContainer.setAttribute("style", style);
			}
			document.body.appendChild(adContainer);
			this.adContainer = document.getElementById("VASTadContainer" + this.config_ContainerId);
		}
	}
	
	this.adLoaded = function(vastElement, wrapper){
		
		if(!this.vastParser) this.vastParser = new VASTModule(this);
		if(!this.adUnits) this.adUnits = new Array();
		
		var nads = this.vastParser.getVastBlock(unescape(vastElement));
		var ready = true;
		
		
		if(nads[0].type == "wrapper"){
			ready=false;
		}
		console.log(nads[0].type);
		if(nads[0].type == "empty"){
			this.adUnLoad();
			return;
		}
		
		
		if(ready){
			if(wrapper){
				this.adUnits = this.vastParser.setWrapper(0, this.adUnits, nads);
			} else {
				
				this.adUnits = nads;
			}
			this.adReady();
			
		} else {
			this.adUnits = nads;
			this.adPlayer.getAd(nads[0].VASTAdTagURI, true);
		}
	}
	
	this.adError = function(vastElement, wrapper){
		this.fireErrors();
		this.adUnLoad();
	}
	
	
	this.adUnLoad = function(){
		//console.log("adUnLoad");
		this.adPlayer.unLoad();
	}
	
	
	this.adReady = function(){
		
		var mediaType, mediaUrl;
		var vpaidObject;
		
		if(this.adUnits[0].creatives.linear){
			
			
			try{
			
				if(this.getMediaFile().apiFramework=="vpaid" || this.getMediaFile().type=="application/x-shockwave-flash"){
					mediaType = "vpaid";
					vpaidObject = this.adUnits[0].creatives.linear;
					vpaidObject.type="linear";
				} else {
					mediaType = "vast";
				}
				
				
			} catch(e){
				mediaType = "vast";
			}
			
			mediaUrl = this.getMediaFile().url;
			
		} else if(this.adUnits[0].creatives.nonlinear){
			if(this.getMediaFile().apiFramework=="vpaid" || this.getMediaFile().type=="application/x-shockwave-flash"){
				mediaType = "vpaid";
				vpaidObject = this.adUnits[0].creatives.nonlinear; 
				vpaidObject.type="nonlinear";
				mediaUrl = this.getMediaFile().url;
			}
		}
		
		if(mediaType && mediaUrl){
			
			if(!this.config_IsMobile){
				
				
				if(mediaType =="vpaid")this.adPlayer.initAd({type:mediaType, obj:vpaidObject});
					else this.adPlayer.initAd({type:mediaType, url:mediaUrl});
			
			} else {
				if(mediaType=="vast"){
					this.adPlayer.initAd({type:mediaType, url:mediaUrl});
				} else {
					//play de video
					alert("This player does not support VPAID");
				}
			}
		} 
	}
	
	this.getMediaFile = function(){
		
		var mf;
		var ad = this.adUnits[0];
		if(ad.creatives.linear.mediaFiles){
			for(var a = 0; a<ad.creatives.linear.mediaFiles.length; a++){
				
				
				var bitrate = Number(ad.creatives.linear.mediaFiles[a].bitrate);
				var vtype = ad.creatives.linear.mediaFiles[a].type;
				if(!this.config_IsMobile){
					if(bitrate<=this.adBitRate && (vtype.indexOf("flv")>-1 || vtype.indexOf("mp4")>-1)){
						mf = ad.creatives.linear.mediaFiles[a];
					}
				} else {
					if(bitrate<=this.adBitRate && (vtype.indexOf("3gp")>-1 || vtype.indexOf("mp4")>-1)){
						mf = ad.creatives.linear.mediaFiles[a];
						//console.log(mf);
					}
				}
			}
			
			if(typeof(mf) == "undefined"){
				
				for(var a = 0; a<ad.creatives.linear.mediaFiles.length; a++){
						var vtype = ad.creatives.linear.mediaFiles[a].type;
						if (this.config_IsMobile && vtype.indexOf("mp4")>-1){
							mf = ad.creatives.linear.mediaFiles[a];
							break;
						}
						if((vtype.indexOf("flv")>-1 || vtype.indexOf("mp4")>-1) && !this.config_IsMobile){
							mf = ad.creatives.linear.mediaFiles[a];
							break;
						}
				}
			}
			
			if(typeof(mf) == "undefined"){
				for(var a = 0; a<ad.creatives.linear.mediaFiles.length; a++){
					
					var frmk = ad.creatives.linear.mediaFiles[a].apiFramework;
					var type = ad.creatives.linear.mediaFiles[a].type;
					if (frmk.toLowerCase() =="vpaid" || type =="application/x-shockwave-flash"){
						mf = ad.creatives.linear.mediaFiles[a];
						break;
					}
				}
			}
		}
		
		return mf;		
	}
	
	this.adPlayerEvent = function(obj){
		
		//console.log("adPlayerEvent");
		//console.log(obj);
		
		switch(obj.type){
			case "start_ad":
				this.fireImpression();
				//this.showCompanion();
			break;
			
			case "video_ad_start":
				this.fireTrackers("start");
			break;
				
			case "complete_ad":
			
				this.fireTrackers("complete");
				this.adCompleted = true;
			break;
			case "update_ad":
				var quarter = Math.round(obj.tt/4);
				if(Math.round(obj.ct) == quarter && !this.TRACKER1){
					//console.log("lanza view 25");
					this.TRACKER1=true;
					this.fireTrackers("firstQuartile");
				}
				if(Math.round(obj.ct)==Math.round((obj.tt/2))&&!this.TRACKER2){
					//console.log("lanza view 50");
					this.TRACKER2=true;
					this.fireTrackers("midpoint");
				}
				if(Math.round(obj.ct)==Math.round(quarter*3) && !this.TRACKER3){
					//console.log("lanza view 75");
					this.TRACKER3=true;
					this.fireTrackers("thirdQuartile");
				}
			break;
			
			case "click_ad":
				this.clickVideoAd();
			break;
			
			case "video_error_ad":
				this.fireErrors();
			break;
			
			case "error_ad":
			console.log(obj);
				this.fireErrors();
			break;
			
			case "skipped_ad":
			break;
			
			case "stop_ad":
				this.adUnLoad();
			break;
		}
	}
	
	this.fireImpression = function(){
		var imp;
		var ad = this.adUnits[0];
		for(var a=0; a<ad.adImpressions.length; a++){
			imp = new Image();
			imp.src = ad.adImpressions[a];
		}	
	}
	
	this.fireErrors = function(){
		try{
			var imp;
			var ad = this.adUnits[0];
			for(var a=0; a<ad.adErrors.length; a++){
				imp = new Image();
				imp.src = ad.adErrors[a];
			}
		} catch(e){
			//console.log("fireError>" + e.message);	
		}	
	}
	
	this.fireTrackers = function(track){
		var imp;
		var ev = this.adUnits[0].creatives.linear.trackingEvents;
		for(var a=0; a<ev.length; a++){
			if(track==ev[a].event && ev[a].state=="no"){
				ev[a].state="yes";
				imp = new Image();
				imp.src = ev[a].tracking;
			}
		}
		
		if(track=="complete"){
			this.adUnLoad();
		}
		
	}
	
	
	this.clickVideoAd = function(){
		var cv = this.adUnits[0].creatives.linear;
		if(cv.clickTracking){
			var img;
			for(var a=0; a<cv.clickTracking.length; a++){
				if(cv.clickTracking[a]!=""){
					imp = new Image();
					imp.src = cv.clickTracking[a];
				}
			}
		}
		if(cv.clickThrough && cv.clickThrough!=""){
			window.open(cv.clickThrough);
		}
		
	}
	
	this.checkBitRate = function(){
			var imageAddr = this.config_Path + "bitrate.gif" + "?n=" + Math.random();
			this.startTime, this.endTime;
			this.downloadSize = 135;
			var download = new Image();
			download.parent = this;
			download.onload = function () {
			   	this.parent.endTime = (new Date()).getTime();
			    this.parent.showResults();
			}
			download.onerror = function () {
			   	//this.parent.getMediaFile();
			}
			this.startTime = (new Date()).getTime();
			download.src = imageAddr;
		}

	this.showResults = function() {
	    
	    var duration = (this.endTime - this.startTime) / 1000;
	    var bitsLoaded = this.downloadSize * 8;
	    var speedBps = Math.round(bitsLoaded / duration);
	    var speedKbps = (speedBps / 1024).toFixed(2);
	    
	    this.adBitRate = Math.round(speedKbps*10);
	    
		
	}
	
	
	
	//UTILIDADES
	
	this.getBrowser = function(){
			var N=navigator.appName, ua=navigator.userAgent, tem;
			var M=ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
			if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
			M=M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];
			return M[0];
		},
			
		
	this.getBrowserRelease = function(){
			var N=navigator.appName, ua=navigator.userAgent, tem;
			var M=ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
			if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
			M=M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];
			return M[1];
		}
		
	this.getPos = function(el){
	    // yay readability
	    for (var lx=0, ly=0;
	         el != null;
	         lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent);
	    return {x: lx,y: ly};
	}
	
	
	
	return this;
}


var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};