<? if(isset($showSearch) && $showSearch == true): ?>
<div class="col-md-2 fr search-box">
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
<div class="clear"></div>
<div class="row">
    <div class="col-md-12">
            <div class="widget">
                    <div class="widget-content">
                            <? if (!empty($analysis)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <? if(!isset($params['slug']) && $parent != 'analystTickerView'): ?>
                                        <th>Analyst</th>
                                        <? endif; ?>
                                        <? if($parent != 'tickerView' && $parent != 'analystTickerView'): ?>
                                        <th>Name</th>
                                        <th>Symbol</th>
                                        <? endif; ?>
                                        <th>Rating</th>
                                        <th>Target price</th>
                                        </thead>
                                        <tbody>
                                            <? foreach ($analysis as $entity): ?>
                                                <tr>
                                                    <td><?= $view['raeting']->renderDate($entity->getDate()->format('Y-m-d'), 'date') ?></td>
                                                    <td><?= $view['raeting']->renderDate($entity->getDate()->format('Y-m-d'), 'hours') ?></td>
                                                    <? if(!isset($params['slug']) && $parent != 'analystTickerView'): ?>
                                                    <td><a href="<?= $parent == 'tickerView' ? $view['router']->generate('analyst_graph', array('slug' => $entity->getAnalyst()->getSlug(), 'ticker' => strtolower($entity->getTicker()->getSymbol()))) : $view['router']->generate('analyst_show', array('slug' => $entity->getAnalyst()->getSlug())) ?>"><?= $entity->getAnalyst()->getName()?></td>
                                                    <? endif; ?>
                                                    <? if($parent != 'tickerView' && $parent != 'analystTickerView'): ?>
                                                    <td><a href="<?= $parent == 'analystView' ? $view['router']->generate('analyst_graph', array('slug' => $entity->getAnalyst()->getSlug(), 'ticker' => strtolower($entity->getTicker()->getSymbol()))) : $view['router']->generate('analysis_show', array('ticker' => strtolower($entity->getTicker()->getSymbol()))) ?>"><?= $entity->getTicker()->getTitle() ?></a></td>
                                                    <td><a href="<?= $parent == 'analystView' ? $view['router']->generate('analyst_graph', array('slug' => $entity->getAnalyst()->getSlug(), 'ticker' => strtolower($entity->getTicker()->getSymbol()))) : $view['router']->generate('analysis_show', array('ticker' => strtolower($entity->getTicker()->getSymbol()))) ?>"><?= $entity->getTicker()->getSymbol() ?></a></td>
                                                    <? endif; ?>
                                                    <td><?= $view['raeting']->renderAnalysisStatus($entity->getRecommendation(), true) ?></td>
                                                    <td><?= $view['raeting']->renderPrice($entity->getEstimation(), $entity->getTicker()) ?></td>
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
        if(isset($params['ticker'])):
            $get['ticker'] = $params['ticker'];
        endif;
    else:
        if(isset($analystSlug)){
            $get = array('slug' => $analystSlug, 'ticker' => strtolower($ticker->getSymbol()));
        }else{
            $get = array('ticker' => strtolower($ticker->getSymbol()));
        }
    endif;
?>
<?= $view['pagination']->render($page, $totalAnalysis, $perPage, $searchLink, $get);?>