var supportsOrientationChange = "onorientationchange" in window,
    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

window.addEventListener(orientationEvent, function() {
	var btnClick = document.getElementById("VASTadClickTag" + window[window.VAST_API].config_ContainerId);
	btnClick.style.visibility="hidden";
	setTimeout(function(){window[window.VAST_API].adPlayer.resize();}, 500);
}, false);

var VASTHTML5Player = function(main){
	
	this.main = main;
	this.contentSource;
	this.updateTime;
	this.adCompleted=false;
	
	this.init = function(){
		this.getAd(unescape(this.main.config_VastUrl), false);	
	}
	
	this.getAd = function(url, wrapper){
		this.makeCorsRequest(url, wrapper);
	}
	
	this.makeCorsRequest = function (adUrl, wrapper) {
	  // All HTML5 Rocks properties support CORS.
	 var xhr = this.createCORSRequest('GET', adUrl);
	  if (!xhr) {
		return;
	  }
	
	  // Response handlers.
	  xhr.main = this;
	  if(wrapper)xhr.wrapper = wrapper;
	  	else xhr.wrapper = false;
	  
	  xhr.onload = function() {
			this.main.main.adLoaded(xhr.responseText, xhr.wrapper);
	   };
	
	  xhr.onerror = function(e) {
		  var err;
		  switch(xhr.status) { 
			  case 404: 
				err = 'File not found'; 
				break; 
			  case 500: 
				err = 'Server error'; 
				break; 
			  case 0: 
				err = 'Request aborted'; 
				break; 
			  default: 
				err = 'Unknown error ' + xhr.status; 
			} 
	
	 };
	 xhr.send();
	}
	
	this.createCORSRequest = function(method, url) {
	  var xhr = new XMLHttpRequest();
	  if ("withCredentials" in xhr) {
		// XHR for Chrome/Firefox/Opera/Safari.
		xhr.open(method, url, true);
	  } else if (typeof XDomainRequest != "undefined") {
		// XDomainRequest for IE.
		xhr = new XDomainRequest();
		xhr.open(method, url);
	  } else {
		// CORS not supported.
		xhr = null;
	  }
	  return xhr;
	}
	
	this.initAd=function(obj){
		var source = this.main.playerContent.src;
		if(!source){
			source = this.main.playerContent.getElementsByTagName("source");
			if(source){
				this.contentSource = source[0].src;
			}
		} else {
			this.contentSource = source;
		}
		
		if(this.contentSource){
		
			this.main.playerContent.src = obj.url;
			this.main.playerContent.addEventListener("loadedmetadata", function(obj){this.main.setDuration(this);}, false);
			this.main.playerContent.addEventListener("error", function(obj){this.main.adError();}, false);
			this.main.playerContent.addEventListener("stalled", function(obj){this.controls=true;}, false);
			this.main.playerContent.addEventListener("paused", function(obj){this.controls=true;}, false);
			this.main.playerContent.addEventListener("canplay", function(obj){this.play();}, false);
			this.main.playerContent.load();
			this.main.playerContent.play();
			this.main.playerContent.main = this;
			
		}
		
	}
	
	
	this.adError = function(){
		this.main.playerContent.pause();
		this.main.adPlayerEvent({type:"complete_ad"});
		
	}
	
	
	this.setDuration = function(obj){
		
		//console.log("setDuration changed cin duration" + String(this.main.playerContent.duration) + " - " + document.getElementById("wistia_3").duration);
		//console.log(this.main.playerContent);
		
		
		if(!this.adCompleted){
		
		
			this.main.playerContent.controls=false;
			this.main.adDuration = Math.round(this.main.playerContent.duration);
			this.main.playerContent.removeEventListener("loadedmetadata", function(obj){this.main.setDuration(this);}, false);
			this.updateTime = setInterval(function(){window[window.VAST_API].adPlayer.updatingVideo();}, 500);
			
			
			if(!document.getElementById("VASTadClickTag" + this.main.config_ContainerId)){
				var adContainer;
				var style = 'position:absolute; display:block;float:none; z-index:9000000000;cursor:pointer;';
				style+='width:100px; height:20px;';
				style+='color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px;';
				var lf = (this.main.getPos(this.main.playerContentContainer).x + this.main.playerContentContainer.offsetWidth) - 105;
				style+='left:' + lf + 'px; top:' + (this.main.getPos(this.main.playerContentContainer).y + 5) + 'px; ';
				style+='background-color:#000;';
				if(this.main.getBrowser() == "MSIE" && Number(this.main.getBrowserRelease())<9){
					adContainer = document.createElement("<div id='VASTadClickTag" + this.main.config_ContainerId + "' style='" + style + "'></div>");
				} else {
					adContainer = document.createElement("div");
					adContainer.setAttribute("id", "VASTadClickTag" + this.main.config_ContainerId);
					adContainer.setAttribute("style", style);
				}
				document.body.appendChild(adContainer);
				this.adClick = document.getElementById("VASTadClickTag" + this.main.config_ContainerId);
				this.adClick.innerHTML = "VISIT SPONSOR";
				this.adClick.main = this;
				this.adClick.onclick = function(){this.main.main.playerContent.controls=true; this.main.main.adPlayerEvent({type:"click_ad"});};	
			}
		} else {
			this.main.playerContent.controls=true;
		}
	}
	
	this.unLoad=function(){
		
		this.adCompleted= true;
		if(document.getElementById("VASTadClickTag" + this.main.config_ContainerId)){
			//console.log("borra div");
			document.body.removeChild(document.getElementById("VASTadClickTag" + this.main.config_ContainerId));
		}
		
		this.main.playerContent.src = this.contentSource;
		this.main.playerContent.load();
		this.main.wistiaEmbed.play();
		
		
	}
	
	
	this.updatingVideo = function(){
		clearInterval(this.updateTime);
		//var s = Math.round(this.main.playerContent.currentTime);
		var s = this.main.playerContent.currentTime;
		//console.log("updatingVideo>" + s + " - " + (this.main.adDuration-1) + " - " + Math.round(this.main.adDuration));
		
		if(s>0 && s<1){
			this.main.adPlayerEvent({type:"start_ad"});
			this.updateTime = setInterval(function(){window[window.VAST_API].adPlayer.updatingVideo();}, 500);
		} else if(s>1 && s<(this.main.adDuration-1)) {
			this.main.adPlayerEvent({type:"update_ad", tt:this.main.adDuration, ct:s});		
			this.updateTime = setInterval(function(){window[window.VAST_API].adPlayer.updatingVideo();}, 500);
		} else if(s>(this.main.adDuration-1) && s<Math.round(this.main.adDuration)){
			this.main.adPlayerEvent({type:"complete_ad"});
			this.main.playerContent.pause();
		} else {
			this.updateTime = setInterval(function(){window[window.VAST_API].adPlayer.updatingVideo();}, 500);	
		}
	}
	
	
	this.resize=function(){
		var btnClick = document.getElementById("VASTadClickTag" + this.main.config_ContainerId);
		btnClick.style.top =  (this.main.getPos(this.main.playerContentContainer).y + 5)  + "px";
		btnClick.style.left =(this.main.getPos(this.main.playerContentContainer).x + this.main.playerContentContainer.offsetWidth) - 105 + "px";
		btnClick.style.visibility="visible";
	}
	
	return this;
}