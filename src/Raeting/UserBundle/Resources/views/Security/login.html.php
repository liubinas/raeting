<? if (!isset($includeLayout)) $view->extend('RaetingUserBundle::layout.html.php'); ?>

<? if ($error): ?>
    <div><?= $error->getMessage() ?></div>
<? endif; ?>

<form action="<?= $view['router']->generate('login_check') ?>" method="post" class="login">
    <div class="login-response"></div>
    <div>
        <input type="text" id="username" name="_username" class="text" required="required" value="<?= $last_username ?>" placeholder="username"/>
        <input type="password" id="password" name="_password" class="text" required="required"  placeholder="password"/>
        <input type="hidden" name="_target_path" class="text" value="<?= $view['router']->generate('user.profile'); ?>" />
        <input type="submit" value="Log in" />
        <div class="clear"></div>
    </div>
    <div class="links">
        <div class="f-left">
            <input type="checkbox" id="remember_me" name="_remember_me" checked="checked"/>
            <label for="remember_me">Keep me logged in</label>
        </div>
        <a href="<?= $view['router']->generate('user.recover') ?>" class="f-right">Recover password</a>
        <div class="clear"></div>
    </div>

</form>

