<?php defined('_EXE') or die('Restricted access'); ?>
<!-- NORMAL MENU -->
<div class='col-md-12 normalmenu' style='padding-left: 0px; padding-right: 0px;'>
    <ul class="nav nav-pills nav-stacked">
      <!--  class="active" -->
        <?php $url = Registry::getUrl(); ?>
        <?php $active = array(); ?>
        <?php $active[$url->app][$url->action] = "active"; ?>

      <li class="<?=$active["programas"]["index"];?> withsub">
        <a href="#">PROGRAMAS</a>
        <?php $secciones = Seccion::select(array("visible" => true)); ?>
        <?php if (count($secciones)) { ?>
            <ul class="submenu" style="display: none;">
                <div class="triangle"></div>
                <?php $x=0; foreach ($secciones as $seccion) { $x = $x+1; ?>
                    <li class="col-md-6" style="padding: 0px; margin: 0px;">
                        <a href="<?=Url::site("programas/seccion/".$seccion->slug);?>">
                            <div id="prg_<?= $x; ?>" class="imgmenu"></div>
                        </a>
                    </li>
                    <style>
                        #prg_<?= $x; ?>{
                          background-image: url("<?=$seccion->getMenuImage();?>");
                        }
                    </style>
                <?php } ?>
            </ul>
        <?php } ?>
      </li>
      <li class="<?=$active["periodismociudadano"]["index"];?> withsub">
        <a href="<?=Url::site("tribonews");?>">TRIBO NEWS</a>
      </li>
      <li class="<?=$active["tvdirecto"]["index"];?>">
        <a href="<?=Url::site("tvdirecto");?>">TV EN DIRECTO</a>
      </li>
      <li class="<?=$active["creadores"]["index"];?>"><a href="<?=Url::site("creadores");?>">CREADORES</a></li>
      <li class="<?=$active["quienessomos"]["index"];?>"><a href="<?=Url::site("quienessomos");?>">QUIÉNES SOMOS</a></li>
    </ul>
</div>
<!-- END NORMAL MENU -->
<!-- RESPONSIVE MENU -->
<div id="MainMenu" class="responsivemenu">
  <div class="list-group panel">
    <a href="#demo3" class="list-group-item list-group-item-success trblue" data-toggle="collapse" data-parent="#MainMenu">Menu</a>
    <div class="collapse" id="demo3">
      <a href="#SubMenu1" class="list-group-item" data-toggle="collapse" data-parent="#SubMenu1">PROGRAMAS<?php if(count($secciones)) echo '<i class="fa fa-caret-down"></i>'; ?></a>
      <?php if (count($secciones)) { ?>
            <div class="collapse list-group-submenu" id="SubMenu1">
                <?php $x=0; foreach ($secciones as $seccion) { $x = $x+1; ?>
                    <a href="<?=Url::site("programas/seccion/".$seccion->slug);?>" id="prg_<?= $x; ?>" class="list-group-item imgmenu" data-parent="#SubMenu1"></a>
                    <style>
                        #prg_<?= $x; ?>{
                          background-image: url("<?=$seccion->getMenuImage();?>");
                        }
                    </style>
                <?php } ?>
            </div>
        <?php } ?>
      <a href="<?=Url::site("tribonews");?>" class="list-group-item">TRIBO NEWS</a>
      <a href="<?=Url::site("tvdirecto");?>" class="list-group-item">TV EN DIRECTO</a>
      <a href="<?=Url::site("creadores");?>" class="list-group-item">CREADORES</a>
      <a href="<?=Url::site("quienessomos");?>" class="list-group-item">QUIÉNES SOMOS</a>
    </div>
  </div>
</div>

<!-- END RESPONSIVE MENU -->

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
    <a href="<?=Url::site("tribonews#haztetriber");?>" class="btn sintonizanos betriber">be triber</a>
</div>
