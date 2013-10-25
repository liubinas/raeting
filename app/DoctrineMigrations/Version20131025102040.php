<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131025102040 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `analyst` ADD  `slug` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        $this->addSql("ALTER TABLE  `raeting`.`analyst` ADD UNIQUE (
                        `slug`
                        )");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE analyst DROP INDEX slug");
        $this->addSql("ALTER TABLE `analyst` DROP `slug`");
    }
}
