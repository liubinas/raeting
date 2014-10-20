<? $view->extend('RaetingCoreBundle::base.html.php'); ?>



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
                <li>
                        <a href="<?= $view['router']->generate('analyst_show', array('slug' => $analyst->getSlug())); ?>"><?= $analyst->getName() ?></a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('analyst_graph', array('slug' => $analyst->getSlug(), 'ticker' => strtolower($ticker->getSymbol()))); ?>"><?= $ticker->getSymbol() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>

<div class="row">
    <div class="col-md-12">
        <h3><?= $ticker->getTitle() ?> (<?= $ticker->getSymbol() ?>) recommendations by <?= $analyst->getName() ?></h3>
    </div>
</div>


<div class="row">
        <div class="col-md-12">
            <div class="tabbable tabbable-custom tabbable-full-width">
                <div class="tab-content row">
                <div class="widget box blue-box">
                    <div class='flot-y'>
                        <div class='flot-tick-label'><?= $ticker->getCurrency() ?></div>
                    </div>
                        <div class="widget-chart labeled"> <!-- Possible colors: widget-chart-blue, widget-chart-blueLight (standard), widget-chart-green, widget-chart-red, widget-chart-yellow, widget-chart-orange, widget-chart-purple, widget-chart-gray -->
                            <div class="title"><?= $ticker->getTitle() ?></div>
                            <div id="chart_widget" class="chart chart-medium"></div>
                        </div>
                    <div class='flot-x'>
                        <div class='flot-tick-label'>&nbsp;</div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.min.js') ?>"></script>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.time.min.js') ?>"></script>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.selection.min.js') ?>"></script>
<script src="<?= $view['assets']->getUrl('js/libs/plugins.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function(){
            <?  $total = count($analysisForGraph);
                $date = $analysisForGraph[0]->getDate()->format('Y-m-d');
                $lastDate = end($analysisForGraph)->getDate()->format('Y-m-d');
                $currentAnalysis = reset($analysisForGraph);
                $nextAnalysis = next($analysisForGraph);
                $i = 1;
            ?>
            var d1 = [<? while($date <= $lastDate): if($i > 1){echo '["'.(strtotime($date.'- 1 DAY')*1000).'","'.$currentAnalysis->getEstimation().'"], ';} echo '["'.(strtotime($date)*1000).'","'.$currentAnalysis->getEstimation().'"]'; if($date < $lastDate) echo ', '; $date = date('Y-m-d', strtotime($date . '+ 1 DAY')); $i++; if($nextAnalysis != null && $nextAnalysis->getDate()->format('Y-m-d') == $date){ $currentAnalysis = $nextAnalysis; $nextAnalysis = next($analysisForGraph); }endwhile; ?>];
            var d2 = [<? $total = count($rates); for($i=1; $i<$total;$i++): echo '["'.(strtotime(date('Y-m-d', strtotime($rates[$i]['source_time'])))*1000).'","'.$rates[$i]['bid'].'"]'; if($i != $total-1) echo ', '; endfor; ?>];

            var data1 = [
                    { label: "Analysis", data: d1},
                    { label: "Rates", data: d2}
            ];

            var plot = $.plot("#chart_widget", data1, $.extend(true, {}, Plugins.getFlotWidgetDefaults(), {
                    xaxis: {
                            mode: "time",
                            timeformat: "%Y-%m-%d"
                    },
                    series: {
                            lines: {
                                    fill: false,
                                    lineWidth: 1.5
                            }
                    },
                    legend: {
                        show: true,
                        position: "sw",
                        noColumns: 2
                    },
                    grid: {
                            hoverable: true,
                            clickable: true
                    },
                    selection: {
                            mode: "x",
                            color : '#aaa'
                    }
            }));
            function showTooltip(x, y, contents) {
                    $("<div id='tooltip'>" + contents + "</div>").css({
                            position: "absolute",
                            display: "none",
                            top: y + 5,
                            left: x + 5,
                            border: "1px solid #ccc",
                            padding: "2px",
                            "background-color": "#eee",
                            opacity: 1,
                            zIndex: 100
                    }).appendTo("body").fadeIn(200);
            }

            var previousPoint = null;
            $("#chart_widget").bind("plothover", function (event, pos, item) {
                    if (item) {
                            if (previousPoint != item.dataIndex) {

                                    previousPoint = item.dataIndex;

                                    $("#tooltip").remove();
                                    var x = item.datapoint[0].toFixed(2),
                                    y = item.datapoint[1].toFixed(2);
                                    var date = new Date(parseInt(x));
                                    var day = date.getDate().toString();
                                    if(day.length < 2){
                                        day = '0'+day;
                                    }
                                    var month = (date.getMonth()+1).toString();
                                    if(month.length < 2){
                                        month = '0'+month;
                                    }
                                    var year = date.getFullYear();
                                    showTooltip(item.pageX, item.pageY,
                                       year+'-'+ month +'-'+ day + "<br/>" + y + " <?= $ticker->getCurrency() ?>");
                            }
                    } else {
                            $("#tooltip").remove();
                            previousPoint = null;
                    }
            });

    });
</script>
<?= $view->render('RaetingRaetingBundle::Analyst/analysis_list.html.php', array(
    'analysis' => $analysis,
    'searchLink' => 'analyst_graph',
    'analystSlug' => $analyst->getSlug(),
    'totalAnalysis' => $totalAnalysis,
    'page' => $page,
    'perPage' => $perPage,
    'ticker' => $ticker,
    'parent' => 'analystTickerView')); ?>
<? $view['slots']->stop('content') ?>