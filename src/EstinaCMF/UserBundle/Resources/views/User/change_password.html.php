<? $view->extend('EstinaCMFUserBundle::layout.html.php'); ?>

<div class="row-fluid signup">
    <div class="span6 offset3">
        <? if (true === $posted && true === $changed): ?>
            <p>Password changed successfully <a href="<?=$view['router']->generate('estinacmf_user.security.login') ?>">Log in </a></p>
        <? else: ?>
            <form action="<?= $view['router']->generate('estinacmf_user.change_password') ?>" class="form-horizontal" method="post" <?= $view['form']->enctype($form) ?> >
                <div class="bind-form-changepassword-response"></div>
                <?=$view['form']->errors($form);?>
                <?= $view['form']->row($form['email'], array('label' => 'E-mail')); ?>
                <?= $view['form']->row($form['hash'], array('label' => 'Hash')); ?>
                <?= $view['form']->row($form['password'], array('first_options' => array('label' => 'Password'))); ?>
                <?= $view['form']->row($form['password'], array('second_options' => array('label' => 'Repeat password'))); ?>
                <?= $view['form']->rest($form);?>
                <!-- Button -->
                <div class="control-group">
                  <label class="control-label" for="singlebutton"></label>
                  <div class="controls">
                    <input type="submit" id="singlebutton" class="btn btn-success" value="Submit" />
                  </div>
                </div>
            </form>
        <? endif; ?>
    </div>
</div>