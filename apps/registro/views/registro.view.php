<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <img src="<?=Url::template("img/haztetriber/betriber.png");?>" />

    <div style="clear: both;"></div>
    <br />
    <div class="haztetriber_title">
        <?=Language::translate("VIEW_REGISTRO_TITLE");?>
    </div>
    <br />
    <div class="haztetriber_description">
        <?=Language::translate("VIEW_REGISTRO_DETAILS_1");?>
        <br /><br />
        <?=Language::translate("VIEW_REGISTRO_DETAILS_2");?>
        <br /><br />
        <?=Language::translate("VIEW_REGISTRO_DETAILS_3");?>
    </div>
    <div style="clear: both;"></div>
    <br /><br />

    <div class="well">
        <fieldset>
            <form class="form-horizontal" role="form" method="post" name="loginForm" id="loginForm" action="">
                <div class="form-group">
                    <label for="user" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        <img src="<?=Url::template("img/haztetriber/user.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_REGISTRO_FIELD_USUARIO");?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="user" name="user" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="passw" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        <img src="<?=Url::template("img/haztetriber/passw.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_REGISTRO_FIELD_PASSWORD");?>
                    </label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="passw" name="passw" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        <img src="<?=Url::template("img/haztetriber/email.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_REGISTRO_FIELD_EMAIL");?>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" />
                    </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-2 l-left">
                        <button class="btn btn-tribo-grey ladda-button" data-style="slide-left">
                            <?=Language::translate("BTN_REGISTER");?>
                        </button>
                    </div>
                    <div class="col-sm-9 l-right">
                        <span class="yareg">
                            <?=Language::translate("VIEW_REGISTRO_YA_REGISTRADO");?>
                        </span>
                        <button class="btn btn-tribo-blue ladda-button" data-style="slide-left">
                            <?=Language::translate("BTN_LOGIN");?>
                        </button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>

    <div style="clear: both;"></div>
    <br /><br />
    <div class="haztetriber_contacta">
        <?=Language::translate("VIEW_REGISTRO_CONTACTA");?>
    <br />
    <a href="mailto:info@tribo.tv">info@tribo.tv</a>
    </div>

</div>
