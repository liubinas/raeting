<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131007091602 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `currency_rate` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `currency_id` int(11) NOT NULL,
                        `bid` decimal(10,6) NOT NULL,
                        `ask` decimal(10,6) NOT NULL,
                        `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `source_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                        PRIMARY KEY (`id`),
                        KEY `currency_id` (`currency_id`),
                        KEY `currency_id_2` (`currency_id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("ALTER TABLE  `currency_rate` ADD INDEX (  `currency_id` );");
        $this->addSql("ALTER TABLE  `currency_rate` ADD FOREIGN KEY (  `currency_id` ) REFERENCES  `symbol` (
                        `id`
                        ) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE currency_rate;");
    }
}
