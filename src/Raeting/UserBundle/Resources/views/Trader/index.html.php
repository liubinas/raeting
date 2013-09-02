<? $view->extend('RaetingUserBundle::Trader/menu.html.php'); ?>

<? $view['slots']->start('content') ?>
    
    <? if (!empty($entities)): ?>
    <div class="row-fluid signals">
        <div class="span12">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Name Surname</th>
                    <th>E-mail</th>
                </thead>
                <tbody>
                    <? foreach ($entities as $entity):?>
                    <tr>
                        <td><a href="<?=$view['router']->generate('trader_show', array('id' => $entity['id'] )) ?>"><?=$entity['firstname']?> <?=$entity['lastname']?></a></td>
                        <td><?=$entity['email']?></td>
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