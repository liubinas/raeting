<? $view->extend('EstinaCMFUserBundle::layout.html.php') ?>


<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="login-container center">
                <div class="title text-transparent">Recover password</div>
                <hr class="main">
                <? if (isset($error)): ?>
                    <div class="login-error"><?= $error->getMessage() ?></div>
                <? endif; ?>

                <? if (true === $posted): ?>
                <p>
                    Password sent to your e-mail
                    <a href="<?=$view['router']->generate('estinacmf_user.change_password') ?>">Enter code </a>
                </p>

                <? else: ?>
                <form class="login-form" action="<?= $view['router']->generate('estinacmf_user.recover') ?>" method="post">
                    <ul class="fields-list">
                        <li>
                            <i class="icon-envelope-alt"></i>
                            <input autocomplete="off" required="required" id="recover_email" name="emailrecover[email]" placeholder="email" type="email">
                        </li>
                    </ul>

                    <div class="actions">
                        <input type="submit" id="singlebutton" class="btn btn-large medium-blue login-btn" value="Remind">
                    </div>

                    <hr class="main">
                    <div class="social-actions">
                        <a href="<?= $view['router']->generate('estinacmf_user.security.login') ?>" class="f-right">Login</a>
                    </div>
                </form>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>