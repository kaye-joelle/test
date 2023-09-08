<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903043658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE full_name full_name VARCHAR(50) DEFAULT NULL, CHANGE subject subject VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe CHANGE image_name image_name VARCHAR(255) DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD client_first_name VARCHAR(255) DEFAULT NULL, ADD client_address VARCHAR(255) DEFAULT NULL, ADD company_name VARCHAR(255) DEFAULT NULL, ADD company_address VARCHAR(255) DEFAULT NULL, ADD siret VARCHAR(14) DEFAULT NULL, CHANGE pseudo pseudo VARCHAR(50) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE full_name full_name VARCHAR(50) DEFAULT \'NULL\', CHANGE subject subject VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recipe CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\', CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user DROP client_first_name, DROP client_address, DROP company_name, DROP company_address, DROP siret, CHANGE pseudo pseudo VARCHAR(50) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
