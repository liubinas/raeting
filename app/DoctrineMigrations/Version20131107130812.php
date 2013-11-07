<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131107130812 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE  `user` ADD  `twitter` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `symbol` ADD  `view_precision` INT NOT NULL DEFAULT  '3'");
        $this->addSql("ALTER TABLE  `analyst` ADD  `company` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
                        ADD  `import_slug` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE `user` DROP `twitter`");
        $this->addSql("ALTER TABLE `symbol` DROP `view_precision`");
        $this->addSql("ALTER TABLE `analyst`
                        DROP `company`,
                        DROP `import_slug`;");
    }
}
