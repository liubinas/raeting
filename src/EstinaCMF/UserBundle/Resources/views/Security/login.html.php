<? $view->extend('EstinaCMFUserBundle::layout.html.php') ?>


<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="login-container center">
                <div class="title text-transparent">Sign in</div>
                <hr class="main">
                <? if (isset($error)): ?>
                    <div class="login-error"><?= $error->getMessage() ?></div>
                <? endif; ?>

                <form class="login-form" action="<?= $view['router']->generate('estinacmf_user.security.login_check') ?>" method="post">
                    <ul class="fields-list">
                        <li>
                            <i class="icon-user"></i>
                            <input autocomplete="off" required="required" id="username" name="_username" placeholder="username" type="text" value="<?= $last_username ?>">
                        </li>
                        <li>
                            <i class="icon-key"></i>
                            <input autocomplete="off" required="required" id="password" name="_password" placeholder="password" type="password">
                        </li>
                    </ul>
                    <div class="actions">
                        <input type="submit" id="singlebutton" class="btn btn-large medium-blue login-btn" value="Sign in">
                    </div>

                    <hr class="main">
                    <div class="social-actions">

                        <div class="control-group">
                            <label class="control-label" for="remember_me">Keep me logged in</label>
                            <div class="controls">
                                <input type="checkbox" id="remember_me" name="_remember_me" checked="checked"/>
                            </div>
                        </div>
                        <a href="<?= $view['router']->generate('estinacmf_user.recover') ?>" class="f-right">Recover password</a> |
                        <a href="<?= $view['router']->generate('estinacmf_user.registration') ?>" class="f-right">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
