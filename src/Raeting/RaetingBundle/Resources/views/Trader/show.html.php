<? $view->extend('RaetingRaetingBundle::Trader/menu.html.php'); ?>

<? $view['slots']->start('content') ?>
<hr>
    
<div class="row-fluid page-head">
    <div class="span12">
        <h1>Trader profile</h1>
    </div>
</div>

<hr>
<div class="row-fluid signals">
            <div class="span12">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Created on</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$entity->getFirstname()?></td>
                            <td><?=$entity->getLastname()?></td>
                            <td><?=$entity->getemail()?></td>
                            <td><?=($entity->getcreateDate())?(string)$entity->getcreateDate()->format("Y-m-d H:i:s"):"";?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    
    <? if (!empty($signals)): ?>
<hr>
<div class="row-fluid page-head">
    <div class="span12">
        <h1>Trader signals</h1>
    </div>
</div>
<hr>
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
                        <? foreach ($signals as $entity):?>
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
    <? endif;?>
<? $view['slots']->stop('content') ?>