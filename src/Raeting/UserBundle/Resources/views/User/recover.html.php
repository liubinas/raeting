<? $view->extend('RaetingUserBundle::layout.html.php'); ?>

<? $view['slots']->start('header') ?>
<div class="slogan">
    <h1>Recover password</h1>


<? if (true === $posted): ?>
    <p>
        Password sent to your e-mail
        <a href="<?=$view['router']->generate('user.change_password') ?>">Enter code </a>.
    </p>
<? else: ?>
    <div class="newsletter_signup">
        <form action="<?=$view['router']->generate('user.recover') ?>" class="recover" method="post" <?=$view['form']->enctype($form) ?> >
            <div class="recover-response"></div>
            <div>
                <?= $view['form']->widget($form['email'], array('attr' => array('class' => 'text newsletter_input', 'placeholder' => 'E-mail'))); ?>
                <?= $view['form']->rest($form) ?>
                <input class="newsletter_submit" type="submit" value="Submit" />
            </div>
        </form>
    </div>
<? endif; ?>
</div>
