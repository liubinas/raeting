<? $view->extend('RaetingUserBundle::User/menu.html.php'); ?>

<? $view['slots']->start('body_attr') ?>class="login"<? $view['slots']->stop('body_attr') ?>
<? $view['slots']->start('content') ?>
<div class="login-wrap">
        <div class="box">
		<div class="content">
                    <? if (true === $posted && true === $changed): ?>
                        <p>Password changed successfully <a href="<?=$view['router']->generate('estinacmf_user.security.login') ?>">Log in </a></p>
                    <? else: ?>
			<!-- Login Formular -->
			<form class="form-vertical login-form" action="<?= $view['router']->generate('estinacmf_user.change_password') ?>" method="post">
				<!-- Title -->
				<h3 class="form-title">Change password</h3>
                                <?=$view['form']->errors($form);?>
                                <?= $view['form']->row($form['email'], array('label' => 'Email', 'attr' => array('class' => 'form-control'))); ?>
                                <?= $view['form']->row($form['hash'], array('label' => 'Hash', 'attr' => array('class' => 'form-control'))); ?>
                                <?= $view['form']->row($form['password']['password'], array('first_options' => array('label' => 'Password'), 'attr' => array('class' => 'form-control'))); ?>
                                <?= $view['form']->row($form['password']['confirm'], array('second_options' => array('label' => 'Repeat password'), 'attr' => array('class' => 'form-control'))); ?>
                                <?= $view['form']->rest($form);?>

				<!-- Form Actions -->
				<div class="form-actions">
					<button type="submit" class="submit btn btn-primary pull-right">
						Change password <i class="icon-angle-right"></i>
					</button>
				</div>
			</form>
			<? endif; ?>
		</div> <!-- /.content -->
	</div>
	<!-- /Login Box -->
    </div>
    
<? $view['slots']->stop('content') ?>