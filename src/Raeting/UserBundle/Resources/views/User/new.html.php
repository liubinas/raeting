<? $view->extend('::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
    <div class="span5">
        <h2><?=$view['translator']->trans('User')?> <?=$view['translator']->trans('Creation')?></h2>
    </div>
    <nav class="span4">
                    <a href="<?= $view['router']->generate('user') ?>" class="btn">
        <i class="icon-chevron-left"></i> 
        <?=$view['translator']->trans('Back to the list')?>
    </a>
    </nav>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('body') ?>
    <div class="box">
        <div class="row-fluid">
            <div class="content form-horizontal">

                <form action="<?= $view['router']->generate('user_create', array('id' => $entity->getId())) ?>" method="post" <?= $view['form']->enctype($form) ?>>
                    <div class="content dark">
                        <fieldset>
                            <legend><b>1.</b> <?=$view['translator']->trans('General information')?></legend>
                            <?= $view['form']->widget($form) ?>
                        </fieldset>
                    </div>

                    <div class="content">
                        <div class="row-fluid">
                            <button type="submit" class="btn btn-large"><?=$view['translator']->trans('Create')?></button> 
                            <a href="<?= $view['router']->generate('user') ?>">
                                <?=$view['translator']->trans('Cancel')?>
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
<? $view['slots']->stop('body') ?>