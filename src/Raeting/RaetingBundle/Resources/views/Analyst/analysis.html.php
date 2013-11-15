<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('menuAnalysisActive') ?> class="current"<? $view['slots']->stop('menuAnalysisActive') ?>

<? $view['slots']->start('header_row') ?>
<h3>Recommmendations</h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('analysis'); ?>">Recommendations</a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>

<?= $view->render('RaetingRaetingBundle::Analyst/analysis_list.html.php', array(
    'analysis' => $analysis, 
    'query' => $query, 
    'searchLink' => 'analysis', 
    'params' => array(),
    'totalAnalysis' => $totalAnalysis, 
    'page' => $page, 
    'perPage' => $perPage, 
    'showSearch' => true,
    'parent' => 'recommendationsView')); ?>
<? $view['slots']->stop('content') ?>