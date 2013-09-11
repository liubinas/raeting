<? $view->extend('RaetingUserBundle::User/menu.html.php'); ?>

<? $view['slots']->start('body_attr') ?>class="login"<? $view['slots']->stop('body_attr') ?>
<? $view['slots']->start('content') ?>
<div class="login-wrap">
        <div class="box">
		<div class="content">
                    <? if (true === $posted): ?>
                        <p>
                            Password sent to your e-mail<br/>
                            <a href="<?=$view['router']->generate('estinacmf_user.change_password') ?>">Enter code </a>
                        </p>
                    <? else: ?>
			<!-- Login Formular -->
			<form class="form-vertical login-form" action="<?=$view['router']->generate('estinacmf_user.recover') ?>" method="post">
				<!-- Title -->
				<h3 class="form-title">Recover password</h3>
                                <?= $view['form']->row($form['email'], array('attr' => array('class' => 'form-control'))); ?>
                                <?= $view['form']->rest($form) ?>

				<!-- Form Actions -->
				<div class="form-actions">
					<button type="submit" class="submit btn btn-primary pull-right">
						Recover <i class="icon-angle-right"></i>
					</button>
				</div>
			</form>
			<? endif; ?>
		</div> <!-- /.content -->
	</div>
	<!-- /Login Box -->
    </div>

<? $view['slots']->stop('content') ?>