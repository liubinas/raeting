<? $view->extend('RaetingUserBundle::Registration/menu.html.php'); ?>

<? $view['slots']->start('body_attr') ?>class="login"<? $view['slots']->stop('body_attr') ?>
<? $view['slots']->start('content') ?>

<div class="login-wrap">
        <div class="box">
		<div class="content">
			<!-- Login Formular -->
			<form class="form-vertical login-form" action="<?=$view['router']->generate('estinacmf_user.registration') ?>" method="post">
				<!-- Title -->
				<h3 class="form-title">Sign up</h3>

				<!-- Error Message -->
				<!--<div class="alert fade in alert-danger">
					<i class="icon-remove close" data-dismiss="alert"></i>
					Enter any username and password.
				</div>-->
                                <?= $view['form']->row($form['firstname'], array('label' => 'Firstname')); ?>
                                <?= $view['form']->row($form['lastname'], array('label' => 'Lastname')); ?>
                                <?= $view['form']->row($form['email'], array('label' => 'E-mail')); ?>

                                <?= $view['form']->row($form['password'], array('first_options' => array('label' => 'Password'))); ?>
                                <?= $view['form']->row($form['password'], array('second_options' => array('label' => 'Repeat password'))); ?>

                                <?= $view['form']->rest($form); ?>

				<!-- Form Actions -->
				<div class="form-actions">
					<button type="submit" class="submit btn btn-primary pull-right">
						Sign Up <i class="icon-angle-right"></i>
					</button>
				</div>
			</form>
			
		</div> <!-- /.content -->
	</div>
	<!-- /Login Box -->
    </div>
<? $view['slots']->stop('content') ?>