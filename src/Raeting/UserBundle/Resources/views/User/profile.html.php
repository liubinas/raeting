<? $view->extend('RaetingUserBundle::layout.html.php'); ?>

<h2>Profile<a href="<?= $view['router']->generate('user.profile_edit'); ?>" class="btn btn-primary pull-right"><i class="icon-pencil icon-white"></i> Edit</a></h2>
<div class="row-fluid">
    <div class="span6">
        <dl class="merchant-info">
            <? if(!empty($user['firstname'])): ?><dt>Firstname</dt><dd><?= $user['firstname'] ?></dd><? endif;?>
            <? if(!empty($user['lastname'])): ?><dt>Lastname</dt><dd><?= $user['lastname'] ?></dd><? endif;?>
        </dl>
    </div>
    <div class="span6">
        <dl class="merchant-info">
            <? if(!empty($user['state'])): ?><dt>State</dt><dd><?= $user['state'] ?></dd><? endif;?>
            <? if(!empty($user['street'])): ?><dt>Street</dt><dd><?= $user['street'] ?></dd><? endif;?>
            <? if(!empty($user['postal_code'])): ?><dt>Postal code</dt><dd><?= $user['postal_code'] ?></dd><? endif;?>
        </dl>
    </div>
</div>
