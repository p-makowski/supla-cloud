<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add direct_link table.
 */
class Version20170722102707 extends AbstractMigration {
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        $this->addSql('CREATE TABLE supla_direct_link (id INT AUTO_INCREMENT NOT NULL, channel_id INT NOT NULL, slug VARCHAR(255) NOT NULL, caption VARCHAR(255) DEFAULT NULL, allowed_actions VARCHAR(255) NOT NULL, active_from DATETIME DEFAULT NULL, active_to DATETIME DEFAULT NULL, executions_limit INT DEFAULT NULL, last_used DATETIME DEFAULT NULL, last_ipv4 INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_6AE7809F72F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supla_direct_link ADD CONSTRAINT FK_6AE7809F72F5A1AA FOREIGN KEY (channel_id) REFERENCES supla_dev_channel (id)');
    }

    public function down(Schema $schema) {
        $this->addSql('DROP TABLE supla_direct_link');
    }
}
