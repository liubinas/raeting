<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131114134120 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `dividend` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `date` date NOT NULL,
            `ticker_id` int(11) NOT NULL,
            `amount` decimal(10,4) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `ticker_id` (`ticker_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("ALTER TABLE `dividend`
            ADD CONSTRAINT `dividend_ibfk_1` FOREIGN KEY (`ticker_id`) REFERENCES `symbol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE dividend");
    }
}
