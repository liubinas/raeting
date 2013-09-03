<div>
    <? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
        Welcome <?= $user->getUsername(); ?>,
        <a href="<?= $view['router']->generate('estinacmf_user.logout') ?>">Log out</a>
    <? else : ?>
        <a href="<?= $view['router']->generate('estinacmf_user.security.login') ?>">Login</a>
        <a href="<?= $view['router']->generate('estinacmf_user.register') ?>">Register</a>
    <? endif; ?>
</div>
