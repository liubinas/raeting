<? $view->extend('RaetingUserBundle::Registration/menu.html.php'); ?>
<? $view['slots']->start('content') ?>
<hr>
    
    <div class="row-fluid page-head">
        <div class="span12">
            <h1>Sign Up</h1>
        </div>
    </div>

    <hr>

    <div class="row-fluid signup">
        <div class="span6 offset3">
            <form action="<?=$view['router']->generate('estinacmf_user.registration') ?>" class="form-horizontal" method="post" <?=$view['form']->enctype($form) ?> >
                <div class="register-response"><?= $view['form']->errors($form); ?></div>
                <?= $view['form']->row($form['firstname'], array('label' => 'Firstname')); ?>
                <?= $view['form']->row($form['lastname'], array('label' => 'Lastname')); ?>
                <?= $view['form']->row($form['email'], array('label' => 'E-mail')); ?>

                <?= $view['form']->row($form['password'], array('first_options' => array('label' => 'Password'))); ?>
                <?= $view['form']->row($form['password'], array('second_options' => array('label' => 'Repeat password'))); ?>

                <?= $view['form']->rest($form); ?>
                <!-- Button -->
                <div class="control-group">
                  <label class="control-label" for="singlebutton"></label>
                  <div class="controls">
                    <input type="submit" id="singlebutton" class="btn btn-success" value="Sign up" />
                  </div>
                </div>
            </form>
        </div>
    </div>
<? $view['slots']->stop('content') ?>