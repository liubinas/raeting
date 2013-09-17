<? $view->extend('RaetingRaetingBundle::Trader/menu.html.php'); ?>

<? $view['slots']->start('crumbs') ?>
    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?= $view['router']->generate('home'); ?>">Home</a>
            </li>
            <li class="current">
                <a href="<?= $view['router']->generate('trader'); ?>">Traders</a>
            </li>
        </ul>
    </div>
<? $view['slots']->stop('crumbs') ?>

<? $view['slots']->start('header_row') ?>
    Traders
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>

<? if (!empty($entities)): ?>
    <div class="row-fluid signals">
        <div class="span12">
            <table class="table table-striped table-hover">
                <thead>
                <th></th>
                <th>Name</th>
                <th>Pips</th>
                <th>Total signals</th>
                <th>Since</th>
                </thead>
                <tbody>
                <? foreach ($entities as $entity): ?>
                    <tr>
                        <td>
                                <img src="https://graph.facebook.com/<?= $entity->getFbname() ?>/picture?type=square">
                        </td>
                        <td>
                            <a href="<?= $view['router']->generate(
                                'trader_show',
                                array('slug' => $entity->getSlug())
                            ) ?>"><?= $entity->getFirstname() . ' ' . $entity->getLastname() ?></a>
                        </td>
                        <td><?= $entity->getCreatedate()->format('Y-m-d') ?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
     <?=$view['pagination']->render($page, $totalTrips, $perPage, 'trader', $routeParams);?>
    <div class="row">
            <div class="table-footer">
                    <div class="col-md-12">
                            <ul class="pagination">
                                    <li class="disabled"><a href="javascript:void(0);">&larr; Prev</a></li>
                                    <li class="active"><a href="javascript:void(0);">1</a></li>
                                    <li><a href="javascript:void(0);">2</a></li>
                                    <li><a href="javascript:void(0);">3</a></li>
                                    <li><a href="javascript:void(0);">4</a></li>
                                    <li><a href="javascript:void(0);">Next &rarr;</a></li>
                            </ul>
                    </div>
            </div>
    </div>
<? else: ?>
    <div class="box box-row">
        <div class="row-fluid">
            <div class="content">
                <p><?= $view['translator']->trans('No entries') ?></p>
            </div>
        </div>
    </div>
<? endif; ?>
<? $view['slots']->stop('content') ?>