ALTER TABLE  `signals` CHANGE  `open`  `open` DECIMAL( 10, 6 ) NOT NULL;
ALTER TABLE  `signals` CHANGE  `take_profit`  `take_profit` DECIMAL( 10, 6 ) NOT NULL;
ALTER TABLE  `signals` CHANGE  `stop_loss`  `stop_loss` DECIMAL( 10, 6 ) NOT NULL;
ALTER TABLE  `signals` CHANGE  `close`  `close` DECIMAL( 10, 6 ) NOT NULL;
ALTER TABLE  `signals` CHANGE  `pips`  `pips` DECIMAL( 10, 1 ) NOT NULL;