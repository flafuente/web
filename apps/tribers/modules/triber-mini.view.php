<?php defined('_EXE') or die('Restricted access'); ?>

<div class="similar_triber col-md-3">
    <img src="<?= $imagen; ?>" alt="<?= $user->getFullName(); ?>" title="<?= $user->getFullName(); ?>" />
    <div class="oversimilar">
        <a href="<?= $enlace; ?>">
            <div class="similar_name">
                <?= $user->getFullName(); ?>
            </div>
            <div class="similar_city">
                <?= $user->ubicacion; ?>
            </div>
            <div class="similar_news">
                <?= count(Video::select(array("userId" => $user->id, "estadoId" => 1))); ?> noticias
            </div>
        </a>
    </div>
</div>
