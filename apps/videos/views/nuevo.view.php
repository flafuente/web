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
		<input type="hidden" name="app" id="app" value="videos">
		<input type="hidden" name="action" id="action" value="save">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Detalles
					</div>
				  	<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Titulo
							</label>
							<div class="col-sm-10">
								<input type="text" id="titulo" name="titulo" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Descripción
							</label>
							<div class="col-sm-10">
								<textarea name="descripcion" class="form-control" id="descripcion"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site("videos");?>">
									<span class="ladda-label">
										Cancelar
									</span>
								</a>
								<button class="btn btn-primary ladda-button" data-style="slide-left">
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