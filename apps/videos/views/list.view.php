<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
	Videos
	<small>
		Listar
	</small>
</h1>

<a class="btn btn-primary ladda-button" href="<?=Url::site("videos/nuevo");?>" data-style="slide-left">
	<span class="ladda-label">
		Crear
	</span>
</a>

<div class="main">
	<form method="post" action="<?=Url::site("users")?>">
		<?php if(count($results)){ ?>
			<?php foreach($results as $video){ ?>
				<div class="media">
					<a class="pull-left" href="#">
						<img class="media-object" src="holder.js/64x64">
					</a>
					<div class="media-body">
						<h4 class="media-heading"><?=$video->titulo;?></h4>
						<?=$video->getCategoriaString();?>
					</div>
				</div>
			<?php } ?>
			<?php $controller->setData("pag", $pag); ?>
			<?=$controller->view("modules.pagination");?>
		<?php }else{ ?>
			<blockquote>
		  		<p>No se han encontrado videos</p>
			</blockquote>
		<?php } ?>
	</form>
</div>