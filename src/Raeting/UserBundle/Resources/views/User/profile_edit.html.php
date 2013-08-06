<? $view->extend('RaetingUserBundle::layout.html.php'); ?>

<h2>Profile edit</h2>

<form method="post" class="bind-form-useredit" action="<?= $view['router']->generate('user.profile_edit'); ?>">
    <div class="bind-form-useredit-response"></div>
    <?=$view['form']->errors($form)?>
    <div class="row-fluid">
        <fieldset class="span6">
            <?= $view['form']->row($form['id']) ?>
            <?= $view['form']->row($form['firstname'], array('label' => 'Firstname', 'attr' => array('class' => 'span12'))) ?>
            <?= $view['form']->row($form['lastname'], array('label' => 'Lastname', 'attr' => array('class' => 'span12'))) ?>
        </fieldset>
        <fieldset class="span6">
            <?= $view['form']->row($form['state'], array('label' => 'State', 'attr' => array('class' => 'span12'))) ?>
            <?= $view['form']->row($form['street'], array('label' => 'Street', 'attr' => array('class' => 'span12'))) ?>
            <?= $view['form']->row($form['postal_code'], array('label' => 'Postal code', 'attr' => array('class' => 'span12'))) ?>
        </fieldset>
    </div>
    <div class="clear"></div>
    <div class="well">
        <div class="btn-group pull-left">
            <a href="<?= $view['router']->generate('user.profile'); ?>" class="btn btn-danger"><i class="icon-back icon-white"></i> back</a>
        </div>
        <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Submit</button>
        </div>
        <div class="clear"></div>
    </div>
</form>