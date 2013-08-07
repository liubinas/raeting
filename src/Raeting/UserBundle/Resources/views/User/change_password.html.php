<? $view->extend('RaetingUserBundle::layout.html.php'); ?>


<? $view['slots']->start('header') ?>
<div class="page_info">
    <h1>Change password</h1>
</div>
<? $view['slots']->stop('header') ?>
<div class="main results merchant">
    <section class="destination_info">

        <? if (true === $posted && true === $changed): ?>
            <p>Password changed successfully</p>
        <? else: ?>
            <form action="<?= $view['router']->generate('user.change_password') ?>" class="bind-form-changepassword" method="post" <?= $view['form']->enctype($form) ?> >
                <div class="bind-form-changepassword-response"></div>
                <?=$view['form']->errors($form);?>
                <?= $view['form']->row($form['email'], array('label' => 'E-mail')); ?>
                <?= $view['form']->row($form['hash'], array('label' => 'Hash')); ?>
                <?= $view['form']->row($form['password'], array('first_options' => array('label' => 'Password'))); ?>
                <?= $view['form']->row($form['password'], array('second_options' => array('label' => 'Repeat password'))); ?>
                <?= $view['form']->rest($form);?>
                <div>
                    <input type="submit" value="Submit"/>
                </div>
            </form>
        <? endif; ?>
    </section>
</div>