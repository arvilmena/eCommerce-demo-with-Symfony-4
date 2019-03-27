<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327110035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F093DA206A5');
        $this->addSql('DROP TABLE checkout');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('ALTER TABLE payment_token CHANGE details details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\'');
        $this->addSql('ALTER TABLE payment CHANGE number number VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE client_email client_email VARCHAR(255) DEFAULT NULL, CHANGE client_id client_id VARCHAR(255) DEFAULT NULL, CHANGE total_amount total_amount INT DEFAULT NULL, CHANGE currency_code currency_code VARCHAR(255) DEFAULT NULL, CHANGE readable_status readable_status VARCHAR(25) DEFAULT NULL, CHANGE payment_gateway payment_gateway VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE checkout (id INT AUTO_INCREMENT NOT NULL, buyer_email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, session_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, payment_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_F52993984C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, order_entity_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_52EA1F094584665A (product_id), INDEX IDX_52EA1F093DA206A5 (order_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F093DA206A5 FOREIGN KEY (order_entity_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE payment CHANGE number number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_email client_email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_id client_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE total_amount total_amount INT DEFAULT NULL, CHANGE currency_code currency_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE readable_status readable_status VARCHAR(25) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE payment_gateway payment_gateway VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE payment_token CHANGE details details LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:object)\'');
        $this->addSql('ALTER TABLE product CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
