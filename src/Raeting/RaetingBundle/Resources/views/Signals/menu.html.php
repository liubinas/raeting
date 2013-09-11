<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('signals'); ?>">Signals</a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>

<? $view['slots']->start('menu') ?>

    <li><a href="<?= $view['router']->generate('home'); ?>">Home</a></li>
    <li><a href="<?= $view['router']->generate('trader'); ?>">Traders</a></li>
    <li class="active"><a href="<?= $view['router']->generate('signals'); ?>">Signals</a></li>
    <!--<li><a href="<?= $view['router']->generate('api'); ?>">API</a></li>-->
    <? if (!$view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
        <li><a href="<?= $view['router']->generate('estinacmf_user.registration'); ?>">Sign Up</a></li>
        <li><a tabindex="0" href="<?= $view['router']->generate('estinacmf_user.security.login'); ?>">Login</a></li>
    <? endif; ?>
    
<? $view['slots']->stop('menu') ?>