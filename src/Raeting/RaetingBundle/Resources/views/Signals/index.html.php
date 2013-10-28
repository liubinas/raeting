<? $view->extend('RaetingRaetingBundle::Signals/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>
<h3>Signals</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('signals'); ?>">Signals</a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>

<? $view->render('RaetingRaetingBundle::Signals/signal_list.html.php', array(
    'entities' => $entities, 'query' => $query, 'showForm' => $showForm, 'form' => $form, 'entity' => $entity, 'searchLink' => 'signals', 'totalSignals' => $totalSignals, 'page' => $page, 'perPage' => $perPage)); ?>