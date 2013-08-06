<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<div class="bg_top"></div>

<div class="wrapper">
    <a href="<?= $view['router']->generate('home') ?>"><img class="headerlogoimg_med" src="<?= $view['assets']->getUrl('images/logo_small.png'); ?>" alt="Raeting" /></a>
    <div class="main_header">
        <? $view['slots']->output('header') ?>
        <div class="clear"></div>
    </div>

    <? $view['slots']->output('_content') ?>

    <div class="clear"></div>
</div>