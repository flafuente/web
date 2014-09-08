<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class='video-info' style="padding: 5px;">
        <div class='title-line'>
            <span>LOCALIZACIÓN TRIBERS</span>
        </div>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <div style="overflow:hidden;height:300px;">
            <div id="gmap_canvas" style="height:300px;"></div>
        </div>
        <script type="text/javascript">
            function init_map()
            {
                var myOptions = {
                    zoom:5,
                    center:new google.maps.LatLng(38.09690980000001,-3.6369803000000047),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]

                };
                map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);

                <?php foreach ($videos as $video) { ?>
                    <?= markerMaps("video".$video->id, $video->lat, $video->long, "<b>".Helper::sanitize($video->titulo)."</b>"); ?>
                <?php } ?>

            }
            google.maps.event.addDomListener(window, 'load', init_map);
        </script>

    </div>
</div>
<div style="clear: both;"></div>

<?php
function markerMaps($name, $lat, $long, $html)
{
    $mark =  $name.' = new google.maps.Marker({map: map, position: new google.maps.LatLng('.$lat.', '.$long.')});
             infowindow'.$name.' = new google.maps.InfoWindow({content:"'.$html.'" });
             google.maps.event.addListener('.$name.', "click", function () {
                 infowindow'.$name.'.open(map,'.$name.');
             });
             infowindow'.$name.'.open(map,'.$name.');';

    return $mark;
}
