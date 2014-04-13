<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<h1>
	<span class="glyphicon glyphicon-user"></span>
	Videos
	<small>
		Nuevo
	</small>
</h1>

<div class="main">
	<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" id="app" value="">
		<input type="hidden" name="action" id="action" value="">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Detalles
					</div>
				  	<div class="panel-body">
						<?php if(count($categorias)){ ?>
							<!-- Categoría -->
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Categoría
								</label>
								<div class="col-sm-8">
									<select class="form-control" name="categoriaId" id="categoriaId">
										<?php foreach($categorias as $categoria){ ?>
											<option value="<?=$categoria->id?>">
												<?=$categoria->nombre;?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
						<?php } ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Titulo
							</label>
							<div class="col-sm-8">
								<input type="text" id="titulo" name="titulo" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Descripción
							</label>
							<div class="col-sm-8">
								<textarea name="descripcion" class="form-control" id="descripcion"></textarea>
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
										<?php foreach($tags as $tags){ ?>
											<option value="<?=$tags->id?>">
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
							        <span>Seleccionar...</span>
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
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site("videos");?>">
									<span class="ladda-label">
										Cancelar
									</span>
								</a>
								<button class="btn btn-primary ladda-button" id="submit" data-style="slide-left">
									<span class="ladda-label">
										Crear
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	$(function () {
		// Change this to the location of your server-side upload handler:
    	var url = "<?=Url::site('api/upload');?>";
		$('#fileupload').fileupload({
			maxChunkSize: 10000000,
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
	    })
	});

	$("#submit").on( "click", function() {
		$("#app").val("videos");
		$("#action").val("save");
		$("#mainForm").submit();
		return false;
	});
</script>