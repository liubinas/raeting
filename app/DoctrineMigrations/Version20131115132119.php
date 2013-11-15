<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131115132119 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `analyst` ADD  `rank` INT NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE `analyst` DROP `rank`");
    }
}
