<? $view->extend('RaetingCoreBundle::base.html.php'); ?>


<? $view['slots']->start('header_row') ?>
    <div class="span5">
        <h2><?=$view['translator']->trans('Traders')?></h2>
    </div>
    <nav class="span4">
        <a href="<?= $view['router']->generate('trader') ?>" class="btn">
            <i class="icon-chevron-left"></i>
            <?=$view['translator']->trans('Back to the list')?>
        </a>
    </nav>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('content') ?>
    <div class="box">
        <div class="row-fluid">
            <div class="content">
                <table>
                    <tbody>
                    <tr>
                        <th>User profile</th>
                        <td><?=$entity->getFirstname()?> <?=$entity->getLastname()?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<? $view['slots']->stop('content') ?>