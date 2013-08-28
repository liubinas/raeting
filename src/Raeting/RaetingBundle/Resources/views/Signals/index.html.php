<? $view->extend('RaetingRaetingBundle::Signals/menu.html.php'); ?>

<? $view['slots']->start('content') ?>


<div class="row-fluid" style="background-color:#F1F1F1; padding-top:20px;">
        <div class="span12" style="text-align: center">
            <form class="form-inline" method="get" action="<?= $view['router']->generate('signals') ?>">
                <div class="controls" style="margin:0 0 5px 0">
                    <input id="signal-search" name="signal-search" type="text" placeholder="search" class="input-xxlarge" style="margin-bottom: 5px">
                    <button id="signal-search-btn" name="signal-search-btn" class="btn btn-info">
                        <i class="icon-search icon-white"></i> Signal Search
                    </button>
                    <button id="signal-add-btn" name="signal-add-btn" class="btn btn-success"
                        onclick="document.getElementsByClassName('signal-form')[0].style.display='block';">
                        <i class="icon-plus icon-white"></i> Add Signal
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row-fluid signal-form" style="background-color:#F5F5F5; display: none">
        <div class="span6 offset3">
            <?= $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('RaetingRaetingBundle:Signals:new', array('includeLayout'=> 'false'))); ?>
        </div>
    </div>
    <? if (!empty($entities)): ?>
    <div class="row-fluid signals">
        <div class="span12">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Status</th>
                    <th>Quote</th>
                    <th>Buy/Sell</th>
                    <th>Open</th>
                    <th>Take profit</th>
                    <th>Stop loss</th>
                    <th>Trader</th>
                    <th>Created</th>
                </thead>
                <tbody>
                    <? foreach ($entities as $entity):?>
                    <tr>
                        <td>
                            <a href="#">
                                <span class="label label-success"><?=$entity->getstatus()?></span></a>
                        </td>
                        <td><?=$entity->getQuote()->getTitle()?></td>
                        <td><?=$entity->getBuyValue()?></td>
                        <td><?=$entity->getOpen()?></td>
                        <td><?=$entity->getTakeprofit()?></td>
                        <td><?=$entity->getStoploss()?></td>
                        <td>
                            <a href="<?=$view['router']->generate('trader_show', array('id' => $entity->getUser()->getId() )) ?>"><?=$entity->getUser()->getFirstname()?> <?=$entity->getUser()->getLastname()?></a></td>
                        <td><?=$entity->getCreated()->format('Y-m-d')?></td>
                    </tr>
                    <? endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <? else: ?>
        <div class="box box-row">
            <div class="row-fluid">
                <div class="content">
                    <p><?=$view['translator']->trans('No entries')?></p>
                </div>
            </div>
        </div>
    <? endif;?>
<? $view['slots']->stop('content') ?>