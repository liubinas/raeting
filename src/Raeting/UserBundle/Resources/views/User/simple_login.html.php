<? $view->extend('RaetingUserBundle::User/menu.html.php'); ?>
<? if (!$view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
    <? $view['slots']->start('content') ?>
        <?= $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('RaetingUserBundle:Security:login', array('includeLayout'=> 'true'))); ?>
    <? $view['slots']->stop('content') ?>
<?php endif;?>
