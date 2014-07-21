<?php defined('_EXE') or die('Restricted access'); ?>
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
    <ul class="nav nav-pills nav-stacked">
      <!--  class="active" -->
        <?php $url = Registry::getUrl(); ?>
        <?php $active = array(); ?>
        <?php $active[$url->app][$url->action] = "active"; ?>

      <li class="<?=$active["programas"]["index"];?> withsub">
        <a href="#">PROGRAMAS</a>
        <?php $categorias = Categoria::select(); ?>
        <?php if (count($categorias)) { ?>
            <ul class="submenu" style="display: none;">
                <div class="triangle"></div>
                <?php foreach ($categorias as $categoria) { ?>
                    <li class="col-md-6"
                    <?php if ($categoria->color) { ?>
                      onMouseOver="this.style.backgroundColor='<?=$categoria->color;?>'"
                      onMouseOut="this.style.backgroundColor='white'"
                    <?php } else { ?>
                      onMouseOver="this.style.backgroundColor='#e40d7e'"
                      onMouseOut="this.style.backgroundColor='white'"
                    <?php } ?>
                    >
                        <a href="<?=Url::site("programas/seccion/".$categoria->slug);?>">
                            <?=Helper::sanitize($categoria->nombre);?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
      </li>
      <li class="<?=$active["periodismociudadano"]["index"];?>">
        <a href="<?=Url::site("periodismociudadano");?>">PERIODISMO CIUDADANO</a>
      </li>
      <li class="<?=$active["tvdirecto"]["index"];?>">
        <a href="<?=Url::site("tvdirecto");?>">TV EN DIRECTO</a>
      </li>
      <li class="<?=$active["colaboradores"]["index"];?>"><a href="<?=Url::site("colaboradores");?>">COLABORADORES</a></li>
      <li class="<?=$active["quienessomos"]["index"];?>"><a href="<?=Url::site("quienessomos");?>">QUIÉNES SOMOS</a></li>
    </ul>
</div>

<!-- Scripts Menu -->
<script>
    $(document).on("mouseover",".withsub",function () {
        $(this).find('.submenu').css("display", "block");
    });
    $(document).on("mouseout",".withsub",function () {
        $(this).find('.submenu').css("display", "none");
    });
</script>

<!-- Parrilla Module -->
<?=$controller->view("modules.parrilla");?>
<!-- /Parrilla Module -->

<!-- Sintonizanos -->
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
    <a href="<?=Url::site("sintonizanos");?>" class="btn sintonizanos"><img src="<?=Url::template("img/weirdicon.png")?>" />&nbsp;&nbsp;SINTONÍZANOS</a>
</div>
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
    <a href="<?=Url::site("periodismociudadano#haztetriber");?>" class="btn sintonizanos betriber">be triber</a>
</div>
