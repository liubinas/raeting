<? $view->extend('RaetingRaetingBundle::Signals/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>
Signal
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>

<div class="row">
    <div class="col-md-12">
            <div class="widget box">
                    <div class="widget-header">
                            <h4>Signal information</h4>
                    </div>
                    <div class="widget-content">
                            <? if (!empty($entity)): ?>
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
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="#">
                                                            <span class="label label-success"><?= $entity->getstatus() ?></span></a>
                                                    </td>
                                                    <td><?= $entity->getSymbol()->getTitle() ?></td>
                                                    <td><?= $entity->getBuyValue() ?></td>
                                                    <td><?= $entity->getOpen() ?></td>
                                                    <td><?= $entity->getTakeprofit() ?></td>
                                                    <td><?= $entity->getStoploss() ?></td>
                                                    <td>
                                                        <a href="<?= $view['router']->generate('trader_show', array('slug' => $entity->getUser()->getSlug())) ?>"><?= $entity->getUser()->getFirstname() ?> <?= $entity->getUser()->getLastname() ?></a></td>
                                                    <td><?= $entity->getCreated()->format('Y-m-d') ?></td>
                                                </tr>
                                        </tbody>
                                    </table>
                        <? else: ?>
                            <p><?= $view['translator']->trans('No info') ?></p>
                        <? endif; ?>
                    </div>
            </div>
            <div class="col-md-12 fb-wrapper">
                <br/><br/>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=133579296820463";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-comments" data-href="<?= $view['router']->generate('signals_show', array('uid' => $entity->getUuid()), true) ?>" data-width="600"></div>
            </div>
    </div>
</div>

<? $view['slots']->stop('content') ?>