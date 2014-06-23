<?php

/**
 * Toolbar Class
 *
 * @package LightFramework\Core
 */
class Toolbar
{
    /**
     * Current title
     * @var array
     */
    private static $title = NULL;

    /**
     * Current buttons
     * @var array
     */
    private static $buttons = NULL;

    public static function addTitle($title, $class=null, $subtitle=null)
    {
        self::$title = array(
            "title" => $title,
            "class" => $class,
            "subtitle" => $subtitle,
        );
    }

    public static function addButton($params = array())
    {
        self::$buttons[] = $params;
    }

    public static function render()
    {
        $title = self::$title;
        $buttons = self::$buttons;
        ?>
        <div class="toolbar row">
            <div class="title">
                <h1>
                    <span class="glyphicon <?=$title["class"]?>"></span>
                    <?=Helper::sanitize($title["title"]);?>
                    <small>
                       <?=Helper::sanitize($title["subtitle"]);?>
                    </small>
                </h1>
            </div>
            <div class="tools">
                <?php if (count($buttons)) { ?>
                    <?php foreach ($buttons as $button) { ?>
                        <button
                            data-style="slide-left"
                            class="btn btn-small btn-<?=$button['class']?> ladda-button"
                                <?php if ($button['id']) {?> id="<?=$button['id']?>" <?php } ?>
                                <?php if ($button['app']) {?> data-app="<?=$button['app']?>" <?php } ?>
                                <?php if ($button['action']) {?> data-action="<?=$button['action']?>" <?php } ?>
                                <?php if ($button['requireIds']) {?> data-requireids="<?=$button['requireIds']?>" <?php } ?>
                                <?php if ($button['confirmation']) {?> data-confirmation="<?=$button['confirmation']?>" <?php } ?>
                                <?php if ($button['ajax']) {?> data-ajax="<?=$button['ajax']?>" <?php } ?>
                                <?php if ($button['noAjax']) {?> data-noajax="<?=$button['noAjax']?>" <?php } ?>
                                <?php if ($button['modal']) {?> data-modal="<?=$button['modal']?>" <?php } ?>
                            >
                            <span class="glyphicon glyphicon-<?=$button['spanClass']?>"></span>
                            <?=$button['title']?>
                        </button>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}
