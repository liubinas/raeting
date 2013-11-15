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
        $this->addSql("CREATE VIEW benchmark as SELECT ticker_id, sum(value) as value FROM `total_return` GROUP BY ticker_id");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP VIEW benchmark");
    }
}
