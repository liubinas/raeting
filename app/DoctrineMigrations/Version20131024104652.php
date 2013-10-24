<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131024104652 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `currency_rate` ADD  `high` DECIMAL( 10, 6 ) NULL DEFAULT NULL AFTER  `ask` ,
                        ADD  `low` DECIMAL( 10, 6 ) NULL DEFAULT NULL AFTER  `high`");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE `currency_rate`
                        DROP `high`,
                        DROP `low`;");
    }
}
