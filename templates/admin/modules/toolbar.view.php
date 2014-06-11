<?php defined('_EXE') or die('Restricted access'); ?>

<div class="toolbar">
    <div class="title pull-left">
        <h1>
            <span class="glyphicon glyphicon-<?=$toolBar['class']?>"></span>
            <?=$toolBar['title']?>
            <small>
                <?=$toolBar['subtitle']?>
            </small>
        </h1>
    </div>
    <div class="pull-right" style="margin-top: 25px;">
        <?php if (count($toolBar['buttons'])) { ?>
            <?php foreach ($toolBar['buttons'] as $button) { ?>
                <button
                    data-style="slide-left"
                    class="btn btn-small btn-<?=$button['buttonClass']?> ladda-button"
                    <?php if ($button['id']) {?> id="<?=$button['id']?>" <?php } ?>
                    onClick="doSubmit($(this), '<?=$button['app']?>', '<?=$button['action']?>', '<?=$button['requireIds']?>', '<?=$button['confirmation']?>', '<?=$button['ajax']?>', '<?=$button['modal']?>', '<?=$button['noAjax']?>');"
                    >
                    <span class="glyphicon glyphicon-<?=$button['spanClass']?>"></span>
                    <?=$button['title']?>
                </button>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="clearfix"></div>
