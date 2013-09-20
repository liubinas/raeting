<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130920100435 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE VIEW user_stats AS SELECT concat(user_id, '_', substr(created,1,10)) as id, user_id, sum(profit) as profit, sum(pips) as pips, count(id) as total_signals, substr(created,1,10) as date_created FROM `signal` WHERE pips IS NOT NULL GROUP BY user_id, date_created;");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP VIEW user_stats");
    }
}
