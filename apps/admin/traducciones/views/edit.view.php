<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
$subtitle = "Editar traducción";
$title = "Guardar";

Toolbar::addTitle("Traducciones", "glyphicon-globe", $subtitle);
//Delete button
Toolbar::addButton(
    array(
        "title" => "Eliminar",
        "app" => "traducciones",
        "action" => "delete",
        "class" => "danger",
        "spanClass" => "remove",
        "confirmation" => "¿Deseas realmente eliminar esta tradución?",
        "noAjax" => true,
    )
);
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/traducciones"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "traducciones",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="traducciones">
    <input type="hidden" name="action" id="action" value="save">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Item
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Idioma
                        </label>
                        <div class="col-sm-10">
                            <?=Html::select('langId', Location::$languages, $langId, array('id' => 'langId', 'class' => 'select2'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Tipo
                        </label>
                        <div class="col-sm-10">
                            <?=Html::select('item', Location::$items, $item, array('id' => 'item', 'class' => 'select2'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Item
                        </label>
                        <div class="col-sm-10">
                            <select id="itemId" name="itemId" class="form-control select2">

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Traducción
                </div>
                <div class="panel-body" id="locations">

                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var ready = true;
    var done = false;
    $(document).on('change', '#item', function (e) {
        $.ajax({
            url: '<?=Url::site("admin/traducciones/getItems");?>',
            data: {
                item: $('#item').val()
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // Items
                var select = $('#itemId');
                select.html('');
                items = data.data.items;
                if (items != null) {
                    $.each(items, function (val, text) {
                        $('#itemId').append(new Option(text, val));
                    });
                }
                $('#itemId').change();
            }
        })
    });
    $('#item').change();

    $(document).on('change', '#itemId', function (e) {
        $.ajax({
            url: '<?=Url::site("admin/traducciones/getItem");?>',
            data: {
                item: $('#item').val(),
                itemId: $('#itemId').val(),
                langId: $('#langId').val()
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                ready = true;
                // Fields
                var div = $('#locations');
                div.html('');
                fields = data.data.fields;
                if (fields != null) {
                    $.each(fields, function (index, val) {
                        if (val.input == 'textarea') {
                            field = '<textarea name="field[' + index + ']" class="summernote">' + val.value + '</textarea>';
                        } else {
                            field = '<input type="text" class="form-control" name="field[' + index + ']" value="' + val.value + '">';
                        }
                        $('#locations').append('<div class="form-group">' +
                        '<label class="col-sm-2 control-label">' + index + '</label>' +
                            '<div class="col-sm-8">' +
                            field +
                            '</div>' +
                        '</div>');
                        $('.summernote').summernote();
                    });
                }
                selectedInit();
            }
        })
    });

    function selectedInit()
    {
        if (ready == true && !done) {
            <?php if ($itemId) { ?>
                $('#itemId').select2("val", <?=$itemId?>);
            <?php } ?>
            done = true;
            $('#itemId').change();
        }
    };
</script>
