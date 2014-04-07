<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
	<span class="glyphicon glyphicon-user"></span>
	Usuarios
	<small>
		Listar
	</small>
</h1>

<div class="action">
	<a class="btn btn-primary ladda-button" href="<?=Url::site("admin/usersEdit");?>" data-style="slide-left">
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
							<th><?=Helper::sortableLink("statusId", "Estado");?></th>
							<th><?=Helper::sortableLink("roleId", "Rol");?></th>
							<th><?=Helper::sortableLink("email", "Email");?></th>
							<th><?=Helper::sortableLink("nombre", "Nombre");?></th>
							<th><?=Helper::sortableLink("apellidos", "Apellidos");?></th>
							<th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
							<th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($results as $user){ ?>
							<tr>
								<td><?=$user->id;?></a></td>
								<td>
									<span class="label label-<?=$user->getStatusCssString();?>">
										<?=$user->getStatusString();?>
									</span>
								</td>
								<td><?=$user->getRoleString()?></td>
								<td>
									<a href="<?=Url::site("admin/usersEdit/".$user->id);?>">
										<?=Helper::sanitize($user->email);?>
									</a>
								</td>
								<td><?=$user->nombre;?></td>
								<td><?=$user->apellidos;?></td>
								<td><?=Helper::humanDate($user->dateInsert);?></td>
								<td><?=Helper::humanDate($user->dateUpdate);?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php $controller->setData("pag", $pag); ?>
				<?=$controller->view("modules.pagination");?>
			</div>
		<?php }else{ ?>
			<blockquote>
		  		<p>No se han encontrado usuarios</p>
			</blockquote>
		<?php } ?>
	</form>
</div>