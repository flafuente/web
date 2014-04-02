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
							if(messages[x].type=="danger"){
								messages[x].type = "error";
							}
							field = form.find("select[name=" + messages[x].field + "], input[name=" + messages[x].field + "], textarea[name=" + messages[x].field + "], checkbox[name=" + messages[x].field + "]");
							if(field.length){
								field.parent().parent().addClass("has-" + messages[x].type);
								field.parent().append('<span class="help-block">' + messages[x].message + '</span>');
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
			//Debug Message
			if(data.debug){
				if(data.debug.length){
					messages = data.debug;
					for(var x=0;x<messages.length;x++) {
						//Increment counter
						var total = parseInt($("#debugCounterMessagesAjax").html());
						total++;
						$("#debugCounterMessagesAjax").html(total);
						//UL exists?
						if(!$("#debugModalMessagesAjax ul.list-group").length){
							//Create UL
							$("#debugModalMessagesAjax .modal-body").append("<ul class='list-group'></ul>");
							//Delete Blockquote
							$("#debugModalMessagesAjax blockquote").remove();
						}
						//Add message
						$("#debugModalMessagesAjax ul.list-group").append("<li class='list-group-item'><blockquote>" + messages[x].message + "</blockquote>" + messages[x].trace + "</li>");
					}
				}
			}
			//Extras
			if(data.data){
				//Modal HTML
				if(data.data.modal){
					$("#genericModal .modal-content").html(data.data.modal);
					$("#genericModal").modal('show');
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

//Sortable Columns
$(document).on('click', '.sortable', function(e){
	var form = $(this).closest("form");
	checkFormField(form, "order", $(this).attr("data-order"));
	checkFormField(form, "orderDir", $(this).attr("data-orderDir"));
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
		return field;
	}
}

//change-submit
$(document).on('change', '.change-submit', function(e){
	$('#mainForm').submit();
});

//delete buttons
$(document).on('click', '.delete', function(e){
	var res = false;
	var confirmation = $(this).attr("confirm");
	if(confirmation){
		res = confirm(confirmation);
	}else{
		res = true;
	}
	if(res){
		$('#action').val("delete");
		$('#mainForm').submit();
	}
	return false;
});

//Page Ready
jQuery(document).ready(function ($) {
    //Slider
    var options = {
        $DragOrientation: 0, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
        $AutoPlay: true,
        $NavigatorOptions: { //[Optional] Options to specify and enable navigator or not
            $Class: $JssorNavigator$, //[Required] Class to create navigator instance
            $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
            $ActionMode: 1, //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
            $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
            $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
            $SpacingX: 10, //[Optional] Horizontal space between each item in pixel, default value is 0
            $SpacingY: 0, //[Optional] Vertical space between each item in pixel, default value is 0
            $Orientation: 1 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
        }
    };
    var jssor_slider1 = new $JssorSlider$("slider1_container", options);
});