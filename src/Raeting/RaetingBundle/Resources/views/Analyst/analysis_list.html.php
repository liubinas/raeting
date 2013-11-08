<div class="row">
    <div class="col-md-12">
            <div class="widget box">
                    <div class="widget-header">
                            <h4>Analyses</h4>
                    </div>
                    <div class="widget-content">
                        <? if(isset($showSearch) && $showSearch == true): ?>
                        <div class="col-md-12">
                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                <form class="form-inline" method="get" action="<?= $view['router']->generate($searchLink, $params) ?>">
                                    <label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-search"></i></span>
                                            <input id="signal-search" name="analysis-search" type="text" placeholder="search" class="form-control" value="<?= $query ?>" />
                                        </div>
                                    </label>
                                </form>
                            </div>
                        </div>
                        <? endif; ?>
                            <? if (!empty($analysis)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>Date</th>
                                        <? if(!isset($params['slug'])): ?>
                                        <th>Analyst</th>
                                        <? endif; ?>
                                        <th>Symbol</th>
                                        <th>Recommendation</th>
                                        <th>Target price</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($analysis as $entity): ?>
                                                <tr>
                                                    <td><?= $entity->getDate()->format('Y-m-d') ?></td>
                                                    <? if(!isset($params['slug'])): ?>
                                                    <td><?= $entity->getAnalyst()->getName()?></td>
                                                    <? endif; ?>
                                                    <td><a href="<?= $view['router']->generate('analyst_graph', array('slug' => $entity->getAnalyst()->getSlug(), 'ticker' => strtolower($entity->getTicker()->getSymbol()))) ?>"><?= $entity->getTicker()->getTitle() ?></a></td>
                                                    <td><?= $view['raeting']->renderAnalysisStatus($entity->getRecommendation(), true) ?></td>
                                                    <td><?= $view['raeting']->renderPrice($entity->getEstimation(), $entity->getTicker()) ?></td>
                                                    <td><a href="<?= $view['router']->generate('analyst_graph', array('slug' => $entity->getAnalyst()->getSlug(), 'ticker' => strtolower($entity->getTicker()->getSymbol()))) ?>">View</a></td>
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
<?  if(isset($showSearch) && $showSearch == true):
        $get = array('analysis-search' => $query);
        if(isset($params['slug'])):
            $get['slug'] = $params['slug'];
        endif;
    else:
        $get = array('slug' => $analystSlug, 'ticker' => strtolower($ticker->getSymbol()));
    endif;
?>
<?= $view['pagination']->render($page, $totalAnalysis, $perPage, $searchLink, $get);?>