<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131016161812 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `analysis` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `ticker_id` int(11) NOT NULL,
                        `analyst_id` int(11) NOT NULL,
                        `estimation` DECIMAL( 10, 6 ) NOT NULL,
                        `date` date NOT NULL,
                        `period` varchar(255) NOT NULL,
                        `recommendation` varchar(255) NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("CREATE TABLE IF NOT EXISTS `analyst` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("ALTER TABLE `analysis` ADD INDEX (  `analyst_id` )");
        $this->addSql("ALTER TABLE  `analysis` ADD FOREIGN KEY (  `analyst_id` ) REFERENCES `analyst` (
                        `id`
                        ) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
        $this->addSql("ALTER TABLE `analysis` ADD INDEX (  `ticker_id` )");
        $this->addSql("ALTER TABLE  `analysis` ADD FOREIGN KEY (  `ticker_id` ) REFERENCES `symbol` (
                        `id`
                        ) ON DELETE NO ACTION ON UPDATE NO ACTION ;");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE analysis;");
        $this->addSql("DROP TABLE analyst;");
    }
}
