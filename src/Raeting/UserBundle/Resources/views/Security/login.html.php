<? $view->extend('RaetingCoreBundle::base.html.php'); ?>
<? if (!$view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
<? $view['slots']->start('body_attr') ?>class="login"<? $view['slots']->stop('body_attr') ?>
    <? $view['slots']->start('content') ?>

    <?php echo $view['facebook']->initialize(array('xfbml' => true, 'fbAsyncInit' => 'onFbInit();')) ?>

    <div class="login-wrap">
        <div class="box">
		<div class="content">
			<!-- Login Formular -->
			<form class="form-vertical login-form" action="<?= $view['router']->generate('estinacmf_user.security.login_check') ?>" method="post">
				<!-- Title -->
				<h3 class="form-title">Sign In to your Account</h3>

				<!-- Error Message -->
                                <? if ($error): ?>
                                    <div class="alert fade in alert-danger">
					<i class="icon-remove close" data-dismiss="alert"></i><?= $error->getMessage() ?>
                                    </div>
                                <? endif; ?>

				<!-- Input Fields -->
                                <div class="form-group">
                                    <div class="input-icon">
                                            <i class="icon-user"></i>
                                            <input type="text" id="username" name="_username" class="form-control" placeholder="Username" required="required" autofocus="autofocus" value="<?= $last_username ?>" />
                                    </div>   
                                </div>  
                                <div class="form-group">
                                    <div class="input-icon">
                                            <i class="icon-lock"></i>
                                            <input type="password" id="password" name="_password" class="form-control" placeholder="Password" required="required" />
                                    </div>
                                </div>
				<!-- /Input Fields -->

				<!-- Form Actions -->
				<div class="form-actions">
					<label class="checkbox pull-left"><input type="checkbox" class="uniform" id="remember_me" name="_remember_me" checked="checked"> Remember me</label>
					<button type="submit" class="submit btn btn-primary pull-right">
						Sign In <i class="icon-angle-right"></i>
					</button>
				</div>
			</form>
			
		</div> <!-- /.content -->
	</div>
	<!-- /Login Box -->

	<!-- Single-Sign-On (SSO) -->
	<div class="single-sign-on">
		<span>or</span>
                <?php echo $view['facebook']->loginButton(array('label' => 'Sign in with Facebook', 'size' => 'large')) ?>
	</div>
	<!-- /Single-Sign-On (SSO) -->

	<!-- Footer -->
	<div class="footer">
		<a href="<?= $view['router']->generate('estinacmf_user.registration') ?>" class="sign-up">Don't have an account yet? <strong>Sign Up</strong></a>
                <br/><br/>
		<a href="<?= $view['router']->generate('estinacmf_user.recover') ?>" class="sign-up">Forgot password? <strong>Recover</strong></a>
	</div>
	<!-- /Footer -->
    </div>
       
        <script>
            function goLogIn(){
                window.location.href = "<?= $view['router']->generate('_security_check') ?>";
            }

            function onFbInit() {
                if (typeof(FB) != 'undefined' && FB != null ) {              
                    FB.Event.subscribe('auth.statusChange', function(response) {
                        if (response.session || response.authResponse) {
                            setTimeout(goLogIn, 500);
                        } else {
                            window.location.href = "<?= $view['router']->generate('_security_logout') ?>";
                        }
                    });
                }
            }
        </script>
    <? $view['slots']->stop('content') ?>
<?php endif; ?>