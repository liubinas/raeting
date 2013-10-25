<? $view->extend('RaetingRaetingBundle::Trader/menu.html.php'); ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li>
                        <a href="<?= $view['router']->generate('trader'); ?>">Traders</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('trader_show', array('slug' => $entity->getSlug())); ?>"><?= $entity->getFirstname() ?> <?= $entity->getLastname() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>

<? $view['slots']->start('header_row') ?>
<h3>Trader Profile</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>
<div class="row">
    <div class="col-md-12">
        <!-- Tabs-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <div class="tab-content row">
                <!--=== Overview ===-->
                <div class="tab-pane active" id="tab_overview">
                    
                    <div class="fl padd-15">
                        <div class="list-group profile-photo">
                            <li class="list-group-item no-padding">
                                <img src="https://graph.facebook.com/<?= $entity->getFbname() ?>/picture?type=large">
                            </li>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row profile-info">
                            <div class="col-md-7">
                                <h1><?= $entity->getFirstname() ?> <?= $entity->getLastname() ?></h1>

                                <dl class="dl-horizontal">
                                    <dt>Company</dt>
                                    <dd><?= $entity->getCompany()?></dd>
                                    <dt>About</dt>
                                    <dd><?= $entity->getAbout()?></dd>
                                    <dt>Member since</dt>
                                    <dd><?= ($entity->getcreateDate()) ? (string) $entity->getcreateDate()->format("Y-m-d") : ""; ?></dd>
                                </dl>
                            </div>
                        </div> <!-- /.row -->
                        <? if (count($chartSignals) > 0): ?>
                            <div class="row">
                                    <div class="col-md-12">
                                            <div class="widget box blue-box">
                                                <div class='flot-y'>
                                                    <div class='flot-tick-label'>Pips</div>
                                                </div>
                                                    <div class="widget-chart"> <!-- Possible colors: widget-chart-blue, widget-chart-blueLight (standard), widget-chart-green, widget-chart-red, widget-chart-yellow, widget-chart-orange, widget-chart-purple, widget-chart-gray -->
                                                            <div id="chart_widget" class="chart chart-medium"></div>
                                                    </div>
                                                <div class='flot-x'>
                                                    <div class='flot-tick-label'>Signals</div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            <script type="text/javascript" src="<?= $view['assets']->getUrl('js/flot/jquery.flot.min.js') ?>"></script>
                            <script src="<?= $view['assets']->getUrl('js/libs/plugins.js') ?>" type="text/javascript"></script>
                            <script>
                                $(document).ready(function(){

                                        // Sample Data
                                        var d1 = [<? $total = count($chartSignals); $counter = 0; for($i=1; $i<$total;$i++): $counter += $chartSignals[$i]['pips']; echo '['.$i.','.$counter.']'; if($i != $total-1) echo ', '; endfor; ?>];

                                        var data1 = [
                                                { label: "Signals", data: d1}
                                        ];

                                        $.plot("#chart_widget", data1, $.extend(true, {}, Plugins.getFlotWidgetDefaults(), {
                                                xaxis: {
                                                        min: 1,
                                                        max: <?= $total ?>
                                                },
                                                series: {
                                                        lines: {
                                                                fill: false,
                                                                lineWidth: 1.5
                                                        },
                                                        grow: { active: true, growings:[ { stepMode: "maximum" } ] }
                                                }
                                        }));

                                });
                            </script>
                        <? endif; ?>
                        <? if (!empty($signals)): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                        <form class="form-inline" method="get" action="<?= $view['router']->generate('trader_show', array('slug' => $entity->getSlug())); ?>">
                                            <label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon-search"></i></span>
                                                    <input id="signal-search" name="signal-search" type="text" placeholder="search" class="form-control" value="<?= $query ?>" />
                                                </div>
                                            </label>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="widget">
                                        <div class="widget-content">
                                            <h3>Signals</h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Symbol</th>
                                                        <th>Buy/Sell</th>
                                                        <th>Open</th>
                                                        <th>Take profit</th>
                                                        <th>Stop loss</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach ($signals as $signal): ?>
                                                        <tr>
                                                            <td>
                                                                <? switch($signal->getstatus()){
                                                                case 'new': $label =  'label-success';break;
                                                                case 'opened': $label =  'label-warning';break;
                                                                case 'closed': $label =  'label-info';break;
                                                                case 'error': $label =  'label-danger';break;
                                                                    } 
                                                                ?>
                                                                <span class="label <?= $label ?>"><?= $signal->getstatus() ?></span>
                                                            </td>
                                                            <td><?= $signal->getSymbol()->getTitle() ?></td>
                                                            <td><?= $signal->getBuyValue() ?></td>
                                                            <td><?= $signal->getOpen() ?></td>
                                                            <td><?= $signal->getTakeprofit() ?></td>
                                                            <td><?= $signal->getStoploss() ?></td>
                                                            <td><?= $signal->getCreated()->format('Y-m-d H:i:s') ?></td>
                                                        <td><a href="<?= $view['router']->generate('signals_show', array('id' => $signal->getId())) ?>">View</a></td>
                                                        </tr>
                                                    <? endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Striped Table -->
                            </div> <!-- /.row -->
                            <?= $view['pagination']->render($page, $totalSignals, $perPage, 'trader_show', array('signal-search' => $query, 'slug' => $entity->getSlug()));?>
                        <? endif; ?>
                    </div> <!-- /.col-md-9 -->
                </div>
                <!-- /Overview -->

            </div> <!-- /.tab-content -->
        </div>
        <!--END TABS-->
    </div>
</div> <!-- /.row -->
<? $view['slots']->stop('content') ?>