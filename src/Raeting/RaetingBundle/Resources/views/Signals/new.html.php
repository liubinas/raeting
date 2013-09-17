<form action="<?= $view['router']->generate('signals_create', array('id' => $entity->getId())) ?>?link=<?= $createLink; ?>" method="post" <?= $view['form']->enctype($form) ?> class="form-horizontal row-border">
                
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                <?= $view['form']->widget($form['buy']) ?>
                    </div>
                <?= $view['form']->row($form['quote'], array(
                'label' => 'Quote',
                'attr' => array(
                    'data-url' => $view['router']->generate('ajax_quotes', array(), true),
                    'class' => 'bind-autocomplete form-control input-width-medium'
                ))) ?>
                <?= $view['form']->row($form['ticker'], array(
                'label' => 'Ticker',
                'attr' => array(
                    'data-url' => $view['router']->generate('ajax_tickers', array(), true),
                    'class' => 'bind-autocomplete form-control input-width-medium'
                ))) ?>
                <?= $view['form']->row($form['open'], array('attr' => array('class' => 'form-control input-width-medium'))) ?>
                <?= $view['form']->row($form['take_profit'], array('attr' => array('class' => 'form-control input-width-medium'))) ?>
                <?= $view['form']->row($form['stop_loss'], array('attr' => array('class' => 'form-control input-width-medium'))) ?>
                <div class="clear"></div>
                <?= $view['form']->row($form['description'], array('attr' => array('class' => 'form-control input-width-xxlarge'))) ?>
                <?= $view['form']->widget($form) ?>
                <!-- Button -->
                <div class="col-md-12">
                        <button type="submit" id="add-signal" class="submit btn btn-success pull-right" name="add-signal">
                                Add signal <i class="icon-angle-right"></i>
                        </button>
                        <button id="add-signal-cancel" name="add-signal-cancel" class="btn pull-right"
                                onclick="document.getElementsByClassName('signal-form')[0].style.display='none';">
                            Cancel
                        </button>
                </div>
                <div class="clear"></div>
            </form>
    <hr/>