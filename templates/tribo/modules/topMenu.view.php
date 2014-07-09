<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>
<?php $config = Registry::getConfig(); ?>

<div class="container">
    <div class="row-fluid">
        <div class='col-md-4 topleft'>
            <div class='col-md-12 pull-left mid'>
                <!-- Login Module -->
                <?=$controller->view("modules.panel.login");?>
                <!-- /Login Module -->
                <!-- Search Module -->
                <?=$controller->view("modules.panel.search");?>
                <!-- /Search Module -->
                <!-- Contacto Module -->
                <?=$controller->view("modules.panel.contacto");?>
                <!-- /Contacto Module -->
            </div>
        </div>
        <div class='col-md-3  col-md-offset-1'>
            <a href='<?=Url::site("home");?>' class='logo'>
                <img src='<?=Url::template("/img/logo.png");?>' />
            </a>
        </div>
        <div class='col-md-4 topright'>
            <div class='col-md-12 mid pull-right'>
            <a class='pull-right lsep' href='#'>
                <img src='<?=Url::template("/img/twitter.png");?>' title='Twitter' />
            </a>
            <a class='pull-right lsep' href='#'>
                <img src='<?=Url::template("/img/facebook.png");?>' title='Facebook' />
            </a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("click",".login",function () {
        $('.login_form').add('.mask').fadeIn();
    });
    $(document).on("click",".contact",function () {
        $('.contact_form').add('.mask').fadeIn();
    });
    $(document).on("click",".search",function () {
        $('.search_form').add('.mask').fadeIn();
    });
    $(document).on("click",".mask",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').fadeOut();
    });
</script>
<!-- /.container -->
