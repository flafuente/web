<?php

/**
 * HTML helper Class
 */
class HTML
{

    public function relativeDate()
    {
    }

    public static function formButton($class = null, $spanClass = null, $display = null, $options = array())
    {
        //Link
        $html = "<button";

        //Default Bootstrap Class
        $options["class"] .= $class." btn ladda-button formButton";
        //Default Ladda
        $options["data-style"] = "slide-left";

        //Atributes
        foreach ((array) $options as $key => $value) {
            $html .= " ".$key."='".Helper::sanitize($value)."'";
        }

        //Link
        $html .= ">";

        //Span
        $html .= "<span class='glyphicon glyphicon-".Helper::sanitize($spanClass)."'></span>";

        if (isset($display)) {
            $html .= Helper::sanitize($display);
        }

        //Link
        $html .= "</button>";

        return $html;
    }

    public static function formLink($class = null, $spanClass = null, $href = null, $display = null, $options = array(), $confirmation = null)
    {
        //Href
        $options["data-link"] = $href;
        //Confirm
        if (isset($confirmation)) {
            $options["data-confirmation"] = Helper::sanitize($confirmation);
        }
        //Form Button
        return self::formButton($class, $spanClass, $display, $options);
    }

    public static function search()
    {
        return '<div class="input-group">
                    <input type="text" class="form-control" name="search" value="'.Helper::sanitize($_REQUEST["search"]).'">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                </div>';
    }

    public static function select($name, $list = array(), $selected = null, $options = array(), $firstOption = array(), $classOptions = array())
    {
        //Selected value
        $selectedArray = array();
        if (is_array($selected)) {
            if (!empty($selected)) {
                foreach ($selected as $s) {
                    $selectedArray[$s] = "selected";
                }
            }
        } else {
            $selectedArray[$selected] = "selected";
        }

        //Object
        if (is_object($list[0])) {
            //Default Id
            if ( ! isset($classOptions['id'])) $classOptions['id'] = "id";
            if ( ! isset($classOptions['display'])) $classOptions['display'] = "name";
            //New array list
            $newList = array();
            foreach ($list as $object) {
                $newList[(string) $object->$classOptions['id']] = $object->$classOptions['display'];
            }
            $list = $newList;
            unset($newList);
        }

        //Select
        $html = "<select";

        //Default Bootstrap Class
        $options["class"] .= " form-control";

        //Name
        if ( ! isset($options['name'])) $options['name'] = $name;

        //Atributes
        foreach ((array) $options as $key => $value) {
            $html .= " ".$key."='".Helper::sanitize($value)."'";
        }

        //Select
        $html .= ">";

        //First Option
        if (!empty($firstOption)) {
            if ( ! isset($firstOption['id'])) $firstOption['id'] = 0;
            if ( ! isset($firstOption['display'])) $firstOption['display'] = "Selecciona una opción";
            $html .= "<option value='".Helper::sanitize($firstOption["id"])."'>".Helper::sanitize($firstOption["display"])."</option>\n";
        }
        //Options
        foreach ($list as $value => $display) {
            $html .= "<option value='".Helper::sanitize($value)."' ".$selectedArray[$value].">".Helper::sanitize($display)."</option>\n";
        }

        //Select
        $html .= "</select>";

        return $html;
    }
    function showRate($value, $max, $min = 0, $bullets = 5)
    {
        $html = "";
        if ($min > 0) {
            /*Ajuste de rango*/
            $max = $max - $min;
            $value = $value - $min;
        }
        $porcentaje = $value * 100 / $max;
        $cuenta = 0;
        $value_bullet = 100 / $bullets;
        for ($x=1; $x<=$bullets; $x++) {
            if ($porcentaje < ($value_bullet * $x)) {
                $html .= "<div class='bullet'></div>";
            } else {
                $html .= "<div class='bullet bullet-blue'></div>";;
            }
        }

        return $html;
    }
}
