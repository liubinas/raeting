<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131030084623 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `rate` CHANGE  `source_time`  `source_time` DATETIME NOT NULL");
        $this->addSql("ALTER TABLE  `rate` ADD  `source_date` DATE NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE `rate` DROP `source_date`");
        $this->addSql("ALTER TABLE  `rate` CHANGE  `source_time`  `source_time` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00'");
    }
}
