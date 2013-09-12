<? $view->extend('RaetingRaetingBundle::Signals/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>
Signals
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>

<div class="row">
    <div class="col-md-12">
            <div class="widget box">
                    <div class="widget-header">
                            <h4>Signals list</h4>
                            <div class="toolbar no-padding">
                                    <? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
                                        <div class="btn-group">
                                                <span onclick="document.getElementsByClassName('signal-form')[0].style.display='block'; return false;" class="btn btn-xs circular-charts-reload"><i class="icon-plus"></i> Add signal</span>
                                        </div>
                                    <? endif; ?>
                            </div>
                    </div>
                    <? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) : ?>
                        <div class="widget-content signal-form"<? if(!$showForm) echo 'style="display: none;"' ?>>
                            <div class="span6 offset3">
                                <?= $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('RaetingRaetingBundle:Signals:new', array('includeLayout' => 'false', 'form' => $form, 'entity' => $entity))); ?>
                            </div>
                        </div>
                    <? endif; ?>
                    <div class="widget-content">
                        <div class="col-md-12">
                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                <form class="form-inline" method="get" action="<?= $view['router']->generate('signals') ?>">
                                    <label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-search"></i></span>
                                            <input id="signal-search" name="signal-search" type="text" placeholder="search" class="form-control" value="<?= $query ?>" />
                                        </div>
                                    </label>
                                </form>
                            </div>
                        </div>
                            <? if (!empty($entities)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>Status</th>
                                        <th>Quote</th>
                                        <th>Buy/Sell</th>
                                        <th>Open</th>
                                        <th>Take profit</th>
                                        <th>Stop loss</th>
                                        <th>Trader</th>
                                        <th>Created</th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($entities as $entity): ?>
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
                                                    <td>
                                                        <a href="<?= $view['router']->generate('trader_show', array('slug' => $entity->getUser()->getSlug())) ?>"><?= $entity->getUser()->getFirstname() ?> <?= $entity->getUser()->getLastname() ?></a></td>
                                                    <td><?= $entity->getCreated()->format('Y-m-d') ?></td>
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

<? $view['slots']->stop('content') ?>