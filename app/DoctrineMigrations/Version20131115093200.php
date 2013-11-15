<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131115093200 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `total_return` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `analyst_id` int(11) NOT NULL,
                        `ticker_id` int(11) NOT NULL,
                        `value` decimal(10,4) NOT NULL,
                        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `analyst_id_2` (`analyst_id`,`ticker_id`),
                        KEY `analyst_id` (`analyst_id`),
                        KEY `ticker_id` (`ticker_id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;");
        $this->addSql("ALTER TABLE `total_return`
                        ADD CONSTRAINT `total_return_ibfk_2` FOREIGN KEY (`ticker_id`) REFERENCES `symbol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                        ADD CONSTRAINT `total_return_ibfk_1` FOREIGN KEY (`analyst_id`) REFERENCES `analyst` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;");
        $this->addSql("CREATE VIEW benchmark as SELECT id, ticker_id, sum(value) as value FROM `total_return` GROUP BY ticker_id");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP VIEW benchmark");
        $this->addSql("DROP table `total_return`");
    }
}
