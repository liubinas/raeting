<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('meta') ?>
    <?=$view['meta']->render(
        $view['meta']->title(), 
        $view['meta']->keywords(), 
        $view['meta']->description() 
    )?>
<? $view['slots']->stop('meta') ?>

<div class="bg_top"></div>
<div class="wrapper">
    <div class="home_top">
        <a href="<?= $view['router']->generate('home') ?>"><img class="headerlogoimg" src="<?=$view['assets']->getUrl('images/logo_medium.png')?>" alt="<?=$view['translation']->trans('core.raeting')?>" /> </a>
        
        <div class="traffic">
            <div class="moving_bus"></div>
            <div class="moving_bike"></div>
            <div class="moving_bike2"></div>
            <div class="moving_truck"></div>
            <div class="moving_truck2"></div>
        </div>


        <h3><?=$view['translation']->trans('home.get_around')?></h3>
        <div class="form_holder">
            <form action="<?= $view['router']->generate('trip.index') ?>" method="post" class="home_search">
                <?= $view['form']->widget($searchForm['stop_start'], array('attr' => array('placeholder' => $view['translation']->trans('trip.search.leaving_from'), 'autocomplete' => 'off'))) ?>
                <?= $view['form']->widget($searchForm['stop_start_slug']) ?>
                <?= $view['form']->widget($searchForm['stop_end'], array('attr' => array('placeholder' => $view['translation']->trans('trip.search.going_to'), 'autocomplete' => 'off'))) ?>
                <?= $view['form']->widget($searchForm['stop_end_slug']) ?>
                <?= $view['form']->widget($searchForm['date'], array('attr' => array('placeholder' => $view['translation']->trans('trip.search.when')))) ?>
                <?= $view['form']->rest($searchForm) ?>
                <input type="submit" id="searchGO" value="<?=$view['translation']->trans('core.search')?>" />
            </form>
            <div class="group"></div>           
        </div>
    </div>
    <div class="home_bottom">
        <!--<div class="featured_destinations">
             <? //$view['actions']->render('RaetingPageBundle:Page:getPage', array('id' => ('en' == $view['request']->getParameter('language')? 5:6)));?>	
             <div class="clear"></div>
        </div>-->
        <div class="featured_destinations">
             <?=$view['actions']->render('RaetingTripBundle:Trip:getFeaturedCountries');?>	
             <div class="clear"></div>
        </div>
        <div class="home_press">
            <?=$view['actions']->render('RaetingPageBundle:Page:getPage', array('id' => ('en' == $view['request']->getParameter('language')? 3:4)));?>
        </div>
    </div>
</div>
