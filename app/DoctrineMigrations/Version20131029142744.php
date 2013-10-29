<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131029142744 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("DROP TABLE currency_rate");
        $this->addSql("RENAME TABLE `ticker_rate` TO `rate` ;");
        $this->addSql("`ALTER TABLE rate DROP INDEX ticker_id`");
        $this->addSql("`ALTER TABLE rate DROP INDEX ticker_id_2`");
        $this->addSql("TRUNCATE TABLE rate");
        $this->addSql("ALTER TABLE  `rate` DROP FOREIGN KEY  `rate_ibfk_1` ;");
        $this->addSql("ALTER TABLE  `rate` CHANGE  `ticker_id`  `symbol_id` INT( 11 ) NOT NULL");
        $this->addSql("ALTER TABLE  `rate` ADD FOREIGN KEY (  `symbol_id` ) REFERENCES `symbol` (
                        `id`
                        ) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
    }

    public function down(Schema $schema)
    {
    }
}
