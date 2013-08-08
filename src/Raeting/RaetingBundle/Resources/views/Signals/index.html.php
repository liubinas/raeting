<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
    <div class="head">
        <ul class="nav nav-pills pull-right">
          <li><a href="home.html">Home</a></li>
          <li><a href="traders.html">Traders</a></li>
          <li class="active"><a href="#">Signals</a></li>
          <li><a href="api.html">API</a></li>
          <li><a href="signup.html">Sign Up</a></li>
          <li><a tabindex="0" href="#">Login</a></li>
        </ul>
        <h3>
            <img src="img/logo.png" alt="raeting logo" id="logo" width="" height="" />
        </h3>
    </div>
    
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('body') ?>
<div class="span5">
        <h2><?=$view['translator']->trans('Signals')?> <?=$view['translator']->trans('Listing')?></h2>
    </div>
    <nav class="span4">
                    <a href="<?= $view['router']->generate('signals_new') ?>" class="btn btn-small pull-right">
                <?=$view['translator']->trans('Create new')?>
            </a>
            </nav>
    <article>
<table>
        <? foreach ($entities as $entity):?>
        <tr>
            <td><?=$entity->getstatus()?></td>
            <td><?=$entity->getquote()?></td>
            <td><?=$entity->gettype()?></td>
            <td><?=$entity->getopen()?></td>
            <td><?=$entity->getprofit()?></td>
            <td><?=$entity->getloss()?></td>
            <td>
                <a href="<?= $view['router']->generate('signals_show', array('id' => $entity->getId())) ?>" class="btn">
                    <?=$view['translator']->trans('show')?></a>
            </td>
            <td>
                <a href="<?= $view['router']->generate('signals_show', array('id' => $entity->getId())) ?>" class="btn">
                    <?=$view['translator']->trans('edit')?></a>
            </td>
        </tr>
        <? endforeach;?>
</table>
        <? if (empty($entities)): ?>
            <div class="box box-row">
                <div class="row-fluid">
                    <div class="content">
                        <p><?=$view['translator']->trans('No entries')?></p>
                    </div>
                </div>
            </div>
        <? endif;?>

    </article>
<? $view['slots']->stop('body') ?>