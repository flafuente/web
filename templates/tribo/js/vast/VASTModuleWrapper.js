var YMPWrapper = function(){
	
	this.setWrapper = function(position, ads, nads){
		
		
		//console.log(ads);
		//console.log(nads);
		
		var nposition = 0;
		
		//search linear ad
		for(var a in nads){
			if(nads.type=="linear"){
				nposition=a;
				break;
			}
		}
		
		if(typeof ads[position].adImpressions == "undefined") ads[position].adImpressions = new Array();
		if(nads[nposition].adImpressions){
			for(var a=0;  a<nads[nposition].adImpressions.length; a++){
				ads[position].adImpressions.push(nads[nposition].adImpressions[a]);	
			}
		}
		
		if(typeof ads[position].adErrors == "undefined") ads[position].adErrors = new Array();
		if(nads[nposition].adErrors){
			for(var a=0;  a<nads[nposition].adErrors.length; a++){
				ads[position].adErrors.push(nads[nposition].adErrors[a]);	
			}
		}
		
		ads[position].type = nads[nposition].type;
		ads[position].adSystem = nads[nposition].adSystem;
		ads[position].adTitle = nads[nposition].adTitle;
		ads[position].adDescription = nads[nposition].adDescription;
		ads[position].adSurvey = nads[nposition].adSurvey;
		ads[position].adExtensions = nads[nposition].adExtensions;
		ads[position].VASTAdTagURI = nads[nposition].VASTAdTagURI;
		
		if(typeof ads[position].creatives.companions == "undefined")ads[position].creatives.companions = new Array();
		if(nads[nposition].creatives.companions && nads[nposition].creatives.companions.length>0){
			for(var e in nads[nposition].creatives.companions){
				ads[position].creatives.companions.push(nads[nposition].creatives.companions[e]);
			}
		}
			
		if(nads[nposition].creatives.linear){
			
			ads[position].creatives.linear.duration = nads[nposition].creatives.linear.duration;
				
			for(var e in nads[nposition].creatives.linear.trackingEvents){
				ads[position].creatives.linear.trackingEvents.push(nads[nposition].creatives.linear.trackingEvents[e]);
			}
			for(var e in nads[nposition].creatives.linear.clickTracking){
				ads[position].creatives.linear.clickTracking.push(nads[nposition].creatives.linear.clickTracking[e]);
			}
			ads[position].creatives.linear.clickThrough = nads[nposition].creatives.linear.clickThrough;
			for(var e in nads[nposition].creatives.linear.clickTracking){
				ads[position].creatives.linear.clickTracking.push(nads[nposition].creatives.linear.clickTracking[e]);
			}
			ads[position].creatives.linear.mediaFiles = nads[nposition].creatives.linear.mediaFiles;
			ads[position].creatives.linear.adParams = nads[nposition].creatives.linear.adParams;
			ads[position].creatives.linear.icons = nads[nposition].creatives.linear.icons;
		
		}
		
		
		return ads;
	}
	
	return this;
		
}