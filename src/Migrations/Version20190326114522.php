<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326114522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment ADD readable_status VARCHAR(25) DEFAULT NULL, ADD payment_gateway VARCHAR(255) DEFAULT NULL, CHANGE number number VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE client_email client_email VARCHAR(255) DEFAULT NULL, CHANGE client_id client_id VARCHAR(255) DEFAULT NULL, CHANGE total_amount total_amount INT DEFAULT NULL, CHANGE currency_code currency_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment_token CHANGE details details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment DROP readable_status, DROP payment_gateway, CHANGE number number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_email client_email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_id client_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE total_amount total_amount INT DEFAULT NULL, CHANGE currency_code currency_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE payment_token CHANGE details details LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:object)\'');
    }
}
