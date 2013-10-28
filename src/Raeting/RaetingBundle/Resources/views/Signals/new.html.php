<form action="<?= $view['router']->generate('signals_create', array('id' => $entity->getId())) ?>?link=<?= $createLink; ?>" method="post" <?= $view['form']->enctype($form) ?> class="form-horizontal">
    <div>
        <div class="col-md-6 form-group">
            <?= $view['form']->label($form['symbol']) ?>
            <div class="input-icon">
                <?=
                $view['form']->widget($form['symbol'], array(
                    'label' => 'Symbol',
                    'attr' => array(
                        'data-url' => $view['router']->generate('ajax_symbols', array(), true),
                        'class' => 'bind-autocomplete form-control input-width-medium'
                        )))
                ?>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <?= $view['form']->label($form['open']) ?>
            <div class="input-icon">
                <?= $view['form']->widget($form['open'], array('attr' => array('class' => 'form-control input-width-medium'))) ?>
            </div>
        </div>
    </div>
    <div>
        <div class="col-md-6 form-group">
            <?= $view['form']->label($form['take_profit']) ?>
            <div class="input-icon">
                <?= $view['form']->widget($form['take_profit'], array('attr' => array('class' => 'form-control input-width-medium'))) ?>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <?= $view['form']->label($form['stop_loss']) ?>
            <div class="input-icon">
                <?= $view['form']->widget($form['stop_loss'], array('attr' => array('class' => 'form-control input-width-medium'))) ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div>
        <div class="col-md-6 form-group">
            <?= $view['form']->label($form['description']) ?>
            <div class="input-icon">
                <?= $view['form']->widget($form['description'], array('attr' => array('class' => 'form-control input-width-xlarge'))) ?>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-md-2 control-label"></label>
            <?= $view['form']->widget($form['buy']) ?>
        </div>
    </div>
    <?= $view['form']->widget($form) ?>
    <div class="clear"></div>
    <!-- Button -->
    <div class="form-group">
        <div class="col-md-6">
            <button type="submit" id="add-signal" class="submit btn btn-success pull-right" name="add-signal">
                Add signal <i class="icon-angle-right"></i>
            </button>
            <button id="add-signal-cancel" name="add-signal-cancel" class="btn pull-right"
                    onclick="document.getElementsByClassName('signal-form')[0].style.display='none';">
                Cancel
            </button>
        </div>
    </div>
    <div class="clear"></div>
</form>
<hr/>