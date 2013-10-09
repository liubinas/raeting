<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131009140929 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `ticker_rate` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `ticker_id` int(11) NOT NULL,
                        `bid` decimal(10,6) NOT NULL,
                        `ask` decimal(10,6) NOT NULL,
                        `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `source_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                        PRIMARY KEY (`id`),
                        KEY `ticker_id` (`ticker_id`),
                        KEY `ticker_id_2` (`ticker_id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("ALTER TABLE  `ticker_rate` ADD INDEX (  `ticker_id` );");
        $this->addSql("ALTER TABLE  `ticker_rate` ADD FOREIGN KEY (  `ticker_id` ) REFERENCES  `symbol` (
                        `id`
                        ) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE ticker_rate;");
    }
}
