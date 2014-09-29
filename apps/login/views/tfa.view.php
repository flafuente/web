<?php defined('_EXE') or die('Restricted access'); ?>

<div class="row">
    <div class="col-sm-offset-3 col-sm-5">
        <div class="well">
            <fieldset>
                <legend>
                    Google Auth
                </legend>
                <form class="form-horizontal ajax" role="form" method="post" name="loginForm" id="loginForm" action="<?=Url::site("login/doTfa")?>">
                    <!-- Code -->
                    <div class="form-group">
                         <label for="login" class="col-sm-2 control-label">
                            Código
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="2faCode" name="2faCode" class="form-control">
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-primary ladda-button" data-style="slide-left">
                                <span class="ladda-label">
                                    Enviar
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>
