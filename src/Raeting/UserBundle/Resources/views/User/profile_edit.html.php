<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('menuProfileEditActive') ?> class="current"<? $view['slots']->stop('menuProfileEditActive') ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?= $view['router']->generate('home'); ?>">Home</a>
        </li>
        <li class="current">
            <a href="<?= $view['router']->generate('user.profile.edit'); ?>">Edit profile</a>
        </li>
    </ul>
</div>
<? $view['slots']->stop('crumbs') ?>

<? $view['slots']->start('header_row') ?>
<h3>Profile edit</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>

<? foreach ($view['session']->getFlash('profile.update.success') as $message): ?>
    <div class="alert alert-success fade in">
        <i class="icon-remove close" data-dismiss="alert"></i>
        <?= $message ?>
    </div>
<? endforeach; ?>
<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-content">
                <div class="col-md-4">
                    <div class="list-group profile-photo">
                        <li class="list-group-item no-padding">
                            <img src="https://graph.facebook.com/<?= $entity->getFbname() ?>/picture?type=large">
                        </li>
                    </div>
                </div>
                <form method="post" class="form-" action="<?= $view['router']->generate('user.profile.edit'); ?>">
                    <div class="col-md-4">
                            <?= $view['form']->errors($form) ?>
                            <?= $view['form']->row($form['firstname'], array('label' => 'Firstname', 'attr' => array('class' => 'input-width-xlarge form-control'))) ?>
                            <?= $view['form']->row($form['lastname'], array('label' => 'Lastname', 'attr' => array('class' => 'input-width-xlarge form-control'))) ?>
                            <?= $view['form']->row($form['company'], array('label' => 'Company', 'attr' => array('class' => 'input-width-xlarge form-control'))) ?>
                            <?= $view['form']->row($form['twitter'], array('label' => 'Twitter name', 'attr' => array('class' => 'input-width-xlarge form-control'))) ?>
                            <?= $view['form']->row($form['about'], array('label' => 'About', 'attr' => array('class' => 'input-width-xlarge form-control'))) ?>
                            <?= $view['form']->rest($form) ?>

                            <div class="clear"></div>
                            <div class="fl">
                                <button type="submit" class="submit btn btn-success pull-right">
                                    Update <i class="icon-angle-right"></i>
                                </button>
                                <a href="<?=$view['router']->generate('trader_show', array('slug' => $entity->getSlug() )) ?>" class="btn pull-right">
                                    Cancel
                                </a>
                            </div>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<? $view['slots']->stop('content') ?>

<? $view->extend('RaetingUserBundle::layout.html.php'); ?>