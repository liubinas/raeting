<? $view->extend('RaetingRaetingBundle::Signals/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>
<h3>Signal</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>
<div class="row">
        <div class="col-md-9">
            <div class="tabbable tabbable-full-width">
                <div class="tab-content row">
                <div class="widget box blue-box">
                    <div class='flot-y'>
                        <div class='flot-tick-label'><?= $entity->getSymbol()->getCurrency() ?></div>
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
        </div>
    <div class="col-md-3">
        <div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i> Signal info</h4>
							</div>
							<div class="widget-content form-horizontal row-border signal-info">
								<div class="form-group">
									<label class="col-md-4 control-label">Status:</label>
                                                                        <? switch($entity->getstatus()){
                                                                                case 'new': $label =  'label-success';break;
                                                                                case 'opened': $label =  'label-warning';break;
                                                                                case 'closed': $label =  'label-info';break;
                                                                                case 'error': $label =  'label-danger';break;
                                                                            } 
                                                                        ?>
									<div class="col-md-8"><span class="label <?= $label ?>"><?= $entity->getstatus() ?></span></div>
								</div>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Symbol:</label>
									<div class="col-md-8"><?= $entity->getSymbol()->getTitle() ?></div>
								</div>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Buy/Sell:</label>
									<div class="col-md-8"><?= $entity->getBuyValue() ?></div>
								</div>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Open:</label>
									<div class="col-md-8"><?= $entity->getOpen() ?></div>
								</div>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Take Profit:</label>
									<div class="col-md-8"><?= $entity->getTakeprofit() ?></div>
								</div>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Stop Loss:</label>
									<div class="col-md-8"><?= $entity->getStoploss() ?></div>
								</div>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Created:</label>
									<div class="col-md-8"><?= $entity->getCreated()->format('Y-m-d') ?></div>
								</div>
							</div>
						</div>
    </div>
</div>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.min.js') ?>"></script>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.time.min.js') ?>"></script>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.selection.min.js') ?>"></script>
<script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.dashes.js') ?>"></script>
<script src="<?= $view['assets']->getUrl('js/libs/plugins.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        
            var d1 = [<? $total = count($rates); for($i=1; $i<$total;$i++): echo '["'.(strtotime(date('Y-m-d H:i:s', strtotime($rates[$i]['source_time'])))*1000).'","'.$rates[$i]['rate'].'"]'; if($i != $total-1) echo ', '; endfor; ?>];
            var d2 = [<? if(!empty($rates)):?>["<?= strtotime(date('Y-m-d H:i:s', strtotime($rates[0]['source_time'])))*1000 ?>", "<?= $entity->getStopLoss() ?>"],["<?= strtotime(date('Y-m-d H:i:s', strtotime($rates[$total-1]['source_time'])))*1000 ?>", "<?= $entity->getStopLoss() ?>"]<? endif;?>];
            var d3 = [<? if(!empty($rates)):?>["<?= strtotime(date('Y-m-d H:i:s', strtotime($rates[0]['source_time'])))*1000 ?>", "<?= $entity->getTakeProfit() ?>"],["<?= strtotime(date('Y-m-d H:i:s', strtotime($rates[$total-1]['source_time'])))*1000 ?>", "<?= $entity->getTakeProfit() ?>"]<? endif;?>];
            <? if($entity->getOpenPrice()): ?>
                var d4 = [["<?= strtotime(date('Y-m-d H:i:s', strtotime($entity->getOpened()->format('Y-m-d H:i:s'))))*1000 ?>", "<?= $entity->getOpenPrice() ?>"]];
            <? endif;?>
            <? if($entity->getClosePrice()): ?>
                var d5 = [["<?= strtotime(date('Y-m-d H:i:s', strtotime($entity->getClosed()->format('Y-m-d H:i:s'))))*1000 ?>", "<?= $entity->getClosePrice() ?>"]];
            <? endif;?>
            var data1 = [
                    { label: "<?= $entity->getSymbol()->getTitle() ?>", data: d1}
                    ,{ label: "Stop loss", data: d2, lines: {show: false},dashes:{show:true,  dashLength: 10, lineWidth: 1.5}}
                    ,{ label: "Take Profit", data: d3, lines: {show: false},dashes:{show:true,  dashLength: 10, lineWidth: 1.5}}
                    <? if($entity->getOpenPrice()): ?>
                        ,{ label: "Opened", data: d4, points: {show: true, radius: 5, fill:true, fillColor: "#f0ad4e"}, color: "#f0ad4e"}
                    <? endif;?>
                    <? if($entity->getClosePrice()): ?>
                        ,{ label: "Closed", data: d5, points: {show: true, radius: 5, fill:true, fillColor: "#555555"}, color: "#555555"}
                    <? endif;?>
            ];

            var plot = $.plot("#chart_widget", data1, $.extend(true, {}, Plugins.getFlotWidgetDefaults(), {
                    xaxis: {
                            mode: "time",
                            timeformat: "%Y-%m-%d %H:%M"
                    },
                    series: {
                            lines: {
                                    fill: false,
                                    lineWidth: 1.5
                            }
                    },
                    grid: {
                            hoverable: true,
                            clickable: true
                    },
                    legend: {
                        show: true,
                        position: "sw",
                        noColumns: 5
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
                                    y = item.datapoint[1];
                                    var date = new Date(parseInt(x));
                                    var day = date.getDate().toString();
                                    if(day.length < 2){
                                        day = '0'+day;
                                    }
                                    var month = (date.getMonth()+1).toString();
                                    if(month.length < 2){
                                        month = '0'+month;
                                    }
                                    var hours = (date.getHours()).toString();
                                    if(hours.length < 2){
                                        hours = '0'+hours;
                                    }
                                    var minutes = (date.getMinutes()).toString();
                                    if(minutes.length < 2){
                                        minutes = '0'+minutes;
                                    }
                                    var seconds = (date.getSeconds()).toString();
                                    if(seconds.length < 2){
                                        seconds = '0'+seconds;
                                    }
                                    var year = date.getFullYear();
                                    showTooltip(item.pageX, item.pageY,
                                       year+'-'+ month +'-'+ day + ' '+ hours + ':'+ minutes + ':'+ seconds + "<br/>" + y + " <?= $entity->getSymbol()->getCurrency() ?>");
                            }
                    } else {
                            $("#tooltip").remove();
                            previousPoint = null;            
                    }
            });

    });
</script>
<div class="row">
    <div class="col-md-12">
        <!-- Tabs-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <div class="tab-content row">
                <!--=== Overview ===-->
                <div class="tab-pane active" id="tab_overview">
                    <div class="col-md-3">
                        <div class="fl padd-15">
                            <div class="list-group">
                                <li class="list-group-item no-padding">
                                    <img src="https://graph.facebook.com/<?= $entity->getUser()->getFbname() ?>/picture?type=large">
                                </li>
                            </div> 
                        </div>
                        <div class="row profile-info">
                            <div class="col-md-12">
                                <h1><?= $entity->getUser()->getFirstname() ?> <?= $entity->getUser()->getLastname() ?></h1>
                                <p><?= $entity->getUser()->getAbout() ?></p>
                                 <a href="<?= $view['router']->generate('trader_show', array('slug' => $entity->getUser()->getSlug())) ?>">View profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12 fb-wrapper">
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=133579296820463";
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-comments" data-href="<?= $view['router']->generate('signals_show', array('id' => $entity->getId()), true) ?>" data-width="600"></div>
                        </div>
                    </div> <!-- /.col-md-9 -->
                </div>
                <!-- /Overview -->
            </div> <!-- /.tab-content -->
        </div>
        <!--END TABS-->
    </div>
</div>

<? $view['slots']->stop('content') ?>