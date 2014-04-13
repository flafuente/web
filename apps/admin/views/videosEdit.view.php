<?php defined('_EXE') or die('Restricted access'); ?>

<?php
if($video->id){
	$toolBar['subtitle'] = "Editar vídeo";
	$title = "Guardar";
}else{
	$toolBar['subtitle'] = "Nuevo vídeo";
	$title = "Crear";
}
$toolBar['title'] = "Vídeos";
$toolBar['class'] = "facetime-video";
$toolBar['buttons'][] = array(
    "buttonClass" => "success",
    "spanClass" => "ok",
    "title" => $title,
    "app" => "admin",
    "action" => "videosSave",
);
$toolBar['buttons'][] = array(
    "buttonClass" => "primary",
    "spanClass" => "chevron-left",
    "title" => "Cancelar",
    "app" => "admin",
    "action" => "videos",
    "noAjax" => true,
);
if($video->id){
	$toolBar['buttons'][] = array(
	    "buttonClass" => "danger",
	    "spanClass" => "remove",
	    "title" => "Eliminar",
	    "app" => "admin",
	    "action" => "videosDelete",
	    "confirmation" => "¿Deseas realmente eliminar este vídeo?",
	);
}
$controller->setData("toolBar", $toolBar);
echo $controller->view("modules.toolbar");
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
	<input type="hidden" name="app" id="app" value="">
	<input type="hidden" name="action" id="action" value="">
	<input type="hidden" name="id" value="<?=$video->id?>">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Detalles
				</div>
			  	<div class="panel-body">
			    	<div class="form-group">
						<label class="col-sm-2 control-label">
							Estado
						</label>
						<div class="col-sm-8">
							<input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($video->estadoId) echo "checked";?>>
						</div>
					</div>
					<?php if(count($categorias)){ ?>
						<!-- Categoría -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Categoría
							</label>
							<div class="col-sm-8">
								<select class="form-control" name="categoriaId" id="categoriaId">
									<?php $s = array(); ?>
									<?php $s[$video->categoriaId] = "selected"; ?>
									<?php foreach($categorias as $categoria){ ?>
										<option value="<?=$categoria->id?>" <?=$s[$categoria->id]?>>
											<?=$categoria->nombre;?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
					<?php } ?>
					<!-- Título -->
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Título
						</label>
						<div class="col-sm-8">
							<input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($video->titulo);?>">
						</div>
					</div>
					<!-- Descripción -->
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Descripción
						</label>
						<div class="col-sm-8">
							<textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($video->descripcion);?></textarea>
						</div>
					</div>
					<?php if(count($tags)){ ?>
						<!-- Tags -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Tags
							</label>
							<div class="col-sm-8">
								<select class="form-control select2" multiple="true" name="tags[]" id="tags">
									<?php $s = array(); ?>
									<?php $currentTags = Tag::getTagsByVideoId($video->id); ?>
									<?php if(Count($currentTags)){ ?>
										<?php foreach($currentTags as $tag){ ?>
											<?php $s[$tag->id] = "selected"; ?>
										<?php } ?>
									<?php } ?>
									<?php foreach($tags as $tags){ ?>
										<option value="<?=$tags->id?>" <?=$s[$tags->id]?>>
											<?=$tags->nombre;?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
					<?php } ?>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Archivo
						</label>
						<div class="col-sm-8">
							<input type="hidden" name="file" id="filename" value="">
							<span class="btn btn-success fileinput-button">
						        <i class="glyphicon glyphicon-plus"></i>
						        <span>Select files...</span>
						        <!-- The file input field used as target for the file upload widget -->
						        <input id="fileupload" type="file" name="files[]" accept="video/*">
						    </span>
						    <br>
						    <br>
						    <!-- The global progress bar -->
						    <div id="progress" class="progress">
						        <div class="progress-bar progress-bar-success"></div>
						    </div>
						    <!-- The container for the uploaded files -->
						    <div id="files" class="files"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	$(function () {
		// Change this to the location of your server-side upload handler:
    	var url = "<?=Url::site('api/upload');?>";
		$('#fileupload').fileupload({
	        url: url,
	        dataType: 'json',
	        done: function (e, data) {
	            $.each(data.result.files, function (index, file) {
	            	if(!file.error){
		                $('<p/>').text(file.name).appendTo('#files');
		                $("#filename").val(file.name);
		            }else{
		            	$("#filename").val("");
		            	alert(file.error);
		            }
	            });
	        },
	        progressall: function (e, data) {
	            var progress = parseInt(data.loaded / data.total * 100, 10);
	            $('#progress .progress-bar').css(
	                'width',
	                progress + '%'
	            );
	        }
	    })/*.on('fileuploadsubmit', function (e, data) {
		   data.formData = data.context.find(':input').serializeArray();
		});*/
	});
</script>