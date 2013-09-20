<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130920155205 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO `email_template` (`id`, `slug`, `subject`, `content`) VALUES (NULL, 'user.remind', 'Raeting password reminder', '<html>
                    <head></head>
                    <body>
                    {email}<br>Hash: <strong>{hash}</strong><br>Url: <a href=''{url}''>{url}</a>
                    </body>
                    </html>
                    ');");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM `email_template` WHERE `email_template`.`slug` = 'user.remind'");
    }
}
