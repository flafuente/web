var VASTModule = function(main){
	
	this.main = main
	this.wrapper = new YMPWrapper();
	
	this.getVastBlock = function(text){
		
		var vast;
				
		if (window.DOMParser){
	  		
			parser=new DOMParser();
	  		vast=parser.parseFromString(text,"text/xml");
	  	
		} else {
			vast=new ActiveXObject("Microsoft.XMLDOM");
			vast.async=false;
			vast.loadXML(text);
	  	}
		
		var adBlocks = new Array();
		var ads = vast.getElementsByTagName("Ad");
		var tmp;
		
		
		if(ads.length==0){
			
			
				
			tmp = new Object();
			tmp.type = "empty";
			adBlocks.push(tmp);
		
		} else {
			
			
			for(var a =0; a < ads.length; a++){
				
				tmp = new Object();
				tmp.adid = ads[a].getAttribute("id");
				tmp.adSequence = ads[a].getAttribute("sequence");
				tmp.adSystem = this.getAdSystem(vast).value;
				tmp.adSystemversion = this.getAdSystem(vast).version;
				tmp.adTitle = this.getAdTitle(vast);
				tmp.adDescription = this.getAdDescription(vast);
				tmp.adImpressions = this.getAdImpressions(vast);
				tmp.adErrors = this.getAdErrors(vast);
				tmp.adSurvey = this.getAdSurvey(vast);
				tmp.adExtensions = this.getAdExtensions(vast);
				tmp.creatives = this.getAdCreatives(vast);
				
				if(vast.getElementsByTagName("InLine").length>0){
					tmp.type = "inline";
				} else if(vast.getElementsByTagName("Wrapper").length>0){
					tmp.type = "wrapper";
					tmp.VASTAdTagURI = this.getVASTAdTagURI(vast);
				}
				adBlocks.push(tmp);
			}
		}
		return adBlocks;
	}
	
	
	this.getAdSystem = function(vast){
		
		var tmp={}
		
		if(vast.getElementsByTagName("AdSystem").length>0){
			if(vast.getElementsByTagName("AdSystem")[0].childNodes[0]){
				tmp.value = vast.getElementsByTagName("AdSystem")[0].childNodes[0].nodeValue;
				tmp.version = vast.getElementsByTagName("AdSystem")[0].getAttribute("version");
			} 
		}
		return tmp;
		
	}
	
	this.getAdTitle = function(vast){
		
		if(vast.getElementsByTagName("AdTitle").length>0){
			if(vast.getElementsByTagName("AdTitle")[0].childNodes[0]){
				return vast.getElementsByTagName("AdTitle")[0].childNodes[0].nodeValue;
			} else {
				return "";
			}
		} else {
			return "";	
		}
		
	}
	
	this.getAdDescription = function(vast){
		
		if(vast.getElementsByTagName("AdDescription").length>0){
			if(vast.getElementsByTagName("AdDescription")[0].childNodes[0]){
				return vast.getElementsByTagName("AdDescription")[0].childNodes[0].nodeValue;
			} else return "";
		} else {
			return "";	
		}
		
	}
	
	this.getAdImpressions = function(vast){
		
		if(vast.getElementsByTagName("Impression").length>0){
			var imp = new Array();
			for(var a=0; a<vast.getElementsByTagName("Impression").length; a++){
				if(vast.getElementsByTagName("Impression")[a].childNodes[0]){
					imp.push(vast.getElementsByTagName("Impression")[a].childNodes[0].nodeValue);
				}
			}
			return imp;
		
		} else {
			return null;	
		}
		
	}
	
	this.getAdErrors = function(vast){
		
		if(vast.getElementsByTagName("Error").length>0){
			var err = new Array();
			for(var a=0; a<vast.getElementsByTagName("Error").length; a++){
				if(vast.getElementsByTagName("Error")[a].childNodes[0]){
					err.push(vast.getElementsByTagName("Error")[a].childNodes[0].nodeValue.toString());
				}
			}
			return err;
		
		} else {
			return null;	
		}
		
	}
	
	this.getAdSurvey = function(vast){
		
		if(vast.getElementsByTagName("Survey").length>0){
			var survey = new Array();
			for(var a=0; a<vast.getElementsByTagName("Survey").length; a++){
				if(vast.getElementsByTagName("Survey")[a].childNodes[0]){
					survey.push(vast.getElementsByTagName("Survey")[a].childNodes[0].nodeValue);
				}
			}
			return survey;
		
		} else {
			return null;	
		}
		
	}
	
	this.getAdExtensions = function(vast){
		
		if(vast.getElementsByTagName("AdExtensions").length>0){
			var survey = new Array();
			for(var a=0; a<vast.getElementsByTagName("AdExtensions").length; a++){
				if(vast.getElementsByTagName("AdExtensions")[a].childNodes[0]){
					survey.push(vast.getElementsByTagName("AdExtensions")[a].childNodes[0].nodeValue);
				}
			}
			return survey;
		
		} else {
			return null;	
		}
		
	}
	
	this.getVASTAdTagURI = function(vast){
		
		if(vast.getElementsByTagName("VASTAdTagURI").length>0){
			
			if(vast.getElementsByTagName("VASTAdTagURI")[0].childNodes[0]){
				return vast.getElementsByTagName("VASTAdTagURI")[0].childNodes[0].nodeValue;
			} else {
				return "";	
			}
			
		} else {
			return "";	
		}
		
	}
	
	
	
	
	this.getAdCreatives = function(vast){
		
		var creatives = new Object();
		
		if(vast.getElementsByTagName("Creative").length>0){
			for(var a =0; a < vast.getElementsByTagName("Creative").length; a++){
				
				
				/*var tmp = new Object();
				
				if(vast.getElementsByTagName("Creative")[a].getAttribute("sequence")){
					tmp.sequence = vast.getElementsByTagName("Creative")[a].getAttribute("sequence").toString();
				}
				
				if(vast.getElementsByTagName("Creative")[a].getAttribute("AdID")){
					tmp.id = vast.getElementsByTagName("Creative")[a].getAttribute("AdID").toString();
				}
				*/
					
				if(vast.getElementsByTagName("Linear").length>0){
					creatives.linear = this.getLinearAds(vast.getElementsByTagName("Linear"));
				}
				if(vast.getElementsByTagName("NonLinearAds").length>0){
					creatives.nonlinear = this.getNonLinearAds(vast.getElementsByTagName("NonLinearAds"));
				}
				if(vast.getElementsByTagName("CompanionAds").length>0){
					creatives.companions = this.getCompanionAds(vast.getElementsByTagName("CompanionAds"));
					//console.log("companion");
				}
				
				
			}
		}
		
		return creatives;
	}
	
	
	this.getLinearAds = function(linear){
		
		if(linear.length>0){
			
			for(var a=0; a<linear.length; a++){
				var tmp = new Object();
				
				if(linear.item(a).parentNode.getAttribute("sequence")){
					tmp.sequence = linear.item(a).parentNode.getAttribute("sequence");
				}
				
				if(linear.item(a).parentNode.getAttribute("id")){
					tmp.id = linear.item(a).parentNode.getAttribute("id");
				}
				
				if(linear.item(a).getElementsByTagName("Duration")[0]){
					tmp.duration = linear.item(a).getElementsByTagName("Duration")[0].childNodes[0].nodeValue;	
				}
				
				if(linear.item(a).getElementsByTagName("TrackingEvents")){
					
					var trk = linear.item(a).getElementsByTagName("Tracking");
					tmp.trackingEvents = new Array();
					
					for(var e=0; e<trk.length; e++){
						var ev = trk[e].getAttribute("event");
						var tr = trk[e].childNodes[0].nodeValue;
						if(tr!="")tmp.trackingEvents.push({event: ev, tracking:tr, state:"no"});
					}
					
				}

				if(linear.item(a).getElementsByTagName("VideoClicks")){
					var trk = linear.item(a).getElementsByTagName("ClickTracking");
					tmp.clickTracking = new Array();
					
					for(var e=0; e<trk.length; e++){
						var tr = trk[e].childNodes[0].nodeValue;
						if(tr!="")tmp.clickTracking.push(tr);
					}
					
					
					try{
						tmp.clickThrough = linear.item(a).getElementsByTagName("ClickThrough")[0].childNodes[0].nodeValue;
					} catch(e){
					}
	

				}
				
				if(linear.item(a).getElementsByTagName("MediaFiles")){
					
					var trk = linear.item(a).getElementsByTagName("MediaFile");
					tmp.mediaFiles = new Array();
					
					for(var e=0; e<trk.length; e++){
						var md = new Object();
						if(trk[e].getAttribute("delivery"))md.delivery = trk[e].getAttribute("delivery");
						if(trk[e].getAttribute("bitrate"))md.bitrate = trk[e].getAttribute("bitrate");
						if(trk[e].getAttribute("width"))md.width = trk[e].getAttribute("width");
						if(trk[e].getAttribute("height"))md.height = trk[e].getAttribute("height");
						if(trk[e].getAttribute("type"))md.type = trk[e].getAttribute("type");
						if(trk[e].getAttribute("codec"))md.codec = trk[e].getAttribute("codec");
						if(trk[e].getAttribute("id"))md.id = trk[e].getAttribute("id");
						if(trk[e].getAttribute("apiFramework"))md.apiFramework = trk[e].getAttribute("apiFramework");
						if(trk[e].getAttribute("scalable"))md.scalable = trk[e].getAttribute("scalable");
						if(trk[e].getAttribute("maintainAspectRatio"))md.maintainAspectRatio = trk[e].getAttribute("maintainAspectRatio");
						
						if(this.main.getBrowser() == "MSIE" && Number(this.main.getBrowserRelease())<9){
							md.url = trk[e].childNodes[0].nodeValue.substr(trk[e].childNodes[0].nodeValue.indexOf("http"));
						} else {
							md.url = trk[e].childNodes[0].wholeText.substr(trk[e].childNodes[0].wholeText.indexOf("http"));
						}
						
						tmp.mediaFiles.push(md);
						//console.log(md);
					}
				}
				
				try{
					if(linear.item(a).getElementsByTagName("AdParameters").length>0){
						var trk = linear.item(a).getElementsByTagName("AdParameters");
						tmp.adParams = new Array();
						
						for(var e=0; e<trk.length; e++){
							if(trk[e].childNodes[0] && trk[e].childNodes[0].nodeValue!=""){
								var tr = trk[e].childNodes[0].nodeValue;
								tmp.adParams.push(tr);
							}
						}
					}
				} catch(e){}
				
				try{
					
					if(linear.item(a).getElementsByTagName("Icons")){
						
						var ic = linear.item(a).getElementsByTagName("Icon");
						tmp.icons = new Array();
						
						for(var e=0; e<ic.length; e++){
							var ic = new Object();
							ic.program = trk[e].getAttribute("program");
							ic.width = trk[e].getAttribute("width");
							ic.height = trk[e].getAttribute("height");
							ic.xPosition = trk[e].getAttribute("xPosition");
							ic.yPosition = trk[e].getAttribute("yPosition");
							ic.apiFramework = trk[e].getAttribute("apiFramework");
							ic.offset = trk[e].getAttribute("offset");
							ic.duration = trk[e].getAttribute("duration");
							
							if(trk[e].childNodes[0].nodeName=="StaticResource"){
								
							}
							
							if(trk[e].childNodes[0].nodeName=="IFrameResource"){
								
							}
							
							if(trk[e].childNodes[0].nodeName=="HTMLResource"){
								
							}
							
							
							if(trk[e].getElementTagsByName("IconClicks").length>0){
								
								if(trk[e].getElementTagsByName("IconClickThrough").length>0){
									ic.clickthrough = trk[e].getElementTagsByName("IconClickThrough")[0].childNodes[0].nodValue; 
								}
								
								if(trk[e].getElementTagsByName("IconClickTracking").length>0){
									ic.clicktracking = new Array();
									for(var i=0; i<trk[e].getElementTagsByName("IconClickTracking").length; i++){
										ic.clicktracking = trk[e].getElementTagsByName("IconClickTracking")[0].childNodes[0].nodeValue;
									}
								}
							}
							
							tmp.icons.push(ic);	
						}
					}
					
				} catch(e){}
			}
		}
	return tmp; 
	}
	
	this.getNonLinearAds = function(nonlinear){
		
		var nonlinearAds = new Array();
		
		if(nonlinear.length>0){
			
			var tmp;
			var nl = nonlinear.item(0).getElementsByTagName("NonLinear");
				
			for(var a=0; a<nl.length; a++){
				
				
				tmp = new Object();
				
				if(nl[a].getElementsByTagName("ClickThrough").length>0)tmp.clickthrough = nl[a].getElementsByTagName("ClickThrough")[0].childNodes[0].nodeValue;
				if(nl[a].getElementsByTagName("ClickTracking").length>0)tmp.clickTracking = nl[a].getElementsByTagName("ClickTracking")[0].childNodes[0].nodeValue;
				if(nl[a].getElementsByTagName("AdParameters").length>0)tmp.adParameters = nl[a].getElementsByTagName("AdParameters")[0].childNodes[0].nodeValue;
				
				if(nl[a].getElementsByTagName("StaticResource").length>0){
					tmp.type="static";	
					tmp.resource = nl[a].getElementsByTagName("StaticResource")[0].childNodes[0].nodeValue;
				}
				
				if(nl[a].getElementsByTagName("IFrameResource").length>0){
					tmp.type="iframe";	
					tmp.resource = nl[a].getElementsByTagName("IFrameResource")[0].childNodes[0].nodeValue;
				}
				
				if(nl[a].getElementsByTagName("HTMLResource").length>0){
					tmp.type="html";	
					tmp.resource = nl[a].getElementsByTagName("HTMLResource")[0].childNodes[0].nodeValue;
				}
				
				tmp.width = nl[a].getAttribute("width");
				tmp.height = nl[a].getAttribute("height");
				tmp.id = nl[a].getAttribute("id");
				tmp.expandedWidth = nl[a].getAttribute("expandedWidth");
				tmp.expandedHeight = nl[a].getAttribute("expandedHeight");
				tmp.scalable = nl[a].getAttribute("scalable");
				tmp.maintainAspectRatio = nl[a].getAttribute("maintainAspectRatio");
				tmp.SuggestedDuration = nl[a].getAttribute("SuggestedDuration");
				tmp.apiFramework = nl[a].getAttribute("apiFramework");
				
				nonlinearAds.push(tmp);
				
			}
		
		
		
		}
		
		return nonlinearAds;
	}
	
	this.getCompanionAds = function(comps){
		
		var companions = new Array();
		
		if(comps.length>0){
			
			var tmp;
			var nl = comps.item(0).getElementsByTagName("Companion");
				
			for(var a=0; a<nl.length; a++){
				
				
				tmp = new Object();
				
				try{
					tmp.altText = nl[a].getElementsByTagName("AltText")[0].childNodes[0].nodeValue;
				} catch(e){
				}
				
				if(nl[a].getElementsByTagName("Tracking").length>0){
					
					var tracks = nl[a].getElementsByTagName("Tracking");
					tmp.trackingEvents = new Array();
					if(tracks.length>0){
						for(var f=0; f<tracks.length; f++){
							var to = new Object();
							to.event = tracks[f].getAttribute("event");
							to.url = tracks[f].childNodes[0].nodeValue;
							tmp.trackingEvents.push(to);
						}	
					}
				}
				
				
				try{
					tmp.clickThrough = nl[a].getElementsByTagName("CompanionClickThrough")[0].childNodes[0].nodeValue;
				} catch(e){
				}
				try{
					tmp.clickTracking = nl[a].getElementsByTagName("CompanionClickTracking")[0].childNodes[0].nodeValue;
				} catch(e){
				}
				try{
					tmp.adParameters = nl[a].getElementsByTagName("AdParameters")[0].childNodes[0].nodeValue;
				} catch(e){
				}
				
				if(nl[a].getElementsByTagName("StaticResource").length>0){
					tmp.type="static";	
					tmp.resource = nl[a].getElementsByTagName("StaticResource")[0].childNodes[0].nodeValue;
					tmp.resource_type = nl[a].getElementsByTagName("StaticResource")[0].getAttribute("creativeType");
				}
				
				if(nl[a].getElementsByTagName("IFrameResource").length>0){
					tmp.type="iframe";
					tmp.resource = nl[a].getElementsByTagName("IFrameResource")[0].childNodes[0].wholeText.toString();
				}
				
				if(nl[a].getElementsByTagName("HTMLResource").length>0){
					tmp.type="html";	
					tmp.resource = nl[a].getElementsByTagName("HTMLResource")[0].childNodes[0].wholeText.toString();
				}
				
				tmp.width = nl[a].getAttribute("width");
				tmp.height = nl[a].getAttribute("height");
				tmp.id = nl[a].getAttribute("id");
				tmp.assetWidth = nl[a].getAttribute("assetWidth");
				tmp.assetHeight = nl[a].getAttribute("assetHeight");
				tmp.expandedWidth = nl[a].getAttribute("expandedWidth");
				tmp.expandedHeight = nl[a].getAttribute("expandedHeight");
				tmp.apiFramework = nl[a].getAttribute("apiFramework");
				tmp.required = nl[a].getAttribute("required");
				tmp.adSlotID = nl[a].getAttribute("adSlotID");
				
				companions.push(tmp);
			}
			
		}
		
		return companions;	
	}
	
	this.setWrapper = function(position, ads, nads){
		//console.log("serwrapper vast Module");
		return this.wrapper.setWrapper(position, ads, nads);
	}
	
	
	return this;
	
	
	

}
function removeWhitespace(node) {
    for (i=0; i < node.childNodes.length; i++){
        var current = node.childNodes[i];
        if (current.nodeType == 3 && whitespace.test(current.nodeValue)) {
           // that is, if it's a whitespace text node
           node.removeChild(current);
           i--;
        } else if (current.nodeType == 1) removeWhitespace(current); //remove whitespace on child element's children
    }
}

