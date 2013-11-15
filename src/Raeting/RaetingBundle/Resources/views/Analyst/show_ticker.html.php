<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
<h3 class="fl"><?= $ticker->getTitle() ?> (<?= $ticker->getSymbol() ?>)</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li>
                        <a href="<?= $view['router']->generate('analysis'); ?>">Recommendations</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('analysis_show', array('ticker' => $ticker->getSymbol())); ?>"><?= $ticker->getSymbol() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>

<?= $view->render('RaetingRaetingBundle::Analyst/analysis_list.html.php', array(
    'analysis' => $analysis, 
    'searchLink' => 'analysis_show', 
    'totalAnalysis' => $totalAnalysis, 
    'page' => $page, 
    'perPage' => $perPage, 
    'ticker' => $ticker,
    'showSearch' => true,
    'params' => array('ticker' => $ticker->getSymbol()),
    'query' => $query, 
    'parent' => 'tickerView')); ?>
<? $view['slots']->stop('content') ?>