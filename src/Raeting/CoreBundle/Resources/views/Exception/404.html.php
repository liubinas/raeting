<? $view->extend('RaetingCoreBundle::layout.html.php'); ?>

<? $view['slots']->start('meta') ?>
    <?=$view['meta']->render(
        $view['meta']->title(), 
        $view['meta']->keywords(), 
        $view['meta']->description()
    )?>
<? $view['slots']->stop('meta') ?>
<div class="main details">
    <section class="destination_info">
        <div class="wrapper">
            <section class="panel four_o_four">
                <h1 class="four_o_four"><?= $statusCode; ?>!</h1>
                <h2 class="four_o_four"><?= $view['translation']->trans($exception->getMessage())?></h2>
                <div class="traffic">
                    <div class="moving_bus"></div>
                    <div class="moving_bike"></div>
                    <div class="moving_bike2"></div>
                    <div class="moving_truck"></div>
                    <div class="moving_truck2"></div>
                </div>
            </section>
            <? if ($isDebug) : ?>
            <div>
                <!-- Show exceptions -->
                <h1>Trace</h1>
                <h2>Exception:</h2>
                <div><pre><? var_dump($exception); ?></pre></div>
                <hr/>
                <h2>Logger</h2>
                <div><pre><? var_dump($logger); ?></pre></div>
                <hr/>
                <h2>Current content</h2>
                <div><pre><? var_dump($currentContent); ?></pre></div>
            </div>
            <? endif; ?>
        </div>
    </section>
</div>
