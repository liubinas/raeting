<? $view->extend('RaetingUserBundle::User/menu.html.php'); ?>

<? $view['slots']->start('content') ?>
<hr>
    
<div class="row-fluid page-head">
    <div class="span12">
        <h1>Recover Password</h1>
    </div>
</div>

<hr>

<div class="row-fluid signup">
    <div class="span6 offset3">
        <? if (true === $posted): ?>
            <p>
                Password sent to your e-mail
                <a href="<?=$view['router']->generate('estinacmf_user.change_password') ?>">Enter code </a>
            </p>
        <? else: ?>
            <form action="<?=$view['router']->generate('estinacmf_user.recover') ?>" class="form-horizontal" method="post" <?=$view['form']->enctype($form) ?> >
                <div class="recover-response"></div>
                <div>
                    <?= $view['form']->row($form['email']); ?>
                    <?= $view['form']->rest($form) ?>
                    <!-- Button -->
                    <div class="control-group">
                      <label class="control-label" for="singlebutton"></label>
                      <div class="controls">
                        <input type="submit" id="singlebutton" class="btn btn-success" value="Submit" />
                      </div>
                    </div>
                </div>
            </form>
        <? endif; ?>
    </div>
</div>    
<? $view['slots']->stop('content') ?>