<div class="form-group">
    <?= $view['form']->label($form) ?>
    <div class="input-icon">
        <?= $view['form']->widget($form) ?>
    </div>
    <? if ('' !== $view['form']->errors($form)): ?>
        <div class="error_message icon_attention">
            <?= $view['form']->errors($form) ?>
        </div>
    <? endif;?>
</div>