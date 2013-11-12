<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('content') ?>
<section id="first" class="home text-center bg1 fullheight" style="background-position: 50% 30px;">
    <div class="row"> <!-- .row-bg -->
        <div class="col-sm-12 col-md-6">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="visual cyan">
                        <i class="icon-signal icon-large"></i>
                    </div>
                    <h4>Signals</h4>
                    <p>
                        Find best investing ideas and turn them into successful trading decisions.
                        Share your ideas with the community and compete in the independent global rating.
                    </p>
                    <a class="more" href="<?= $view['router']->generate('signals'); ?>">View More <i class="pull-right icon-angle-right"></i></a>
                </div>
            </div> <!-- /.smallstat -->
        </div> 

        <div class="col-sm-12 col-md-6">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="visual green">
                        <i class="icon-money icon-large"></i>
                    </div>
                    <h4>Traders</h4>
                    <p>
                        Find the best performing and the most interesting signal providers. 
                        Share your strategies and compete with others globally.
                    </p>
                    <a class="more" href="<?= $view['router']->generate('trader'); ?>">View More <i class="pull-right icon-angle-right"></i></a>
                </div>
            </div> <!-- /.smallstat -->
        </div> 
    </div>	
    <div class="row"> <!-- .row-bg -->
        <div class="col-sm-12 col-md-6">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="visual red">
                        <i class="icon-group icon-large"></i>
                    </div>
                    <h4>Analysts</h4>
                    <p>
                        Find the analyst you can trust! 
                        We've put some effort to rate analysts so you can find and follow best-performing ones in the different markets and industries.
                    </p>
                    <a class="more" href="<?= $view['router']->generate('analyst'); ?>">View More <i class="pull-right icon-angle-right"></i></a>
                </div>
            </div> <!-- /.smallstat -->
        </div> 

        <div class="col-sm-12 col-md-6">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="visual yellow">
                        <i class="icon-thumbs-up-alt icon-large"></i>
                    </div>
                    <h4>Recommendations</h4>
                    <p>
                        Make informed investment decisions by following recommendations by professional analysts.
                    </p>
                    <a class="more" href="<?= $view['router']->generate('analysis'); ?>">View More <i class="pull-right icon-angle-right"></i></a>
                </div>
            </div> <!-- /.smallstat -->
        </div> 
    </div>	
</section>
<? $view['slots']->stop('content') ?>