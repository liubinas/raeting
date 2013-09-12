<? $view->extend('RaetingRaetingBundle::Trader/menu.html.php'); ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li>
                        <a href="<?= $view['router']->generate('trader'); ?>">Traders</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('trader_show', array('slug' => $entity->getSlug())); ?>"><?= $entity->getFirstname() ?> <?= $entity->getLastname() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>

<? $view['slots']->start('header_row') ?>
Trader Profile
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>
<div class="row">
    <div class="col-md-12">
        <!-- Tabs-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <div class="tab-content row">
                <!--=== Overview ===-->
                <div class="tab-pane active" id="tab_overview">
                    
                    <div class="fl padd-15">
                        <div class="list-group">
                            <li class="list-group-item no-padding">
                                <img src="https://graph.facebook.com/<?= $entity->getFbname() ?>/picture?type=large">
                            </li>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row profile-info">
                            <div class="col-md-7">
                                <h1><?= $entity->getFirstname() ?> <?= $entity->getLastname() ?></h1>

                                <dl class="dl-horizontal">
                                    <dt>Email</dt>
                                    <dd><?= $entity->getemail() ?></dd>
                                    <dt>Created On</dt>
                                    <dd><?= ($entity->getcreateDate()) ? (string) $entity->getcreateDate()->format("Y-m-d H:i:s") : ""; ?></dd>
                                </dl>
                            </div>
                        </div> <!-- /.row -->
                        <? if (!empty($signals)): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget">
                                        <div class="widget-content">
                                            <h3>Signals</h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Quote</th>
                                                        <th>Buy/Sell</th>
                                                        <th>Open</th>
                                                        <th>Take profit</th>
                                                        <th>Stop loss</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach ($signals as $entity): ?>
                                                        <tr>
                                                            <td>
                                                                <a href="#">
                                                                    <span class="label label-success"><?= $entity->getstatus() ?></span></a>
                                                            </td>
                                                            <td><?= $entity->getQuote()->getTitle() ?></td>
                                                            <td><?= $entity->getBuyValue() ?></td>
                                                            <td><?= $entity->getOpen() ?></td>
                                                            <td><?= $entity->getTakeprofit() ?></td>
                                                            <td><?= $entity->getStoploss() ?></td>
                                                            <td><?= $entity->getCreated()->format('Y-m-d') ?></td>
                                                        </tr>
                                                    <? endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Striped Table -->
                            </div> <!-- /.row -->
                        <? endif; ?>
                    </div> <!-- /.col-md-9 -->
                </div>
                <!-- /Overview -->

            </div> <!-- /.tab-content -->
        </div>
        <!--END TABS-->
    </div>
</div> <!-- /.row -->
<? $view['slots']->stop('content') ?>