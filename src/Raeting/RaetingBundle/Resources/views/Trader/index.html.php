<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('menuTradersActive') ?> class="current"<? $view['slots']->stop('menuTradersActive') ?>

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
                <th>Company</th>
                <th>Profit(pips)</th>
                <th>Total signals</th>
                <th>Since</th>
                </thead>
                <tbody>
                <? foreach ($entities as $entity): ?>
                    <tr>
                        <td>        
                            <img src="<?= $entity['fbname'] ? 'https://graph.facebook.com/'.$view->escape($entity['fbname']).'/picture?type=square' : $view['assets']->getUrl('img/blank_profile_small.png') ?>">
                        </td>
                        <td>
                            <a href="<?= $view['router']->generate(
                                'trader_show',
                                array('slug' => $entity['slug'])
                            ) ?>"><?= $view->escape($entity['firstname']) . ' ' . $view->escape($entity['lastname']) ?></a>
                        </td>
                        <td><?= $view->escape($entity['company']) ?></td>
                        <td><?= $entity['pips'] ? $entity['pips'] : '0' ?></td>
                        <td><?= $entity['signals'] ? $entity['signals'] : '0' ?></td>
                        <td><?= $view['raeting']->renderDate($entity['createDate']->format('Y-m-d'), 'date') ?></td>
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