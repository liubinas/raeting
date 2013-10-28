<label class="radio inline control-label" <?php echo $view['form']->block($form, 'label_attributes') ?>><input type="radio"
    <?php echo $view['form']->block($form, 'widget_attributes') ?>
    value="<?php echo $view->escape($value) ?>"
    <?php if ($checked): ?> checked="checked"<?php endif ?>
/><?php echo $view->escape($label) ?></label>
