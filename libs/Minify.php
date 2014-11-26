<?php

class Minify
{
    private static $javascript;
    private static $stylesheet;

    private static $cssUri = "css/cache.css";
    private static $jsUri = "js/cache.js";

    public static function js($scriptPath)
    {
        $config = Registry::getConfig();
        if ($config->get("minify")) {
            self::$javascript .= file_get_contents(self::getTemplatePath().$scriptPath).";\n";

            return true;
        } else {
            self::htmlJs($scriptPath);
        }
    }

    public static function css($cssPath)
    {
        $config = Registry::getConfig();
        if ($config->get("minify")) {
            self::$stylesheet .= file_get_contents(self::getTemplatePath().$cssPath).";\n";

            return true;
        } else {
            self::htmlCss($cssPath);
        }
    }

    public static function renderJs()
    {
        $config = Registry::getConfig();
        if ($config->get("minify")) {
            $path = self::getTemplatePath().self::$jsUri;
            if (!file_exists($path) || $config->get("minifyForce")) {
                file_put_contents($path, JSMin::minify(self::$javascript));
            }
            self::htmlJs(self::$jsUri);
        }
    }

    public function renderCss()
    {
        $config = Registry::getConfig();
        if ($config->get("minify")) {
            $path = self::getTemplatePath().self::$cssUri;
            if (!file_exists($path) || $config->get("minifyForce")) {
                file_put_contents($path, CssMin::minify(self::$stylesheet));
            }
            self::htmlCss(self::$cssUri);
        }
    }

    private static function htmlCss($uri)
    {
        echo '<link href="'.Url::template($uri).'" media="screen" rel="stylesheet" type="text/css" />';
    }

    private static function htmlJs($uri)
    {
        echo '<script src="'.Url::template($uri).'" type="text/javascript"></script>';
    }

    private static function getTemplatePath()
    {
        $config = Registry::getConfig();
        $template = $config->get("template");

        return $config->get("path")."/templates/".$template."/";
    }

}
