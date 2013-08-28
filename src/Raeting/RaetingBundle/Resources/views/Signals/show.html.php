<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
    <div class="span5">
        <h2><?=$view['translator']->trans('Signals')?></h2>
    </div>
    <nav class="span4">
                    <a href="<?= $view['router']->generate('signals') ?>" class="btn">
        <i class="icon-chevron-left"></i> 
        <?=$view['translator']->trans('Back to the list')?>
    </a>
    <a href="<?= $view['router']->generate('signals_edit', array('id' => $entity->getId())) ?>" class="btn">
        <i class="icon-pencil"></i> 
        <?=$view['translator']->trans('Edit')?>
    </a>
    <a href="<?= $view['router']->generate('signals_delete', array('id' => $entity->getId())) ?>" class="btn" onclick="return confirm('<?=$view['translator']->trans('Confirm delete')?>">
        <i class="icon-trash"></i>
        <?=$view['translator']->trans('Delete')?>
    </a>
    </nav>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('body') ?>
    <div class="box">
        <div class="row-fluid">
            <div class="content">
                <table>
                    <tbody>
                        <tr>
                            <th>User</th>
                            <td><?=$entity->getUser()?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?=$entity->getStatus()?></td>
                        </tr>
                        <tr>
                            <th>Quote</th>
                            <td><?=$entity->getQuote()?></td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td><?=$entity->gettype()?></td>
                        </tr>
                        <tr>
                            <th>Open</th>
                            <td><?=$entity->getopen()?></td>
                        </tr>
                        <tr>
                            <th>Profit</th>
                            <td><?=$entity->getProfit()?></td>
                        </tr>
                        <tr>
                            <th>Loss</th>
                            <td><?=$entity->getLoss()?></td>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <td><?=($entity->getCreated())?(string)$entity->getCreated()->format("Y-m-d H:i:s"):"";?></td>
                        </tr>
                        <tr>
                            <th>Id</th>
                            <td><?=$entity->getId()?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<? $view['slots']->stop('body') ?>