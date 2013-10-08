<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131008104329 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `signal` ADD  `open_price` DECIMAL( 10, 6 ) NULL DEFAULT NULL AFTER  `stop_loss` ,
                        ADD  `close_price` DECIMAL( 10, 6 ) NULL DEFAULT NULL AFTER  `open_price`");
        $this->addSql("ALTER TABLE `signal` DROP `profit`");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE `signal` DROP `open_price`");
        $this->addSql("ALTER TABLE `signal` DROP `close_price`");
        $this->addSql("ALTER TABLE  `signal` ADD  `profit` DECIMAL( 10, 6 ) NULL DEFAULT NULL");
    }
}
