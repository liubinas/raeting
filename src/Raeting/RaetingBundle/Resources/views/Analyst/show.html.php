<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
<h3><?= $analyst->getName() ?></h3>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('crumbs') ?>
<div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
                <li>
                        <i class="icon-home"></i>
                        <a href="<?= $view['router']->generate('home'); ?>">Home</a>
                </li>
                <li>
                        <a href="<?= $view['router']->generate('analyst'); ?>">Analysts</a>
                </li>
                <li class="current">
                        <a href="<?= $view['router']->generate('analyst_show', array('slug' => $analyst->getSlug())); ?>"><?= $analyst->getName() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>

<?= $view->render('RaetingRaetingBundle::Analyst/analysis_list.html.php', array(
    'analysis' => $analysis, 
    'query' => $query, 
    'searchLink' => 'analyst_show', 
    'params' => array('slug' => $analyst->getSlug()),
    'totalAnalysis' => $totalAnalysis, 
    'page' => $page, 
    'perPage' => $perPage, 
    'showSearch' => true,
    'parent' => 'analystView')); ?>
<? $view['slots']->stop('content') ?>