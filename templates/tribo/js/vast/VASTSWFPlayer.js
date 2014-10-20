var VASTSWFPlayerUnload
var VASTSWFPlayer = function(main){
	
	this.main = main;
	this.playerId = "VASTSWFPlayer_" + this.main.config_ContainerId;
	
    this.init = function(){
		
		this.checkSWFObject();
	}
	
	
	
	this.checkSWFObject = function(){
		try{
			
			var URL = "/templates/tribo/js/vast/" + "VASTPlayer.swf?apiName=" + this.main.config_API + "&vastURL=" + this.main.config_VastUrl + "&" + Math.random();
			var so = new SWFObject(URL, this.playerId,'100%','100%','9');
			so.addParam('allowFullScreen','true');
			so.addParam('allowscriptaccess','always');
			so.addParam('wmode','transparent');
			so.addParam('id', this.playerId);
			so.addParam('name', this.playerId);
			so.addParam('autostart','false');
			so.addParam('data', URL);
			so.write(this.main.adContainer);
		
		} catch(e) {
			this.main.adUnLoad();
		}
	}
	
	
	this.getAd = function(url, wrapper){
		this.thisMovie(this.playerId).getAd(url);
	}
	
	
	this.initAd=function(obj){
		this.thisMovie(this.playerId).init(obj);
	}
	
	this.startAd = function(){
		//console.log("startAd");
		//this.thisMovie(this.playerId).playerAction({action:"play"});
	}
	
	
	this.thisMovie = function (movieName) {
	   	if (navigator.appName.indexOf("Microsoft") != -1) {
			 return window[movieName]
		} else {
			return document[movieName]
		}
	}
	
	this.unLoad=function(){
		VASTSWFPlayerUnload = setInterval(function(){window[window.VAST_API].adPlayer.destroy();}, 500);		
	}
	
	this.destroy = function(){
		clearInterval(VASTSWFPlayerUnload);
		
		if(document.getElementById("VASTadContainer" + this.main.config_ContainerId)){
			document.body.removeChild(document.getElementById("VASTadContainer" + this.main.config_ContainerId));
		}
		this.main.wistiaEmbed.play();
	}
	
	return this;
}