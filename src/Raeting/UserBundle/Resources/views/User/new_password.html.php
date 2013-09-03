<? $view->extend('RaetingUserBundle::layout.html.php'); ?>

<h2>Change password</h2>

<form method="post" class="bind-form-newpassword" action="<?= $view['router']->generate('estinacmf_user.new_password'); ?>">
    <div class="bind-form-newpassword-response"></div>
    <?=$view['form']->errors($form);?>
    <div class="row-fluid">
        <fieldset class="span6">
            <?= $view['form']->row($form['id']) ?>
            <?= $view['form']->row($form['password_old'], array('label' => 'Old password', 'attr' => array('class' => 'span12'))) ?>
            <?= $view['form']->row($form['password_new'], array('label' => 'New password', 'attr' => array('class' => 'span12'))) ?>
            <?= $view['form']->row($form['password_confirm'], array('label' => 'Repeat password', 'attr' => array('class' => 'span12'))) ?>
        </fieldset>
    </div>
    <div class="clear"></div>
    <div class="well">
        <div class="btn-group pull-left">
            <a href="<?= $view['router']->generate('estinacmf_user.profile'); ?>" class="btn btn-danger"><i class="icon-back icon-white"></i> back</a>
        </div>
        <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Submit</button>
        </div>
        <div class="clear"></div>
    </div>
</form>