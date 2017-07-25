<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170725141222 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE supla_direct_link (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, channel_id INT NOT NULL, slug VARCHAR(255) NOT NULL, caption VARCHAR(255) DEFAULT NULL, allowed_actions VARCHAR(255) NOT NULL, active_from DATETIME DEFAULT NULL, active_to DATETIME DEFAULT NULL, executions_limit INT DEFAULT NULL, last_used DATETIME DEFAULT NULL, last_ipv4 INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_6AE7809FA76ED395 (user_id), INDEX IDX_6AE7809F72F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supla_direct_link ADD CONSTRAINT FK_6AE7809FA76ED395 FOREIGN KEY (user_id) REFERENCES supla_user (id)');
        $this->addSql('ALTER TABLE supla_direct_link ADD CONSTRAINT FK_6AE7809F72F5A1AA FOREIGN KEY (channel_id) REFERENCES supla_dev_channel (id)');
        $this->addSql('ALTER TABLE supla_schedule CHANGE date_start date_start DATETIME NOT NULL, CHANGE date_end date_end DATETIME DEFAULT NULL, CHANGE next_calculation_date next_calculation_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE supla_client DROP FOREIGN KEY FK_5430007F4FEA67CF');
        $this->addSql('ALTER TABLE supla_client ADD CONSTRAINT FK_5430007F4FEA67CF FOREIGN KEY (access_id) REFERENCES supla_accessid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supla_scheduled_executions CHANGE planned_timestamp planned_timestamp DATETIME DEFAULT NULL, CHANGE fetched_timestamp fetched_timestamp DATETIME DEFAULT NULL, CHANGE result_timestamp result_timestamp DATETIME DEFAULT NULL, CHANGE retry_timestamp retry_timestamp DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE supla_direct_link');
        $this->addSql('ALTER TABLE supla_client DROP FOREIGN KEY FK_5430007F4FEA67CF');
        $this->addSql('ALTER TABLE supla_client ADD CONSTRAINT FK_5430007F4FEA67CF FOREIGN KEY (access_id) REFERENCES supla_accessid (id)');
        $this->addSql('ALTER TABLE supla_schedule CHANGE date_start date_start DATETIME NOT NULL, CHANGE date_end date_end DATETIME DEFAULT NULL, CHANGE next_calculation_date next_calculation_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE supla_scheduled_executions CHANGE planned_timestamp planned_timestamp DATETIME DEFAULT NULL, CHANGE fetched_timestamp fetched_timestamp DATETIME DEFAULT NULL, CHANGE retry_timestamp retry_timestamp DATETIME DEFAULT NULL, CHANGE result_timestamp result_timestamp DATETIME DEFAULT NULL');
    }
}
