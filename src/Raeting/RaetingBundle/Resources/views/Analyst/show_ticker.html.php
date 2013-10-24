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
                <li>
                        <a href="<?= $view['router']->generate('analyst'); ?>">Analysts</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('analyst_show', array('id' => $analyst->getId())); ?>"><?= $analyst->getName() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>

<div class="row">
    <div class="col-md-12">
        <!-- Tabs-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <div class="tab-content row">
                <!--=== Overview ===-->
                <div class="tab-pane active" id="tab_overview">
                    <div class="col-md-9">
                        <div class="row profile-info">
                            <div class="col-md-7">
                                <h1><?= $analyst->getName() ?></h1>
                                <h2><?= $ticker->getTitle() ?> (<?= $ticker->getSymbol() ?>)</h2>
                            </div>
                        </div> <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-md-12">
                <div class="widget box blue-box">
                    <div class='flot-y'>
                        <div class='flot-tick-label'><?= $ticker->getCurrency() ?></div>
                    </div>
                        <div class="widget-chart"> <!-- Possible colors: widget-chart-blue, widget-chart-blueLight (standard), widget-chart-green, widget-chart-red, widget-chart-yellow, widget-chart-orange, widget-chart-purple, widget-chart-gray -->
                                <div id="chart_widget" class="chart chart-medium"></div>
                        </div>
                    <div class='flot-x'>
                        <div class='flot-tick-label'>Date</div>
                    </div>
                </div>
        </div>
</div>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.min.js') ?>"></script>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.time.min.js') ?>"></script>
<script src="<?= $view['assets']->getUrl('js/libs/plugins.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function(){

            var d1 = [<? $total = count($analysisForGraph); for($i=1; $i<$total;$i++): if($i > 1){echo '["'.(strtotime($analysisForGraph[$i-1]->getDate()->format('Y-m-d'))*1000).'","'.$analysisForGraph[$i]->getEstimation().'"]';}echo ', ["'.(strtotime($analysisForGraph[$i]->getDate()->format('Y-m-d'))*1000).'","'.$analysisForGraph[$i]->getEstimation().'"]'; if($i != $total-1) echo ', '; endfor; ?>];
            var d2 = [<? $total = count($rates); for($i=1; $i<$total;$i++): echo '["'.(strtotime($rates[$i]->getSourceTime()->format('Y-m-d'))*1000).'","'.$rates[$i]->getBid().'"]'; if($i != $total-1) echo ', '; endfor; ?>];

            var data1 = [
                    { label: "Analysis", data: d1},
                    { label: "Rates", data: d2}
            ];

            $.plot("#chart_widget", data1, $.extend(true, {}, Plugins.getFlotWidgetDefaults(), {
                    xaxis: {
                            mode: "time",
                            timeformat: "%Y-%m-%d"
                    },
                    series: {
                            lines: {
                                    fill: false,
                                    lineWidth: 1.5
                            }
                    }
            }));

    });
</script>
<?= $view->render('RaetingRaetingBundle::Analyst/analysis_list.html.php', array(
    'analysis' => $analysis, 'searchLink' => 'analyst_graph', 'analystId' => $analyst->getId(), 'totalAnalysis' => $totalAnalysis, 'page' => $page, 'perPage' => $perPage, 'ticker' => $ticker)); ?>
<? $view['slots']->stop('content') ?>