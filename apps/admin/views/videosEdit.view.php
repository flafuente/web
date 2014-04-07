<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
	<span class="glyphicon glyphicon-facetime-video"></span>
	Videos
	<small>
		<?=$user->id ? "Editar" : "Nuevo";?>
	</small>
</h1>

<div class="main">
	<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" id="app" value="admin">
		<input type="hidden" name="action" id="action" value="videosSave">
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
							<div class="col-sm-10">
								<input type="checkbox" name="estadoId" id="estadoId" value="1" <?php if($titulo->estadoId) echo "checked";?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Titulo
							</label>
							<div class="col-sm-10">
								<input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($video->titulo);?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Descripción
							</label>
							<div class="col-sm-10">
								<textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($video->descripcion);?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<?php if($video->id){ ?>
									<button class="btn btn-danger ladda-button delete" data-style="slide-left" action="videosDelete" confirm="¿Deseas realmente eliminar este video?">
										<span class="ladda-label">
											Eliminar
										</span>
									</button>
								<?php } ?>
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site("admin/videos");?>">
									<span class="ladda-label">
										Cancelar
									</span>
								</a>
								<button class="btn btn-primary ladda-button" data-style="slide-left">
									<span class="ladda-label">
										<?=$video->id ? "Guardar" : "Crear";?>
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