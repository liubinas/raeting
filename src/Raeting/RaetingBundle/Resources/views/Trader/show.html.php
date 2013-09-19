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
                                    <dt>Company</dt>
                                    <dd><?= $entity->getCompany()?></dd>
                                    <dt>About</dt>
                                    <dd><?= $entity->getAbout()?></dd>
                                    <dt>Member since</dt>
                                    <dd><?= ($entity->getcreateDate()) ? (string) $entity->getcreateDate()->format("Y-m-d") : ""; ?></dd>
                                </dl>
                            </div>
                        </div> <!-- /.row -->
                        <? if (!empty($signals)): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                        <form class="form-inline" method="get" action="<?= $view['router']->generate('trader_show', array('slug' => $entity->getSlug())); ?>">
                                            <label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon-search"></i></span>
                                                    <input id="signal-search" name="signal-search" type="text" placeholder="search" class="form-control" value="<?= $query ?>" />
                                                </div>
                                            </label>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="widget">
                                        <div class="widget-content">
                                            <h3>Signals</h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Symbol</th>
                                                        <th>Buy/Sell</th>
                                                        <th>Open</th>
                                                        <th>Take profit</th>
                                                        <th>Stop loss</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach ($signals as $signal): ?>
                                                        <tr>
                                                            <td>
                                                                <a href="#">
                                                                    <span class="label label-success"><?= $signal->getstatus() ?></span></a>
                                                            </td>
                                                            <td><?= $signal->getSymbol()->getTitle() ?></td>
                                                            <td><?= $signal->getBuyValue() ?></td>
                                                            <td><?= $signal->getOpen() ?></td>
                                                            <td><?= $signal->getTakeprofit() ?></td>
                                                            <td><?= $signal->getStoploss() ?></td>
                                                            <td><?= $signal->getCreated()->format('Y-m-d H:i:s') ?></td>
                                                        </tr>
                                                    <? endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Striped Table -->
                            </div> <!-- /.row -->
                            <?= $view['pagination']->render($page, $totalSignals, $perPage, 'trader_show', array('signal-search' => $query, 'slug' => $entity->getSlug()));?>
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