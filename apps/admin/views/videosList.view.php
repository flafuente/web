<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
	<span class="glyphicon glyphicon-facetime-video"></span>
	Videos
	<small>
		Listar
	</small>
</h1>

<div class="action">
	<a class="btn btn-primary ladda-button" href="<?=Url::site("admin/videosEdit");?>" data-style="slide-left">
		<span class="ladda-label">
			Crear
		</span>
	</a>
</div>

<div class="main">
	<form method="post" action="<?=Url::site("users")?>">
		<?php if(count($results)){ ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?=Helper::sortableLink("id", "Id");?></th>
							<th><?=Helper::sortableLink("estadoId", "Estado");?></th>
							<th><?=Helper::sortableLink("categoriaId", "Categoría");?></th>
							<th><?=Helper::sortableLink("titulo", "Titulo");?></th>
							<th><?=Helper::sortableLink("userId", "Usuario");?></th>
							<th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
							<th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($results as $video){ ?>
							<?php $user = new User($video->userId); ?>
							<tr>
								<td><?=$video->id;?></a></td>
								<td>
									<span class="label label-<?=$video->getEstadoCssString();?>">
										<?=$video->getEstadoString();?>
									</span>
								</td>
								<td>
									<?=$video->getCategoriaString();?>
								</td>
								<td>
									<a href="<?=Url::site("admin/videosEdit/".$video->id);?>">
										<?=Helper::sanitize($video->titulo);?>
									</a>
								</td>
								<td>
									<a href="<?=Url::site("admin/usersEdit/".$user->id);?>">
										<?=Helper::sanitize($user->email);?>
									</a>
								</td>
								<td><?=Helper::humanDate($video->dateInsert);?></td>
								<td><?=Helper::humanDate($video->dateUpdate);?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php $controller->setData("pag", $pag); ?>
				<?=$controller->view("modules.pagination");?>
			</div>
		<?php }else{ ?>
			<blockquote>
		  		<p>No se han encontrado videos</p>
			</blockquote>
		<?php } ?>
	</form>
</div>