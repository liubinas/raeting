<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131115095019 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE `total_return` ADD UNIQUE (
                        `analyst_id` ,
                        `ticker_id`
                        )");
        $this->addSql("CREATE VIEW analyst_total_return as SELECT analyst_id, sum(value) as value FROM `total_return` GROUP BY analyst_id");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE total_return DROP INDEX analyst_id_2");
        $this->addSql("DROP VIEW analyst_total_return");
    }
}
