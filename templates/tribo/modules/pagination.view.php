<?php defined('_EXE') or die('Restricted access'); ?>

<?php $pages = $pag['limit'] ? ceil($pag['total'] / $pag['limit']) : $pag['total']; ?>
<?php $current = ($pag['limitStart']/$pag['limit']); ?>
<?php $url = Registry::getUrl(); ?>
<?php $app = $url->app; ?>
<?php $action = $url->action; ?>
<?php $next = $current + $pag["limit"]; ?>
<?php $back = $current - $pag["limit"]; ?>

<?php if ($pages) { ?>
    <center>
        <ul class="pagination">
            <li class="<?php if(($pag['limitStart']/$pag['limit'])==0) echo "disabled"; ?>">
                <a data-app="<?=$app?>" data-action="<?=$action?>" data-limit="<?=(int) $pag['limit']?>" data-limitStart="0">
                    &laquo;
                </a>
            </li>
            <?php for ($i=0; $i<$pages; $i++) { ?>
                <li class="<?php if($i == ($pag['limitStart']/$pag['limit'])) echo "active"; ?>">
                    <a data-app="<?=$app?>" data-action="<?=$action?>" data-limit="<?=(int) $pag['limit']?>" data-limitStart="<?=(int) ($i*$pag['limit'])?>">
                        <?=(int) $i+1?><span class="sr-only"></span>
                    </a>
                </li>
            <?php } ?>
            <li class="<?php if(($pag['limitStart']/$pag['limit'])==$pages-1) echo "disabled"; ?>">
                <a data-app="<?=$app?>" data-action="<?=$action?>" data-limit="<?=(int) $pag['limit']?>" data-limitStart="<?=(int) (($pages-1)*$pag['limit'])?>">
                    &raquo;
                </a>
            </li>
        </ul>
    </center>
<?php }
