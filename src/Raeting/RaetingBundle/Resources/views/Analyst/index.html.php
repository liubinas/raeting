<? $view->extend('RaetingRaetingBundle::Analyst/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>
Analysts
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

<div class="row">
    <div class="col-md-12">
            <div class="widget box">
                    <div class="widget-content">
                            <? if (!empty($entities)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>Name</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($entities as $entity): ?>
                                                <tr>
                                                    <td><?= $entity->getName() ?></td>
                                                    <td><a href="<?= $view['router']->generate('analyst_show', array('id' => $entity->getId())) ?>">View</a></td>
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
<?= $view['pagination']->render($page, $totalEntities, $perPage, 'analyst');?>

<? $view['slots']->stop('content') ?>