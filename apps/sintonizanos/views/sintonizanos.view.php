<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <img src="<?=Url::template("img/sintonizanos/sintonizanos.png");?>" alt="Sintonízanos" />
    <div class="square-info">
        <div class="grey">
            <?=Language::translate("VIEW_SINTONIZANOS_TITLE")?>
        </div>
        <div class="canalesd">
            <div class='title-linewh'>
                <span><img src='<?=Url::template("img/sintonizanos/TDT2.png")?>' title='tdt'></span>
            </div>
            <p class='center'><?=Language::translate("VIEW_SINTONIZANOS_CHANNELS_TITLE")?></p>
            <div class='region col-md-6'>
                <p><span class='blue'>MADRID</span> - Canal 39 - 618 MHz</p>
                <p><span class='blue'>ARANJUEZ</span> - Canal 21 - 474 MHz</p>
                <p><span class='blue'>ALCOBENDAS</span> - Canal 51 - 714 MHz</p>
                <p><span class='blue'>MOSTOLES</span> - Canal 39 - 618 MHz</p>
                <p><span class='blue'>SOTO DEL REAL</span> - Canal 35 - 586 MHz</p>
            </div>
            <div class='region col-md-6'>
                <p><span class='blue'>Fuenlabrada</span> - Canal 42 - 642 MHz</p>
                <p><span class='blue'>COLLADO VILLALBA</span> - Canal 29 - 538 MHz</p>
                <p><span class='blue'>ALCALA DE HENARES</span> - Canal 46 - 674 MHz</p>
                <p><span class='blue'>POZUELO</span> - Canal 23 - 490 MHz</p>
                <p><span class='blue'>SAN MARTIN DE VALDEIGLESIAS</span> - Canal 51 - 714 MHz</p>
            </div>
            <div class='region col-md-12'>
                <p style="text-align:center;"><span class='blue'>País Vasco</span> - Euskaltel</p>
            </div>
            <div style='clear:both;'></div>
            <div class='title-linewh'></div>
            <p class='center blue'><?=Language::translate("VIEW_SINTONIZANOS_CHANNELS_SUBTITLE")?></p>

        </div>
       <div style="clear: both;"></div>
    </div>
</div>
