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
                                <?= $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('RaetingRaetingBundle:Signals:new', array('includeLayout' => 'false', 'form' => $form, 'entity' => $entity, 'createLink' => $searchLink))); ?>
                            </div>
                        </div>
                    <? endif; ?>
                    <div class="widget-content">
                        <div class="col-md-12">
                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                <form class="form-inline" method="get" action="<?= $view['router']->generate($searchLink) ?>">
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
                                        <th>Symbol</th>
                                        <th>Buy/Sell</th>
                                        <th>Open</th>
                                        <th>Take profit</th>
                                        <th>Stop loss</th>
                                        <th>Trader</th>
                                        <th>Created</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($entities as $entity): ?>
                                                <tr>
                                                    <td>
                                                        <? switch($entity->getstatus()):
                                                                case 'new': $label =  'label-success';break;
                                                                case 'opened': $label =  'label-warning';break;
                                                                case 'closed': $label =  'label-info';break;
                                                                case 'error': $label =  'label-danger';break;
                                                            endswitch;
                                                        ?>
                                                        <span class="label <?= $label ?>"><?= $entity->getstatus() ?></span>
                                                    </td>
                                                    <td><?= $entity->getSymbol()->getTitle() ?></td>
                                                    <td><?= $entity->getBuyValue() ?></td>
                                                    <td><?= $view['raeting']->renderPrice($entity->getOpen(), $entity->getSymbol()) ?></td>
                                                    <td><?= $view['raeting']->renderPrice($entity->getTakeprofit(), $entity->getSymbol()) ?></td>
                                                    <td><?= $view['raeting']->renderPrice($entity->getStoploss(), $entity->getSymbol()) ?></td>
                                                    <td>
                                                        <a href="<?= $view['router']->generate('trader_show', array('slug' => $entity->getUser()->getSlug())) ?>"><?= $entity->getUser()->getFirstname() ?> <?= $entity->getUser()->getLastname() ?></a></td>
                                                    <td><?= $entity->getCreated()->format('Y-m-d H:i:s') ?></td>
                                                    <td><a href="<?= $view['router']->generate('signals_show', array('uuid' => $entity->getUuid())) ?>">View</a></td>
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
<?= $view['pagination']->render($page, $totalSignals, $perPage, $searchLink, array('signal-search' => $query));?>

<? $view['slots']->stop('content') ?>