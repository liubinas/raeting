<? $view->extend('::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
    <div class="span5">
        <h2><?=$view['translator']->trans('User')?> <?=$view['translator']->trans('Listing')?></h2>
    </div>
    <nav class="span4">
                    <a href="<?= $view['router']->generate('user_new') ?>" class="btn btn-small pull-right">
                <?=$view['translator']->trans('Create new')?>
            </a>
            </nav>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('body') ?>
    <article>

        <? foreach ($entities as $entity):?>
        <div class="box box-row">
            <div class="row-fluid info">
                <div class="span5 offset1">
                    <b><?=(string)$entity?></b>
                </div>
                <div class="span2 txt-light">
                </div>
                <div class="span4 status"><ul>    <li>
        <a href="<?= $view['router']->generate('user_show', array('id' => $entity->getId())) ?>" class="btn">
            <?=$view['translator']->trans('show')?>
        </a>
    </li>    <li>
        <a href="<?= $view['router']->generate('user_edit', array('id' => $entity->getId())) ?>" class="btn">
            <?=$view['translator']->trans('edit')?>
        </a>
    </li></ul>                </div>
            </div>
        </div>
        <? endforeach;?>

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