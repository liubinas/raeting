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
        <form action="<?= $view['router']->generate('login_check') ?>" method="post" class="form-horizontal">
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
            <input type="hidden" name="_target_path" class="text" value="<?= $view['router']->generate('home'); ?>" />
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
                    <a href="<?= $view['router']->generate('user.recover') ?>" class="f-right">Recover password</a>
                    <br/><br/>
                    <a href="<?= $view['router']->generate('user.register') ?>" class="f-right">Register</a>
                </div>    
            </div>  
        </form>
    </div>
</div>    