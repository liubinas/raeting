<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130920095931 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `email_template` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `slug` varchar(255) NOT NULL,
            `subject` varchar(255) DEFAULT NULL,
            `content` longtext NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id` (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("CREATE TABLE IF NOT EXISTS `market` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->addSql("CREATE TABLE IF NOT EXISTS `signal` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `symbol_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `uuid` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
            `buy` tinyint(1) NOT NULL,
            `open` decimal(10,6) NOT NULL,
            `take_profit` decimal(10,6) NOT NULL,
            `stop_loss` decimal(10,6) NOT NULL,
            `profit` decimal(10,6) DEFAULT NULL,
            `pips` decimal(10,1) DEFAULT NULL,
            `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `status` enum('new','opened','closed','error') CHARACTER SET utf8 NOT NULL DEFAULT 'new',
            `created` datetime NOT NULL,
            `opened` datetime NOT NULL,
            `open_expire` datetime NOT NULL,
            `closed` datetime NOT NULL,
            `close_expire` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `IDX_740C95F5C0F75674` (`symbol_id`),
            KEY `IDX_740C95F5A76ED395` (`user_id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;");
        $this->addSql("CREATE TABLE IF NOT EXISTS `symbol` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `market_id` int(11) DEFAULT NULL,
            `symbol` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
            `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `pips_position` int(11) NOT NULL,
            `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`id`),
            KEY `IDX_ECC836F9622F3F37` (`market_id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;");
        $this->addSql("CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `create_date` datetime NOT NULL,
            `recovery_hash` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
            `recovery_date` datetime DEFAULT NULL,
            `last_login_date` datetime DEFAULT NULL,
            `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `facebookId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `fbname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `about` longtext COLLATE utf8_unicode_ci,
            `company` longtext COLLATE utf8_unicode_ci,
            PRIMARY KEY (`id`),
            UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
            UNIQUE KEY `UNIQ_8D93D649989D9B62` (`slug`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
        $this->addSql("ALTER TABLE `signal`
            ADD CONSTRAINT `FK_740C95F5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
            ADD CONSTRAINT `FK_740C95F5C0F75674` FOREIGN KEY (`symbol_id`) REFERENCES `symbol` (`id`);");
        $this->addSql("ALTER TABLE `symbol`
            ADD CONSTRAINT `FK_ECC836F9622F3F37` FOREIGN KEY (`market_id`) REFERENCES `market` (`id`);");

    }

    public function down(Schema $schema)
    {
        
    }
}
