<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131031100014 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `signal` CHANGE  `description`  `description` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `opened`  `opened` DATETIME NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `open_expire`  `open_expire` DATETIME NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `closed`  `closed` DATETIME NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `close_expire`  `close_expire` DATETIME NULL DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `signal` CHANGE  `description`  `description` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `opened`  `opened` DATETIME NOT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `open_expire`  `open_expire` DATETIME NOT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `closed`  `closed` DATETIME NOT NULL");
        $this->addSql("ALTER TABLE  `signal` CHANGE  `close_expire`  `close_expire` DATETIME NOT NULL");
    }
}
