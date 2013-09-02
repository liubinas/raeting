<div class="box">
    <div class="row-fluid">
        <div class="content form-horizontal">
            <form action="<?= $view['router']->generate('signals_create', array('id' => $entity->getId())) ?>" method="post" <?= $view['form']->enctype($form) ?> class="form-horizontal" style="padding:20px 0 10px 0;">
                <?= $view['form']->row($form['buy']) ?>
                <?= $view['form']->row($form['quote'], array(
                'label' => 'quote',
                'attr' => array(
                    'data-url' => $view['router']->generate('ajax_quotes', array(), true),
                    'class' => 'bind-autocomplete'
                ))) ?>
                <?= $view['form']->row($form['ticker'], array(
                'label' => 'ticker',
                'attr' => array(
                    'data-url' => $view['router']->generate('ajax_tickers', array(), true),
                    'class' => 'bind-autocomplete'
                ))) ?>
                <?= $view['form']->row($form['open']) ?>
                <?= $view['form']->row($form['take_profit']) ?>
                <?= $view['form']->row($form['stop_loss']) ?>
                <?= $view['form']->row($form['description']) ?>
                <?= $view['form']->widget($form) ?>
                <!-- Button -->
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" id="add-signal" name="add-signal" class="btn btn-primary" value="Submit">
                        <button id="add-signal-cancel" name="add-signal-cancel" class="btn"
                                onclick="document.getElementsByClassName('signal-form')[0].style.display='none';">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>