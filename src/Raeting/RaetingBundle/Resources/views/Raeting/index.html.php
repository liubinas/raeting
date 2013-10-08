<? $view->extend('RaetingRaetingBundle::Raeting/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>

    Welcome to RAETING
    
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>

                <hr>
                <p class="lead">
                    Follow and compare trading signals from different markets and traders. 
                    Share your ideas easily.
                </p>
                <div class="row row-bg"> <!-- .row-bg -->
                    <div class="col-sm-8 col-md-4">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content">
                                <div class="visual cyan">
                                    <i class="icon-dollar"></i>
                                </div>
                                <h4>Signals</h4>
                                <p>
                                    Find best investing ideas and turn them into successful trading decisions.
                                    Share your ideas with the community and compete in the independent global rating.
                                </p>
                                <a class="more" href="<?= $view['router']->generate('signals'); ?>">View More <i class="pull-right icon-angle-right"></i></a>
                            </div>
                        </div> <!-- /.smallstat -->
                    </div> <!-- /.col-md-3 -->

                    <div class="col-sm-8 col-md-4">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content">
                                <div class="visual green">
                                    <i class="icon-dollar"></i>
                                </div>
                                <h4>Traders</h4>
                                <p>
                                    Find the best performing and the most interesting signal providers. 
                                    Share your strategies and compete with others globally.
                                </p>
                                <a class="more" href="<?= $view['router']->generate('trader'); ?>">View More <i class="pull-right icon-angle-right"></i></a>
                            </div>
                        </div> <!-- /.smallstat -->
                    </div> <!-- /.col-md-3 -->

                    <div class="col-sm-8 col-md-4 hidden-xs">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content">
                                <div class="visual yellow">
                                    <i class="icon-dollar"></i>
                                </div>
                                <h4>API</h4>
                                <p>
                                    Our system is secure, free and open for integration with your favorite trading 
                                    platform or tool.
                                </p>
                                <!--<a class="more" href="<?= $view['router']->generate('api'); ?>">View More <i class="pull-right icon-angle-right"></i></a>-->
                            </div>
                        </div> <!-- /.smallstat -->
                    </div> <!-- /.col-md-3 -->

                </div>
            </div>
<? $view['slots']->stop('content') ?>