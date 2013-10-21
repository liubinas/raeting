<div class="row">
    <div class="col-md-12">
            <div class="widget box">
                    <div class="widget-header">
                            <h4>Analysis</h4>
                    </div>
                    <div class="widget-content">
                        <div class="col-md-12">
                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                <form class="form-inline" method="get" action="<?= $view['router']->generate($searchLink, array('id' => $analystId)) ?>">
                                    <label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-search"></i></span>
                                            <input id="signal-search" name="analysis-search" type="text" placeholder="search" class="form-control" value="<?= $query ?>" />
                                        </div>
                                    </label>
                                </form>
                            </div>
                        </div>
                            <? if (!empty($analysis)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>Symbol</th>
                                        <th>Estimation</th>
                                        <th>Date</th>
                                        <th>Recommendation</th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($analysis as $entity): ?>
                                                <tr>
                                                    <td><?= $entity->getTicker()->getTitle() ?></td>
                                                    <td><?= $entity->getEstimation() ?></td>
                                                    <td><?= $entity->getDate()->format('Y-m-d') ?></td>
                                                    <td><?= $entity->getRecommendation() ?></td>
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
<?= $view['pagination']->render($page, $totalAnalysis, $perPage, $searchLink, array('analysis-search' => $query, 'id' => $analystId));?>