<? $view->extend('RaetingUserBundle::User/menu.html.php'); ?>
<? if (!$view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
    <? $view['slots']->start('content') ?>

    <?php echo $view['facebook']->initialize(array('xfbml' => true, 'fbAsyncInit' => 'onFbInit();')) ?>

    <? if ($error): ?>
        <div><?= $error->getMessage() ?></div>
    <? endif; ?>
    <hr>

    <div class="row-fluid page-head">
        <div class="span12">
            <h1>Log in</h1>
        </div>
    </div>

    <hr>

    <div class="row-fluid signup">
        <div class="span6 offset3">
            <form action="<?= $view['router']->generate('estinacmf_user.security.login_check') ?>" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input type="text" id="username" name="_username" class="text" required="required" value="<?= $last_username ?>" />
                    </div>    
                </div>  
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" id="password" name="_password" class="text" required="required" />
                    </div>    
                </div>
                <!-- Button -->
                <div class="control-group">
                    <label class="control-label" for="singlebutton"></label>
                    <div class="controls">
                        <input type="submit" id="singlebutton" class="btn btn-success" value="Log in" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="remember_me">Keep me logged in</label>
                    <div class="controls">
                        <input type="checkbox" id="remember_me" name="_remember_me" checked="checked"/>
                        <br/><br/>
                        <a href="<?= $view['router']->generate('estinacmf_user.recover') ?>" class="f-right">Recover password</a>
                        <br/><br/>
                        <a href="<?= $view['router']->generate('estinacmf_user.registration') ?>" class="f-right">Register</a>
                    </div>    
                </div>  
                <?php echo $view['facebook']->loginButton(array('autologoutlink' => true)) ?>
                <script>
                    function goLogIn(){
                        window.location.href = "<?= $view['router']->generate('_security_check') ?>";
                    }

                    function onFbInit() {
                        if (typeof(FB) != 'undefined' && FB != null ) {              
                            FB.Event.subscribe('auth.statusChange', function(response) {
                                if (response.session || response.authResponse) {
                                    setTimeout(goLogIn, 500);
                                }
                            });
                        }
                    }
                </script>
            </form>
        </div>
    </div>    
    <? $view['slots']->stop('content') ?>
<?php endif; ?>