<?php defined('_EXE') or die('Restricted access'); ?>

<?php $date = $_REQUEST["date"] ? $_REQUEST["date"] : date("Y-m-d", strtotime('Monday this week')); ?>

<link href='<?=Url::template("/css/fullcalendar.css");?>' rel='stylesheet' />
<link href='<?=Url::template("/css/fullcalendar.print.css");?>' rel='stylesheet' media='print' />
<script src='<?=Url::template("/js/moment.min.js");?>'></script>
<script src='<?=Url::template("/js/jquery-ui.fullcal.min.js");?>'></script>
<script src='<?=Url::template("/js/fullcalendar.js");?>'></script>
<script>

    $(document).ready(function () {
        var unit = 720000;
        /* initialize the external events
        -----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                start: function (e, ui) {
                    if ($(this).attr('size-overlay')!="" && $(this).attr('size-overlay')) {
                        $('#size-overlay').val($(this).attr('size-overlay'));
                    }
                    if ($(this).attr('event-color')!="" && $(this).attr('event-color')) {
                        $('#event-color').val($(this).attr('event-color'));
                    }
                    if ($(this).attr('event-cap')!="" && $(this).attr('event-cap')) {
                        $('#event-cap').val($(this).attr('event-cap'));
                    }
                },
                revertDuration: 0  //  original position after the drag
            });

        });

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            defaultDate: '<?=$date;?>',
            defaultView: 'agendaWeek',
            selectable: false,
            allDaySlot: false,
            firstDay: 1,
            slotDuration: '00:12:00',
            selectHelper: true,
            eventClick: function (event) {
               if (confirm('Proceder a eliminar el registro?')) {
                    $.ajax({
                        type: "POST",
                        url: "<?=Url::site('admin/parrilla/delete/');?>",
                        data: {
                            id: event._id,
                        },
                        dataType: "json"
                    }).done(function (json) {
                        $('#calendar').fullCalendar('removeEvents',event._id);
                    });
                }
            },
            eventResize: function (event, delta, revertFunc) {
                $.ajax({
                    type: "POST",
                    url: "<?=Url::site('admin/parrilla/save/');?>",
                    data: {
                        id: event._id,
                        fechaInicio: event.start.format("YYYY-MM-DD HH:mm:ss"),
                        fechaFin: event.end.format("YYYY-MM-DD HH:mm:ss")
                    },
                    dataType: "json"
                });
            },
            editable: true,
            droppable: true,
            eventDragStop: function (event) {
                $.ajax({
                    type: "POST",
                    url: "<?=Url::site('admin/parrilla/save/');?>",
                    data: {
                        id: event._id,
                        fechaInicio: event.start.format("YYYY-MM-DD HH:mm:ss"),
                        fechaFin: event.end.format("YYYY-MM-DD HH:mm:ss")
                    },
                    dataType: "json"
                });
            },
            prev: function () {
                window.location.href = "<?=Url::site('admin/parrilla');?>/?date=<?=date('Y-m-d', strtotime($date . ' -7 day'));?>";
            },
            next: function () {
                window.location.href = "<?=Url::site('admin/parrilla');?>/?date=<?=date('Y-m-d', strtotime($date . ' +7 day'));?>";
            },
            drop: function (date) { // this function is called when something is dropped
                var idinsert = 0;
                var startinsert = date.format("YYYY-MM-DD HH:mm:ss");
                var endinsert =  $.fullCalendar.moment.parseZone(date + (unit*$('#size-overlay').val()));
                var originalEventObject = $(this).data('eventObject');// retrieve the dropped element's stored Event Object
                endinsert=endinsert.format("YYYY-MM-DD HH:mm:ss");
                $.ajax({
                    type: "POST",
                    url: "<?=Url::site('admin/parrilla/save/');?>",
                    data: {
                        capituloId: $("#event-cap").val(),
                        fechaInicio: startinsert,
                        fechaFin: endinsert
                    },
                    dataType: "json"
                }).done(function (json) {
                    idinsert = json["data"]["evento"].id;
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.id = idinsert;
                    copiedEventObject.start = startinsert;
                    copiedEventObject.end    = endinsert;
                    copiedEventObject.allDay = false;
                    copiedEventObject.backgroundColor = "#" + $('#event-color').val();
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject);
                    $('#size-overlay').val("1");
                    $('#event-color').val("6BA5C1");

                });

            },
            events: [
                <?php if (count($eventos)) { ?>
                    <?php foreach ($eventos as $i=>$evento) { ?>
                        <?php $capitulo = new Capitulo($evento->capituloId); ?>
                        <?php $programa = new Programa($capitulo->programaId); ?>
                        {
                            id: '<?=$evento->id;?>',
                            title: '<?=$capitulo->getFullTitulo();?>',
                            start: '<?=$evento->fechaInicio;?>',
                            end: '<?=$evento->fechaFin;?>',
                            color: '<?=$programa->color;?>'
                        }
                        <?php if ($i<count($eventos)-1) { ?>
                            ,
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            ]
        });

        //Prev
        $( ".fc-button-prev").unbind( "click" );
        $(document).on('click', '.fc-button-prev', function (e) {
            window.location.href = "<?=Url::site('admin/parrilla');?>/?date=<?=date('Y-m-d', strtotime($date . ' -1 day'));?>";

            return false;
        });
        //Next
        $( ".fc-button-next").unbind( "click" );
        $(document).on('click', '.fc-button-next', function (e) {
            window.location.href = "<?=Url::site('admin/parrilla');?>/?date=<?=date('Y-m-d', strtotime($date . ' +1 day'));?>";

            return false;
        });
    });

</script>
<style>

    body {
        margin-top: 40px;
        text-align: center;
        font-size: 14px;
        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    }

    #wrap {
        width: 1100px;
        margin: 0 auto;
    }

    #external-events {
        float: left;
        width: 240px;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #eee;
        text-align: left;
    }

    #external-events h4 {
        font-size: 16px;
        margin-top: 0;
        padding-top: 1em;
    }

    .external-event { /* try to mimick the look of a real event */
        margin: 10px 0;
        padding: 2px 4px;
        background: #3366CC;
        color: #fff;
        font-size: .85em;
        cursor: pointer;
    }

    #external-events p {
        margin: 1.5em 0;
        font-size: 11px;
        color: #666;
    }

    #external-events p input {
        margin: 0;
        vertical-align: middle;
    }

    #calendar {
        float: right;
        width: 850px;
    }
.drophover {
    background-color:green;
}
</style>

<script>
    $(document).on('change', '#programaId', function (e) {
        $(".capitulos").hide();
        $("#programa_" + $(this).val()).show();
    });
    //Force change
    $(document).ready(function () {
        $("#programaId").change();
    });
</script>

<div id='wrap'>

    <div id='external-events'>
        <h4>Programas</h4>

        <?php if ($programas) { ?>

            <?=HTML::select("programaId", $programas, null, array("id" => "programaId", "class" => "select2"), array("id" => "0", "display" => "- Selecciona un programa -"), array("display" => "titulo")); ?>

            <?php foreach ($programas as $programa) { ?>
                <div class="capitulos" id="programa_<?=$programa->id;?>" style="display:none">
                    <?php $capitulos = Capitulo::select(array("programaId" => $programa->id)); ?>
                    <?php if (count($capitulos)) { ?>
                        <?php foreach ($capitulos as $capitulo) { ?>
                            <div class='external-event' event-color='<?=str_replace("#","",$programa->color);?>' size-overlay='1' event-cap='<?=$capitulo->id;?>'>
                                <?=$capitulo->getFullTitulo();?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
        <br />
        <center>
            <input type="button" class="btn btn-primary" id="importar" value="Importar">
        </center>
        <br />
    </div>

    <div id='calendar'></div>

    <div style='clear:both'></div>
    <input type='hidden' id='size-overlay' value='1'>
    <input type='hidden' id='event-color' value='6BA5C1'>
    <input type='hidden' id='event-cap' value=''>
</div>

<script>
    $(document).on('click', '#importar', function (e) {
        window.location.href = "<?=Url::site('admin/parrilla/importar');?>?date=" + "<?=$date?>";
    });
</script>
