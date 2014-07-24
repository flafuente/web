<?php defined('_EXE') or die('Restricted access'); ?>

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
            defaultDate: '2014-06-12',
            defaultView: 'agendaWeek',
            selectable: false,
            allDaySlot: false,
            firstDay: 1,
            slotDuration: '00:12:00',
            selectHelper: true,
            eventClick: function (event) {
               if (confirm('Proceder a eliminar el registro?')) {
                    /* LLAMADA a Delete */
                    /* ID del evento que deberia ser igual al id de bdd esta en event._id*/
                    //alert("tete - llamada al delete " + event._id);
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
                /* LLAMADA a Update */
                /* Se hace la llamada al update actualizando solo el EndDate*/
                $.ajax({
                    type: "POST",
                    url: "<?=Url::site('admin/parrilla/save/');?>",
                    data: {
                        id: event._id,
                        fechaInicio: event.start,
                        fechaFin: event.end
                    },
                    dataType: "json"
                });
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            eventDragStop: function (event) {
                /* LLAMADA a Insert */
                /* Se hace la llamada al update actualizando solo el startDate y endDate*/
                $.ajax({
                    type: "POST",
                    url: "<?=Url::site('admin/parrilla/save/');?>",
                    data: {
                        id: event._id,
                        fechaInicio: event.start,
                        fechaFin: event.end
                    },
                    dataType: "json"
                });
            },
            drop: function (date) { // this function is called when something is dropped
                var idinsert = 0;
                var startinsert = date*1;
                var endinsert = (date + (unit*$('#size-overlay').val()));
                /* LLAMADA a Update */
                /* Se hace la llamada al insert y devuelve el id del registro de bdd a la variable idinsert*/
                $.ajax({
                    type: "POST",
                    url: "<?=Url::site('admin/parrilla/save/');?>",
                    data: {
                        capituloId: $("#event-cap").val(),
                        fechaInicio: $('#calendar').fullCalendar.formatDate(startinsert, "YYYY-MM-dd HH:mm:ss"),
                        fechaFin: "lel"
                    },
                    dataType: "json"
                }).done(function (json) {
                    idinsert = json["evento"].id
                });

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject._id = idinsert;
                copiedEventObject.start = startinsert;
                copiedEventObject.end    = endinsert; // put your desired end time here
                copiedEventObject.allDay = false;
                copiedEventObject.backgroundColor = "#" + $('#event-color').val();
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                $('#size-overlay').val("1");
                $('#event-color').val("6BA5C1");
            },
            /* LLAMADA a Cargar todos los eventos de la semana situada, haremos que recargue en el pasar de semana los nuevos eventos*/
            events: [
                <?php if (count($eventos)) { ?>
                    <?php foreach ($eventos as $i=>$evento) { ?>
                        <?php $capitulo = new Capitulo($evento->id); ?>
                        {
                            id: '<?=$evento->id;?>',
                            title: '<?=$capitulo->getFullTitulo();?>',
                            start: '<?=$evento->fechaInicio;?>',
                            end: '<?=$evento->fechaFin;?>'
                        }
                        <?php if ($i<count($eventos)-1) { ?>
                            ,
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            ]
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
        width: 150px;
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
            <h4>Draggable Events</h4>

            <?php if ($programas) { ?>
                <select class="form-control" name="programaId" id="programaId">
                    <?php foreach ($programas as $programa) { ?>
                        <option value="<?=$programa->id?>" <?=$s[$programa->id]?>>
                            <?=Helper::sanitize($programa->titulo);?>
                        </option>
                    <?php } ?>
                </select>

                <?php foreach ($programas as $programa) { ?>
                    <div class="capitulos" id="programa_<?=$programa->id;?>" style="display:none">
                        <?php $capitulos = Capitulo::select(array("programaId" => $programa->id)); ?>
                        <?php if (count($capitulos)) { ?>
                            <?php foreach ($capitulos as $capitulo) { ?>
                                <div class='external-event' event-color='ffd700' size-overlay='1' event-cap='<?=$capitulo->id;?>'>
                                    <?=$capitulo->getFullTitulo();?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class='external-event' event-color='ffd700' size-overlay='1'>Toros</div>
            <div class='external-event' event-color='a52a2a' size-overlay='2'>Amateur</div>
            <div class='external-event' event-color='ee82ee' size-overlay='3'>Pubises</div>
            <div class='external-event' event-color='00bfff'>Coches</div>
            <p>
                <input type='checkbox' id='drop-remove' />
                <label for='drop-remove'>remove after drop</label>
            </p>
        </div>

        <div id='calendar'></div>

        <div style='clear:both'></div>
        <input type='hidden' id='size-overlay' value='1'>
        <input type='hidden' id='event-color' value='6BA5C1'>
        <input type='hidden' id='event-cap' value=''>
    </div>
