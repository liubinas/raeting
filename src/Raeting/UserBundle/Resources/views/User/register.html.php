<? $view->extend('RaetingUserBundle::layout.html.php'); ?>

<? $view['slots']->start('header') ?>
<div class="page_info">
    <h1>Registration </h1>
</div>
<? $view['slots']->stop('header') ?>

<form action="<?=$view['router']->generate('user.register') ?>" class="register" method="post" <?=$view['form']->enctype($form) ?> >
    <div class="register-response"><?= $view['form']->errors($form); ?></div>
    <?= $view['form']->row($form['firstname'], array('label' => 'Firstname')); ?>
    <?= $view['form']->row($form['lastname'], array('label' => 'Lastname')); ?>
    <?= $view['form']->row($form['email'], array('label' => 'E-mail')); ?>
    
    <?= $view['form']->row($form['password'], array('first_options' => array('label' => 'Password'))); ?>
    <?= $view['form']->row($form['password'], array('second_options' => array('label' => 'Repeat password'))); ?>
    
    <?= $view['form']->rest($form); ?>
    <div>
        <input type="submit" value="Submit"/>
        <a href="<?= $view['router']->generate('login') ?>">back </a>
    </div>
</form>
