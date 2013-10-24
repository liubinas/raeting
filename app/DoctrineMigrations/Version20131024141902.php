<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131024141902 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `ticker_rate` CHANGE  `high`  `high` DECIMAL( 10, 6 ) NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `ticker_rate` CHANGE  `low`  `low` DECIMAL( 10, 6 ) NULL DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `ticker_rate` CHANGE  `high`  `high` DECIMAL( 10, 6 ) NOT NULL");
        $this->addSql("ALTER TABLE  `ticker_rate` CHANGE  `low`  `low` DECIMAL( 10, 6 ) NOT NULL");
    }
}
