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
<h3>Traders</h3>
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
                                <img src="https://graph.facebook.com/<?= $entity['fbname'] ?>/picture?type=square">
                        </td>
                        <td>
                            <a href="<?= $view['router']->generate(
                                'trader_show',
                                array('slug' => $entity['slug'])
                            ) ?>"><?= $entity['firstname'] . ' ' . $entity['lastname'] ?></a>
                        </td>
                        <td><?= $entity['pips'] ?></td>
                        <td><?= $entity['signals'] ?></td>
                        <td><?= $entity['createDate']->format('Y-m-d') ?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?=$view['pagination']->render($page, $totalTraders, $perPage, 'trader');?>
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