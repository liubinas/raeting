<? $view->extend('RaetingUserBundle::layout.html.php'); ?>
<div class="slogan">
Hello
    <? if (!$view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
        <div class="landing_login">
            <?= $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('RaetingUserBundle:Security:login', array('includeLayout'=> 'true'))); ?>
        </div>
    <?php endif;?>
</div>
