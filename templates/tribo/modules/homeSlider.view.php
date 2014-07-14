<?php defined('_EXE') or die('Restricted access'); ?>

<!-- Jssor Slider Begin -->
<!-- You can move inline styles (except 'top', 'left', 'width' and 'height') to css file or css block. -->
<div id="slider1_container" style="position: relative;
        top: 0px; left: 0px; width: 960px; height: 310px; z-index:99999 ;">
    <!-- Loading Screen -->
    <div u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block; background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
        </div>
        <div style="position: absolute; display: block; background: url(<?=Url::template("/img/loading.gif");?>) no-repeat center center; top: 0px; left: 0px;width: 100%;height:100%;">
        </div>
    </div>
    <!-- Slides Container -->
    <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 960px;            height: 310px; overflow: hidden;">
        <div>
            <a href="<?=Url::site("periodismociudadano#haztetriber");?>"><img u="image" src="<?=Url::template("/img/home/slide0.jpg");?>" />
            
            </a>
            <!--<div class='title'>
                <p><span>tribo tv es..</span></p>
            </div>-->
        </div>
        <div>
            <img u="image" src="<?=Url::template("/img/home/slide1.jpg");?>" />
            <!--<div class='title'>
                <p><span>Sólo las personas saben lo que les gusta a las personas</span></p>
            </div>-->
        </div>
        <div>
            <a href="<?=Url::site("periodismociudadano#haztetriber");?>">
            <img u="image" src="<?=Url::template("/img/home/slide2.jpg");?>" />
            </a>
            <!--<div class='title'>
                <p><span>Sólo las personas saben lo que les gusta a las personas</span></p>
            </div>-->
        </div>
        <div>
            <a href="<?=Url::site("periodismociudadano#haztetriber");?>">
            <img u="image" src="<?=Url::template("/img/home/slide3.jpg");?>" />
            </a>
            <!--<div class='title'>
                <p><span>Sólo las personas saben lo que les gusta a las personas</span></p>
            </div>-->
        </div>
    </div>
    <!-- navigator container -->
    <div u="navigator" class="jssorn03" style="position: absolute; bottom: -15px; left: 48%;">
        <!-- navigator item prototype -->
        <div u="prototype" style="position: absolute; width: 11px; height: 11px; ">

        </div>
    </div>
</div>
<!-- Jssor Slider End -->

<script>
//Page Ready
jQuery(document).ready(function ($) {
    //Slider
    var options = {
        $DragOrientation: 0, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
        $FillMode: 2,
		$AutoPlay: true,
        $NavigatorOptions: { //[Optional] Options to specify and enable navigator or not
            $Class: $JssorNavigator$, //[Required] Class to create navigator instance
            $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
            $ActionMode: 1, //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
            $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
            $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
            $SpacingX: 10, //[Optional] Horizontal space between each item in pixel, default value is 0
            $SpacingY: 0, //[Optional] Vertical space between each item in pixel, default value is 0
            $Orientation: 1 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
        }
    };
    var jssor_slider1 = new $JssorSlider$("slider1_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(bodyWidth, 960));
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();

            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $(window).bind('resize', ScaleSlider);
            }


            //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
            //    $(window).bind("orientationchange", ScaleSlider);
            //}
            //responsive code end
});
</script>