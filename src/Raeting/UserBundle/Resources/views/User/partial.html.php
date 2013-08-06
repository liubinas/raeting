<div>
    <? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
        Welcome <?= $user->getUsername(); ?>,
        <a href="<?= $view['router']->generate('logout') ?>">Log out</a>
    <? else : ?>
        <a href="<?= $view['router']->generate('login') ?>">Login</a>
        <a href="<?= $view['router']->generate('user.register') ?>">Register</a>
    <? endif; ?>
</div>
