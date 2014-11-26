<?php defined('_EXE') or die('Restricted access'); ?>

<?php if (count($videos)) { ?>

    <?php
    // Agrupación de coordenadas
    $coords = array();
    foreach ($videos as $video) {

        // El vídeo tiene coordenadas?
        if ($video->lat && $video->long) {

            $coords[$video->lat.":".$video->long][] = $video;
        }
    }
    ?>

    <?php if (!empty($coords)) { ?>

        <div class='col-md-12'>
            <div class='video-info' style="padding: 5px;">

                <div class='title-line'>
                    <span>LOCALIZACIÓN</span>
                </div>

                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

                <div style="overflow:hidden;height:300px;">
                    <div id="gmap_canvas" style="height:300px;"></div>
                </div>

                <script type="text/javascript">
                    function init_map()
                    {
                        //Map
                        var myOptions = {
                            zoom:5,
                            center: new google.maps.LatLng(38.09690980000001,-3.6369803000000047),
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]

                        };
                        var map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);

                        //Zoom limit
                        google.maps.event.addListener(map, 'zoom_changed', function () {
                            zoomChangeBoundsListener = google.maps.event.addListener(map, 'bounds_changed', function (event) {
                                if (this.getZoom() > 15)
                                    this.setZoom(15);
                                google.maps.event.removeListener(zoomChangeBoundsListener);
                            });
                        });

                        //Markers
                        var latlngbounds = new google.maps.LatLngBounds();
                        <?php foreach ($coords as $coord => $videos) { ?>
                            <?php $i++; ?>
                            <?php $coord = explode(":", $coord); ?>

                            <?php
                            //Content
                            $content = "<div style='min-width: 150px'>";
                            foreach ($videos as $video) {
                                $content .= "<p><a href='".Url::site("tribonews/video/".$video->id)."'>".Helper::sanitize($video->titulo)."</a></p>";
                            }
                            $content .= "</div>";
                            ?>

                            marker<?=$i;?> = new google.maps.Marker({
                                map: map,
                                position: new google.maps.LatLng('<?=$coord[0]?>', '<?=$coord[1]?>'),
                            });

                            infowindow<?=$i;?> = new google.maps.InfoWindow({
                                content: "<?=$content;?>",
                            });

                            google.maps.event.addListener(marker<?=$i;?>, "click", function () {
                                infowindow<?=$i;?>.open(map, marker<?=$i;?>);
                            });

                            latlngbounds.extend(new google.maps.LatLng('<?=$coord[0]?>', '<?=$coord[1]?>'));

                            map.setCenter(latlngbounds.getCenter());
                        <?php } ?>

                    }
                    google.maps.event.addDomListener(window, 'load', init_map);
                </script>

            </div>
        </div>
        <div style="clear: both;"></div>

    <?php } ?>

<?php } ?>
