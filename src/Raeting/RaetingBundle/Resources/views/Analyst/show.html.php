<? $view->extend('RaetingRaetingBundle::Analyst/menu.html.php'); ?>

<? $view['slots']->start('header_row') ?>
Analysts
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
                        <a href="<?= $view['router']->generate('analyst_show', array('id' => $analyst->getId())); ?>"><?= $analyst->getName() ?></a>
                </li>
        </ul>
</div>
<? $view['slots']->stop('crumbs') ?>
<? $view['slots']->start('content') ?>

<div class="row">
    <div class="col-md-12">
        <!-- Tabs-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <div class="tab-content row">
                <!--=== Overview ===-->
                <div class="tab-pane active" id="tab_overview">
                    <div class="col-md-9">
                        <div class="row profile-info">
                            <div class="col-md-7">
                                <h1><?= $analyst->getName() ?></h1>
                            </div>
                        </div> <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $view->render('RaetingRaetingBundle::Analyst/analysis_list.html.php', array(
    'analysis' => $analysis, 'query' => $query, 'searchLink' => 'analyst_show', 'analystId' => $analyst->getId(), 'totalAnalysis' => $totalAnalysis, 'page' => $page, 'perPage' => $perPage, 'showSearch' => true)); ?>
<? $view['slots']->stop('content') ?>