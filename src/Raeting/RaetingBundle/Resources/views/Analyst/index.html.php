<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('menuAnalystsActive') ?> class="current"<? $view['slots']->stop('menuAnalystsActive') ?>

<? $view['slots']->start('header_row') ?>
<h3>Analysts</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('analyst'); ?>">Analysts</a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>
<div class="clear"></div>
<div class="row">
    <div class="col-md-12">
            <div class="widget">
                    <div class="widget-content">
                            <? if (!empty($analysts)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Total recommendations</th>
                                        <th>Last recommendation</th>
                                        <th>Latest symbols</th>
                                        <th>Total return</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($analysts as $analyst): ?>
                                                <tr>
                                                    <td><?= $analyst['rank'] ?></td>
                                                    <td><?= $analyst['name'] ?></td>
                                                    <td><?= $analyst['company'] ?></td>
                                                    <td><?= $analyst['totalAnalysis'] ?></td>
                                                    <td><?= !empty($analyst['lastAnalysis']) ? $view['raeting']->renderDate($analyst['lastAnalysis']->getDate()->format('Y-m-d')) : '' ?></td>
                                                    <td><?= $analyst['lastSymbols'] ?></td>
                                                    <td><?= $analyst['totalReturn'] ?></td>
                                                    <td><a href="<?= $view['router']->generate('analyst_show', array('slug' => $analyst['slug'])) ?>"><i class="icon-search"></i></a></td>
                                                </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                        <? else: ?>
                                        <p><?= $view['translator']->trans('No entries') ?></p>
                        <? endif; ?>
                    </div>
            </div>
    </div>
</div>
<?= $view['pagination']->render($page, $totalAnalysts, $perPage, 'analyst');?>

<? $view['slots']->stop('content') ?>