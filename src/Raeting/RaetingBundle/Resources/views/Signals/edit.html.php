<? $view->extend('RaetingCoreBundle::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
    <div class="span5">
        <h2><?=$view['translator']->trans('Signals')?> <?=$view['translator']->trans('Edit')?></h2>
    </div>
    <nav class="span4">
                    <a href="<?= $view['router']->generate('signals') ?>" class="btn">
        <i class="icon-chevron-left"></i> 
        <?=$view['translator']->trans('Back to the list')?>
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
            <div class="content form-horizontal">

                <form action="<?= $view['router']->generate('signals_update', array('id' => $entity->getId())) ?>" method="post" <?= $view['form']->enctype($form) ?>>
                    <div class="content dark">
                        <fieldset>
                            <legend><b>1.</b> <?=$view['translator']->trans('General information')?></legend>
                            <?= $view['form']->widget($form) ?>
                        </fieldset>
                    </div>

                    <div class="content">
                        <div class="row-fluid">
                            <button type="submit" class="btn btn-large"><?=$view['translator']->trans('Edit')?></button> 
                            <a href="<?= $view['router']->generate('signals') ?>">
                                <?=$view['translator']->trans('Cancel')?>
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
<? $view['slots']->stop('body') ?>