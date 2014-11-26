<?php defined('_EXE') or die('Restricted access'); ?>
<?php
$stl = "";
if (Registry::getUser()->id) {
    $stl = "margin-top: -40px; left: 45px;";
}
?>
<a class='rsep search' href='#'>
    <img src='<?=Url::template("/img/lupa.png");?>' title='<?=Language::translate("VIEW_TEMPLATE_SEARCH_BUSCAR");?>' />
</a>
<div class="search_form" style="display: none;<?=$stl;?>">
    <div class="forgot col-md-12">
        <img class="imgmdl" src='<?=Url::template("/img/lupa.png");?>' title='Login' />
        <h1>&nbsp;&nbsp;&nbsp;<?=Language::translate("VIEW_TEMPLATE_SEARCH_TITLE");?></h1>
    </div>
    <div style="clear: both;"></div>
    <br />
    <form class="l_form" action="" method="POST">
        <div class="col-md-12"><input class="form-control" type="text" name="search" id="search" placeholder="<?=Language::translate("VIEW_TEMPLATE_SEARCH_BUSCAR");?>..."/></div>
        <div class="forgot col-md-8"></div>
        <!--<div class="col-md-4 l-right"><button type="submit" class="btn btn-tribo-blue ladda-button"><?=Language::translate("VIEW_TEMPLATE_SEARCH_BUSCAR");?></button></div>-->
        <div style="clear: both;"></div>
        <div id="searchResults"></div>
    </form>
</div>

<script>
    //Autosearch
    $(document).on('keypress', '#search', function (e) {
        var search = $(this).val();
        $.post( "<?=Url::site('buscar/byAjax/');?>", { search: search }).done(function (data) {
            $( "#searchResults" ).html( data );
        });
    });
</script>
