<?php

/**
 * HTML helper Class
 */
class HTML
{

    public static function wistiaPlayer($hash, $width = 450, $height = 253)
    {
        ?>
            <div id="wistia_<?=$hash;?>" class="wistia_embed" style="width:<?=$width?>px;height:<?=$height?>px;"></div>
            <script>
                wistiaEmbed = Wistia.embed("<?=$hash;?>");
            </script>
        <?php
    }

    public function relativeDate($date)
    {
        //type cast, current time, difference in timestamps
        $timestamp      = (int) strtotime($date);
        $current_time   = time();
        $diff           = $current_time - $timestamp;

        //intervals in seconds
        $intervals      = array (
            'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
        );

        //now we just find the difference
        if ($diff == 0) {
            return 'Justo ahora';
        }

        if ($diff < 60) {
            return $diff == 1 ? $diff . ' segundo' : $diff . ' segundos';
        }

        if ($diff >= 60 && $diff < $intervals['hour']) {
            $diff = floor($diff/$intervals['minute']);

            return $diff == 1 ? $diff . ' minuto' : $diff . ' minutos';
        }

        if ($diff >= $intervals['hour'] && $diff < $intervals['day']) {
            $diff = floor($diff/$intervals['hour']);

            return $diff == 1 ? $diff . ' hora' : $diff . ' horas';
        }

        if ($diff >= $intervals['day'] && $diff < $intervals['week']) {
            $diff = floor($diff/$intervals['day']);

            return $diff == 1 ? $diff . ' dia' : $diff . ' dias';
        }

        if ($diff >= $intervals['week'] && $diff < $intervals['month']) {
            $diff = floor($diff/$intervals['week']);

            return $diff == 1 ? $diff . ' semana' : $diff . ' semanas';
        }

        if ($diff >= $intervals['month'] && $diff < $intervals['year']) {
            $diff = floor($diff/$intervals['month']);

            return $diff == 1 ? $diff . ' mes' : $diff . ' meses';
        }

        if ($diff >= $intervals['year']) {
            $diff = floor($diff/$intervals['year']);

            return $diff == 1 ? $diff . ' año' : $diff . ' años';
        }
    }

    public static function formButton($class = null, $spanClass = null, $display = null, $options = array(), $gli = "glyphicon")
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
        $html .= "<span class='".$gli." ".$gli."-".Helper::sanitize($spanClass)."'></span>";

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
    function showInput($img, $label, $name, $valor = "", $placeholder = "", $type = "text", $showlabel = true, $s_label = 3)
    {
        $s_field = (12-$s_label);
        $html = "";
        if($img != "") $img = '<img src="'.$img.'" />&nbsp;&nbsp;';
        if($placeholder == "") $placeholder = $label;
        $html = '
        <!-- '.$name.' -->
        <div class="form-group">';
        if ($showlabel) {
            $html .= '
            <label for="'.$name.'" class="col-sm-'.$s_label.' control-label l-left" style="margin-top: 10px;">
                '.$img.$label.'
            </label>';
        }
        $html .= '<div class="col-sm-'.$s_field.'">';
                if ($type == "textarea") {
                    $html .= '<textarea id="'.$name.'" name="'.$name.'" class="form-control" placeholder="'.$placeholder.'">'.$valor.'</textarea>';
                } else {
                    $html .= '<input type="'.$type.'" class="form-control" id="'.$name.'" name="'.$name.'" placeholder="'.$placeholder.'"  value="'.$valor.'"/>';
                }
        $html .= '
            </div>
        </div>';

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

    /**
     * Make a sortable link for a table in a form
     *
     * @param string $sortableField Database Field
     * @param string $text          Text
     *
     * @return string HTML Link
     */
    public function sortableLink($sortableField = "", $text = "")
    {
        $orderDir = "ASC";
        if ($_REQUEST['order']==$sortableField) {
             $cssClass = "sort-by-attributes-alt";
            if ($_REQUEST['orderDir']=="ASC") {
                $orderDir = "DESC";
                $cssClass = "sort-by-attributes";
            }
        }

        return
            "<a href='#' class='sortable' data-order='".Helper::sanitize($sortableField)."' data-orderDir='".Helper::sanitize($orderDir)."'>
                ".Helper::sanitize($text)."
                <span class='glyphicon glyphicon-".Helper::sanitize($cssClass)."'></span>
            </a>";
    }

    /**
     * Make a sort inputs.
     *
     * @return string HTML form inputs
     */
    public function sortInputs()
    {
        return "<input type='hidden' name='order' value='".Helper::sanitize($_REQUEST["order"])."'>
                <input type='hidden' name='orderDir' value='".Helper::sanitize($_REQUEST["orderDir"])."'>";
    }

    /**
     * Make a pagination form inputs.
     *
     * @return string HTML inputs
     */
    public function paginationInputs()
    {
        return "<input type='hidden' name='limit' value='".Helper::sanitize($_REQUEST["limit"])."'>
                <input type='hidden' name='limitStart' value='".Helper::sanitize($_REQUEST["limitStart"])."'>";
    }
}
