<div class="prev_next_ui">
    <h5><?=$from?>-<?=$to?> <?=$view['translation']->trans('core.pagination.of')?> <?=$total?></h5>
    <?php if ($urlPrev):?>
        <div class="prev" title="previous <?=$perPage?> listings">
            <a href="<?=$urlPrev?>"><?=$view['translation']->trans('core.pagination.prev')?></a>
        </div>
    <?php endif;?>
    <?php if ($urlNext):?>
        <div class="next" title="next <?=$perPage?> listings">
            <a href="<?=$urlNext?>"><?=$view['translation']->trans('core.pagination.next')?></a>
        </div>
    <?php endif;?>
</div>