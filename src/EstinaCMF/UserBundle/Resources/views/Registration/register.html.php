<? $view->extend('EstinaCMFUserBundle::layout.html.php') ?>


<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="login-container center">
                <div class="title text-transparent">Sign up</div>
                <hr class="main">
                    <div class="login-error">
                        <?= $view['form']->errors($form['password']);?>
                    </div>

                <form class="login-form" action="<?= $view['router']->generate('estinacmf_user.registration') ?>" method="post">
                    <ul class="fields-list">
                        <li>
                            <i class="icon-envelope-alt"></i>
                            <?= $view['form']->widget($form['email'],
                                array('attr'=>array('placeholder'=>'Email'), 'id' => 'email',  'autocomplete' => 'off')) ?>
                        </li>

                        <li>
                            <i class="icon-user"></i>
                            <?= $view['form']->widget($form['firstname'], array('attr'=>array('placeholder'=>'First name'))) ?>
                        </li>
                        <li>
                            <i class="icon-user"></i>
                            <?= $view['form']->widget($form['lastname'], array('attr'=>array('placeholder'=>'Last name'))) ?>
                        </li>
                        <li>
                            <i class="icon-key"></i>
                            <?= $view['form']->widget($form['password']['password'], array('attr'=>array('placeholder'=>'Password'))) ?>
                        </li>
                        <li>
                            <i class="icon-key"></i>
                            <?= $view['form']->widget($form['password']['confirm'], array('attr'=>array('placeholder'=>'Repeat password'))) ?>
                          </li>
                    </ul>

                    <?= $view['form']->widget($form['_token']); ?>
                    <?= $view['form']->rest($form); ?>

                    <div class="actions">
                        <input type="submit" id="singlebutton" class="btn btn-large medium-blue login-btn" value="Register">
                    </div>

                    <hr class="main">
                    <div class="social-actions">
                        <a href="<?= $view['router']->generate('estinacmf_user.security.login') ?>" class="f-right">login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>